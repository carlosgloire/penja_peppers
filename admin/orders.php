<?php
    session_start();
    require_once('../controllers/database/db.php');
    require_once('../controllers/functions.php');
    notAdmin();
    logout();
    $user = null;
    if (isset($_SESSION['user_id'])) {
        $query = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $query->execute(['user_id' => $_SESSION['user_id']]);
        $user = $query->fetch();
    }

    notAdmin();
    // Check if a payment status filter is provided
    $payment_status = isset($_GET['status']) ? $_GET['status'] : null;
    // Build the query dynamically based on the selected status
    $sql = "
        SELECT 
            o.order_id,
            o.order_date,
            o.status as order_status,
            o.delivered,
            u.firstname,
            u.lastname,
            u.location,
            u.phone,
            p.name,
            p.price,
            p.photo,
            oi.order_item_id,  
            oi.quantity,  
            oi.total_price,
            pay.whatsapp_number,
            pay.address as payment_address
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        JOIN order_item oi ON o.order_id = oi.order_id
        JOIN products p ON oi.product_id = p.product_id
        JOIN payment pay ON o.order_id = pay.order_id
    ";

    // Add a WHERE clause if a payment status is provided
    if ($payment_status) {
        $sql .= " WHERE o.status = :status";
    }

    $sql .= " ORDER BY o.order_date DESC";

    $query = $db->prepare($sql);

    // Bind the status parameter if it's provided
    if ($payment_status) {
        $query->execute(['status' => $payment_status]);
    } else {
        $query->execute();
    }

    $orders = $query->fetchAll(PDO::FETCH_ASSOC);

    // Group orders by firstname, lastname, order_id, and date
    $grouped_orders = [];

    foreach ($orders as $order) {
        $firstname = $order['firstname'];
        $lastname = $order['lastname'];
        $location = $order['location'];
        $phone = $order['phone'];
        $order_id = $order['order_id'];
        $date = date('d/m/Y', strtotime($order['order_date']));

        if (!isset($grouped_orders[$firstname])) {
            $grouped_orders[$firstname] = [];
        }
        if (!isset($grouped_orders[$firstname][$lastname])) {
            $grouped_orders[$firstname][$lastname] = [
                'location' => $location,
                'phone' => $phone,
                'dates' => []
            ];
        }
        if (!isset($grouped_orders[$firstname][$lastname]['dates'][$date])) {
            $grouped_orders[$firstname][$lastname]['dates'][$date] = [];
        }
        if (!isset($grouped_orders[$firstname][$lastname]['dates'][$date][$order_id])) {
            $grouped_orders[$firstname][$lastname]['dates'][$date][$order_id] = [];
        }
        $grouped_orders[$firstname][$lastname]['dates'][$date][$order_id][] = $order;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <link rel="icon" href="../asset/images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="../asset/css/admin_dashboard.css">
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
    <section>
      <aside>
        <nav>
          <div class="title" style="font-size: 0.8rem;">
                <div class="profile">
                    <p><img src="../pages/profile_photo/<?=$user['photo']?>" alt="" width="30px" height="30px"></p>
                </div>
                <h3 style="margin-top: -10px;"><?=$user['firstname']?> <?=$user['lastname']?></h3>
          </div>
          <div >
            <i class="bi bi-speedometer2"></i>
            <a href="adminDashboard.php">Dashboard</a>
          </div>
          <div >
            <i class="bi bi-dropbox"></i>
            <a href="products.php">Products</a>
          </div>
          <div class="activ">
            <i class="bi bi-basket2-fill"></i>
             <a href="orders.php">Orders</a>
          </div>
          <div >
            <i class="bi bi-file-earmark-post"></i>
            <a href="posts.php">Posts</a>
          </div>
          <div >
            <i class="bi bi-images"></i>
            <a href="slides.php">Slides</a>
          </div>
          <div >
            <i class="bi bi-envelope"></i>
            <a href="news-letter.php">News letter</a>
          </div>
          <div>
            <i class="bi bi-credit-card-2-front"></i>
            <a href="payment_history.php">Payment history</a>
          </div>
          <form action="" method="post">
            <button name="logout"><i class="bi bi-box-arrow-left"></i> <p>Logout</p></button>
          </form>
        </nav>
      </aside>
      <div class="right-side">
        <div class="admin-header">
            <h3>Admin Dashboard</h3>
        </div>
        <div id="order-container" style="margin-top:20px;overflow:auto;height:550px">
            <div id="all-container">
                <input id="search-input" style="width:300px;padding:8px;border-radius:30px;border: 1px solid gray;outline:none; font-family: 'Outfit', sans-serif;float:right" type="text" class="search" placeholder="Search..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" onkeyup="liveSearch()">
                <div id="order-list">
                    <?php foreach ($grouped_orders as $firstname => $orders_by_firstname): ?>
                        <?php foreach ($orders_by_firstname as $lastname => $user_details): ?>
                            <div class="order-group">
                                <h4 style="margin-left: 30px;"><?php echo htmlspecialchars($firstname . ' ' . $lastname); ?></h4>
                                <p style="margin-left: 30px; color: #555;"><?php echo htmlspecialchars( $user_details['location'] . ' - ' . $user_details['phone']); ?></p>
                                <?php foreach ($user_details['dates'] as $date => $orders_by_date): ?>
                                    <div class="date-group">
                                        <div class="date" style="display: flex; color: #9a9a9a; font-weight: 500; font-size: 1rem; margin-top: 20px; justify-content: flex-end; margin-right: 30px;"><?php echo $date; ?></div>
                                        <?php foreach ($orders_by_date as $order_id => $items): 
                                            $total_order_price = 0;
                                            foreach ($items as $item):
                                                $total_order_price += $item['total_price'];
                                            ?>
                                            <div class="our-panier-prod" style="margin-bottom: 20px;">
                                                <div class="order-prod" >
                                                    <div>
                                                        <p><img src="../pages/products_images/<?=$item['photo']?>" alt=""></p>
                                                    </div>
                                                    <div>
                                                        <h4>Product name</h4>
                                                        <span><?=$item['name']?></span>
                                                    </div>
                                                    <div>
                                                        <h4>Price</h4>
                                                        <span><?=$item['price']?></span>
                                                    </div>
                                                    <div>
                                                        <h4>Quantity </h4>
                                                        <p><?=$item['quantity']?></p>
                                                    </div>
                                                </div>
                                                <div class="price">
                                                    <h4>Total price</h4>
                                                    <span>$<?php echo htmlspecialchars($item['total_price']); ?></span>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                            <div style="margin-left: 30px; font-weight:normal" class="total-price">
                                                <h4 style="font-weight:normal">Total Order Price: $<span><?php echo htmlspecialchars($total_order_price); ?> </span></h4>
                                            </div>
                                            <div style="margin-left: 30px;" class="shipping-info">
                                                <div>
                                                    <h4>Delivery address</h4>
                                                    <p>WhatsApp: <?php echo htmlspecialchars($items[0]['whatsapp_number']); ?></p>
                                                    <p>Address: <?php echo htmlspecialchars($items[0]['payment_address']); ?></p>
                                                </div>
                                            </div>
                                            <div class="status" style="margin-left: 30px;">
                                                <?php 
                                                    $delivered = $items[0]['delivered']; // Initialize $delivered
                                                    $pending_order_found = ($items[0]['order_status'] === 'Pending');
                                                ?>
                                                <p>Status: <?php echo $pending_order_found ? '<span style="color: red;">Pending</span>' : '<span style="color: green;">Completed</span>'; ?></p>
                                                <?php if (!$pending_order_found && $delivered == 'Not Delivered'): ?>
                                                    <form method="POST" action="update_delivery.php" >
                                                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                                        <button style="background-color: #141b1fda; padding: 3px 15px; color: white; margin-bottom: 10px; font-size: 1.2rem; cursor: pointer; border-radius: 3px;" 
                                                                type="submit" class="btn btn-primary" title="Deliver this product">
                                                            <i class="bi bi-truck"></i>
                                                        </button>
                                                    </form>
                                                <?php elseif (!$pending_order_found && $delivered == 'Delivered'): ?>
                                                    <p>Delivery Status: <span style="color: #02ccfe;">Delivered</span></p>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
      </div>

      </div>
    </section>
    <script>
        function liveSearch() {
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const orderList = document.getElementById('order-list');
            const orderGroups = orderList.getElementsByClassName('order-group');

            Array.from(orderGroups).forEach(group => {
                const fullname = group.querySelector('h4').textContent.toLowerCase();
                const locationPhone = group.querySelector('p').textContent.toLowerCase();
                const orderItems = group.querySelectorAll('.our-panier-prod');

                let matchFound = false;
                
                if (fullname.includes(searchInput) || locationPhone.includes(searchInput)) {
                    matchFound = true;
                } else {
                    orderItems.forEach(item => {
                        const productName = item.querySelector('span').textContent.toLowerCase();
                        if (productName.includes(searchInput)) {
                            matchFound = true;
                        }
                    });
                }
                
                group.style.display = matchFound ? 'block' : 'none';
            });
        }
    </script>
    </script>
</body>
</html>
