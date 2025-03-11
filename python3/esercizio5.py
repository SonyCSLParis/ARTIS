import openai
import json
import mysql.connector
import requests
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

def trova_non_sinonimi(word,numero,lang):
    if lang =="it":
        response = openai.ChatCompletion.create(
            model="gpt-4",
            messages=[
                {"role": "system", "content": "Sei un assistente utile e rispondi sempre in formato lista o JSON."},
                {"role": "user", "content": "Genera una lista di '"+str(numero)+"' non sinonimi della parola '"+str(word)+"' e completamente non legate semanticamente e la loro definizione , assicurandoti che non abbiano alcuna connessione semantica, in formato JSON array le chiavi sono parola e definizione."}
            ]
        )
        print(response)
        # Estrai il contenuto della risposta
        response_content = response["choices"][0]["message"]["content"]

        # Converte la risposta JSON in una lista Python
        response_list = json.loads(response_content)
        return response_list
    if lang =="en":
        response = openai.ChatCompletion.create(
            model="gpt-4",
            messages=[
                {"role": "system", "content": "You are a helpful assistant and always respond in list or JSON format."},
                {"role": "user", "content": "Generate a list of '"+str(numero)+"' non-synonyms of the word '"+str(word)+"' and completely unrelated semantically and their definition, ensuring they have no semantic connection, in JSON array format the keys are word and definition."}
            ]
        )
        print(response)
        # Estrai il contenuto della risposta
        response_content = response["choices"][0]["message"]["content"]

        # Converte la risposta JSON in una lista Python
        response_list = json.loads(response_content)
        return response_list

def trova_sinonimi(word,lang):

    if lang =="it":
        # Effettua la chiamata usando il nuovo metodo
        response = openai.ChatCompletion.create(
            model="gpt-4",
            messages=[
                {"role": "system", "content": "Sei un assistente utile e rispondi sempre in formato lista o JSON."},
                {"role": "user", "content": "Genera una lista di sinonimi di '"+str(word)+"' e la loro definizione in formato JSON array le chiavi sono sinonimo e definizione."}
            ]
        )
        print(response)
        # Estrai il contenuto della risposta
        response_content = response["choices"][0]["message"]["content"]

        # Converte la risposta JSON in una lista Python
        response_list = json.loads(response_content)
        return response_list
    if lang =="en":
        # Effettua la chiamata usando il nuovo metodo
        response = openai.ChatCompletion.create(
            model="gpt-4",
            messages=[
                {"role": "system", "content": "You are a helpful assistant and always respond in list or JSON format."},
                {"role": "user", "content": "Generates a list of synonyms of '"+str(word)+"' and their definition in JSON array format the keys are synonym and definition."}
            ]
        )
        print(response)
        # Estrai il contenuto della risposta
        response_content = response["choices"][0]["message"]["content"]

        # Converte la risposta JSON in una lista Python
        response_list = json.loads(response_content)
        return response_list

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
def trova_definizione(word,lang):

    if lang=='it':
    # Effettua la chiamata usando il nuovo metodo
        response = openai.ChatCompletion.create(
            model="gpt-4",
            messages=[
                {"role": "system", "content": "Sei un assistente utile e rispondi sempre in formato lista o JSON."},
                {"role": "user", "content": "dammi la definizione di '"+str(word)+"' in formato JSON array con chiave definizione."}
            ]
        )
        #print(response)
        # Estrai il contenuto della risposta
        response_content = response["choices"][0]["message"]["content"]

        # Converte la risposta JSON in una lista Python
        response_list = json.loads(response_content)
        res = response_list[0]["definizione"].replace("'","\\'")
    if lang=='en':
        response = openai.ChatCompletion.create(
            model="gpt-4",
            messages=[
            {"role": "system", "content": "You are a helpful assistant and always respond in list or JSON format."},
            {"role": "user", "content": "give me the definition of '"+str(word)+"' in JSON array format with definition key and string type value. "}
            ]
        )
        #print(response)
        # Estrai il contenuto della risposta
        response_content = response["choices"][0]["message"]["content"]

        # Converte la risposta JSON in una lista Python
        response_list = json.loads(response_content)
        res = response_list[0]["definition"].replace("'","\\'")
    return res

def run_exercise5(id,lang):
    query = "select * from tab_word where id_word="+str(id)
    mydb = connessione()
    cur = mydb.cursor(buffered=True)
    cur.execute(query)  
    frase = cur.fetchall()
    for ele in frase:
        word = ele[1]
        id_word = ele[0]
        urlimg = find_picto2(word,lang)
        #print(urlimg)
        definizione = trova_definizione(word,lang)
        definizion = definizione
        #print(definizione[0]["definizione"])
        qryupdate = "update tab_word set img='"+str(urlimg)+"' , definition ='"+str(definizion)+"' where id_word="+str(id_word)
        print(qryupdate)
        cur.execute(qryupdate)  

        ## inserisco img e definizione della parola di partenza
        lista_sinonimi = trova_sinonimi(word,lang)
        paroledacercare=0
        
        
        for element in lista_sinonimi:
            if lang=="it":
                pp =element["sinonimo"]
                img_app = find_picto2(element["sinonimo"],lang)
            if lang=="en":
                pp =element["synonym"]
                img_app = find_picto2(element["synonym"],lang)
            if img_app:
                paroledacercare =paroledacercare+1
                if lang=="it":
                    defin = element["definizione"].replace("'","\\'")
                if lang=="en":
                    defin = element["definition"].replace("'","\\'")
                qryins = "insert into tab_synset set id_word="+str(ele[0])+", word ='"+str(pp)+"' , img ='"+str(img_app)+"', definition ='"+str(defin)+"',giusto=1"
                
                cur.execute(qryins)
        
        
        lista_non_sinonimi = trova_non_sinonimi(word,len(lista_sinonimi),lang)
        st = 0
        for element in lista_non_sinonimi:
            if lang=="it":
                pp =element["parola"]
                img_app = find_picto2(element["parola"],lang)
            if lang=="en":
                pp =element["word"]
                img_app = find_picto2(element["word"],lang)
           
            if img_app:
                st=st+1
                if lang=="it":
                    defin = element["definizione"].replace("'","\\'")
                if lang=="en":
                    defin = element["definition"].replace("'","\\'")
                qryins = "insert into tab_synset set id_word="+str(ele[0])+", word ='"+str(pp)+"' , img ='"+str(img_app)+"', definition ='"+str(defin)+"',giusto=0"
                
                cur.execute(qryins)
                if st== paroledacercare:
                    break    
            #print(lista_sinonimi)
        ##trovo img e salvo 
    cur.close()