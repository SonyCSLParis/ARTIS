import requests
import json
import spacy
from keybert import KeyBERT
from sentence_transformers import SentenceTransformer
from sklearn.feature_extraction.text import CountVectorizer

class PictoFinder:
    def __init__(self, url):
        self.url = url

    def find_picto(self, keyword, repo):
        querystring = {"name": keyword, "lang": "en", "repo": repo, "limit": "10"}
        response = requests.request("GET", self.url, params=querystring)
        str_response = response.text
        if str_response == "no result":
            print("no result")
            return None
        elif str_response.lower() == "an error has occurred":
            print("error")
            return None
        else:
            try:
                response_data = json.loads(str_response)
                if response_data:
                    highest = response_data[0]
                    image_url = highest.get('image_url')
                    return image_url
                else:
                    print("No pictograms found")
                    return None
            except json.decoder.JSONDecodeError:
                print("Error decoding JSON response")
                return None

    def extract_keywords(self, sentence):
        sentence_model = SentenceTransformer("all-MiniLM-L6-v2")
        kw_model = KeyBERT(model=sentence_model)
        vectorizer = CountVectorizer(ngram_range=(1, 1), stop_words="english")
        keywords = kw_model.extract_keywords(sentence, vectorizer=vectorizer, nr_candidates=10, top_n=5)
        nlp = spacy.load("en_core_web_sm")
        included_text = {"NN", "VB", "JJ"}
        new_keywords = []
        for keyword in keywords:
            doc = nlp(keyword[0])
            for token in doc:
                if token.tag_ in included_text:
                    new_keywords.append(token.text)
        new_new_keywords = new_keywords[:10]
        return new_new_keywords


if __name__ == '__main__':
    picto_finder = PictoFinder(url="https://symbotalkapiv1.azurewebsites.net/search/")
    repo = ["mulberry", "arasaac", "sclera"]
    picto_result = picto_finder.find_picto(keyword="casa", repo="arasaac")
    print(picto_result)

