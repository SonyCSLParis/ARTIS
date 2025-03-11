Code to fine-tune open source image generation models (available on Hugging Face) on ARASAAC pictograms



## Running the code:

Launch train_multiple.sh to run Get_Pictos.py => train_text_to_image.py => Gen_Picto_Model_Comps.py
This will retreive pictograms from ARASAAC, fine-tune the pretrained image-gen models on the pictograms and generate images using the fine-tuned models


## Description of files in picto_generation:

- Get_One_Picto.py: script to retrieve url of one picto from arasaac api 


- Gen_Picto_Model_Comps.py: script to generate test image from fine-tuned models


- Get_Pictos.py: script to retrieve and save pictograms locally 


- Get_Resize_Example.py: script to produce examples of one pictogram at different lower resolutions


- train_text_to_image.py: script to fine-tune model on new images


- train_multiple.sh: bash code to launch Get_Pictos.py => train_text_to_image.py => Gen_Picto_Model_Comps.py
