from artisapi.main2 import *
from texttopictogramsmain.picto_retrieval.Get_Pictos_yake_meanings import *
from pdftotext import *
from flask import Flask, request, jsonify
from flask_cors import CORS, cross_origin
from esercizio4 import run_exercise4
from esercizio5 import run_exercise5
from multiprocessing import Process
app = Flask(__name__)
CORS(app)
import mysql.connector
def connessione():
    mydb = mysql.connector.connect(
            host="192.168.1.150",
            user="usr_remote",
           
            passwd="4sr0m4-2001",
            database="artisdb",
            autocommit=True
    )
    mydb.set_charset_collation('utf8mb4', 'utf8mb4_general_ci')
    return mydb
@app.route('/carica_libro_da_img', methods=['POST'])
def carica_libro_da_img():
    print("chiamata")
    data = request.get_json()
    libro = data.get('file')
    
    text = inserisci_libro_da_img(libro)
    #print(text)
    #picto_finder = PictoFinder(text[0])
    #root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    #output_folder = os.path.join(root, "Pictos_per_sentence")
    #sentence_pictos = picto_finder.get_all_pictos(pictos_per_sentence=2, save_each_sentence_path=output_folder)
    print(text[1])
    return ""+str(text[1])

@app.route('/run_all', methods=['POST'])
def run_all_api():
    data = request.get_json()
    return run_all(data)


@app.route('/see_another', methods=['POST'])
def find_another_pic_api():
    data = request.get_json()
    
    return jsonify(find_another_pic(data))



@app.route('/get_keywords', methods=['POST'])

def get_key_api():
    data = request.get_json()
    return test(data)


@app.route('/extract_sentence_token', methods=['POST'])
def extract_sentence_web_api():
    """ Function to get the sentence in a text where a certain token is contained."""
    # example of Curl Request :
    # IT :  curl -X POST -H "Content-Type: application/json" -d '{"text": "Frase su olio e gas. Frase su gas", "token":"olio", "language": "italian"}' http://127.0.0.1:5000/extract_sentence
    # EN :  curl -X POST -H "Content-Type: application/json" -d '{"text": "Sentence on oil and gas. Sentence on gas", "token":"oil", "language": "english"}' http://127.0.0.1:5000/extract_sentence
    data = request.get_json()
    return extract_sentence_web(data)


@app.route('/get_most_difficult_words', methods=['POST'])
def get_most_difficult_words_web_api():
    """ Function to get the statistically least frequent words in a text."""
    # example of Curl Request :
    # IT : curl -X POST -H "Content-Type: application/json" -d '{"text": "Frase su olio e gas", "language": "it"}' http://127.0.0.1:5000/get_most_difficult_words
    # EN : curl -X POST -H "Content-Type: application/json" -d '{"text": "Sentence on oil and gas", "language": "en"}' http://127.0.0.1:5000/get_most_difficult_words
    data = request.get_json()
    return jsonify(get_most_difficult_words_web(data))



@app.route('/get_definition', methods=['POST'])

def def_parole_api():
    data = request.get_json()
    return def_parole(data)

@app.route('/get_definition_json', methods=['POST'])

def def_parole_json_api():
    data = request.get_json()
    return jsonify(def_parole_json(data))


@app.route('/get_definition_json_all', methods=['POST'])
def def_parole_json_all_api():
    data = request.get_json()
    return def_parole_json_all(data)


@app.route('/get_sem_graph_csv', methods=['POST'])
def get_sem_graph_csv_api():
    """ Function to get the html maps of synonyms."""
    # example of Curl Request :
    # IT : curl -X POST -H "Content-Type: application/json" -d '{"word": "Olio", "language": "italian"}' http://127.0.0.1:5000/get_sem_graph_csv
    # EN : curl -X POST -H "Content-Type: application/json" -d '{"word": "Oil", "language": "english"}' http://127.0.0.1:5000/get_sem_graph_csv
    data = request.get_json()
    print(data)
    return get_sem_graph_csv(data)


@app.route('/pronouns', methods=['POST'])
def pronouns_web_api():
    """ Function to extract pronouns and their reference."""
    # example of Curl Request :
    # IT : curl -X POST -H "Content-Type: application/json" -d '{"text": "Olio", "language": "italian"}' http://127.0.0.1:5000/pronouns
    # EN : curl -X POST -H "Content-Type: application/json" -d '{"text": "Oil", "language": "english"}' http://127.0.0.1:5000/pronouns
    data = request.get_json()
    return jsonify(pronouns_web(data))


@app.route('/simplify_sentence', methods=['POST'])
def simplify_sentence_web_api():
    data = request.get_json()
    return jsonify(simplify_sentence_web(data))


@app.route('/run_exercise4', methods=['GET'])
def run_exercise4_web_api():
    id_text = request.args.get('id')
    lang = request.args.get('lang')
    p = Process(target=run_exercise4, args=(id_text,lang))
    # you have to set daemon true to not have to wait for the process to join
    p.daemon = True
    p.start()

    return "ok"
@app.route('/run_exercise5', methods=['GET'])
def run_exercise5_web_api():
    id_text = request.args.get('id')
    lang = request.args.get('lang')
    p = Process(target=run_exercise5, args=(id_text,lang))
    # you have to set daemon true to not have to wait for the process to join
    p.daemon = True
    p.start()

    return "ok"


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5002)