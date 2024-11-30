<?php
    session_start();
    require_once('../controllers/database/db.php');

    if (isset($_GET['query'])) {
        $searchQuery = $_GET['query'];
        // Search products based on the query
        $stmt = $db->prepare('SELECT * FROM products WHERE name LIKE :query ORDER BY product_id DESC');
        $stmt->execute(['query' => '%' . $searchQuery . '%']);
        $products = $stmt->fetchAll();

        if(!$products){
            echo '<p>No products found</p>';
        } else {
            foreach($products as $product){
                ?>
                 <div class="product">
                    <img src="../pages/products_images/<?=$product['photo']?>" alt="">
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
                
                    <p>Available stock: <?=$product['stock']?></p>
                    <div class="buy">
                        <p>$<?=$product['price']?></p>
                        <div style="gap: 10px;display:flex;margin-left:10px">
                            <a href="edit_product.php?product_id=<?=$product['product_id']?>"><i class="bi bi-pen" title="Edit this product"></i></a>
                            <a style="color: red;cursor:pointer" product_id='<?=$product['product_id']?>' class="delete" title="Delete this product"><i class="bi bi-trash3"></i></a>
                        </div>
                        
                    </div>
                </div>
                <?php
            }
        }
    }
?>
