<?php
session_start();
require_once('../controllers/database/db.php');
require_once('../controllers/functions.php');
notAdmin();
logout();

$user = null;
if (isset($_SESSION['user_id'])) {
    $query = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $query->execute(['user_id' => $_SESSION['user_id']]);
    $user = $query->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slides</title>
    <link rel="icon" href="../asset/images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="../asset/css/admin_dashboard.css">
    <link rel="stylesheet" href="../asset/css/styles.css">
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
          <div class="title" style="font-size: 0.8rem;">
            <div class="profile">
                <p><img src="../pages/profile_photo/<?=$user['photo']?>" alt="" width="30px" height="30px"></p>
            </div>
            <h3 style="margin-top: -10px;"><?=$user['firstname']?> <?=$user['lastname']?></h3>
          </div>
          <div >
            <i class="bi bi-speedometer2"></i>
            <a href="adminDashboard.php">Dashboard</a>
          </div>
          <div >
            <i class="bi bi-dropbox"></i>
            <a href="products.php">Products</a>
          </div>
          <div>
            <i class="bi bi-basket2-fill"></i>
             <a href="orders.php">Orders</a>
          </div>
          <div>
            <i class="bi bi-file-earmark-post"></i>
            <a href="posts.php">Posts</a>
          </div>
          <div  class="activ">
            <i class="bi bi-images"></i>
            <a href="slides.php">Slides</a>
          </div>
          <div >
                <i class="bi bi-envelope"></i>
                <a href="news-letter.php">News letter</a>
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
        <div class="admin-header">
            <h3>Admin Dashboard</h3>
        </div>
        <div class="products-section" >
            <h3>Slides</h3>
            <div class="add-product">
                <a href="add_slide.php">Add a slide</a>
            </div>
            <div class="product-container" style="overflow:auto;height:400px; background-color:#fff;padding:10px;border-radius:10px">
                <?php
                    $stmt =$db->prepare('SELECT * FROM slides ');
                    $stmt->execute();
                    $slides=$stmt->fetchAll();
                    if(!$slides){
                        ?>
                            <p>No slides yet added</p>
                        <?php
                    }else{
                        foreach($slides as $slide){
                            ?>
                                <div class="product">
                                    <img src="../pages/slides_images/<?=$slide['photo']?>" alt="">
                                    <div class="buy">
                                        <div >
                                            <a style="color: red;cursor:pointer" gallery_id="<?= $slide['id'] ?>"  class="delete" title="Delete this slide"><i class="bi bi-trash3"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    }
                ?>
               
            </div>
        </div>
    </div>
    <?=popup_slides()?>
    </section>
    <script src="../asset/javascript/popup_delete_slide.js"></script>
</body>
</html>
