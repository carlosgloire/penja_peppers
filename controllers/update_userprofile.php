<?php
$error = null;
$success = null;
require_once('database/db.php');

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo '<script>alert("No user ID provided.");</script>';
    echo '<script>window.location.href="../pages/";</script>';
    exit;
}

$query = $db->prepare('SELECT * FROM users WHERE user_id = ?');
$query->execute([$user_id]);
$user = $query->fetch();
if (!$user) {
    echo '<script>alert("User ID not found.");</script>';
    echo '<script>window.location.href="../pages/";</script>';
    exit;
}

$photo = $user['photo'];

if (isset($_POST['edit'])) {
    $firstname = htmlspecialchars($_POST['fname']);
    $lastname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $location = htmlspecialchars($_POST['location']);
    $current_password = htmlspecialchars($_POST['current_password']);
    $filename = $_FILES["uploadfile"]["name"];
    $filesize = $_FILES["uploadfile"]["size"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "../pages/profile_photo/" . $filename;
    $allowedExtensions = ['png', 'jpg', 'jpeg'];
    $pattern = '/\.(' . implode('|', $allowedExtensions) . ')$/i';

    // Validate other fields
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($location)) {
        $error = "Please complete all fields!!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Your email is incorrect.";
    } elseif (!preg_match("#^[+]+[0-9]{12}$#", $phone)) {
        $error = "Please write the phone number with the country code Ex:+1 000 000 000.";
    } elseif (!preg_match($pattern, $_FILES['uploadfile']['name']) && !empty($_FILES['uploadfile']['name'])) {
        $error = "Your file must be in \"jpg, jpeg or png\" format";
    } elseif ($filesize > 3000000) {
        $error = "Your file must not exceed 3Mb";
    } elseif (!empty($filename) && !move_uploaded_file($tempname, $folder)) {
        $error = "Error while uploading";
    } elseif (empty($current_password)) {
        $error = "To update your profile enter your password !!";
    } elseif (!password_verify($current_password, $user['password'])) {
        $error = "Incorrect password. Please try again.";
    } else {
        // Check for existing email
        $existing_user_query = $db->prepare("SELECT * FROM users WHERE email = :email AND user_id != :user_id");
        $existing_user_query->execute(['email' => $email, 'user_id' => $_SESSION['user_id']]);
        $existing_user = $existing_user_query->fetch(PDO::FETCH_ASSOC);

        if ($existing_user) {
            $error = "There is another account created with the email address you entered in this system. Please change the email or delete the account.";
        }

        if (empty($filename)) {
            $filename = $photo;
        }

        // Perform the update
        $query = $db->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ?, phone = ?, location = ?, photo = ? WHERE user_id = ?");
        $update = $query->execute([$firstname, $lastname, $email, $phone, $location, $filename, $_SESSION['user_id']]);

        if ($update) {
            // Check if email was modified
            if ($email !== $user['email']) {
                unset($_SESSION['user']);
                echo '<script>alert("Profile updated successfully login again.");</script>';
                echo '<script>window.location.href="../";</script>';
                exit;
            }
            $success = "Profile updated successfully.";

        } else {
            $error = "Error updating profile.";
        }
    }
}
?>
