const express = require('express');
const multer = require('multer');
const sharp = require('sharp');

const app = express();
const upload = multer({ dest: 'uploads/' });

app.post('/compress', upload.single('image'), (req, res) => {
  // Check if a file was uploaded
  if (!req.file) {
    return res.status(400).send('No image file provided');
  }

  const imagePath = req.file.path;

  // Compress the image using Sharp
  sharp(imagePath)
    .resize(800) // Adjust the desired compression settings
    .toBuffer((err, data) => {
      if (err) {
        return res.status(500).send('Error compressing the image');
      }

      // Do something with the compressed image data
      // For example, you can save it to a file or send it as a response
      // In this example, we're sending it as a base64-encoded data URL
      const compressedImage = `data:${req.file.mimetype};base64,${data.toString('base64')}`;
      return res.send(`<img src="${compressedImage}" alt="Compressed Image">`);
    });
});

// Start the server
const port = process.env.PORT || 3000;
app.listen(port, () => {
  console.log(`Server listening on port ${port}`);
});
