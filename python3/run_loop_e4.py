from artisapi.main2 import *
from texttopictogramsmain.picto_retrieval.Get_Pictos_yake_meanings import *
import time
import mysql.connector
import requests
from bs4 import BeautifulSoup
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

    print("find picto normal")
    url = "https://api.arasaac.org/api/pictograms/" + language_code + "/search/"
    response = requests.request("GET", url + keyword.lower())
    if response.status_code == 200:
        id = response.json()[0]['_id']
        image_url = 'https://api.arasaac.org/api/pictograms/' + str(id) + '?resolution='+str(resolution)
        return image_url
    else:
        return None


# URL della pagina che vuoi fare scraping
def cerca_definizione(parola):
    res=""
    url = 'https://www.dizionario-italiano.it/dizionario-italiano.php?parola='+str(parola)  # Cambia con il tuo URL
    print(url)
    # Invia una richiesta GET alla pagina
    response = requests.get(url)

    # Verifica se la richiesta è stata eseguita con successo (status code 200)
    if response.status_code == 200:
        # Analizza il contenuto HTML della pagina
        soup = BeautifulSoup(response.content, 'html.parser')
        esempi = soup.find_all(class_='esempi')
        for elemento in esempi:
            elemento.decompose()
        autore = soup.find_all(class_='autore')
        for elemento in autore:
            elemento.decompose()
        italic = soup.find_all(class_='text-italic')
        for elemento in italic:
            elemento.decompose()

        # Trova tutti gli elementi con la classe 'italiano'
        elementi_italiano = soup.find_all(class_='italiano')
        if elementi_italiano:
        # Stampa il testo di ciascun elemento trovato
            for elemento in elementi_italiano:
                #print(elemento.get_text(strip=True))
                res = elemento.get_text(strip=True)
                return res
        
        
        else:
            return res     
    else:
       
        print("Errore nella richiesta:", response.status_code)    
        return res

def prova_definizione(parola):
    
    res = cerca_definizione(parola)
    if res:
        return res

    print("non trovato")
    paroladacercare = parola[0:len(parola)-1]+str("?")
    res = cerca_definizione(paroladacercare)
    print(res)
    if res:
        return res
    print("non trovato1")
    paroladacercare = parola.upper()+str(100)
    res = cerca_definizione(paroladacercare)
    print(res)
    if res:
        return res
    print("non trovato2")
    paroladacercare = lemmatize_word(parola)
    res = cerca_definizione(paroladacercare)
    print(res)
    if res:
        return res
    print("non trovato3")
    res = cerca_definizione(paroladacercare.upper()+str(100))
    print(res)
    if res:
        return res
    res=""
    return res
     
def lemmatize_word( word, language_code="it"):
        if language_code == None:
            language_code = language_code
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

def salvastato(idtesto,stato,language):
    if language=='it':
        qry ="update tab_text_exe set status="+str(stato)+" where id_text="+str(idtesto)+""
    else:
        qry ="update tab_text_exe set status_en="+str(stato)+" where id_text="+str(idtesto)+""
    mydb = connessione()
    cur = mydb.cursor(buffered=True)
    cur.execute(qry)
    cur.close()

while True:
    print("tick")
    
       
    lan='it'
    qry="select * from tab_text_exe where status=0 "
    
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
            
            testo = testo.replace("-","")
            testo = testo.replace("\n"," ")
            print(testo) 
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
               
               
        
                qry="insert into tab_map_exe set id_text="+str(idtesto)+", text ='"+str(frase)+"'   ,lang='"+str(language)+"'"
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
                        print(parola2)
                        print(img)
                        parola = parola.replace("'","\\'")
                        qryins ="insert into tab_keyword_exe set id_map="+str(idmap)+" ,keyword ='"+str(parola)+"' , img ='"+str(img)+"'"
            # print(qryins) 
                    cur1.execute(qryins)
            cur1.close

            #salvastato(idtesto,2,lan)
            """
            parole = get_most_difficult_words(testo,language)
            x=0
            if language =="it":
                testo_domanda ="Cosa significa "
            else:
                testo_domanda ="What does it mean "
            for ele in parole:
                print(ele)
            
                x=x+1
                definizione = prova_definizione(ele).replace("'","\\'")
                frase = extract_sentence(language,testo,ele).replace("'","\\'")
                img = find_picto(ele,language)
                if img:
                    imgof = img[0]
                else:
                    imgof = ""

                qryins="insert into tab_difficult_words set id_text="+str(idtesto)+", img ='"+str(imgof)+"' , word ='"+str(ele).replace("'","\\'")+"',definition='"+str(definizione)+"',frase='"+str(frase)+"', lang='"+str(language)+"'"
                
                qryins1="insert into tab_question set id_exercise = 1, id_text="+str(idtesto)+", question ='"+str(testo_domanda)+" "+str(ele).replace("'","\\'")+" ?',multi=0, lang='"+str(language)+"', tab_question.order="+str(x)+""    
                qryins2="insert into tab_question set id_exercise = 2, id_text="+str(idtesto)+", question ='"+str(testo_domanda)+" "+str(ele).replace("'","\\'")+" ?',multi=0, lang='"+str(language)+"', tab_question.order="+str(x)+""    
                
                mydb = connessione()
                cur = mydb.cursor(buffered=True)
                cur.execute(qryins)
                cur.execute(qryins1)
                cur.execute(qryins2)
                cur.close() 
            #get_most_difficult_words_loop(idtesto,testo,language,lang)
         
                
                
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
                                                                                            