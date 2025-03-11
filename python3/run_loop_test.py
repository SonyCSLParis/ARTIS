from artisapi.main2 import *
from texttopictogramsmain.picto_retrieval.Get_Pictos_yake_meanings import *
import time
import mysql.connector
import requests
from bs4 import BeautifulSoup
import openai
openai.api_key = "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"

def connessione():
    mydb = mysql.connector.connect(
            host="192.168.1.150",
            user="usr_remote",
           
            passwd="4sr0m4-2001",
            database="artis_DB_TEST",
            autocommit=True
    )
    mydb.set_charset_collation('utf8mb4', 'utf8mb4_general_ci')
    return mydb
starttime = time.time()




def is_proper_noun(word,language_code="it" ):
        if language_code == None:
            language_code = language_code
        
        try:
            language_model = language_code + "_core_news_sm"
            nlp = spacy.load(language_model)
        except:
            language_model = language_code + "_core_web_sm"
            nlp = spacy.load(language_model)
    
        
    
        doc = nlp(word)
        # Check if the word is a proper noun (POS tag 'PROPN')
        print(word)
        print(any(token.pos_ == "PROPN" for token in doc))
        
        if any(token.pos_ == "PROPN" for token in doc):
            d = gender.Detector()
            word1 =d.get_gender(word)
            print(word)
            word="persona"
            if word1=="male":
                word="uomo"
            if word1=="female":
                word ="donna"
            
               
        else:
            word

        print(word)
        return word
def find_picto2( keyword, language_code='it', resolution=500):
    
    url = "https://api.arasaac.org/api/pictograms/" + language_code + "/search/"
    response = requests.request("GET", url + keyword.lower())
    if response.status_code == 200:
        id = response.json()[0]['_id']
        image_url = 'https://api.arasaac.org/api/pictograms/' + str(id) + '?resolution='+str(resolution)
        return image_url
    else:
        return None


def salvastato(idtesto,stato,language):
    if language=='it':
        qry ="update tab_text set status="+str(stato)+" where id_text="+str(idtesto)+""
    else:
        qry ="update tab_text set status_en="+str(stato)+" where id_text="+str(idtesto)+""
    mydb = connessione()
    cur = mydb.cursor(buffered=True)
    cur.execute(qry)
    cur.close()

while True:
    print("tick")

    lan='it'
    qry="select * from tab_text where status=0 "  
    mydb = connessione()
    cur = mydb.cursor(buffered=True)
    cur.execute(qry)
    libro = cur.fetchall()
        
    for ele in libro:
               
        language ="it"
        lang="italian"
        titolo = ele[1]
        testo = ele[2]
    
        idtesto= ele[0]
        if testo:
            print("Inizio "+str(titolo)) 
            
            #testo = testo.replace("-","")
            #testo = testo.replace("\n"," ")
            #print(testo) 
            salvastato(idtesto,1,lan)
            
            result=[]
            picto_finder = PictoFinder(testo)
            root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
            output_folder = os.path.join(root, "Pictos_per_sentence")
            sentence_pictos = picto_finder.get_all_pictos(pictos_per_sentence=2, save_each_sentence_path=output_folder)
            for stringa in sentence_pictos:
                print(stringa)
                                     
                frase = stringa["sentence"]
                frase = frase.replace("'","\\'")
                
                
                qry="insert into tab_map set id_text="+str(idtesto)+", text ='"+str(frase)+"' "
                mydb = connessione()
                cur = mydb.cursor(buffered=True)
                cur1 = mydb.cursor(buffered=True)
                cur.execute(qry)
                idmap = cur.lastrowid
                cur.close() 
                    
                parola =""
                for words in stringa["picto"]:
                    if parola == words["word"]:
                        continue
                    else:
                        parola =words["word"]
                        parola2 = is_proper_noun(str(parola))
                        if not parola == parola2:
                            img = find_picto2(parola2)
                        else:
                            img = words["picto"]

                        parola = parola.replace("'","\\'")
                        qryins ="insert into tab_keyword set id_map="+str(idmap)+" ,keyw ='"+str(parola)+"' , img ='"+str(img)+"'"

                        cur1.execute(qryins)
                cur1.close

                salvastato(idtesto,2,lan)
                
 
    time.sleep(60.0 - ((time.time() - starttime) % 60.0))
                                                                                            