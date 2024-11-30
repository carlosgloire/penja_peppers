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
    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $item) {
            $total_quantity += (isset($item['quantity']) ? $item['quantity'] : 0);
        }
    }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund and Cancellation Policy</title>
    <link rel="icon" href="../asset/images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="../asset//css/styles.css">
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
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="contact.php">Contact us</a></li>
                </ul>
                
            </nav>
            <div class="header-icons">
                <div class="search-container">
                    <input type="text" class="search-input" id="search-input" placeholder="Search..." onkeyup="liveSearch()">
                    <i class="fas fa-search search-icon"></i>
                </div>
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
                <div class="our-menu" >
                    <i class="bi bi-list menu-icon"></i>
                    <i class="bi bi-x exit-icon"></i>
                </div>
            </div>
        </header>
    </section>

<!-- About Us Section -->

<section class="about-us" >
    <div class="container">
        <h3>Penja Peppers Refund and Cancellation Policy</h3>
        <div class="paragraphs">
            <div class="column">
                <p>
                    At Penja Peppers, we are committed to providing our customers with high-quality products and exceptional service. We understand that there may be instances where you may need to cancel an order or request a refund. This policy outlines the terms and conditions governing refunds and cancellations to ensure transparency and fairness for both parties. <br><br>
                    <span>1. Order Cancellations</span><br>
                    <span>1.1 Cancellation by Customer</span><br>
                    Customers may cancel their order under the following conditions: <br>
                      <span class="icon"><i class="bi bi-check-all"></i></span> Cancellations must be requested within 24 hours of placing the order. <br>
                      <span class="icon"><i class="bi bi-check-all"></i></span>  To cancel an order, customers must contact our customer service team via email at [insert email] or through our customer support hotline at [insert number]. <br>
                      <span class="icon"><i class="bi bi-check-all"></i></span>  If the order has already been processed or shipped, it cannot be cancelled. However, the customer may proceed with a return or refund request as outlined below. <br>

                    <span>1.2 Cancellation by Penja Peppers</span> <br>
                    Penja Peppers reserves the right to cancel any order under the following circumstances:
                    <br>

                    <span class="icon"><i class="bi bi-check-all"></i></span> If the product is out of stock or discontinued. <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> If there are issues with payment processing.<br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> If the shipping address provided is deemed incomplete or incorrect.<br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> If Penja Peppers suspects fraud or misuse of the purchasing system.<br>
                    In such cases, customers will be notified via email or phone, and a full refund will be issued within 7-10 business days. <br><br>
                    <span>2. Refund Policy</span><br>

                    <span>2.1 Eligibility for Refunds</span><br>
                    Refunds will be issued under the following circumstances:
                    <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Products are damaged or defective upon arrival. <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Incorrect products were delivered compared to the original order. <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Orders cancelled by Penja Peppers due to unavailability of stock or other issues (see 1.2).<br>

                    <span>2.2 Conditions for Refund</span><br>
                    Refund requests must meet the following conditions:
                    <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Requests for refunds must be made within 7 days of receiving the product. <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Products must be returned in their original packaging and condition (excluding damaged or defective items).<br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Proof of purchase (invoice or receipt) must be provided with any refund request.<br>

                    <span>2.3 Non-Refundable Situations</span><br>
                    Penja Peppers will not provide refunds in the following cases:
                    <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Products were purchased through unauthorized channels or resellers. <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Products were damaged due to improper handling or storage by the customer. <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Refund requests made after 7 days from the date of delivery.<br><br>

                    <span>3. Return Process</span><br>

                    <span>3.1 How to Initiate a Return</span><br>
                    To initiate a return, please follow these steps:
                    <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Contact our customer service team via email at [insert email] or call [insert phone number] to request a return authorization. <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Provide your order number, a description of the issue, and any necessary photos of the damaged or defective product. <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Once your return is authorized, you will receive instructions on how to return the product. <br>

                    <span>3.2 Return Shipping</span><br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Customers are responsible for the cost of return shipping unless the return is due to a Penja Peppers error (e.g., incorrect or defective products). <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> For eligible returns, Penja Peppers will provide a prepaid shipping label or reimburse the cost of shipping upon receiving the returned item. <br><br>

                    <span>4. Refund Process</span><br>
                    Once we receive and inspect the returned product, we will notify you of the status of your refund. If your refund is approved, it will be processed, and a credit will automatically be applied to your original method of payment within 7-10 business days. <br><br>

                    <span>5. Exchange Policy</span><br>
                    Penja Peppers does not offer product exchanges at this time. If you are dissatisfied with your purchase, we recommend following the return and refund process and placing a new order. <br><br>

                    <span>6. Cancellation of Pre-Orders</span><br>
                    For any pre-orders or special-order products:
                    <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Cancellations must be requested at least 48 hours before the scheduled shipping date. <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> A full refund will be provided for any pre-orders cancelled within the allowed time frame. <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> If the pre-order is cancelled after the product has been shipped, the standard return and refund policy will apply. <br><br>

                    <span>7. Refunds for Bulk Orders</span><br>
                    For bulk or wholesale orders:
                    <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Refunds will be considered on a case-by-case basis. <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Requests must be made within 5 days of receiving the bulk order. <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Penja Peppers reserves the right to deduct restocking fees or shipping charges for large returns. <br><br>

                    <span>8. Contact Information</span><br>
                    If you have any questions or concerns about this Refund and Cancellation Policy, please contact our customer service team:
                    <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Email: <a href="mailto:contact@generalconsultinggroups.com" style="color: #3c8cc9;">contact@generalconsultinggroups.com</a> <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Phone: +250 798 706 600 / +250 729 528 664 <br>
                    <span class="icon"><i class="bi bi-check-all"></i></span> Our Location: KN 4 Av 22, CAR FREE ZONE DOWNTOWN <br>
                    We aim to resolve all queries in a timely and efficient manner, ensuring customer satisfaction.
                </p>
            </div>
        </div>
        <div class="download-button" style="margin-left: 20px;">
            <a href="pdf/Penja_Peppers_Refund_and_Cancellation_Policy.pdf" class="btn btn-primary" style="color: #3c8cc9;font-weight:300" download>
                Download Refund and Cancellation Policy PDF
            </a>
        </div>    
    </div>
</section>

<footer>
    <div class="writer">
        &copy; <?= date("Y") ?> General consulting group ltd. All rights reserved.  Developed by SoftCreatix 
    </div>
    <a href="">Refund and Cancellation Policy</a>
</footer>
<script src="../asset/javascript/app.js"></script>
</body>
</html>