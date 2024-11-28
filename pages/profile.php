<?php
session_start();
require_once('../controllers/database/db.php');
require_once('../controllers/delete_account.php');
require_once('../controllers/functions.php');
require_once('../controllers/update_userprofile.php');
notconnected();
logout();
if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $_SESSION['user_id'] = $user_id; // Ensure session user_id is set
} elseif (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo '<script>alert("No user ID provided.");</script>';
    echo '<script>window.location.href="templates/";</script>';
    exit;
}

$query = $db->prepare('SELECT * FROM users WHERE user_id = ?');
$query->execute([$user_id]);
$user = $query->fetch();

if ($user) {
    $photo = $user['photo'];
    $fname = $user['firstname'];
    $lname = $user['lastname'];
    $email = $user['email'];
    $phone = $user['phone'];
    $location_fetched = $user['location'];

} else {
    echo '<script>alert("User ID not found.");</script>';
    echo '<script>window.location.href="templates/";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="../asset/images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="../asset/css/userDashboard.css">
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
    <section>
      <aside>
        <nav>
          <div class="title">
            <i class="bi bi-person-circle"></i> <h3>Penja Peppers</h3>
          </div>
          <div >
            <i class="bi bi-speedometer2"></i>
            <a href="userDashboard.php">Dashboard</a>
          </div>
          <div class="activ">
            <i class="bi bi-gear-wide-connected"></i>
            <a href="">Settings</a>
          </div>
          <div>
            <i class="bi bi-credit-card-2-front"></i>
            <a href="payment_history.php">Payment history</a>
          </div>
          <form action="" method="post">
            <button name="logout"><i class="bi bi-box-arrow-left"></i> <p>Logout</p></button>
          </form>
        </nav>
      </aside>
      <div class="right-side">
        <div class="profile-section">

            <div class="profile-card">
                <img src="profile_photo/<?=$photo?>" alt="User Profile Photo">
                <h3><?=$fname?> <?=$lname?></h3>
                <p>Email: <?=$email?></p>
                <p>Phone: <?=$phone?></p>
                <p>Address: <?=$location_fetched?></p>
                <button title="Delete my account" class="delete" id="open" name="delete" ><i class="bi bi-trash3"></i></button>
            </div>
            <?=popup_delete_count($error)?>
            <div class="profile-edit">
              <form action="" action="" method="POST" enctype="multipart/form-data">
                  <h4>Edit My profile</h4>
                  <input type="text" name="fname"  value="<?=$fname?>">
                  <input type="text" name="lname"  value="<?=$lname?>">
                  <input type="email" name="email"  value="<?=$email?>">
                  <input type="text" name="phone"  value="<?=$phone?>">
                  <input type="text" name="location" value="<?=$location_fetched?>">
                  <input type="file" name="uploadfile" accept="image/*">
                  <input type="password" name="current_password" placeholder="Enter your password to update your profile">
                  <input type="submit"  name="edit" value="Save changes" class="edit-button">
                  <div class="errors-management">
                      <p class="error"><?=$error?></p>
                      <p class="success"><?=$success?></p>
                  </div>
              </form>
            </div>
        </div>
      </div>
    </section>
    <script src="../asset/javascript/popup_delete_account.js"></script>
</body>
</html>
