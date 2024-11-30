<?php
    session_start();
    require_once('../controllers/database/db.php');
    if (isset($_GET['query'])) {
        $searchQuery = $_GET['query'];
        
        // Search products based on the query
        $stmt = $db->prepare('SELECT * FROM products WHERE stock > 0 AND name LIKE :query ORDER BY product_id DESC');
        $stmt->execute(['query' => '%' . $searchQuery . '%']);
        $products = $stmt->fetchAll();

        if(!$products){
            echo '<p>No products found</p>';
        } else {
            foreach($products as $product){
                ?>
                <div class="product">
                    <a href="product_detail.php?product=<?=$product['product']?>"><img src="products_images/<?=$product['photo']?>" alt=""></a>
                    <h4><?=$product['name']?></h4>
                    <?php
                            $sql = 'SELECT AVG(rating) as avg_rating FROM reviews WHERE product_id = ?';
                            $stmt = $db->prepare($sql);
                            $stmt->execute([$product['product_id']]);
                            $result = $stmt->fetch();
                            $avg_rating = round($result['avg_rating'], 1);
                            ?>
                                <div class="stars">
                                    <div>
                                        <?php
                                            // Loop through 5 stars
                                            for ($i = 1; $i <= 5; $i++) {
                                                // Check if we should display a filled star, half star, or an empty star
                                                if ($i <= floor($avg_rating)) {
                                                    // Full star
                                                    echo "<i class='bi bi-star-fill'></i>";
                                                } elseif ($i == ceil($avg_rating) && $avg_rating != floor($avg_rating)) {
                                                    // Half star (if it's a fractional rating)
                                                    echo "<i class='bi bi-star-half'></i>";
                                                } else {
                                                    // Empty star
                                                    echo "<i class='bi bi-star'></i>";
                                                }
                                            }
                                        ?>
                                    </div>
                                    <p>(<?php echo $avg_rating; ?>)</p>
                                </div>
                            <?php
                        ?>
                    <div class="buy">
                        <p>$<?=$product['price']?></p>
                        <a href="product_detail.php?product=<?=$product['product']?>">Buy</a>
                    </div>
                </div>
                <?php
            }
        }
    }
?>
