<?php
session_start();
include_once "./db.php";

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['pitch']) && !empty($_POST['title'])) {
        $pitch = htmlspecialchars($_POST['pitch'], ENT_QUOTES, 'UTF-8');
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
        $imgnewfile = null;
    
        // Handle image upload
        if (isset($_FILES['upload'])) {
            if ($_FILES['upload']['error'] === UPLOAD_ERR_OK) {
                $image = $_FILES['upload']['name'];
                $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    
                // Check if the file is an actual image
                $check = getimagesize($_FILES['upload']['tmp_name']);
                if ($check === false) {
                    header("Location: ../post.php?error=File is not an image.");
                    exit();
                }
    
                // Check file size (e.g., 5MB)
                if ($_FILES['upload']['size'] > 5000000) {
                    header("Location: ../post.php?error=Sorry, your file is too large.");
                    exit();
                }
    
                if (!in_array($extension, $allowed_extensions)) {
                    header("Location: ../post.php?error=Invalid format. Only jpg / jpeg/ png / gif formats are allowed.");
                    exit();
                }
    
                // Generate a unique filename and move uploaded file
                $imgnewfile = substr(md5($image), 0, 8) . time() . '.' . $extension;
                $target_path = "../Idea/" . $imgnewfile;
                if (!move_uploaded_file($_FILES['upload']['tmp_name'], $target_path)) {
                    header("Location: ../post.php?error=Error uploading image.");
                    exit();
                }
            } else {
                // Handle different upload errors
                switch ($_FILES['upload']['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $error_message = "File is too large.";
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $error_message = "File was only partially uploaded.";
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $error_message = "No file was uploaded.";
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $error_message = "Missing a temporary folder.";
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $error_message = "Failed to write file to disk.";
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        $error_message = "File upload stopped by extension.";
                        break;
                    default:
                        $error_message = "Unknown upload error.";
                        break;
                }
                header("Location: ../post.php?error=" . urlencode($error_message));
                exit();
            }
        }

        // Prepare and execute the SQL statement
        $sql = "INSERT INTO facts (user_id, pitch, title, picture) VALUES (:user_id, :pitch, :title, :picture)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'user_id' => $_SESSION['id'],
            'pitch' => $pitch,
            'title' => $title,
            'picture' => $imgnewfile
        ]);

        // Check if the statement executed successfully
        if ($result) {
            header("Location: ../post.php?message=New pitch posted successfully");
            exit();
        } else {
            // Log the SQL error for debugging
            $errorInfo = $stmt->errorInfo();
            header("Location: ../post.php?error=Error posting pitch: " . htmlspecialchars($errorInfo[2], ENT_QUOTES, 'UTF-8'));
            exit();
        }
    } else {
        header("Location: ../post.php?error=Pitch and title are required fields!");
        exit();
    }
} else {
    header("Location: ../post.php?error=Please login to post a pitch!");
    exit();
}
