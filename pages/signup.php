<?php
    require_once('../controllers/register.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="icon" href="../asset/images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="../asset/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Klee+One:wght@400;600&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.0/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <section class="login-section">
        <form action="" method="post"  enctype="multipart/form-data">
            <div class="errors-management">
                <p class="error"><?=$error?></p>
                <p class="success"><?=$success?></p>
            </div>
            <h3>Sign up here</h3>
            <div>
                <input type="text" name="fname" placeholder="Enter your first name" value="<?=isset($firstname)?$firstname:''?>">
                <input type="text" name="lname" placeholder="Enter your last name" value="<?=isset($lastname)?$lastname:''?>">
                <input type="text" name="email" placeholder="Enter your email address" value="<?=isset($email)?$email:''?>">
                <input type="text" name="phone" placeholder="Enter your phone number" value="<?=isset($phone)?$phone:''?>">
                <p style="text-align: left;">Profile photo</p>
                <input type="file" name="uploadfile" >
                <input type="text" name="location" placeholder="Enter your full address, country,city.." value="<?=isset($location)?$location:''?>">
                <input type="password" placeholder="Enter your password" name="password">
                <input class="button" type="submit" name="register" value="Sign in">
                <p class="forgot">Already have an account ? <a href="login.php">sign in here</a></p>

            </div>
        </form>
    </section>
</body>
</html>