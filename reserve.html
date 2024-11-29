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
    <title>Blog</title>
    <link rel="icon" href="../asset/images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="../asset/css/styles.css">
    <link rel="stylesheet" href="../asset/css/blog.css">
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
                <li><a href="products.php">Products</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="contact.php">Contact us</a></li>
            </ul>
            
        </nav>
        <div class="header-icons">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search...">
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
            <div class="our-menu">
                <i class="bi bi-list menu-icon"></i>
                <i class="bi bi-x exit-icon"></i>
            </div>
        </div>
    </header>
</section>
<div class="blog-container">
    <h3 style="text-align: center;margin-bottom: 10px;">Recent Articles</h3>

    <div class="articles-section">
        <div class="blog-post" data-post-id="102">
            <h4 class="title">All You Need to Know About Ok Ginger</h4>
            <img src="../asset/images/products/10.png" alt="">
            <p>
                "Ok Ginger" is an exciting new product that is rapidly gaining popularity due to its numerous health benefits. 
                Derived from the roots of the ginger plant, this product is packed with antioxidants and bioactive compounds 
                that are believed to aid in digestion, reduce inflammation, and even support heart health.
            </p>
            <p>
                In this article, we'll explore the numerous benefits of Ok Ginger, how it can be used in everyday life, 
                and why it's an essential addition to your wellness routine.
            </p> <!-- Blog content -->
    
            <!-- Like button with like count -->
            <div>
                <button class="like-button">
                    <i class="bi bi-hand-thumbs-up"></i> Like
                </button>
                <span class="like-count">42</span>
                <button class="share-button">
                    <i class="bi bi-share"></i> Share
                </button>
            </div>
            
            <!-- Comment section -->
            <div class="comment-section">
                <h4>Comments</h4>
                <div class="comments">
                    <!-- Example comments -->
                    <div class="comment">
                        <span>HealthGuru:</span> I tried Ok Ginger and loved its soothing effects. Highly recommend it!
                    </div>
                    <div class="comment">
                        <span>WellnessFan:</span> The benefits of ginger are truly incredible. Can’t wait to try Ok Ginger!
                    </div>
                    <div class="comment hidden">
                        <span>NaturalLiving:</span> Does it help with joint pain as well?
                    </div>
                </div>
    
                <!-- Show toggle button for more comments -->
                <button class="toggle-comments">View more comments</button>
    
                <!-- Comment form -->
                <form class="comment-form">
                    <textarea name="comment" placeholder="Add a comment..." required></textarea>
                    <input type="hidden" name="post_id" value="102">
                    <button type="submit">Post Comment</button>
                </form>
            </div>
        </div>
        <div class="blog-post" data-post-id="102">
            <h4 class="title">The benefits of using our peppers</h4>
            <img src="../asset/images/products/cool1.jpeg" alt="">
            <p>
                "Ok Ginger" is an exciting new product that is rapidly gaining popularity due to its numerous health benefits. 
                Derived from the roots of the ginger plant, this product is packed with antioxidants and bioactive compounds 
                that are believed to aid in digestion, reduce inflammation, and even support heart health.
            </p>
            <p>
                In this article, we'll explore the numerous benefits of Ok Ginger, how it can be used in everyday life, 
                and why it's an essential addition to your wellness routine.
            </p> <!-- Blog content -->
    
            <!-- Like button with like count -->
            <div>
                <button class="like-button">
                    <i class="bi bi-hand-thumbs-up"></i> Like
                </button>
                <span class="like-count">42</span>
                <button class="share-button">
                    <i class="bi bi-share"></i> Share
                </button>
            </div>
            
            <!-- Comment section -->
            <div class="comment-section">
                <h4>Comments</h4>
                <div class="comments">
                    <!-- Example comments -->
                    <div class="comment">
                        <span>HealthGuru:</span> I tried Ok Ginger and loved its soothing effects. Highly recommend it!
                    </div>
                    <div class="comment">
                        <span>WellnessFan:</span> The benefits of ginger are truly incredible. Can’t wait to try Ok Ginger!
                    </div>
                    <div class="comment hidden">
                        <span>NaturalLiving:</span> Does it help with joint pain as well?
                    </div>
                </div>
    
                <!-- Show toggle button for more comments -->
                <button class="toggle-comments">View more comments</button>
    
                <!-- Comment form -->
                <form class="comment-form">
                    <textarea name="comment" placeholder="Add a comment..." required></textarea>
                    <input type="hidden" name="post_id" value="102">
                    <button type="submit">Post Comment</button>
                </form>
            </div>
        </div>
    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const likeButtons = document.querySelectorAll('.like-button'); // Select all like buttons
        const toggleButtons = document.querySelectorAll('.toggle-comments'); // Select all toggle buttons

        // Handle like button click
        likeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.closest('.blog-post').dataset.postId;

                this.classList.toggle('liked'); // Toggle liked state

                fetch('like.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ post_id: postId }) // Send post ID in request body
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.nextElementSibling.textContent = data.like_count + ''; // Update like count
                    } else {
                        alert('Error liking the post.');
                    }
                });
            });
        });
        

        // Handle toggle comments button click
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const commentsDiv = this.closest('.comment-section').querySelectorAll('.comment');
                commentsDiv.forEach((comment, index) => {
                    if (index > 0) {
                        comment.classList.toggle('hidden'); // Toggle visibility of comments
                    }
                });
                this.textContent = this.textContent === 'View more comments' ? 'View less comments' : 'View more comments'; // Toggle button text
            });
        });
    });
</script>

</body>
</html>