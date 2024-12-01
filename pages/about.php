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
    <title>About Us</title>
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
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="contact.php">Contact us</a></li>
                </ul>
                
            </nav>
            <div class="header-icons">
                <div class="search-container">
                    <input type="text" class="search-input" id="search-input" placeholder="Search..." onkeyup="liveSearch()">
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
                <div class="our-menu" >
                    <i class="bi bi-list menu-icon"></i>
                    <i class="bi bi-x exit-icon"></i>
                </div>
            </div>
        </header>
    </section>
<!-- About Us Section -->

<section class="about-us" >
    <div class="container">
        <h3>Presentation of Penja Peppers Enterprise</h3>
        <div class="paragraphs">
            <div class="column">
                <p>
                    Penja Peppers Enterprise is a leading agribusiness company renowned for its premium quality products and commitment to sustainable practices. Founded in Cameroon in 2022 and expanding to Rwanda in 2023, the company has quickly established itself as a pioneer in the cultivation, processing, and export of one of the world’s most sought-after spices—Penja peppers. <br><br>
                    <span>Our Mission</span><br>

                    Penja Peppers Enterprise is dedicated to delivering the highest quality pepper while ensuring ethical and sustainable practices throughout the value chain. Our mission is to celebrate the rich agricultural heritage of Africa by providing a product that meets global standards while uplifting local communities. <br><br>
                    <span>Our Values</span> <br>

                    Premium Quality:
                    Penja Peppers is internationally recognized for its superior flavor, aroma, and quality. Our peppers are cultivated in volcanic soils, which naturally enhance their distinctive characteristics, making them a favorite among chefs and culinary enthusiasts worldwide. <br>

                    Unique Origin:
                    Originating from the Penja region in Cameroon, our peppers are cultivated under optimal natural conditions. In Rwanda, we have successfully adapted our farming techniques to maintain the same exceptional quality while diversifying our geographical reach. <br>

                    Fair Trade:
                    At Penja Peppers, we believe in empowering farmers and promoting equitable trade. We work closely with local farmers, ensuring they receive fair compensation for their hard work and access to the resources they need to succeed. <br>

                    Traceability and Sustainability:
                    Our operations prioritize transparency and environmental responsibility. Every batch of Penja peppers is fully traceable, from farm to table. We employ sustainable farming practices that minimize environmental impact, safeguard biodiversity, and ensure long-term soil fertility. <br><br>

                    <span>Our Expansion to Rwanda</span><br>

                    In 2023, Penja Peppers Enterprise expanded to Rwanda, capitalizing on the country’s favorable agricultural policies and fertile lands. This strategic move has allowed us to increase our production capacity, serve new markets, and continue our mission of promoting African agricultural excellence on a global scale.
                    Why Choose Penja Peppers Enterprise? <br>

                    Unmatched Flavor: Our peppers are renowned for their rich, earthy taste and distinctive aroma.
                    Certified Quality: We adhere to rigorous international standards, ensuring our products meet the expectations of even the most discerning customers.
                    Community Impact: By choosing Penja Peppers, you are directly supporting African farmers and contributing to the development of rural communities.
                    Eco-Friendly Practices: We are committed to sustainability, ensuring our operations benefit the environment as well as the people who depend on it. <br><br>

                    <span>Looking to the Future</span><br>

                    Penja Peppers Enterprise is continuously innovating and expanding its reach. With operations in Cameroon and Rwanda, we are well-positioned to meet the growing global demand for premium spices while remaining true to our core values of quality, fairness, and sustainability. <br>

                    Whether you are a gourmet chef, a distributor, or a lover of fine cuisine, Penja Peppers Enterprise invites you to discover the excellence of our products and join us in celebrating the richness of Africa’s agricultural heritage.
                </p>
            </div>
        </div>    
    </div>
</section>
<footer>
    <div class="writer">
        &copy; <?= date("Y") ?> General consulting group ltd. All rights reserved.  Developed by SoftCreatix 
    </div>
    <a href="terms_policy.php">Refund and Cancellation Policy</a>
</footer>
<script src="../asset/javascript/app.js"></script>
</body>
</html>