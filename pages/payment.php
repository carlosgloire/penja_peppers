<?php
session_start();
require_once('../controllers/database/db.php');
require_once('../controllers/functions.php');
notconnected();

if (!isset($_SESSION['order_id']) || !isset($_SESSION['user_id'])) {
    header('Location: cart.php');
    exit();
}

$order_id = $_SESSION['order_id'];
$user_id = $_SESSION['user_id'];

// Fetch order details
$order_query = $db->prepare('SELECT * FROM orders WHERE order_id = ?');
$order_query->execute([$order_id]);
$order = $order_query->fetch();

if (!$order) {
    header('Location: cart.php');
    exit();
}

$quantity_query = $db->prepare('SELECT SUM(quantity) AS total_quantity FROM order_item WHERE order_id = ?');
$quantity_query->execute([$order_id]);
$order_quantity = $quantity_query->fetchColumn();
$totalorder_dollars = $order['total_amount'] ;
$totalorder = $order['total_amount'] * 1380;
// Fetch user details
$user_query = $db->prepare('SELECT email, phone, firstname, lastname FROM users WHERE user_id = ?');
$user_query->execute([$user_id]);
$user = $user_query->fetch();

if (!$user) {
    header('Location: cart.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
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
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script type="text/javascript" src="https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
</head>
<body>
    <style>
        .continue-shopping {
            color: #fff;
            width: 100%;
            padding: 10px 15px;
            text-align: center;
            margin-top: 10px;
            border-radius: 8px;
            border: none;
            background: #141b1fda;
            font-family: "Poppins", sans-serif;
            cursor: pointer;
        }
    </style>
        <section class="login-section">
        <form action="" method="post"  enctype="multipart/form-data">

            <h3>Complete your payment </h3>
            <div>
                <form id="payment-form">
                    <div class="all-inputs">
                        <input type="text" style="width:100%" id="address" name="address" placeholder="Provide your delivery address">
                    </div>
                    <div class="all-inputs">
                        <input type="text" style="width:100%" id="whatsapp" name="whatsapp" placeholder="Provide your WhatsApp number">
                    </div>
                    <div class="all-inputs">
                        <select id="payment-method" name="payment_method">
                            <option value="mobilemoneyrwanda">Mobile Money (MTN Rwanda)</option>
                            <option value="banktransfer">Bank Transfer</option>
                        </select>
                    </div>
                    <p style="text-align:left;margin-left:20px">Total order amount in $: <span id="order-total"><?= number_format($totalorder_dollars,0 ) ?></span> </p>
                    <p style="text-align:left;margin-left:20px">Total order amount in RWF: <span id="order-total"><?= number_format($totalorder, 2) ?></span> </p>
                    <button type="button" onclick="makePayment()" class="continue-shopping">Pay Now</button>
                </form>

            </div>
        </form>
    </section>

    <script>
        const orderTotal = parseFloat(<?= json_encode($totalorder) ?>);
        const orderId = <?= json_encode($order_id) ?>;

        function makePayment() {
            const paymentMethod = document.getElementById('payment-method').value;
            const address = document.getElementById('address').value;
            const whatsapp = document.getElementById('whatsapp').value;
            const amount = orderTotal.toFixed(2);

            FlutterwaveCheckout({
                public_key: "FLWPUBK_TEST-33e52f06e038469d6693230b8bc85b62-X",
                tx_ref: "RX1_" + Math.floor((Math.random() * 1000000000) + 1),
                amount: orderTotal,
                currency: "RWF", // Currency set to RWF
                payment_options: paymentMethod,
                meta: {
                    consumer_id: 23,
                    consumer_mac: "92a3-912ba-1192a",
                },
                customer: {
                    email: "<?= $user['email'] ?>",
                    phone_number: "<?= $user['phone'] ?>",
                    name: "<?= $user['firstname'] ?>",
                },
                callback: function (data) {
                    console.log(data);
                    window.location.href = `confirmcheckout.php?order_id=${orderId}&address=${encodeURIComponent(address)}&whatsapp=${encodeURIComponent(whatsapp)}&amount=${amount}`;
                },
                onclose: function () {
                    // Close modal
                },
                customizations: {
                    title: "Payment Gateway",
                    description: "Payment for your order",
                    logo: "img/favicon-32x32.png",
                },
            });
        }
    </script>
</body>
</html>
