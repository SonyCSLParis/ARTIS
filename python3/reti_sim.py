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

def trova_non_sinonimi(word,numero):
  
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

def trova_sinonimi(word):

    
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
    # Stampa ogni elemento della lista
    #for index, item in enumerate(response_list, start=1):
    #    print(f"{index}: {item} ")

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
def trova_definizione(word):

    
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
    return response_list

def run_net_dw(id_text):
    query = "select * from tab_difficul_words where id_word="+str(id_text)
    mydb = connessione()
    cur = mydb.cursor(buffered=True)
    cur.execute(query)  
    frase = cur.fetchall()
    for ele in frase:
        word = ele[2]
        id_word = ele[0]
        urlimg = find_picto2(word)
        #print(urlimg)
        definizione = trova_definizione(word)
        definizion = definizione[0]["definizione"].replace("'","\\'")
        #print(definizione[0]["definizione"])
        qryupdate = "update tab_difficul_words set img='"+str(urlimg)+"' , definition ='"+str(definizion)+"' where id_df="+str(id_word)
        print(qryupdate)
        cur.execute(qryupdate)  

        ## inserisco img e definizione della parola di partenza
        lista_sinonimi = trova_sinonimi(word)
        paroledacercare=0
        
        
        for element in lista_sinonimi:
            img_app = find_picto2(element["sinonimo"])
            if img_app:
                paroledacercare =paroledacercare+1
                defin = element["definizione"].replace("'","\\'")
                qryins = "insert into tab_synset_df set id_word="+str(ele[0])+", word ='"+str(element["sinonimo"])+"' , img ='"+str(img_app)+"', definition ='"+str(defin)+"',giusto=1"
                
                cur.execute(qryins)
        
        
       
    cur.close()