<?php
    session_start();
    // Fetch product ID and quantity from request
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if cart exists in session
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    // Check if the product is already in the cart
    $product_found = false;
    foreach ($_SESSION['panier'] as &$cart_product) {
        if ($cart_product['product_id'] == $product_id) {
            // If the product exists, update its quantity
            $cart_product['quantity'] += $quantity;
            $product_found = true;
            break;
        }
    }

    // If the product is not in the cart, add it as a new item
    if (!$product_found) {
        $_SESSION['panier'][] = [
            'product_id' => $product_id,
            'quantity' => $quantity,
        ];
    }

    echo '<script>alert("Product added to cart successfully!");</script>';
    echo '<script>window.location.href="../pages/products.php";</script>';
    exit;
?>