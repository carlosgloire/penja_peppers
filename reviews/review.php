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
