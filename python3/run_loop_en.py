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
            database="artisdb",
            autocommit=True
    )
    mydb.set_charset_collation('utf8mb4', 'utf8mb4_general_ci')
    return mydb
starttime = time.time()

def add_img(word,ele):
    word = word.replace("'","\\'")
    ele = ele.replace("'","\\'")
    qry="insert into tab_img set word='"+str(word)+"' , img ='"+str(ele)+"'"
    mydb = connessione()
    cur = mydb.cursor(buffered=True)
    cur.execute(qry)
    cur.close()

def add_definition(word,definizione):
    word = word.replace("'","\\'")
    definizion =""
    print("ADD DEFINITION_____________")
    print(definizione)
    print(type(definizione))
    
    if type(definizione) == list: 
        definizion = definizione[0]["definition"]
    if type(definizione) == dict: 
        definizion = definizione["definition"][0]
    if definizion=="":
        definizion = definizione

    if definizion and isinstance(definizion, str) :
        definizion = definizion.replace("'","\\'")
    
    
    qry="insert into tab_definition set word='"+str(word)+"' , definition ='"+str(definizion)+"'"
    print(qry)
    print("CLOSE ADD DEFINITION_____________")
    mydb = connessione()
    cur = mydb.cursor(buffered=True)
    cur.execute(qry)
    cur.close()
    

def check_definition(word):
    word = word.replace("'","\\'")
    qry="select * from tab_definition where word =  '"+str(word)+"'"
    print(qry)
    mydb = connessione()
    cur = mydb.cursor(buffered=True)
    cur.execute(qry)
    parole = cur.fetchall()
    result=[]
    for ele in parole:
        result = [ele[1],ele[2]]
        return result
    cur.close()
    return None

def check_img(word):
    word = word.replace("'","\\'")
    qry="select * from tab_img where word = '"+str(word)+"'"

    mydb = connessione()
    cur = mydb.cursor(buffered=True)
    cur.execute(qry)
    parole = cur.fetchall()
    result=[]
    for ele in parole:
        print(ele)
        result = [ele[1],ele[2]]
        return result
    return None

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
            word =d.get_gender(word)
            
            
               
        else:
            word

        print(word)
        return word
def find_picto2( keyword, language_code='en', resolution=500):
    old_img = check_img(keyword)
    if old_img:
        img_url = old_img[1]
        return img_url
    print("find picto normal")
    url = "https://api.arasaac.org/api/pictograms/" + language_code + "/search/"
    response = requests.request("GET", url + keyword.lower())
    if response.status_code == 200:
        id = response.json()[0]['_id']
        image_url = 'https://api.arasaac.org/api/pictograms/' + str(id) + '?resolution='+str(resolution)
        add_img(keyword,image_url)
        return image_url
    else:
        return None



def trova_sinonimi(word):

    print("trova ")
    # Effettua la chiamata usando il nuovo metodo
    response = openai.ChatCompletion.create(
        model="gpt-4",
        messages=[
            {"role": "system", "content": "You are a helpful assistant and always respond in list or JSON format."},
            {"role": "user", "content": "Generates a list of synonyms of '"+str(word)+"' and their definition in JSON array format the keys are synonym and definition."}
        ]
    )
    print(response)
    response_content = response["choices"][0]["message"]["content"]
    if response_content:
        response_list = json.loads(response_content)
        return response_list
    else:
        return []
   


def trova_definizione(word):
    old_definition = check_definition(word)
    if old_definition:
        img_url = old_definition[1]
        return [{"definition":img_url}]
    
    # Effettua la chiamata usando il nuovo metodo
    response = openai.ChatCompletion.create(
        model="gpt-4",
        messages=[
            {"role": "system", "content": "You are a helpful assistant and always respond in list or JSON format."},
            {"role": "user", "content": "give me the definition of '"+str(word)+"' in JSON array format with definition key and string type value. "}
        ]
    )
    print("TROVA DEFINIZIOOE___________")
    print(response)
    # Estrai il contenuto della risposta
    response_content = response["choices"][0]["message"]["content"]

    # Converte la risposta JSON in una lista Python
    response_list = json.loads(response_content)
    add_definition(word,response_list)
    return response_list

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
    for ln in range(1,3):
        if ln==1:
            lan='it'
            qry="select * from tab_text where status=0 "
        else:   
            lan='en' 
            qry="select * from tab_text where status_en=0 "
        mydb = connessione()
        cur = mydb.cursor(buffered=True)
        cur.execute(qry)
        libro = cur.fetchall()
        
        for ele in libro:
            print(lan)
            if lan=='it':    
                language ="it"
                lang="italian"
                titolo = ele[1]
                testo = ele[2]
            else:
                language ="en"
                lang="english"
                titolo = ele[3]
                testo = ele[4]
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
                    #text_simpl =simplify_sentence(frase,lang)
                    text_simpl = ""
                    print(text_simpl)
                    qry="insert into tab_map set id_text="+str(idtesto)+", text ='"+str(frase)+"' , text_simp ='"+str(text_simpl)+"' ,lang='"+str(language)+"'"
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
                                if check_img(parola)==[]:
                                    add_img(parola,img)
                            print(parola2)
                            print(img)
                            parola = parola.replace("'","\\'")
                        qryins ="insert into tab_keyword set id_map="+str(idmap)+" ,keyw ='"+str(parola)+"' , img ='"+str(img)+"'"
                       
                        cur1.execute(qryins)
                cur1.close

                salvastato(idtesto,2,lan)
               
                parole = get_most_difficult_words(testo,language)
                x=0
                
                if language =="it":
                    testo_domanda ="Cosa significa "
                else:
                    testo_domanda ="What does it mean "
                for ele in parole:
                    print(ele)
                    definizione=[]
                    x=x+1
                    definizione = trova_definizione(ele)
                        
                    print("########")
                    print(definizione)
                    print("########")
                    definizion=""
                    print(type(definizione))
                    if type(definizione) == list: 
                        definizion = definizione[0]["definition"]
                    if type(definizione) == dict: 
                        definizion = definizione["definition"]
                    if definizion=="":
                        definizion = definizione

                    if definizion and isinstance(definizion, str) :
                        definizion = definizion.replace("'","\\'")

                    frase = extract_sentence(language,testo,ele).replace("'","\\'")
                    
                    
                    img=""
                    
                    img = find_picto2(ele)
                        
                    
                    print(img)
                    if img:
                        qryins="insert into tab_difficult_words set id_text="+str(idtesto)+", img ='"+str(img)+"' , word ='"+str(ele).replace("'","\\'")+"',definition='"+str(definizion)+"',frase='"+str(frase)+"', lang='"+str(language)+"'"
                        print("_______________________")
                        print(qryins)
                        print("_______________________")
                        qryins1="insert into tab_question set id_exercise = 1, id_text="+str(idtesto)+", question ='"+str(testo_domanda)+" "+str(ele).replace("'","\\'")+" ?',multi=0, lang='"+str(language)+"', tab_question.order="+str(x)+""    
                        #qryins2="insert into tab_question set id_exercise = 2, id_text="+str(idtesto)+", question ='"+str(testo_domanda)+" "+str(ele).replace("'","\\'")+" ?',multi=0, lang='"+str(language)+"', tab_question.order="+str(x)+""    
                    
                        mydb = connessione()
                        cur = mydb.cursor(buffered=True)
                        cur.execute(qryins)
                        cur.execute(qryins1)
                        #cur.execute(qryins2)
                        cur.close() 


                    
                mydb = connessione()   
                cur = mydb.cursor(buffered=True) 
                qrysel="Select * from tab_difficult_words where id_text="+str(idtesto)
                cur.execute(qrysel)
                par = cur.fetchall()
                for ele in par:
                    lista_sinonimi = trova_sinonimi(ele[2])
                    paroledacercare=0
                    for element in lista_sinonimi:
                        
                        img_app = find_picto2(element["synonym"])
                        if img_app:
                            paroledacercare =paroledacercare+1
                            defin = element["definition"].replace("'","\\'")
                            parola = element["synonym"].replace("'","\\'")
                            qryins = "insert into tab_synset_df set id_df="+str(ele[0])+", word ='"+str(parola)+"' , img ='"+str(img_app)+"', definition ='"+str(defin)+"'"
                            print(qryins)
                            cur.execute(qryins)

                
                #get_most_difficult_words_loop(idtesto,testo,language,lang)
                """"
                   
                    
                    qry="insert into tab_map set id_text="+str(idtesto)+", text ='"+str(frase)+"' , text_simp ='"+str(text_simpl)+"' ,lang='"+str(language)+"'"
                    mydb = connessione()
                    cur = mydb.cursor(buffered=True)
                """
                """
                stringhe = get_sentences(testo,lang)
                print("Inizio salva frasi")
                for stringa in stringhe:
                    salva_testo(stringa,language,idtesto,"")
                print("Fine salva frasi")
                
                print("Inizio salva keyword + img")
                carica_keywords(idtesto,language,2)
                print("Fine salva keyword + img")
                salvastato(idtesto,3,lan)
                print("Inizio semplifica")
                
                
                simplify_sentence_loop(idtesto,lang,language) 
                print("Fine semplifica")
                salvastato(idtesto,4,lan)
                print("parole difficili e esercizi")
                
                salvastato(idtesto,5,lan)
                print("pronomi")
                pronouns_loop(idtesto,testo,lang,language)
                salvastato(idtesto,10,lan)  
                print("Fine "+str(titolo))       
            else:
                salvastato(idtesto,-1,lan)        
"""
    time.sleep(60.0 - ((time.time() - starttime) % 60.0))
                                                                                            