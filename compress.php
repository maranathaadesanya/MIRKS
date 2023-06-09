<?php
// Check if the image file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $imageFile = $_FILES["image"]["tmp_name"];

    // Move the uploaded image to a desired location
    $uploadDir = "uploads/";
    $targetFile = $uploadDir . basename($_FILES["image"]["name"]);
    move_uploaded_file($imageFile, $targetFile);

    // Invoke the Python script to compress the image
    $pythonScript = "MIRKS.py";
    $command = "python3 " . $pythonScript . " " . $targetFile . " " . $uploadDir;
    $output = shell_exec($command);

    // Get the compressed image file path from the Python script's output
    $compressedImagePath = trim($output);

    // Check if the compression was successful
    if ($compressedImagePath) {
        // Create the compressed directory if it doesn't exist
        $compressedDir = "compressed/";
        if (!is_dir($compressedDir)) {
            mkdir($compressedDir, 0777, true);
        }

        // Generate a unique filename for the compressed image
        $compressedFilename = uniqid() . ".jpg";
        $compressedFile = $compressedDir . $compressedFilename;

        // Move the compressed image to the compressed directory
        rename($compressedImagePath, $compressedFile);

        // Display the compressed image to the user
        echo "<img src='" . $compressedFile . "' alt='Compressed Image'>";

        // Delete the original uploaded file
        unlink($targetFile);
    } else {
        echo "Failed to compress the image.";
    }
} else {
    echo "No image file uploaded.";
}
?>
