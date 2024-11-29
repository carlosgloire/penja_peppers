<?php
session_start();
require_once('controllers/database/db.php');
require_once('controllers/functions.php');
function logout2(){
    if(isset($_POST['logout'])){
        unset($_SESSION['user']);
        unset($_SESSION['panier']);
        unset( $_SESSION['role']);
        header('location:../penjapeppers/');
        exit();
    }
}
logout2();
// Calculate the total quantity of all orders
$total_quantity = 0;
if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $item) {
        $total_quantity += (isset($item['quantity']) ? $item['quantity'] : 0);
    }
}
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
    <title>Home</title>
    <link rel="icon" href="asset/images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="asset/css/styles.css">
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
            <div class="logo"><img src="asset/images/logo.png" alt=""></div>
            <nav>
                
                
                <ul class="nav-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="pages/about.php">About us</a></li>
                    <li><a href="pages/blog.php">Blog</a></li>
                    <li><a href="pages/products.php">Products</a></li>
                    <li><a href="pages/categories.php">Categories</a></li>
                    <li><a href="pages/contact.php">Contact us</a></li>
                </ul>
               
            </nav>
            <div class="header-icons">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search...">
                    <i class="fas fa-search search-icon"></i>
                </div>
                <div class="cart-list">
                    <a class="cart" href="pages/cart.php"><i class="fas fa-shopping-cart"></i></a>
                    <span><?=$total_quantity > 0 ? $total_quantity:"0"?></span>
                </div>
                <?php
                    if (isset($_SESSION['user']) && $_SESSION['user']){
                        ?>
                            <div class="indicator">
                                <div class="profile">
                                    <p><a style="display: flex;" href="pages/userDashboard.php"><img src="pages/profile_photo/<?=$user['photo']?>" alt="" width="30px" height="30px"><i style="margin-top: 10px;" class="bi bi-three-dots-vertical"></i></a></p>
                                </div>
                                <div class="dashboard-user">
                                    <a href="pages/userDashboard.php">
                                        <i class="bi bi-speedometer2"></i>
                                        <span>Dashboard</span>
                                    </a>

                                    <?php
                                        $admin=$user['role'];
                                        if($admin=='admin'){
                                            ?>
                                                 <a href="admin/adminDashboard.php">
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

    <section class="home-section">
        <div class="home-text">
            <h1>Welcome to Penja Peppers</h1>
            <p>We are delighted to have you here! At Penja Peppers, we pride ourselves on delivering premium quality products and exceptional service. Explore our offerings and let us bring the finest flavors to your table.</p>
            <a href="pages/login.php">Get started</a>
        </div>

        <div class="home-images">
            <div class="gradient-overlay"></div>
            <p><img class="home-bg" src="asset/images/products/1.jpg"></p>
            <p><img class="home-bg" src="asset/images/products/10.png"></p>
            <p><img class="home-bg" src="asset/images/products/11.png"></p>
            <p><img class="home-bg" src="asset/images/products/2.jpg"></p>
            <p><img class="home-bg" src="asset/images/products/8.1.png"></p>
            <p><img class="home-bg" src="asset/images/products/4.1.jpg"></p>
            <p><img class="home-bg" src="asset/images/products/5.1.jpg"></p>
        </div>

        <div class="circle-btn">
            <div class="circle active"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
        </div>
    </section>

    <section class="timeline">
        <h3>Why to choose us</h3>
        <div class="timeline-row">
            <div class="timeline-column">
                <div class="timeline-box">
                    <!-- 24/7 Customer Service -->
                    <div class="timeline-content">
                        <div class="content">
                            <div class="titre">
                                <i class="fas fa-headset"></i>
                                <h3>24/7 Customer Service</h3>
                            </div>
                            <p>We are available 24/7 to assist with any questions or concerns, ensuring a seamless experience.</p>
                        </div>
                    </div>
                    <!-- Money Back Guarantee -->
                    <div class="timeline-content">
                        <div class="content">
                            <div class="titre">
                                <i class="fas fa-money-bill-wave"></i>
                                <h3>Money Back Guarantee</h3>
                            </div>
                            <p>Your satisfaction is our priority. If you're not happy with your purchase, we offer a hassle-free money-back guarantee.</p>
                        </div>
                    </div>
                    <!-- Superior Quality -->
                    <div class="timeline-content">
                        <div class="content">
                            <div class="titre">
                                <i class="fas fa-star"></i>
                                <h3>Superior Quality</h3>
                            </div>
                            <p>Our products are crafted with the finest materials and exceptional attention to detail, ensuring unmatched quality.</p>
                        </div>
                    </div>
                    <span class="animate" style="--i:2;"></span>
                </div>
            </div>
            <div class="timeline-column">
                <div class="timeline-box">
                    <!-- Unique Origin -->
                    <div class="timeline-content">
                        <div class="content">
                            <div class="titre">
                                <i class="fas fa-map-marker-alt"></i>
                                <h3>Unique Origin</h3>
                            </div>
                            <p>Our products come from distinct and authentic origins, bringing you the richness of diverse cultures and traditions.</p>
                        </div>
                    </div>
                    <!-- Fair Trade -->
                    <div class="timeline-content">
                        <div class="content">
                            <div class="titre">
                                <i class="fas fa-balance-scale"></i>
                                <h3>Fair Trade</h3>
                            </div>
                            <p>We are committed to ethical practices, ensuring that our products support fair trade and benefit the communities involved.</p>
                        </div>
                    </div>
                    <!-- Traceability and Sustainability -->
                    <div class="timeline-content">
                        <div class="content">
                            <div class="titre">
                                <i class="fas fa-seedling"></i>
                                <h3>Traceability and Sustainability</h3>
                            </div>
                            <p>Our transparent supply chain ensures traceability, while our sustainable practices protect the environment.</p>
                        </div>
                    </div>
                    <span class="animate" style="--i:2;"></span>
                </div>
            </div>
        </div>
    </section>
    <div class="products-section" >
        <h3>Products</h3>
        <div class="product-container">
            <?php
                $stmt =$db->prepare('SELECT * FROM products ORDER BY product_id DESC LIMIT 8');
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
                                <a href="pages/product_detail.php?product=<?=$product['product']?>"><img src="pages/products_images/<?=$product['photo']?>" alt=""></a>
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
                                    <a href="pages/product_detail.php?product=<?=$product['product']?>">Buy</a>
                                </div>
                            </div>
                        <?php
                    }
                }
            ?>
            
        </div>
        <a class="view-more" href="pages/products.php">View more products</a>
    </div>

    <section class="newsletter-section">
        <div>
            <h3>Subscribe to Our Newsletter</h3>
            <p>Get the latest updates and offers directly in your inbox.</p>
            <form class="newsletter-form" action="controllers/news-letter.php" method="post">
              <input type="email" name="mail-newsLetter" placeholder="Enter your email address" required />
              <button name="send-NewsLetter" type="submit">Send</button>
            </form>
        </div>
      </section>
      
      <section class="penja-peppers-section">
        <div class="content-container">
          <!-- Image Part -->
          <div class="image-container">
            <img src="asset/images/001.png" alt="Penja Peppers" class="pepper-image" />
          </div>
          <!-- Text Part -->
          <div class="text-container">
            <h3>The Benefit of using our Peppers</h3>
            <p>
              <strong>Black peppers</strong> is an excellent natural remedy for gastrointestinal disorders. In fact, regular use in your dishes can help combat a number of problems such as:
            </p>
            <ul>
              <li><span class="icon"><i class="bi bi-check-all"></i></span> Stomach pain</li>
              <li><span class="icon"><i class="bi bi-check-all"></i></span> Abdominal pain</li>
              <li><span class="icon"><i class="bi bi-check-all"></i></span> Nausea and vomiting</li>
            </ul>
            <h3>Why is Penja Peppers PGI?</h3>
            <p>
              The Penja peppers from Cameroon hold a <strong>Protected Geographical Indication (PGI)</strong> status, which signifies its unique qualities and ties to its specific geographic origin.
              This recognition ensures that only peppers produced in the Penja region of Cameroon can be labeled as such. 
              This PGI status highlights the distinct flavor profile and quality associated with Penja peppers, making it a sought-after spice in culinary circles worldwide.
            </p>
          </div>
        </div>
      </section>
      <!-- Features Section -->
    <section class="features">
        <h3>Core Values of Excellence</h3>
        <div class="features-container">
            <div class="feature">
                <div>
                    <h4>Authentic Chocolate from Cameroon</h4>
                    <p>Made with premium ingredients and passion, offering an unforgettable taste experience.            </p>
                </div>
            </div>
            <div class="feature">
                <div>
                    <h4>Delivery Times by Area</h4>
                    <p>Rwanda: Delivery within 24 hours.</p>
                    <p>Worldwide: Delivery within 7 days.</p>
                </div>
            </div>
            <div class="feature">
                <div>
                    <h4>Guaranteed Product Security</h4>
                    <p> Penja Peppers ensures safe delivery to your hands.</p>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="writer">
            &copy;  <?= date("Y") ?> General consulting group ltd. All rights reserved.  Developed by SoftCreatix 
        </div>
        <a href="">Terms of use and privacy policy</a>
    </footer>
    <script src="asset/javascript/app.js"></script>
</body>
</html>
<?php

$database = require("controllers/mail/database.php");

// Call the function to check stock and send email
sendStockAlertEmail($database, 'ndayisabagloire96@gmail.com');
?>