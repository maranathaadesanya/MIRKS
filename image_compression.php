<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  
    // Check if the file is an image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "Error: Invalid image file.";
        exit;
    }

    // Generate a unique filename
    $filename = uniqid() . "." . $imageFileType;
    $compressed_file = $target_dir . $filename;
    
    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $filename)) {
        // Run the image compression command
        exec("image_compression " . $target_dir . $filename . " " . $compressed_file);

        // Check if the compression was successful
        if (file_exists($compressed_file)) {
            // Send the compressed image file to the client
            header("Content-Type: image/" . $imageFileType);
            header("Content-Length: " . filesize($compressed_file));
            header("Content-Disposition: inline; filename=" . $filename);
            readfile($compressed_file);
            
            // Delete the compressed file
            unlink($compressed_file);
        } else {
            echo "Error: Image compression failed.";
        }

        // Delete the original uploaded file
        unlink($target_file);
    } else {
        echo "Error: Failed to move the uploaded file.";
    }
} else {
    echo "Error: Invalid request.";
}
?>
