<?php
$error = null;
$success = null;
require_once('database/db.php');

function generateSlug($title) {
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
}

if (isset($_POST['add_post'])) {
    // Retrieve and sanitize input
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    // Handle file upload
    $filename = $_FILES["uploadfile"]["name"];
    $filesize = $_FILES["uploadfile"]["size"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "../pages/posts_images/" . $filename;
    $allowed_formats = array('jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG');
    $slug = generateSlug($title);
    
    // Check for duplicate entry
    $existing_post = $db->prepare('SELECT * FROM posts WHERE title = :title');
    $existing_post->execute(['title' => $title]);
    $get_post = $existing_post->fetch();

    if (empty($title)  || empty($content)  || empty($filename)) {
        $error = "Please fill all fields!";
    }elseif ($filesize > 5000000) {
        $error = "Your photo should not exceed 5MB.";
    } elseif (!in_array(pathinfo($filename, PATHINFO_EXTENSION), $allowed_formats)) {
        $error = "Only JPG, JPEG, and PNG formats are allowed.";
    } elseif ($get_post) {
        $error = "The post <strong>" . $title . "</strong> already exists.";
    } else {
        // Move uploaded file
        if (!move_uploaded_file($tempname, $folder)) {
            $error = "Error uploading the file.";
        } else {
            // Insert into posts table
            $query = $db->prepare('INSERT INTO posts (title, content,  image, post) VALUES (:title,  :content,  :image, :post)');
            $query->bindParam(':title', $title);
            $query->bindParam(':content', $content);
            $query->bindParam(':image', $filename);
            $query->bindParam(':post', $slug);

            if ($query->execute()) {
                $success = "Post added successfully ✅";
            } else {
                $error = "Error adding the post.";
            }
        }
    }
}
?>
