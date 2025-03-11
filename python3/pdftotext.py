import os
from PIL import Image
from pdf2image import convert_from_path
import pytesseract
import numpy as np
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
filePath ='../img/uploads/8.jpg' 
pp= "../img/uploads/"
def estrai_testo(filePath):
    totale=""
    if filePath.endswith('.pdf'):
        doc = convert_from_path(filePath)
        path, fileName = os.path.split(filePath)
        fileBaseName, fileExtension = os.path.splitext(fileName)
        for page_number, page_data in enumerate(doc):
            txt = pytesseract.image_to_string(page_data).encode("utf-8")
            #print("Page # {} - {}".format(str(page_number),txt.decode()))
            totale = totale + txt.decode()

    elif filePath.endswith('.jpg'):
        img1 = np.array(Image.open(filePath))
        text = pytesseract.image_to_string(img1)
        totale= text

    print(totale)
    res = pulisci_testo(totale)
    return res
def pulisci_testo(testo):
    testo = testo.replace("-\n","")
    testo= testo.replace("\n","")
    return testo

def inserisci_libro_da_img(file):
    print("inserisci")
  
    newp = os.path.join(pp, file)
    text = estrai_testo(newp)
    nomelibro = file.split(".")
    qryinsert = "insert into tab_text set title ='"+str(nomelibro[0])+"' , title_en ='TMP_TITLE' , text ='"+str(text.replace("'", "\\'"))+"' ,text_en ='' , status=0, status_en=0,  id_suitable =0"
    mydb = connessione()
    cur = mydb.cursor(buffered=True)
    cur.execute(qryinsert)
    idtext = cur.lastrowid
    cur.close() 
    os.remove(newp)
    print(idtext)
    return [text,idtext]

  