<?php
    session_start();
    require_once('../controllers/database/db.php');
    require_once('../controllers/functions.php');
    notconnected();

    // Get form data
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];

    // Check if the product exists in the database
    $query = $db->prepare('SELECT product FROM products WHERE product_id = ?');
    $query->execute([$product_id]);
    $product = $query->fetchColumn();

    // Check if the user has already reviewed the product
    $checkReviewQuery = $db->prepare('SELECT COUNT(*) FROM reviews WHERE product_id = ? AND user_id = ?');
    $checkReviewQuery->execute([$product_id, $_SESSION['user_id']]);
    $reviewCount = $checkReviewQuery->fetchColumn();

    if ($reviewCount > 0) {
        // If the user has already reviewed the product, show an alert and redirect them
        echo '<script>alert("You have already reviewed this product.");</script>';
        echo '<script>window.location.href="../pages/product_detail.php?product=' . $product . '";</script>';
        exit;
    }

    // Insert review into the database
    $sql = 'INSERT INTO reviews (product_id, user_id, rating) VALUES (?, ?, ?)';
    $stmt = $db->prepare($sql);
    $stmt->execute([$product_id, $_SESSION['user_id'], $rating]);

    // Alert the user that the review was added successfully
    echo '<script>alert("Your review has been added successfully");</script>';

    // Redirect to the product detail page with the correct product_id in the URL
    echo '<script>window.location.href="../pages/product_detail.php?product=' . $product . '";</script>';
    exit;
?>
