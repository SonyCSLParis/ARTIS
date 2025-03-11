import os.path
import os
import requests
import json
from sentence_transformers import SentenceTransformer, util
from lingua import LanguageDetectorBuilder
import nltk
from nltk.tokenize import sent_tokenize, word_tokenize
from nltk.corpus import stopwords
import numpy as np
import simplemma
import spacy
import yake
import contractions
from translate import Translator
from word2number import w2n
import gender_guesser.detector as gender
nltk.download('punkt')
nltk.download('wordnet')
nltk.download('stopwords')


class PictoFinder:
    def __init__(self, text):
        self.text = text
        self.language_name, self.language_code = self.detect_language(text)
        self.url ="https://api.arasaac.org/api/pictograms/"+self.language_code+"/search/"
    
 
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
        # Ensure the Punkt tokenizer is trained on Italian data
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
        print("find picto normal")
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

    def find_pictos_and_meanings(self, keyword, language_code=None, resolution=500):
        """

        :param keyword:
        :param resolution: only one of two values possible 500 or 2500
        :return:
        """
        print("find picto meanings"+str(keyword))
        if language_code == None:
            language_code = self.language_code
   
        url = "https://api.arasaac.org/api/pictograms/" + language_code + "/search/"
        response = requests.request("GET", url + keyword.lower())
        dict = {}
        id_list = []
        url_list = []
        meaning_list = []
        if response.status_code == 200:
            for i in range(len(response.json())):
                id = response.json()[i]['_id']
                image_url = 'https://api.arasaac.org/api/pictograms/' + str(id) + '?resolution=' + str(resolution)
                if response.json()[i]['keywords'] != []:
                    if 'meaning' in response.json()[i]['keywords'][0].keys():
                        meaning = response.json()[i]['keywords'][0]['meaning']
                        id_list.append(id)
                        url_list.append(image_url)
                        meaning_list.append(meaning)
                else:
                    continue
            if id_list == []:
                i=0
                id = response.json()[i]['_id']
                image_url = 'https://api.arasaac.org/api/pictograms/' + str(id) + '?resolution=' + str(resolution)
                if response.json()[i]['keywords'] != []:
                    meaning = response.json()[i]['keywords'][0]['keyword']
                    id_list.append(id)
                    url_list.append(image_url)
                    meaning_list.append(meaning)
                else:
                    return None
            dict['_id'] = id_list
            dict['url'] = url_list
            dict['meaning'] = meaning_list
            return dict
        else:
            return None

    def split_sentence_to_words(self, sentence, language_code=None, language_name=None):
        if language_code == None:
            language_code = self.language_code
        if language_name == None:
            language_name = self.language_name
        if language_code == 'en':
            sentence = contractions.fix(sentence)
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

                # tokens = [token for token in tokens_not_filtered if
                #           all(c.isalnum() or c.isspace() for c in token)]

                tokens = [
                    token for token in tokens_not_filtered
                    if all(c.isalnum() or c.isspace() for c in token) and '\n' not in token
                ]

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

    def is_number_string(self, text, language_name=None):

        if language_name == None:
            language_name = self.language_name
        if language_name != 'english':
        # Initialize the translator
            translator = Translator(to_lang=language_name)
            translated_text = translator.translate(text)
        else:
            translated_text = text

        try:
            # Try to convert the translated text to a number
            number = w2n.word_to_num(translated_text)
            return True
        except ValueError:
            return False

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

    def select_best_definition(self, sentence, word, definitions, context_window = 2, language_name=None):
        """
        Selects the best definition for a word in a given sentence based on semantic similarity.

        :param word: The target word.
        :param sentence: The sentence containing the word.
        :param definitions: A list of definitions for the word.
        """
        if language_name == None:
            language_name = self.language_name
        if language_name == 'english':
            sentence_transformer = SentenceTransformer("paraphrase-MiniLM-L6-v2")
        else:
            sentence_transformer = SentenceTransformer("paraphrase-multilingual-MiniLM-L12-v2")

        words = self.split_sentence_to_words(sentence)
        word_idx = words.index(word)
        start_idx = max(0, word_idx - context_window)
        end_idx = min(len(words), word_idx + context_window + 1)
        context = ' '.join(words[start_idx:end_idx])

        sentence_embedding = sentence_transformer.encode(context, convert_to_tensor=True)
        definition_embeddings = sentence_transformer.encode(definitions, convert_to_tensor=True)

        # Compute cosine similarity between the sentence and each definition
        similarities = util.pytorch_cos_sim(sentence_embedding, definition_embeddings)[0]
        # print(similarities)

        if self.is_number_string(word):
            best_idx = 0
            best_def = definitions[best_idx]
        else:
            if len(similarities) > 8 and max(similarities) - max(similarities[:8]) < 0.06:
                best_idx = similarities[:6].cpu().data.numpy().argmax()
                best_def = definitions[best_idx]
            else:
                best_idx = similarities.cpu().data.numpy().argmax()
                best_def = definitions[best_idx]

        if max(similarities) > 0:
            return best_def, best_idx
        else:
            return None, None
   
   

    def get_all_pictos(self, pictos_per_sentence=2, save_each_sentence_path=None, delete_files=True):
        already_deleted = False
        sentences = self.split_into_sentences()
        sentence_pictos = {}
        count = 0
        result=[]
        for sentence in sentences:
            count += 1
            print("sentence " + str(count) + "/" + str(len(sentences)))
            print(sentence)
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

            word_meanings_dict = {}
            pictos_and_meanings_dict = {}
            for word in words_ordered:
                
                if not self.find_pictos_and_meanings(self.lemmatize_word(str(word))) == None:
                  
                    pictos_and_meanings_dict[word] = self.find_pictos_and_meanings(self.lemmatize_word(str(word)))
                    word_meanings_dict[word] = pictos_and_meanings_dict[word]['meaning']

            extracted_keywords_plus = extracted_keywords.copy()
            for word in words_ordered:
                if word not in extracted_keywords:
                   
                    extracted_keywords_plus.append(word)
            stop_words = set(stopwords.words(self.language_name))
            try:
                negation = 'not'
                if self.language_name != 'english':
                    translator = Translator(to_lang=self.language_name)
                    negation = translator.translate(negation)
                stop_words.remove(negation)
            except:
                pass
            extracted_keywords_plus_fitered = [word for word in extracted_keywords_plus if word.lower() not in stop_words]
            keyword_pictos_not_ordered = {}
            # print(words_ordered)
            for word in extracted_keywords_plus_fitered:
                
                if word in word_meanings_dict.keys():
                    
                   
                    try:
                        best_meaning, idx = self.select_best_definition(sentence=sentence, word=word, definitions=word_meanings_dict[word])
                    except:
                        continue
                    else:
                        if best_meaning == None:
                            continue
                        else:
                            # print(sentence)
                            image_url = pictos_and_meanings_dict[word]['url'][idx]
                            keyword_pictos_not_ordered[word] = image_url
                if len(keyword_pictos_not_ordered.keys()) > (pictos_per_sentence-1):
                    break
            keyword_pictos_ordered = {}
            keyword =[]
            for word in words_ordered:
                if word in keyword_pictos_not_ordered.keys():
                    keyword_pictos_ordered[word] = keyword_pictos_not_ordered[word]
                    keyword.append({'word':word,'picto':keyword_pictos_not_ordered[word]})
                if len(keyword_pictos_ordered.keys()) > (pictos_per_sentence-1):
                    break

            if save_each_sentence_path != None:
                data = {}
                data["sentence"] = sentence
                data["picto"]= keyword
                result.append(data)
                #data[sentence] = keyword_pictos_ordered
                if not os.path.exists(save_each_sentence_path):
                    os.makedirs(save_each_sentence_path)
                if delete_files:
                    if not already_deleted:
                        already_deleted = True
                        self.delete_files(save_each_sentence_path)
                with open(os.path.join(save_each_sentence_path, 'sentence_'+str(count)), 'w') as json_file:
                    json.dump(data, json_file, indent=4)
            sentence_pictos[sentence] = keyword_pictos_ordered
        return result

   


text_en = "Today, I woke up in Paris. I ate a cookie. Now, I am going out to eat french fries. Later I am going to sleep early."
text_de = 'Heute bin ich in Paris aufgewacht. Ich habe einen Keks gegessen. Jetzt gehe ich Pommes essen. Später gehe ich früh schlafen.'
text_it = 'I discorsi più belli a quel tempo li facevo con il mio papà. '
     

if __name__ == '__main__':
    picto_finder = PictoFinder(text_it)
    root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    output_folder = os.path.join(root, "Pictos_per_sentence")
    sentence_pictos = picto_finder.get_all_pictos(pictos_per_sentence=8, save_each_sentence_path = output_folder)
