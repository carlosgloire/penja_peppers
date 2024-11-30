<?php
    session_start();
    require_once('../controllers/database/db.php');
    require_once('../controllers/functions.php');
    logout();
    $name = $category = $stock = $description = $price = '';
    
    if (isset($_GET['product']) && !empty($_GET['product'])) {
        $product_slug = $_GET['product'];
        $query = $db->prepare('SELECT name, category, stock, description, price,photo,product_id FROM products WHERE product = ?');
        $query->execute([$product_slug]);
        $product = $query->fetch();
        if ($product) {
            $name = $product['name'];
            $category = $product['category'];
            $stock = $product['stock'];
            $description = $product['description'];
            $price = $product['price'];
            $product_image = $product['photo'];
            $product_id= $product['product_id'];
        } else {
            echo '<script>alert("Product not found.");</script>';
            echo '<script>window.location.href="../";</script>';
        }
    } else {
        echo '<script>alert("Product not found.");</script>';
        echo '<script>window.location.href="../";</script>';
    }

    $user = null;
    if (isset($_SESSION['user_id'])) {
        $query = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $query->execute(['user_id' => $_SESSION['user_id']]);
        $user = $query->fetch();
    }
    $total_quantity=0;
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
    <title><?= $name?></title>
    <link rel="icon" href="../asset/images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Klee+One:wght@400;600&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.0/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../asset/css/review_details.css">
    <link rel="stylesheet" href="../asset/css/product_detail.css">
    <link rel="stylesheet" href="../asset/css/styles.css">
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
    <div class="product-container">
        <div class="product-photo">
          <img src="productS_images/<?=$product_image?>" alt="Product Photo" />
        </div>
        <!-- Product Details -->
        <div class="product-details">
          <h3> <?=$category?></h3>
          <h4><?=$name?></h4>
          <p>Number in Stock: <span><?=$stock?></span></p>
          <p><?=$description?></p>
          <p>Price: <span style="font-weight: 600;">$<?=$price?></span></p>
           <a style="color:#3498db; text-decoration:none" href="../reviews/review.php?product=<?=$product_slug?>">Review this product <span style="color:#ffdc60;"><i class="bi bi-star-fill"></i></span></a> 
          <div class="product-actions">
            <form action="../controllers/add_to_cart.php" method="post">
                <input type="hidden" name="product_id" value="<?=$product_id?>">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?=$stock?>" />
                <button name="add_to_cart">Add to Cart</button>
            </form>
          </div>
        </div>
    </div>
    <?php
    // Fetch product reviews and ratings
    $review_query = $db->prepare("
        SELECT 
            r.rating, 
            r.created_at, 
            u.firstname AS fname,
            u.lastname AS lname,
            u.photo AS profile
        FROM reviews r
        INNER JOIN users u ON r.user_id = u.user_id
        WHERE r.product_id = ?
        ORDER BY r.created_at DESC
    ");
    $review_query->execute([$product['product_id']]);
    $reviews = $review_query->fetchAll();

    // Calculate rating breakdown and overall average
    $ratings_summary_query = $db->prepare("
        SELECT 
            rating, COUNT(*) AS count 
        FROM reviews 
        WHERE product_id = ? 
        GROUP BY rating
    ");
    $ratings_summary_query->execute([$product['product_id']]);
    $ratings_summary = $ratings_summary_query->fetchAll(PDO::FETCH_KEY_PAIR);

    $total_reviews = array_sum($ratings_summary);
    $average_rating = 0;
    if ($total_reviews > 0) {
        $average_rating = round(array_sum(array_map(function ($rating, $count) {
            return $rating * $count;
        }, array_keys($ratings_summary), $ratings_summary)) / $total_reviews, 1);
    }

    // Calculate percentages for the progress bars
    $ratings_percentage = [];
    for ($i = 5; $i >= 1; $i--) {
        $ratings_percentage[$i] = isset($ratings_summary[$i]) ? round(($ratings_summary[$i] / $total_reviews) * 100) : 0;
    }

    // Function to get comment text based on rating
    function getCommentText($rating) {
        switch ($rating) {
            case 5: return "This product is Excellent";
            case 4: return "This product is Good";
            case 3: return "This product is Ok";
            case 2: return "This product is Bad";
            case 1: return "This product is Terrible";
            default: return "";
        }
    }
    ?>

    <div class="reviews-section">
        <div class="reviews-header">
            <div class="average-rating">
                <h1><?= $average_rating ?></h1>
                <div class="stars">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= floor($average_rating)) {
                            // Full star
                            echo "<i class='bi bi-star-fill'></i>";
                        } elseif ($i == ceil($average_rating) && $average_rating != floor($average_rating)) {
                            // Half star
                            echo "<i class='bi bi-star-half'></i>";
                        } else {
                            // Empty star
                            echo "<i class='bi bi-star'></i>";
                        }
                    }
                    ?>
                </div>
                <p><?= $total_reviews ?> reviews</p>
            </div>

            <div class="rating-breakdown">
                <?php foreach ($ratings_percentage as $star => $percent): ?>
                    <div class="rating-row">
                        <span><?= $star ?> star</span>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: <?= $percent ?>%;"></div>
                        </div>
                        <span><?= $percent ?>%</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="review-list">
            <?php if (!empty($reviews)): ?>
                <!-- Display only the first review -->
                <div class="review-item">
                    <div class="review-header">
                        <span style="font-weight: 500;">
                            <!-- Corrected profile image reference -->
                            <img style="border-radius: 50%; margin-right:5px;" 
                                src="profile_photo/<?= $reviews[0]['profile'] ?>" 
                                alt="Profile Photo" width="20px" height="20px">
                            <?= $reviews[0]['fname'].' '.$reviews[0]['lname'] ?>
                        </span>
                        <div class="stars">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $reviews[0]['rating']
                                    ? "<i class='bi bi-star-fill'></i>"
                                    : "<i class='bi bi-star'></i>";
                            }
                            ?>
                        </div>
                        <span class="review-date"><?= date('F j, Y', strtotime($reviews[0]['created_at'])) ?></span>
                    </div>
                    <p class="review-text"><?= getCommentText($reviews[0]['rating']) ?></p>
                </div>

                <!-- The rest of the reviews, initially hidden -->
                <?php if (count($reviews) > 1): ?>
                    <div id="more-reviews" style="display: none;">
                        <?php foreach ($reviews as $index => $review): ?>
                            <?php if ($index > 0): ?>
                                <div class="review-item">
                                    <div class="review-header">
                                        <span style="font-weight: 500;">
                                            <!-- Corrected profile image reference -->
                                            <img style="border-radius: 50%; margin-right:5px;" 
                                                src="profile_photo/<?= $review['profile'] ?>" 
                                                alt="Profile Photo" width="20px" height="20px">
                                            <?= $review['fname'].' '.$review['lname'] ?>
                                        </span>
                                        <div class="stars">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                echo $i <= $review['rating']
                                                    ? "<i class='bi bi-star-fill'></i>"
                                                    : "<i class='bi bi-star'></i>";
                                            }
                                            ?>
                                        </div>
                                        <span class="review-date"><?= date('F j, Y', strtotime($review['created_at'])) ?></span>
                                    </div>
                                    <p class="review-text"><?= getCommentText($review['rating']) ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <!-- Show More / Less button -->
                    <p style="cursor: pointer; color:#3498db" id="toggle-reviews" onclick="toggleReviews()">Show More Reviews</p>
                <?php endif; ?>

            <?php else: ?>
                <p>No reviews for this product yet. Be the first to review!</p>
                <a style="color:#3498db; text-decoration:none" href="../reviews/review.php?product=<?= $product_slug ?>">Click here to review this product <span style="color:#ffdc60;"><i class="bi bi-star-fill"></i></span></a>
            <?php endif; ?>
        </div>
    </div>
    <?php
        // Fetch similar products excluding the current product
        $stmt = $db->prepare("SELECT * FROM products WHERE category = ? AND product != ? ORDER BY product_id DESC");
        $stmt->execute([$category, $_GET['product']]); // Pass the category and exclude the current product
        $similar_products = $stmt->fetchAll();
        
        // Store the count of similar products
        $similar_product_count = count($similar_products);

        // Determine if carousel buttons should be shown
        $show_carousel_buttons = ($similar_product_count > 1) ? 'show-carousel-mobile' : '';
        if ($similar_product_count > 6) {
            $show_carousel_buttons = 'show-carousel-desktop';
        }
    ?>

    <?php if (!empty($similar_products)): // Check if similar products exist ?>
        <div class="similar-products">
    <h3>Other products you need to see</h3>
    <div class="products-section">
        <!-- In the HTML, use the PHP class to conditionally display carousel buttons -->
        <div class="carousel-wrapper <?= $show_carousel_buttons ?>">
            <i class="bi bi-chevron-left carousel-nav prev"></i>
            <i class="bi bi-chevron-right carousel-nav next"></i>
        </div>

        <div class="product-container-similar" id="product-container-similar">
            <?php foreach ($similar_products as $similar_product): ?>
                <div class="product">
                    <a href="product_detail.php?product=<?= htmlspecialchars($similar_product['product']) ?>">
                        <img src="products_images/<?= htmlspecialchars($similar_product['photo']) ?>" alt="Product Image">
                    </a>
                    <h4><?= htmlspecialchars($similar_product['name']) ?></h4>
                    <?php
                    // Fetch average rating for the current product
                    $sql = 'SELECT AVG(rating) as avg_rating FROM reviews WHERE product_id = ?';
                    $stmt = $db->prepare($sql);
                    $stmt->execute([$similar_product['product_id']]);
                    $result = $stmt->fetch();
                    $avg_rating = round($result['avg_rating'], 1);
                    ?>
                    <div class="stars">
                        <div>
                            <?php
                            // Loop through 5 stars
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= floor($avg_rating)) {
                                    // Full star
                                    echo "<i class='bi bi-star-fill'></i>";
                                } elseif ($i == ceil($avg_rating) && $avg_rating != floor($avg_rating)) {
                                    // Half star
                                    echo "<i class='bi bi-star-half'></i>";
                                } else {
                                    // Empty star
                                    echo "<i class='bi bi-star'></i>";
                                }
                            }
                            ?>
                        </div>
                        <p>(<?= $avg_rating ?>)</p>
                    </div>

                    <div class="buy">
                        <p>$<?= htmlspecialchars($similar_product['price']) ?></p>
                        <a href="product_detail.php?product=<?= htmlspecialchars($similar_product['product']) ?>">Buy</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
<footer>
    <div class="writer">
        &copy;  <?= date("Y") ?> General consulting group ltd. All rights reserved.  Developed by SoftCreatix 
    </div>
    <a href="terms_policy.php">Refund and Cancellation Policy</a>
</footer>

    <?php endif; ?>
    <script src="../asset/javascript/app.js"></script>
    <script src="../asset/javascript/carrousel.js"></script>
    <script>
    // JavaScript to validate quantity input
    function validateQuantity() {
        const stock = parseInt(document.getElementById('stock-count').textContent);
        const quantity = parseInt(document.getElementById('quantity').value);

        if (quantity > stock) {
            alert('The quantity entered is not available in stock.');
            return false;
        }
        return true;
    }
    </script>    
</body>
</html>