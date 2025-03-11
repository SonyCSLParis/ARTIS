#!/mnt/diskMartines/soufiane/Projects/text-to-pictograms-main/venv/bin/python3.10

import requests
import json
from PIL import Image
from io import BytesIO
import os
import torch
import random
import nltk
from nltk.corpus import webtext, stopwords, brown, words, reuters, movie_reviews
from nltk.tokenize import word_tokenize
from nltk.stem import WordNetLemmatizer
from collections import Counter
import shutil
from nltk.probability import FreqDist


def get_frequent_words(number_of_words=2000):

    # Download NLTK resources if not already downloaded
    nltk.download('webtext')
    nltk.download('punkt')
    nltk.download('stopwords')
    nltk.download('brown')
    nltk.download('words')
    nltk.download('reuters')
    nltk.download('movie_reviews')
    nltk.download('wordnet')

    # Get a list of stopwords
    stop_words = set(stopwords.words('english'))

    # Initialize WordNet Lemmatizer
    lemmatizer = WordNetLemmatizer()

    # Get all words from the Gutenberg corpus, excluding stopwords and non-alphabetic words
    all_words_brown = [word.lower() for file_id in brown.fileids() for word in brown.words(file_id)]
    all_words_reuters = [word.lower() for file_id in reuters.fileids() for word in reuters.words(file_id)]
    all_words_webtext = [word.lower() for file_id in webtext.fileids() for word in webtext.words(file_id)]
    all_words_movie_reviews = [word.lower() for file_id in movie_reviews.fileids() for word in movie_reviews.words(file_id)]
    all_words = all_words_brown + all_words_reuters + all_words_webtext + all_words_movie_reviews
    filtered_words = [word for word in all_words if word.isalpha() and word not in stop_words]

    # Lemmatize the words and count the frequency of each lemma
    lemmatized_words = [lemmatizer.lemmatize(word) for word in filtered_words]
    word_freq = Counter(lemmatized_words)

    # Get the top 2000 most frequent lemmas
    top_lemmas = [word for word, _ in word_freq.most_common(number_of_words)]

    # Print the top 2000 most frequent lemmas
    return top_lemmas


class TrainingPictos:

    def __init__(self, output_path, lang="en", delete_everything=False):
        if not os.path.exists(output_path):
            os.makedirs(output_path)
        if delete_everything:
            self.delete_files(output_path)
        self.output_path = output_path
        self.url = "https://api.arasaac.org/api/pictograms/" + lang + "/search/"

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

    def get_pictos(self, words_list, resolution=2500, metadata=True, overwrite=True):
        found_pictos = []
        output_folder = os.path.join(self.output_path, 'pictos')

        if not os.path.exists(output_folder):
            os.makedirs(output_folder)

        for word in words_list:
            response = requests.request("GET", self.url + word)

            if response.status_code == 200:
                found_pictos.append(word)
                id = response.json()[0]['_id']
                # image_url = 'https://static.arasaac.org/pictograms/' + str(id) + '/' + str(id) + '_500.png'
                image_url = 'https://api.arasaac.org/v1/pictograms/' + str(id) + '?resolution='+str(resolution)
                image = Image.open(BytesIO(requests.get(image_url).content))
                # Save the image to a file
                image.save(os.path.join(output_folder, word + '.png'))

        image_directory = output_folder + '_' + str(len(words_list))
        if os.path.exists(image_directory):
            if overwrite:
                shutil.rmtree(image_directory)
            else:
                print('Picto folder name already exists => Name of picto output folder was not changed')
        os.rename(output_folder, image_directory)
        print(str(len(found_pictos)) + " pictos have been retrieved and saved")

        if metadata:
            output_file = os.path.join(image_directory, 'metadata.jsonl')
            with open(output_file, 'w') as f:
                # Loop through all files in the directory
                for filename in os.listdir(image_directory):
                    # Only process image files (you can add more extensions if needed)
                    if filename.endswith(('.png', '.jpg', '.jpeg', '.gif', '.bmp')):
                        # Extract the label from the filename (excluding the extension)
                        label = os.path.splitext(filename)[0]
                        # Create the metadata entry
                        metadata = {"file_name": filename, "text": label}
                        # Write the metadata to the JSONL file
                        f.write(json.dumps(metadata) + '\n')

            print(f"Metadata has been written to {output_file}")




# Nouns (50)
Nouns = [
    "apple", "cat", "tree", "car", "house", "mountain", "river", "book", "computer", "teacher",
    "dog", "city", "flower", "bird", "bicycle", "sun", "moon", "ocean", "chair", "bed",
    "garden", "horse", "train", "plane", "fish", "building", "road", "bridge", "boat", "clock",
    "phone", "table", "bag", "bottle", "shirt", "pencil", "cup", "hat", "window", "door",
    "shoe", "ball", "lamp", "key", "plate", "knife", "fork", "spoon", "book", "map"
]

# Verbs (30)
Verbs = [
    "run", "jump", "eat", "sleep", "read", "write", "swim", "fly", "walk", "talk",
    "sing", "dance", "play", "cook", "drive", "teach", "learn", "build", "paint", "clean",
    "watch", "listen", "speak", "laugh", "cry", "draw", "throw", "catch", "open", "close"
]

# Adjectives (25)
Adjectives = [
    "happy", "sad", "big", "small", "fast", "slow", "hot", "cold", "bright", "dark",
    "young", "old", "new", "beautiful", "ugly", "tall", "short", "fat", "thin", "strong",
    "weak", "rich", "poor", "smart", "brave"
]

# Adverbs (15)
Adverbs = [
    "quickly", "slowly", "quietly", "loudly", "happily", "sadly", "brightly", "darkly", "eagerly", "lazily",
    "calmly", "carefully", "easily", "clearly", "angrily"
]

# Prepositions (10)
Prepositions = [
    "on", "under", "in", "over", "between", "beside", "behind", "above", "below", "near"
]

# Conjunctions (10)
Conjunctions = [
    "and", "but", "or", "because", "so", "although", "if", "while", "when", "since"
]

# Pronouns (10)
Pronouns = [
    "i", "you", "he", "she", "it", "we", "they", "me", "him", "her"
]

Words_150 = Nouns + Verbs + Adjectives + Adverbs + Prepositions + Conjunctions + Pronouns
random.shuffle(Words_150)

Words_2000 = get_frequent_words(2000) + Words_150
Words_2000 = list(set(Words_2000))
random.shuffle(Words_2000)
Words_2000 = Words_2000[:2000]

Words_10000 = get_frequent_words(10000) + Words_150
Words_10000 = list(set(Words_10000))
random.shuffle(Words_10000)
Words_10000 = Words_10000[:10000]

Words_20 = Words_150.copy()
random.shuffle(Words_20)
Words_20 = Words_20[:20]

list_of_WordsList = [Words_20, Words_150, Words_2000, Words_10000]


if __name__ == '__main__':

    root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    output_folder = os.path.join(root, "Pictos")

    training_pictos = TrainingPictos(output_folder, lang="en", delete_everything=True)

    for WordsList in list_of_WordsList:
        training_pictos.get_pictos(words_list=WordsList, resolution=2500)

