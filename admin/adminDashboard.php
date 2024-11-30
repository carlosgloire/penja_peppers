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
        notAdmin();
    }
    $stmt =$db->prepare("SELECT COUNT(*) AS prod_number FROM products WHERE category='Chocolates'ORDER BY product_id DESC");
    $stmt->execute();
    $products_chocolates=$stmt->fetch(PDO::FETCH_ASSOC);
    $chocolates= $products_chocolates['prod_number'];

    $stmt =$db->prepare("SELECT COUNT(product_id) AS prod_number  FROM products WHERE category='Peppers'ORDER BY product_id DESC");
    $stmt->execute();
    $products_peppers=$stmt->fetch(PDO::FETCH_ASSOC);
    $peppers = $products_peppers['prod_number'];

    $stmt =$db->prepare("SELECT COUNT(product_id) AS prod_number   FROM products WHERE category='Cigars' ORDER BY product_id DESC");
    $stmt->execute();
    $products_cigars=$stmt->fetch(PDO::FETCH_ASSOC);
    $cigars = $products_cigars['prod_number'];

    $stmt =$db->prepare("SELECT COUNT(product_id) AS prod_number   FROM products WHERE category='Other' ORDER BY product_id DESC");
    $stmt->execute();
    $products_others=$stmt->fetch(PDO::FETCH_ASSOC);
    $others = $products_others['prod_number'];
    // Fetch payment and shoes data per month
    $paymentQuery = $db->prepare('
        SELECT 
            DATE_FORMAT(p.payment_date, "%Y-%m") AS month,
            SUM(p.amount) AS total_amount,
            SUM(oi.quantity) AS total_products
        FROM 
            payment p
        LEFT JOIN 
            orders o ON p.order_id = o.order_id
        LEFT JOIN 
            order_item oi ON o.order_id = oi.order_id
        WHERE 
            p.status = "completed"
        GROUP BY 
            DATE_FORMAT(p.payment_date, "%Y-%m")
        ORDER BY 
            month
    ');
    $paymentQuery->execute();
    $paymentResults = $paymentQuery->fetchAll(PDO::FETCH_ASSOC);

    $months = [];
    $amounts = [];
    $quantities = [];

    foreach ($paymentResults as $payment) {
        $months[] = $payment['month'];
        $amounts[] = (float) $payment['total_amount'];
        $quantities[] = (int) $payment['total_products'];
    }

    // Fetch the sum of all shoes in stock
    $totalStockQuery = $db->prepare('SELECT SUM(stock) AS total_stock FROM products');
    $totalStockQuery->execute();
    $totalStockResult = $totalStockQuery->fetch(PDO::FETCH_ASSOC);
    $totalStock = $totalStockResult['total_stock'];

    // Fetch the total number of users
    $totalUsersQuery = $db->prepare('SELECT COUNT(user_id) AS total_users FROM users');
    $totalUsersQuery->execute();
    $totalUsersResult = $totalUsersQuery->fetch(PDO::FETCH_ASSOC);
    $totalUsers = $totalUsersResult['total_users'];

    // Fetch the total number of orders
    $totalOrdersQuery = $db->prepare('SELECT COUNT(order_id) AS total_orders FROM orders');
    $totalOrdersQuery->execute();
    $totalOrdersResult = $totalOrdersQuery->fetch(PDO::FETCH_ASSOC);
    $totalOrders = $totalOrdersResult['total_orders'];
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
    <!--Highcharts-->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
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
          <div class="activ">
            <i class="bi bi-speedometer2"></i>
            <a href="">Dashboard</a>
          </div>
          <div >
            <i class="bi bi-dropbox"></i>
            <a href="products.php">Products</a>
          </div>
          <div>
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
        <div class="all-items" style='display:grid'>
            <div class="bloc-content">
                <div>
                    <i class="bi bi-people"></i>
                    <p>Users</p>
                    <span><?php echo $totalUsers; ?></span>
                </div>
                <div>
                    <i class="bi bi-dropbox"></i>
                    <p>Products</p>
                    <span><?php echo $totalStock; ?></span>
                </div>

                <div>
                    <i class="bi bi-basket2-fill"></i>
                    <p>Orders</p>
                    <span><?php echo $totalOrders; ?></span>
                </div>
                <div>
                    <i class="bi bi-border-style"></i>
                    <p>Chocolates</p>
                    <span><?php echo $chocolates; ?></span>
                </div>
                <div>
                    <i class="bi bi-border-style"></i>
                    <p>Peppers</p>
                    <span><?php echo $peppers; ?></span>
                </div>
                <div>
                    <i class="bi bi-border-style"></i>
                    <p>Cigars</p>
                    <span><?php echo $cigars; ?></span>
                </div>
                <div>
                    <i class="bi bi-border-style"></i>
                    <p>Other</p>
                    <span><?php echo $others; ?></span>
                </div>
            </div>
        </div>
        <div id="payment-chart" style="width: 100%; height: 400px; margin-top: 50px;"></div> 
    </section>
</body>
</html>
<script>

document.addEventListener('DOMContentLoaded', function () {
    Highcharts.chart('payment-chart', {
        chart: {
            type: 'line',
            style: {
               fontFamily: 'Outfit, sans-serif'
            }
        },
        title: {
            text: 'Monthly Payments and products Purchased',
            style: {
                fontFamily: 'Outfit, sans-serif',
                fontWeight:500
            }
        },
        xAxis: {
            categories: <?php echo json_encode($months); ?>,
            crosshair: true,
            labels: {
                style: {
                  fontFamily: 'Outfit, sans-serif'
                }
            }
        },
        yAxis: [{
            title: {
                text: 'Total Amount',
                style: {
                  fontFamily: 'Outfit, sans-serif'
                }
            },
            labels: {
                style: {
                  fontFamily: 'Outfit, sans-serif'
                }
            }
        }, {
            title: {
                text: 'Total products Purchased',
                style: {
                    fontFamily: 'Poppins, sans-serif'
                }
            },
            labels: {
                style: {
                  fontFamily: 'Outfit, sans-serif'
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true,
            style: {
                fontFamily: 'Poppins, sans-serif'
            }
        },
        series: [{
            name: 'Total Amount',
            data: <?php echo json_encode($amounts);?>
        }, {
            name: 'Total Products Purchased',
            data: <?php echo json_encode($quantities); ?>,
            yAxis: 1
        }]
    });
});
</script>