# MIRKS Image Compression App

The MIRKS Image Compression App is a web application that allows users to compress images using a server-side image compression algorithm. It provides an intuitive user interface for selecting and compressing images, and displays the compressed image to the user.

## Features

- Image compression using a server-side algorithm
- Accepts various image formats (JPEG, PNG, etc.)
- User-friendly interface for selecting and compressing images
- Displays the compressed image to the user

## Technologies Used

- HTML, CSS, JavaScript for the frontend
- Python for the backend
- C for the image compression algorithm
- Libraries: libjpeg (for image compression), Flask (Python web framework)

## Prerequisites

- Python 3.x installed on your machine
- Flask and libjpeg libraries installed (for the backend)

## Installation

1. Clone the repository:

git clone https://github.com/maranathaadesanya/MIRKS.git

2. Navigate to the project directory:

cd mirks-image-compression-app

3. Install the required Python packages:

pip install -r requirements.txt

4. Compile the C program for image compression (if necessary) using an appropriate compiler. Make sure the compiled C program is placed in the correct location and can be accessed by the backend.

5. Start the server:

python mirks.py

6. Access the app by visiting `http://localhost:5000` in your web browser.

## Usage

1. Open the MIRKS Image Compression App in your web browser.

2. Click on the "Choose File" button to select an image file from your local device.

3. Once the image is selected, click the "Compress Image" button.

4. The app will send the selected image to the server for compression.

5. After the compression process is completed, the compressed image will be displayed on the page.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please feel free to submit a pull request or open an issue in the GitHub repository.
