import os
from openai import OpenAI
import json


from openai import OpenAI
word="banca"
client = OpenAI( api_key="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")
chiamata = "Dammi una lista dei synset della parola '"+str(word)+"' da WordNet, in formato JSON"
completion = client.chat.completions.create(
    messages=[
          {"role": "system", "content": "Sei un assistente utile e rispondi sempre in formato lista o JSON."},
        {"role": "user", "content": "Genera una lista di synset di '"+str(word)+"' da WordNet in formato JSON array."}
       
    ],
    model="gpt-4o",
    
)
data = completion.choices[0].message.content
print(data)
"""
for chunk in stream:
    print(chunk.choices[0].delta.content or "", end="")



def ricerca(word):

       
    client = OpenAI(
        api_key="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"
    )
    chiamata = "Fornisci i synset della parola '"+str(word)+"' da WordNet, includendo le loro definizioni e esempi di utilizzo. "
    stream = client.chat.completions.create(
        messages=[ 
            {"role": "system", "content": "Sei un assistente utile."},
            {
                "role": "user",
                "content": chiamata,
            }
        ],
        model="gpt-4",
        temperature=0.7,
        max_tokens=10,
        stream=True,
   
    )
   # Converti il risultato in JSON string (se necessario)
    print(stream)
    for chunk in stream:
        print(chunk.choices[0].message.content or "", end="")
    # Imposta la tua chiave API
  

controchiamta = "Generate a list of words that are completely unrelated to the word '[word]', ensuring they have no semantic, phonetic, or contextual connection." 
controchiamata_en = "Genera un elenco di parole completamente non correlate alla parola '[word]', assicurandoti che non abbiano alcuna connessione semantica, fonetica o contestuale."


ricerca("banca")
"""