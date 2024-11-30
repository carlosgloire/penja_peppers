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
    // Fetch all blog posts along with their like count
// Fetch all blog posts along with their like count
// Fetch posts without joining comments to prevent duplication
$stmt = $db->query("
    SELECT posts.*, 
           (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.post_id) AS like_count,
           posts.image , posts.post
    FROM posts
    ORDER BY posts.created_at DESC
");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

 
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
                                <p><a style="display: flex;" href="userDashboard.php"><img  src="profile_photo/<?=$user['photo']?>" alt="" width="30px" height="30px"><i style="margin-top: 10px;" class="bi bi-three-dots-vertical"></i></a></p>
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
    <h3 style="text-align: center;margin-bottom:10px">Recent Articles</h3>
    <div class="articles-section">
        <?php foreach ($blogs as $blog): ?> <!-- Loop through each blog post -->
            <?php
                    $likeCheckStmt = $db->prepare("
                    SELECT 1 
                    FROM likes 
                    WHERE user_ip = ? AND post_id = ?
                ");
                $likeCheckStmt->execute([$_SERVER['REMOTE_ADDR'], $blog['post_id']]);
                $blog['is_liked'] = $likeCheckStmt->fetchColumn() ? true : false;
                
                ?>
            <div class="blog-post" data-post-id="<?php echo $blog['post_id']; ?>">
                <h4 class="title"><?php echo htmlspecialchars($blog['title']); ?></h4> <!-- Display blog title -->
                <img class="image-article" src="../pages/posts_images/<?= $blog['image']; ?>" alt=""> <!-- Display image -->
                <p><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p> <!-- Display blog content -->

                <!-- Like button with dynamic like count -->
                <div>
                    <button class="like-button">
                        <i class="<?php echo $blog['is_liked'] ? 'bi bi-hand-thumbs-up-fill' : 'bi bi-hand-thumbs-up'; ?>"></i>
                    </button>

                    <span class="like-count"><?php echo $blog['like_count']; ?></span>
                    <button class="share-button" 
                            data-link="https://penjaspeppers.com/pages/blog.php?post=<?php echo $blog['post']; ?>" 
                            data-image="../pages/posts_images/<?php echo $blog['image']; ?>">
                            <i class="bi bi-share"></i> Share
                    </button>
                </div>

                <!-- Comment section -->
                <div class="comment-section">
                    <h4>Comments</h4>
                    <div class="comments">
                        <?php
                        // Fetch comments for this post
                        $commentStmt = $db->prepare("
                            SELECT comments.comment, comments.id, users.user_id, users.firstname , users.lastname,users.photo
                            FROM comments
                            JOIN users ON comments.user_id = users.user_id
                            WHERE comments.post_id = ?
                            ORDER BY comments.created_at DESC
                        ");
                        $commentStmt->execute([$blog['post_id']]);
                        $comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <?php foreach ($comments as $index => $comment): ?> <!-- Loop through comments -->
                            <div class="comment <?php echo $index > 1 ? 'hidden' : ''; ?>" data-comment-id="<?php echo $comment['id']; ?>"> <!-- Show first two comments -->
                               
                                    <span style="display: flex;"><img  src="../pages/profile_photo/<?=$comment['photo']?>" style="border-radius:50%;height:20px;width:20px; margin-top:5px;margin-right:5px" alt=""><?php echo htmlspecialchars($comment['firstname']).' '.htmlspecialchars($comment['lastname']); ?>:</span>
                               
                                <span style="margin-left: 25px;font-weight:200" class="comment-text"><?php echo htmlspecialchars($comment['comment']); ?></span>

                                <?php if (isset($_SESSION['user']) && $_SESSION['user_id'] == $comment['user_id']): ?> <!-- Check if the logged-in user owns the comment -->
                                    <!-- Edit and Delete buttons -->
                                    <button style="margin-left: 40px;" title="Delete this comment" class="delete-comment post-button-delete"><i class="bi bi-trash3"></i></button>
                                    <button title="Edit this comment" class="edit-comment post-button-edit"><i class="bi bi-pen"></i></button>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (count($comments) > 2): ?> <!-- Show toggle button if more than 2 comments -->
                        <button class="toggle-comments">View more comments</button>
                    <?php endif; ?>

                    <!-- Comment form -->
                    <form class="comment-form" method="POST" action="comment.php">
                        <textarea name="comment" placeholder="Add a comment..." required></textarea>
                        <input type="hidden" name="post_id" value="<?php echo $blog['post_id']; ?>">
                        <button type="submit">Post Comment</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<!-- Share Popup -->
<!-- Share Popup -->
 <div class="popup-container">
    <div id="share-popup" style="display: none; position: fixed; top: 20%; left: 35%; background: #fff; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.2); z-index: 1000; border-radius: 10px; text-align: center;">
        <h4>Share this post</h4>
        <div class="media-sociaux" style="margin: 15px 0;">
            <a id="share-facebook" href="#" target="_blank" style="margin: 0 10px;"><i style="color: #0080f7;" class='bx bxl-facebook'></i></a>
            <a id="share-twitter" href="#" target="_blank" style="margin: 0 10px;"><i style="color: #000000;" class="fa-brands fa-x-twitter"></i></a>
            <a id="share-whatsapp" href="#" target="_blank" style="margin: 0 10px;"><i style="color: #41d251;" class='bx bxl-whatsapp'></i></a>
            <a id="share-linkedin" href="#" target="_blank" style="margin: 0 10px;"><i style="color: #1DA1F2;" class='bx bxl-linkedin'></i></a>
        </div>
        <button id="close-popup" style="margin-top: 10px; background: initial; color: #3c8cc9; cursor: pointer; "><i class="bi bi-x-circle"></i></button>
    </div>
 </div>
<script src="../asset/javascript/app.js"></script>
<script src="../asset/javascript/blog.js"></script>
</body>
</html>