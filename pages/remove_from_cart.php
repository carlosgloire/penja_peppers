<?php
    session_start();
    // Check if the product_id is set in the request
    if (isset($_GET['product_id']) && !empty($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        // Remove the product from the session cart
        if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
            foreach ($_SESSION['panier'] as $key => $cart_product) {
                if ($cart_product['product_id'] == $product_id) {
                    unset($_SESSION['panier'][$key]);
                    $_SESSION['panier'] = array_values($_SESSION['panier']); // Reindex the array after removing
                    break;
                }
            }
        }
    }
?>
