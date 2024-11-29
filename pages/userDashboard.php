
<?php 
  session_start();
  require_once('../controllers/database/db.php');
  require_once('../controllers/functions.php');
  logout();

  $user = null;
  if (isset($_SESSION['user_id'])) {
      $query = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
      $query->execute(['user_id' => $_SESSION['user_id']]);
      $user = $query->fetch();
  }

  // Fetch all orders for the current user
  $query = $db->prepare("
      SELECT o.order_id, o.order_date, o.total_amount, o.status 
      FROM orders o
      WHERE o.user_id = :user_id
      ORDER BY o.order_date DESC
  ");
  $query->execute(['user_id' => $_SESSION['user_id']]);
  $orders = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="../asset/images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="../asset/css/userDashboard.css">
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
          <div class="title">
            <i class="bi bi-person-circle"></i> <h3>Penja Peppers</h3>
          </div>
          <div class="activ">
            <i class="bi bi-speedometer2"></i>
            <a href="">Dashboard</a>
          </div>
          <div>
            <i class="bi bi-gear-wide-connected"></i>
            <a href="profile.php">Settings</a>
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
      <div class="right-side" >
        <div class="profile">
          <h3 style="margin-top: 10px;">Welcome to Penja Peppers</h3>
          <p><img src="profile_photo/<?=$user['photo']?>" alt="" width="30px" height="30px"></p>
        </div>
        <h4><?=$user['firstname']?> <?=$user['lastname']?> !</h4>
        <p style="font-size: 17px;">Explore your orders at Penja Peppers! You can explore all your orders, delete the ones you don’t need, edit their details, and pay for any unpaid ones. It’s easy to manage everything in one place! use the scroll bar to view more orders.</p>
        <div class="orders">
          <?php foreach ($orders as $order): ?>
            <div class="order-container">
                <p style="text-align: right;font-size: 16px;margin-right: 10px;"><?=$order['order_date']?></p>

                <?php 
                // Fetch the order items for this order
                $itemQuery = $db->prepare("
                    SELECT oi.product_id, oi.order_item_id, oi.quantity, oi.total_price, p.name, p.photo
                    FROM order_item oi
                    JOIN products p ON oi.product_id = p.product_id
                    WHERE oi.order_id = :order_id
                ");
                $itemQuery->execute(['order_id' => $order['order_id']]);
                $orderItems = $itemQuery->fetchAll();

                // Calculate the total order price
                $totalQuery = $db->prepare("SELECT SUM(total_price) AS total_order_price FROM order_item WHERE order_id = :order_id");
                $totalQuery->execute(['order_id' => $order['order_id']]);
                $totalOrderPrice = $totalQuery->fetchColumn();
                ?>
                <div>
                  
                </div>
                <?php foreach ($orderItems as $item): ?>
                    <div class="order-prod" style="margin-bottom: 20px;">
                        <div>
                            <p><img src="products_images/<?=$item['photo']?>" alt=""></p>
                        </div>
                        <div>
                            <h4>Product name</h4>
                            <span><?=$item['name']?></span>
                        </div>
                        <div>
                            <h4>Price</h4>
                            <span><?=$item['total_price']?></span>
                        </div>
                        <div>
                            <h4>Quantity selected</h4>
                            <p><?=$item['quantity']?></p>
                        </div>
                        <div class="delete">
                        <?php if ($order['status'] !== 'completed'): ?>
                        <button title="Delete order item" class="delete_item" gallery_id="<?= $item['order_item_id'] ?>"><i class="bi bi-trash3"></i></button>
                            <a href="edit_order_item.php?order_item_id=<?= $item['order_item_id'] ?>&order_id=<?= $order['order_id'] ?>" title="Edit order item">
                                <i class="bi bi-pen"></i> 
                            </a>
                        <?php endif; ?>

                        </div>
                    </div>
                    <?=popup_order_item()?>
                <?php endforeach; ?>

                <div class="price">
                    <h4>Total price</h4>
                    <span>$<?= number_format($totalOrderPrice, 0) ?></span>
                </div>

                <div class="order-status">
                    <?php if ($order['status'] === 'pending'): ?>
                        <p>Status: Pending</p>
                        <a href="payment_from_orders.php?order_id=<?= $order['order_id'] ?>" class="pay-now-btn">Pay Now</a>
                    <?php else: ?>
                        <p>Status: Paid</p>
                    <?php endif; ?>
                </div>
            </div>
          <?php endforeach; ?>
        </div>


    </div>
    
    </section>
    <script src="../asset/javascript/popup_delete_oderItem.js"></script>

</body>
</html>

