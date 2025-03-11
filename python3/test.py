import requests

# URL dell'API di OpenAI (se utilizzi il modello di ChatGPT di OpenAI)
url = "https://api.openai.com/v1/chat/completions"

# Chiave API (da sostituire con la tua)

api_key ="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"

# Headers per l'autenticazione e il tipo di contenuto
headers = {
    "Authorization": f"Bearer {api_key}",
    "Content-Type": "application/json"
}

# Dati della richiesta
data = {
    "model": "gpt-3.5-turbo",   # Puoi specificare il modello, come 'gpt-3.5-turbo' o 'gpt-4'
    "messages": [
        {"role": "system", "content": "You are a helpful assistant."},
        {"role": "user", "content": "Come faccio una richiesta tramite API in Python?"}
    ],
    "temperature": 0.2
}

# Invia la richiesta POST
response = requests.post(url, headers=headers, json=data)

# Controlla se la richiesta ha avuto successo
if response.status_code == 200:
    # Ottieni la risposta in formato JSON e stampa il contenuto
    response_data = response.json()
    chat_response = response_data['choices'][0]['message']['content']
    print(chat_response)
else:
    print(f"Errore: {response.status_code}")
    print(response.json())