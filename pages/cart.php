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
$total_order_price = 0;
$cart_items = [];

if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    $product_ids = array_column($_SESSION['panier'], 'product_id');
    $placeholders = rtrim(str_repeat('?,', count($product_ids)), ',');
    
    // Fetch product details for all products in the cart
    $stmt = $db->prepare("SELECT * FROM products WHERE product_id IN ($placeholders)");
    $stmt->execute($product_ids);
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Merge quantities from the session
    $cart_details = [];
    foreach ($_SESSION['panier'] as $cart_product) {
        foreach ($cart_items as $product) {
            if ($product['product_id'] == $cart_product['product_id']) {
                $cart_details[] = [
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'photo' => $product['photo'],
                    'price' => $product['price'],
                    'quantity' => $cart_product['quantity'],
                    'total_price' => $product['price'] * $cart_product['quantity'],
                ];
                $total_quantity += $cart_product['quantity'];
                $total_order_price += $product['price'] * $cart_product['quantity'];
                break;
            }
        }
    }
    $cart_items = $cart_details; // Replace with merged details
}

// Update cart quantities after form submission
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $product_id => $quantity) {
        // Update session quantities for each product
        foreach ($_SESSION['panier'] as &$cart_product) {
            if ($cart_product['product_id'] == $product_id) {
                $cart_product['quantity'] = $quantity;
            }
        }
    }
    // Optionally, you can redirect to refresh the page after updating the cart
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="../asset/images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="../asset/css/styles.css">
    <link rel="stylesheet" href="../asset/css/cart.css">
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
                    <li><a href="products.php">Products</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="contact.php">Contact us</a></li>
                </ul>
               
            </nav>
            <div class="header-icons">
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
     <section class="cart-section">
    <h3>Cart</h3>
    <p style="font-size: 17px;">In this section you can view all your orders! You can explore them, delete the ones you don’t need or increase the quantity. It’s easy to manage everything in one place!</p>
    
    <?php if (!empty($cart_items)): ?>
        <form action="cart.php" method="POST">
            <?php foreach ($cart_items as $item): ?>
                <div class="our-cart-prod">
                    <div class="order-prod">
                        <div>
                            <p><img src="products_images/<?= htmlspecialchars($item['photo']); ?>" alt=""></p>
                        </div>
                        <div>
                            <h4>Product name</h4>
                            <span><?= htmlspecialchars($item['name']); ?></span>
                        </div>
                        <div>
                            <h4>Price</h4>
                            <span>$<?= htmlspecialchars($item['price']); ?></span>
                        </div>
                        <div>
                            <h4>Quantity selected</h4>
                            <input type="number" name="quantities[<?= $item['product_id']; ?>]" value="<?= htmlspecialchars($item['quantity']); ?>" min="1">
                        </div>
                        <div class="delete">
                            <button title="Delete order item" class="remove" onclick="removeFromCart(<?=$item['product_id']?>)">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </div>
                    <div class="price">
                        <h4>Total price</h4>
                        <span>$<?= htmlspecialchars($item['total_price']); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
            <p style="text-align: right; font-weight: 400;">Total order price: $<?= htmlspecialchars($total_order_price); ?></p>
            <div class="our-buttons">
                <button type="submit" name="update_cart" style="cursor: pointer;" class="continue-shopping">Update cart</button>
                <a href="../controllers/process_order.php" class="order-now">Order now</a>
            </div>
        </form>
    <?php else: ?>
        <p style="text-align: center;">Your cart is empty.</p>
    <?php endif; ?>
</section>

<script>
    function removeFromCart(product_id) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'remove_from_cart.php?product_id=' + product_id, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Successfully removed, update the cart UI (reload the page)
            location.reload();  // Optionally, you can update the cart without reloading
        } else {
            alert('Error removing item from cart');
        }
    };
    xhr.send();
}

</script>
<script src="../asset/javascript/app.js"></script>
</body>
</html>