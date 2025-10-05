<?php

try {
    include_once('../conn/config.php');
    include_once('../conn/headers.php');

    if ($conn) {

        // Check if the image file was uploaded without errors
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Define the directory where you want to store the uploaded images
            $uploadDirectory = 'uploads/';

            // Create the directory if it doesn't exist
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            // Get the temporary file name
            $tempName = $_FILES['image']['tmp_name'];

            // Generate a unique file name for the uploaded image
            $uniqueName = uniqid('image_') . '.jpg'; // You can adjust the file extension as needed

            // Build the full path to the destination file
            $destination = $uploadDirectory . $uniqueName;

            // Move the temporary file to the destination directory
            if (move_uploaded_file($tempName, $destination)) {

             
                

                $query = "INSERT INTO news ('dept', 'title', 'desc', 'img' ) VALUES ( 'a', 'b', 'c',  '$uniqueName')";
                $stmt = $conn->prepare($query);
                if ($stmt->execute()) {
                    echo json_encode(['message' => 'File uploaded and data inserted successfully']);
                } else {
                    echo json_encode(['error' => 'Error inserting data into the database']);
                }
                // File uploaded successfully
                echo json_encode(['message' => 'File uploaded successfully', 'filename' => $uniqueName]);
            } else {
                // Error moving the file
                echo json_encode(['error' => 'Error uploading the file']);
            }
        } else {
            // File upload error
            echo json_encode(['error' => 'File upload error']);
        }
    } else {
        echo "something went wrong";
    }

    /* close connection */
    $conn = null;
} catch (PDOException $e) {
    echo $e->getMessage();
}
