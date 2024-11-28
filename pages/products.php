<?php
    session_start();
    require_once('../controllers/functions.php');
    require_once('../controllers/database/db.php');
    logout();
    $user = null;
    if (isset($_SESSION['user_id'])) {
        $query = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $query->execute(['user_id' => $_SESSION['user_id']]);
        $user = $query->fetch();
    }
    $total_quantity = 0;
    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $item) {
            $total_quantity += (isset($item['quantity']) ? $item['quantity'] : 0);
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="icon" href="../asset/images/logo.png" type="image/png" sizes="16x16">
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

     <!-- Top Bar -->
     <section class="header">
        <div class="top-bar">
            <div class="moving-text">
                <div class="text">Free Shipping on All Orders Over $500 </div>
                <div class="text">Call us on +250 798 706 600 | +250 729 528 664</div>
            </div>
        </div>
            <!-- Header -->
        <header>
            <div class="logo"><img src="../asset/images/logo.png" alt=""></div>
            <nav>
                <ul class="nav-links">
                    <li><a href="../">Home</a></li>
                    <li><a href="about.php">About us</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="contact.php">Contact us</a></li>
                </ul>
               
            </nav>
            <div class="header-icons">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search...">
                    <i class="fas fa-search search-icon"></i>
                </div>
                <div class="cart-list">
                    <a class="cart" href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                    <span><?=$total_quantity > 0 ? $total_quantity:"0"?></span>
                </div>
                <?php
                    if (isset($_SESSION['user']) && $_SESSION['user']){
                        ?>
                            <div class="indicator">
                                <div class="profile">
                                    <p><a style="display: flex;" href="userDashboard.php"><img src="profile_photo/<?=$user['photo']?>" alt="" width="30px" height="30px"><i style="margin-top: 10px;" class="bi bi-three-dots-vertical"></i></a></p>
                                </div>
                                <div class="dashboard-user">
                                    <a href="userDashboard.php">
                                        <i class="bi bi-speedometer2"></i>
                                        <span>Dashboard</span>
                                    </a>

                                    <?php
                                        $admin=$user['role'];
                                        if($admin=='admin'){
                                            ?>
                                                 <a href="../admin/adminDashboard.php">
                                                    <i class="bi bi-clipboard-pulse"></i>
                                                    <span>Administration</span>
                                                </a>
                                            <?php
                                        }
                                    ?>
                                    <a href="pages/profile.php">
                                        <i class="bi bi-person-check"></i>
                                        <span>My profile</span>
                                    </a>
                                    <a   style="display: flex;align-items:center;gap:5px;;">
                                        <i class="bi bi-box-arrow-in-right"></i>
                                        <form action="" method="post" style="margin-top: -3px;">
                                            <button name="logout"><span>Log out</span></button>
                                        </form>
                                    </a>
                                </div>
                            </div>
                            <?php
                    }
                ?>
                <div class="our-menu">
                    <i class="bi bi-list menu-icon"></i>
                    <i class="bi bi-x exit-icon"></i>
                </div>
            </div>
        </header>
     </section>


     <div class="products-section" style="padding-top: 130px;">
        <h3>Products</h3>
        <div class="product-container">
            <?php
                $stmt =$db->prepare('SELECT * FROM products ORDER BY product_id DESC');
                $stmt->execute();
                $products=$stmt->fetchAll();
                if(!$products){
                    ?>
                        <p>No product yet added</p>
                    <?php
                }else{
                    foreach($products as $product){
                        ?>
                            <div class="product">
                                <a href="product_detail.php?product=<?=$product['product']?>"><img src="products_images/<?=$product['photo']?>" alt=""></a>
                                <h4><?=$product['name']?></h4>
                                <?php
                                    $sql = 'SELECT AVG(rating) as avg_rating FROM reviews WHERE product_id = ?';
                                    $stmt = $db->prepare($sql);
                                    $stmt->execute([$product['product_id']]);
                                    $result = $stmt->fetch();
                                    $avg_rating = round($result['avg_rating'], 1);
                                    ?>
                                        <div class="stars">
                                            <div>
                                                <?php
                                                    // Loop through 5 stars
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        // Check if we should display a filled star, half star, or an empty star
                                                        if ($i <= floor($avg_rating)) {
                                                            // Full star
                                                            echo "<i class='bi bi-star-fill'></i>";
                                                        } elseif ($i == ceil($avg_rating) && $avg_rating != floor($avg_rating)) {
                                                            // Half star (if it's a fractional rating)
                                                            echo "<i class='bi bi-star-half'></i>";
                                                        } else {
                                                            // Empty star
                                                            echo "<i class='bi bi-star'></i>";
                                                        }
                                                    }
                                                ?>
                                            </div>
                                            <p>(<?php echo $avg_rating; ?>)</p>
                                        </div>
                                    <?php
                                ?>
                                
                                <div class="buy">
                                    <p>$<?=$product['price']?></p>
                                    <a href="product_detail.php?product=<?=$product['product']?>">Buy</a>
                                </div>
                            </div>
                        <?php
                    }
                }
            ?>
            
        </div>
    </div>


    <script>
        function removeFromCart(productId) {
            const form = document.createElement('form');
            form.method = 'post';
            form.action = 'remove_from_cart.php';
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'product_id';
            input.value = productId;
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }

        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('change', function() {
                const stock = parseInt(this.getAttribute('data-stock'));
                const value = parseInt(this.value);
                if (value > stock) {
                    alert('The quantity entered is not available in stock.');
                    this.value = stock;
                }
            });
        });

    </script>
    <script src="../asset/javascript/app.js"></script>
</body>
</html>
