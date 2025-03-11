import openai
import json

# Imposta la tua chiave API
openai.api_key = "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"

# Esempio di richiesta con ChatCompletion
response = openai.ChatCompletion.create(
    model="gpt-4",  # Modello GPT aggiornato
    messages=[
        {"role": "system", "content": "Sei un assistente utile."},
        {"role": "user", "content": "Dammi una lista di 5 linguaggi di programmazione più usati."}
    ],
    temperature=0.7,
    max_tokens=5
)

# Estrarre solo il contenuto generato
response_text = response['choices'][0]['message']['content']

# Trasformare in una lista Python, separata per righe
response_list = response_text.split("\n")

# Pulire la lista (rimuove eventuali linee vuote o spazi extra)
response_list = [item.strip() for item in response_list if item.strip()]

# Stampa ogni elemento indicizzato
for index, item in enumerate(response_list, start=1):
    print(f"{index}: {item}")