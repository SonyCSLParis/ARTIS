import requests
import json
from PIL import Image
from io import BytesIO
import os
import torch
from diffusers import StableDiffusionPipeline

words = ['how', 'angry', 'knife', 'river', 'her', 'giraffe', 'sick', 'under', 'asleep', 'you']

root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

input_path = os.path.join(root, "Models")

output_path = os.path.join(root, "Gen_pictos")
if not os.path.exists(output_path):
    os.makedirs(output_path)

training_sets = ['20', '150', '2000']

models = os.listdir(input_path)


if __name__ == '__main__':

    for model in models:
        sets = os.listdir(input_path)
        for set in sets:
            model_path = os.path.join(input_path,model,'output_model_'+set[13:])
            output_folder = os.path.join(output_path,model,'trained_on_'+set[13:])
            if not os.path.exists(output_folder):
                os.makedirs(output_folder)
            pipe = StableDiffusionPipeline.from_pretrained(model_path, torch_dtype=torch.float16)
            pipe.to("cuda")
            for w in words:
                image = pipe(prompt=w).images[0]
                image.save(os.path.join(output_folder,w+'.png'))








