<?php
    session_start(); // Start the session
    require_once('mail/database.php');
    // Check if session variables are set and not empty
    if (!empty($_SESSION['fname']) && !empty($_SESSION['lname']) && !empty($_SESSION['email']) && !empty($_SESSION['phone']) && !empty($_SESSION['location'])  && !empty($_SESSION['password'])) {
        $query = $mysqli->prepare("SELECT * FROM users WHERE firstname = ? AND lastname = ? AND email = ? ");
        $query->bind_param("sss", $_SESSION['fname'],$_SESSION['lname'],$_SESSION['email']);
        $query->execute();
        $userexist = $query->get_result()->fetch_assoc();
        if($userexist){
            echo '<script>alert("This account has already been created you cannot duplicate it ");</script>';
            echo '<script>window.location.href="../pages/register.php";</script>';
            exit;
        }else{
            $query = $mysqli->prepare('INSERT INTO users (firstname, lastname, email, phone, location,  password,photo) VALUES ( ?, ?, ?, ?, ?, ?,?)');

            $query->bind_param('sssssss', $_SESSION['fname'], $_SESSION['lname'], $_SESSION['email'], $_SESSION['phone'], $_SESSION['location'],  $_SESSION['password'],$_SESSION['filename']);
            $query->execute();
        
            if ($query->affected_rows > 0) {
                echo '<script>alert("Account created successfully you can now login");</script>';
                echo '<script>window.location.href="../index.php";</script>';
                exit;
            } else {
                echo "Error creating account: " . $mysqli->error;
            }
        
            // Close the statement
            $query->close();
        }
    } else {
        // Handle empty session variables
        echo '<script>alert("Registration failed, please try again.");</script>';
        echo '<script>window.location.href="../pages/signup.php";</script>';
        exit;
    }
?>
