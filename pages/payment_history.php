<?php
  session_start();
  require_once('../controllers/functions.php');
  require_once('../controllers/database/db.php');
  logout();
  notconnected();

  $user_id = $_SESSION['user_id'];
  $sql = "
  SELECT 
      p.payment_date, 
      SUM(oiu.quantity) AS shoes_purchased, 
      p.payment_method, 
      p.amount, 
      p.status 
  FROM 
      payment p 
  JOIN 
      orders ou ON p.order_id = ou.order_id 
  JOIN 
      order_item oiu ON ou.order_id = oiu.order_id 
  WHERE 
      ou.user_id = :user_id
  GROUP BY 
      p.payment_date, 
      p.payment_method, 
      p.amount, 
      p.status
  ORDER BY
      p.payment_date DESC     
  ";

  $stmt = $db->prepare($sql);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="../asset/images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="../asset/css/payment_history.css">
    <link rel="stylesheet" href="../asset/css/userDashboard.css">
    <link rel="stylesheet" href="../asset/css/userPayment_media_query.css">
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
          <div  class="title">
            <i class="bi bi-person-circle"></i> <h3>Penja Peppers</h3>
          </div>
          <div >
            <i class="bi bi-speedometer2"></i>
            <a href="userDashboard.php">Dashboard</a>
          </div>
          <div >
            <i class="bi bi-gear-wide-connected"></i>
            <a href="profile.php">Settings</a>
          </div>
          <div class="activ">
            <i class="bi bi-credit-card-2-front"></i>
            <a href="">Payment history</a>
          </div>
          <form action="" method="post">
            <button name="logout"><i class="bi bi-box-arrow-left"></i> <p>Logout</p></button>
          </form>
        </nav>
      </aside>
      <div class="right-side">
        <div class="profile-section">
            <div class=" container" >
              <div class="admin-menu">
                  <i class="bi bi-list menu-icon-admin"></i>
                  <i class="bi bi-x exit-icon-admin"></i>
              </div>
              <h3 style="margin-bottom: 20px;">Payment history</h3>
              <div class="table-container">
                <table>
                    <tr>
                        <th>Payment Date</th>
                        <th>Product Purchased</th>
                        <th>Payment Method</th>
                        <th>Amount in Rwf</th>
                        <th>Status</th>
                    </tr>

                    <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['payment_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['shoes_purchased']); ?></td>
                        <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td class="<?php echo 'status-' . strtolower(htmlspecialchars($row['status'])); ?>">
                            <?php echo htmlspecialchars($row['status']); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </table>
            </div>

            </div>
        </div>
      </div>
    </section>
    <script src="../asset/javascript/app.js"></script>
</body>
</html>
