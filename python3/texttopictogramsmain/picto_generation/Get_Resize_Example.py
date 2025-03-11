from PIL import Image
from torchvision import transforms
import os
import random

root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

pictos_folder = os.path.join(root,"Pictos")

image_files = os.listdir(os.path.join(pictos_folder,os.listdir(pictos_folder)[0]))
random.shuffle(image_files)

# Path to the input image
input_image_path = os.path.join(pictos_folder,os.listdir(pictos_folder)[0],image_files[0])

output_folder = os.path.join(root,'Resize_examples')
if not os.path.exists(output_folder):
    os.makedirs(output_folder)

# Resolution to resize the image
# res = 80  # Replace with your desired resolution
resolutions = [16, 32, 50, 75, 100, 120, 150, 200]


if __name__ == '__main__':

    for res in resolutions:
        # Read the input image
        input_image = Image.open(input_image_path)

        # Define the transformation to resize the image
        resize_transform = transforms.Resize(res, interpolation=transforms.InterpolationMode.BILINEAR)

        # Apply the transformation to resize the image
        resized_image = resize_transform(input_image)

        # Path to save the resized image
        image_name = image_files[0].split('.')[0]
        output_image_path = os.path.join(output_folder,image_name + '_' + str(res) + '.png')

        # Save the resized image
        resized_image.save(output_image_path)

        # Display the resized image
        # resized_image.show()
