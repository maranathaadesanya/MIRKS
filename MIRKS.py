import subprocess
import os
from flask import Flask

app = Flask(__name__)

@app.route('/')
def compress_image(input_image_path, output_image_path):
    # Path to the compiled C program
    c_program = "./image_compression"
    
    # Check if the C program exists
    if not os.path.exists(c_program):
        print("C program not found.")
        return
    
    # Call the C program using subprocess
    try:
        subprocess.call([c_program, input_image_path, output_image_path])
        print("Image compression completed.")
    except subprocess.CalledProcessError as e:
        print("Error occurred during image compression:", e)

# Example usage
input_image = "input.jpg"
output_image = "output.jpg"
compress_image(input_image, output_image)
