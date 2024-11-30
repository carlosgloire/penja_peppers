<?php
    session_start();
    require_once('../controllers/database/db.php');
    require_once('../controllers/functions.php');
    notAdmin();
    logout();
    $error = null;
    // Fetch post details if post_id is provided
    $post_id = $title = $content = $photo = '';

    if (isset($_GET['post_id']) && !empty($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
        $query = $db->prepare('SELECT * FROM posts WHERE post_id = ?');
        $query->execute([$post_id]);
        $post = $query->fetch();

        if ($post) {
            $title = $post['title'];
            $content = $post['content'];
            $photo = $post['image'];
        } else {
            echo '<script>alert("Post not found.");</script>';
            echo '<script>window.location.href="posts.php";</script>';
            exit;
        }
    } else {
        echo '<script>alert("Post not found.");</script>';
        echo '<script>window.location.href="posts.php";</script>';
        exit;
    }
    // Process the update form submission
    if (isset($_POST['update_post'])) {
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);

        $filename = $_FILES['uploadfile']['name'];
        $tempname = $_FILES['uploadfile']['tmp_name'];
        $folder = "../pages/posts_images/" . $filename;

        // Validation
        if (empty($title) || empty($content)) {
            $error = "Please fill all fields!";
        } elseif ($_FILES['uploadfile']['size'] > 5000000) {
            $error = "Your photo should not exceed 5MB";
        } else {
            // Use the previous photo if no new photo is uploaded
            if (empty($filename)) {
                $filename = $photo;
            } else {
                // Move the uploaded file
                if (!move_uploaded_file($tempname, $folder)) {
                    $error = "Error uploading file";
                }
            }

            // Update the post details
            $update_query = $db->prepare('UPDATE posts SET title=?, content=?, image=? WHERE post_id=?');
            $update_result = $update_query->execute([$title, $content, $filename, $post_id]);

            if ($update_result) {
                $success = "Post details updated successfully";
                echo "<script>alert('$success');</script>";
                echo '<script>window.location.href="posts.php";</script>';
                exit;
            } else {
                $error = "Failed to update post details";
            }
        }
    }
?>