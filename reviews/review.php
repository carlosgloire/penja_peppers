<?php
    session_start();
    require_once('../controllers/functions.php');
    notconnected();
    require_once('../controllers/database/db.php');

    if (isset($_GET['product']) && !empty($_GET['product'])) {
        $product = $_GET['product'];  // Get 'product' from the URL
        $query = $db->prepare('SELECT * FROM products WHERE product = ?');  // Query based on product name
        $query->execute([$product]);
        $products = $query->fetch();
        if (!$products) {
            echo '<script>alert("Product not found.");</script>';
            echo '<script>window.location.href="../";</script>';
        } else {
            $product_name = $products['name'];
        }
    } else {
        echo '<script>alert("Product not found.");</script>';
        echo '<script>window.location.href="../";</script>';
    }
    $query = $db->prepare('SELECT product_id FROM products WHERE product = ?');
    $query->execute([$product]);
    $product_id = $query->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review <?=$product_name?></title>
    <link rel="stylesheet" href="../asset/css/review.css">
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
    <div class="container">
        <h2>Review <?=$product_name?></h2>
        <form id="reviewForm" method="POST" action="submit_review.php">
            <input type="hidden" name="product_id" id="product_id" value="<?=$product_id?>">
            <input type="hidden" name="product" id="product">
            <input type="hidden" name="rating" id="rating" value="">
        </form>
        <p style="margin-bottom: 10px;">To review a product, please click on a line of stars <br> according to how you appreciated the product </p>
        <div id="star-rating">
            <div data-value="5" class="star-row"title="Click here to review a shoe">
                <div class="bloc">
                    <div>
                        <span>5.0</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                    </div>
                    <p>(Excellent)</p>
                </div>
 
            </div>
            <div data-value="4" class="star-row" title="Click here to review a shoe">
                <div class="bloc">
                    <div>
                        <span>4.0</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9734;</span>
                    </div>
                    <p>(Good)</p>
                </div>
            </div>
            <div data-value="3" class="star-row" title="Click here to review a shoe">
                <div class="bloc">
                    <div>
                        <span>3.0</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9734;</span>
                        <span class="star">&#9734;</span>
                    </div>
                    <p>(Ok)</p>
                </div>
            </div>
            <div data-value="2" class="star-row" title="Click here to review a shoe">
                <div class="bloc">
                    <div>
                        <span>2.0</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9734;</span>
                        <span class="star">&#9734;</span>
                        <span class="star">&#9734;</span>
                    </div>
                    <p>(Bad)</p>
                </div>
            </div>
            <div data-value="1" class="star-row" title="Click here to review a shoe">
                <div class="bloc">
                    <div>
                        <span>1.0</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9734;</span>
                        <span class="star">&#9734;</span>
                        <span class="star">&#9734;</span>
                        <span class="star">&#9734;</span>
                    </div>
                    <p>(Terrible)</p>
                </div>
            </div>
        </div>
        <button id="submit-btn" type="button">Submit a review</button>
    </div>
    <script src="../asset/javascript/review.js"></script>
    <script src="../../asset/javascript/app.js"></script>
</body>
</html>
