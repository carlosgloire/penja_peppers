<?php
session_start();
require_once('../controllers/functions.php');
require_once('../controllers/database/db.php');

notconnected();

if (!isset($_GET['order_item_id']) || empty($_GET['order_item_id'])) {
    echo '<script>alert("No order item ID provided.");</script>';
    echo '<script>window.location.href="dashboard.php";</script>';
    exit;
}
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo '<script>alert("No order ID provided.");</script>';
    echo '<script>window.location.href="dashboard.php";</script>';
    exit;
}

$order_item_id = $_GET['order_item_id'];
$order_id = $_GET['order_id'];

// Fetch the order item details
$query = $db->prepare("SELECT oi.*, p.name AS product_name, p.photo, p.price, p.product_id
                       FROM order_item oi
                       JOIN products p ON oi.product_id = p.product_id
                       WHERE oi.order_item_id = ?");
$query->execute([$order_item_id]);
$order_item = $query->fetch(PDO::FETCH_ASSOC);

if (!$order_item) {
    echo '<script>alert("Order item not found.");</script>';
    echo '<script>window.location.href="dashboard.php";</script>';
    exit;
}

// Fetch all products for the dropdown
$products_query = $db->prepare("SELECT * FROM products");
$products_query->execute();
$products = $products_query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch the available stock of the selected product
    $stock_query = $db->prepare("SELECT stock FROM products WHERE product_id = ?");
    $stock_query->execute([$product_id]);
    $available_stock = $stock_query->fetchColumn();

    if ($quantity > $available_stock) {
        echo '<script>alert("The quantity entered is unavailable. Available stock: ' . htmlspecialchars($available_stock) . '");</script>';
        echo '<script>window.location.href="edit_order.php?order_item_id=' . htmlspecialchars($order_item_id) . '&order_id=' . htmlspecialchars($order_id) . '";</script>';
        exit;
    }

    // Fetch the price of the selected product
    $price_query = $db->prepare("SELECT price FROM products WHERE product_id = ?");
    $price_query->execute([$product_id]);
    $price = $price_query->fetchColumn();

    // Calculate the total price
    $total_price = $price * $quantity;

    // Update the order_item table
    $update_query = $db->prepare("UPDATE order_item 
                                  SET product_id = ?, quantity = ?, total_price = ? 
                                  WHERE order_item_id = ?");
    $update_query->execute([$product_id, $quantity, $total_price, $order_item_id]);

    echo '<script>alert("Order item updated successfully.");</script>';
    echo '<script>window.location.href="userDashboard.php";</script>';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="../asset/images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="../asset/css/login.css">
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
    <section class="login-section">
        <form action="" method="post">
            <h3>Update <?= htmlspecialchars($order_item['product_name']) ?></h3>
            <div>
            <div>
                <label style="text-align: left;margin-left:20px"  for="product_id">Product:</label>
                <select name="product_id" id="product_id" required>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['product_id'] ?>" <?= $product['product_id'] == $order_item['product_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($product['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                </div>
                <div>
                    <label style="text-align: left;margin-left:20px" for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" value="<?= htmlspecialchars($order_item['quantity']) ?>" min="1" required>
                </div>
                <div>
                    <label style="text-align: left;margin-left:20px">Current Product Photo:</label><br>
                    <img src="products_images/<?= htmlspecialchars($order_item['photo']) ?>" alt="Product Photo" style="width: 100px; height: 120px;mix-blend-mode:multiply;object-fit:cover;margin-top:-40px">
                </div>
                <input class="button" type="submit" name="update" value="Update">
            </div>
        </form>
    </section>
</body>
</html>