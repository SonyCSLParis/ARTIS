import requests
from bs4 import BeautifulSoup

# URL della pagina che vuoi fare scraping
def cerca_definizione(parola):
    pippo=""
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

        # Trova tutti gli elementi con la classe 'italiano'
        elementi_italiano = soup.find_all(class_='italiano')
        if elementi_italiano:
        # Stampa il testo di ciascun elemento trovato
            for elemento in elementi_italiano:
                #print(elemento.get_text(strip=True))
                pippo = pippo+elemento.get_text(strip=True)
        else:
            print("non trovato")
            parola = parola.upper()+str(100)
            pippo = pippo+cerca_definizione(parola)
        return pippo     
    else:
        print("Errore nella richiesta:", response.status_code)



test = str(cerca_definizione("prova"))
definizioni = test.split("|")

print(definizioni[0].replace("[]",""))
