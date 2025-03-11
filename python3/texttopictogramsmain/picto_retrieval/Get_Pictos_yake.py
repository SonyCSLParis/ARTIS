import requests
import json
import os
from lingua import LanguageDetectorBuilder
import nltk
from nltk.tokenize import sent_tokenize, word_tokenize
import numpy as np
import simplemma
import spacy
import yake
nltk.download('punkt')
nltk.download('wordnet')
nltk.download('stopwords')

class PictoFinder:
    def __init__(self, text):
        self.text = text
        self.language_name, self.language_code = self.detect_language(text)
        self.url ="https://api.arasaac.org/api/pictograms/"+self.language_code+"/search/"

    def delete_files(self, folder_path):
        # Iterate over all items in the folder
        for item in os.listdir(folder_path):
            item_path = os.path.join(folder_path, item)
            # Check if the item is a file or directory
            if os.path.isfile(item_path):
                # Delete the file
                os.remove(item_path)
            elif os.path.isdir(item_path):
                # Recursively delete the subdirectory and its contents
                self.delete_files(item_path)
                # Remove the empty directory
                os.rmdir(item_path)

    def detect_language(self, text=None):
        if text == None:
            text = self.text
        detector = LanguageDetectorBuilder.from_all_languages().build()
        language = detector.detect_language_of(text)

        language_name = language.name.lower()  # Get the full language name (e.g., 'ENGLISH')
        language_code = language.iso_code_639_1.name.lower()  # Get the ISO code (e.g., 'en')

        language_name = language_name
        language_code = language_code

        return language_name, language_code

    def split_into_sentences(self, text=None):
        if text == None:
            text = self.text
        try:
            nltk.data.load(f'tokenizers/punkt/{self.language_name}.pickle')
        except LookupError:
            print(f"the {self.language_name} language not supported.")

        sentences = sent_tokenize(text, language=self.language_name)
        return sentences

    def find_picto(self, keyword, language_code=None, resolution=500):
        """

        :param keyword:
        :param resolution: only one of two values possible 500 or 2500
        :return:
        """
        if language_code == None:
            language_code = self.language_code
        url = "https://api.arasaac.org/api/pictograms/" + language_code + "/search/"
        response = requests.request("GET", url + keyword.lower())
        if response.status_code == 200:
            id = response.json()[0]['_id']
            image_url = 'https://api.arasaac.org/api/pictograms/' + str(id) + '?resolution='+str(resolution) 
            return image_url
        else:
            return None

    def split_sentence_to_words(self, sentence, language_code=None, language_name=None):
        if language_code == None:
            language_code = self.language_code
        if language_name == None:
            language_name = self.language_name
        try:
            try:
                language_model = language_code + "_core_news_sm"
                nlp = spacy.load(language_model)
            except:
                language_model = language_code + "_core_web_sm"
                nlp = spacy.load(language_model)
        except:
            tokens_not_filtered = word_tokenize(sentence, language=language_name)
            tokens = [token for token in tokens_not_filtered if token.isalnum()]
        else:
            # Process the sentence with spaCy
            doc = nlp(sentence)

            # List to hold final tokens/phrases
            tokens_not_filtered = []

            # Loop through the tokens in the doc
            i = 0
            while i < len(doc):
                token = doc[i]

                # Check if the token is a part of a multi-word expression
                if token.dep_ == "prt" and token.head.i == i - 1:
                    # Combine the base verb and the particle
                    phrase = f"{doc[i - 1].text} {token.text}"
                    tokens_not_filtered[-1] = phrase  # Replace the last token with the combined phrase
                else:
                    tokens_not_filtered.append(token.text)

                i += 1

                tokens = [token for token in tokens_not_filtered if
                          all(c.isalnum() or c.isspace() for c in token)]

        return tokens

    def lemmatize_word(self, word, language_code=None):
        if language_code == None:
            language_code = self.language_code
        try:
            try:
                language_model = language_code + "_core_news_sm"
                nlp = spacy.load(language_model)
            except:
                language_model = language_code + "_core_web_sm"
                nlp = spacy.load(language_model)
        except:
            lemmatized_word = simplemma.lemmatize(word, lang=language_code)
        else:
            # Process the word/phrase with spaCy
            doc = nlp(word)

            # List to hold the lemmatized tokens
            lemmas = []

            for token in doc:
                lemmas.append(token.lemma_)

            # Join the lemmas with space for multi-word expressions
            lemmatized_word = " ".join(lemmas)

        return lemmatized_word

    def extract_keywords_from_sentence(self, sentence, language_code=None, top_n=10, keyphrase_ngram_range=1):
        if language_code == None:
            language_code = self.language_code
        print(language_code)
        kw_extractor = yake.KeywordExtractor(lan=language_code, n=keyphrase_ngram_range, dedupLim=0.8, dedupFunc='seqm', windowsSize=3, top=top_n,
                                             features=None)
        keywords = kw_extractor.extract_keywords(sentence)
        return keywords

    def get_all_pictos(self, pictos_per_sentence = 5, save_each_sentence_path=None, delete_files=True):
        already_deleted = False
        sentences = self.split_into_sentences()
        sentence_pictos = {}
        count = 0
        result=[]
        for sentence in sentences:
            count += 1
            print("sentence " + str(count) + "/" + str(len(sentences)))
            if self.extract_keywords_from_sentence(sentence) == []:
                extracted_keywords = []
            else:
                extracted_keywords = list(np.array(self.extract_keywords_from_sentence(sentence))[:, 0])


            words_ordered = self.split_sentence_to_words(sentence)
            for keyword in extracted_keywords:
                if keyword not in words_ordered:
                    for word in words_ordered:
                        if keyword in word and keyword[:3] == word[:3]:
                            extracted_keywords[extracted_keywords.index(keyword)] = word

            extracted_keywords_plus = extracted_keywords.copy()
            for word in words_ordered:
                if word not in extracted_keywords:
                    extracted_keywords_plus.append(word)

            keyword_pictos_not_ordered = {}
            keyword =[]
            for word in extracted_keywords_plus:
                if not self.find_picto(self.lemmatize_word(str(word))) == None:
                    keyword_pictos_not_ordered[word] = self.find_picto(self.lemmatize_word(str(word)))
                    keyword.append({'word':word,'picto':self.find_picto(self.lemmatize_word(str(word)))})
                if len(keyword_pictos_not_ordered.keys()) > (pictos_per_sentence-1):
                    break
            keyword_pictos_ordered = {}
            for word in words_ordered:
                if word in keyword_pictos_not_ordered.keys():
                    keyword_pictos_ordered[word] = keyword_pictos_not_ordered[word]
                if len(keyword_pictos_ordered.keys()) > (pictos_per_sentence-1):
                    break

            if save_each_sentence_path != None:
                data = {}
                data["sentence"] = sentence
                data["picto"]= keyword
                result.append(data)
                if not os.path.exists(save_each_sentence_path):
                    os.makedirs(save_each_sentence_path)
                if delete_files:
                    if not already_deleted:
                        already_deleted = True
                        self.delete_files(save_each_sentence_path)
                with open(os.path.join(save_each_sentence_path, 'sentence_'+str(count)), 'w') as json_file:
                    json.dump(data, json_file, indent=4)
                   # print (data)
            sentence_pictos[sentence] = keyword_pictos_ordered
        return result


text_it = """
I discorsi più belli a quel tempo li facevo con il mio papà. Era vivace e allegro e ogni giorno inventava nuovi giochi e scherzi. La sera arrivava sempre con dei regali, portava qualcosa per ciascuno di noi, non c’era giorno che tornasse a casa senza portarci un piccolo dono. Andavo già a scuola da qualche mese, quando accadde una cosa solenne ed eccitante che determinò tutto ciò che mi sarebbe successo in futuro. Mio padre mi portò un libro. Era “Le mille e una notte” in un’edizione adatta alla mia età. Sulla copertina c’era un’illustrazione a colori, se non sbaglio di Aladino con la lampada meravigliosa. Papà mi parlò in tono molto serio e incoraggiante e mi disse quanto sarebbe stato bello leggere quel libro. Quando lo avessi terminato, disse, me ne avrebbe portato un altro. Non me lo feci ripetere due volte e, sebbene a scuola avessi appena finito di imparare a leggere, mi gettai subito su quel libro meraviglioso e ogni sera avevo qualcosa da raccontargli.Lui mantenne la promessa: ogni volta c’era un libro nuovo, così che non ho mai dovuto interrompere, neppure per un solo giorno, le mie amate letture. Era una collana di libri per bambini, tutti dello stesso formato quadrato.Si distinguevano solo per la diversa illustrazione a colori in copertina. In tutti i volumi i caratteri erano di uguale grandezza, in modo che si aveva l’impressione di leggere sempre lo stesso libro.I titoli li ricordo tutti. Dopo “Le mille e una notte” vennero le fiabe dei fratelli Grimm, poi “Robinson Crusoe”, “I viaggi di Gulliver”, “Don Chisciotte”, “Guglielmo Tell”. Sarebbe facile dimostrare che quasi tutto ciò che ha poi ispirato e guidato la mia vita era già contenuto in quei libri, i libri che io lessi per amore di mio padre."""

text_en = """
My name is Luca and today was awesome! I woke up early to have breakfast with my mom. We had bread and Nutella, my absolute favorite!

After that, I went to the park with my dog, Fido. We played frisbee and chased squirrels. Fido is always so much fun!

For lunch, Grandma made pesto pasta, which is super yummy. I ate a ton, then took a nap on the couch.

In the afternoon, I went to my friend Marco's house. We built a spaceship out of cardboard boxes and pretended to travel through space.

At night, Mom read me a story before bed. It was about a brave dragon who rescues a princess. I fell asleep dreaming of being a dragon too!
"""


if __name__ == '__main__':
    picto_finder = PictoFinder(text_it)
    root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    output_folder = os.path.join(root, "Pictos_per_sentence")
    sentence_pictos = picto_finder.get_all_pictos(pictos_per_sentence=2, save_each_sentence_path=output_folder)
