<?php
    require_once('database/db.php');
    if (isset($_GET['product_id']) && !empty($_GET['product_id'])) {
        $getid = $_GET['product_id'];
        $recup_id = $db->prepare('SELECT * FROM products WHERE product_id = ?');
        $recup_id->execute(array($getid));
        if ($recup_id->rowCount() > 0) {
            $delete_image = $db->prepare('DELETE FROM products WHERE product_id = ?');
            $delete_image->execute(array($getid));
            echo '<script>alert("Product successfully deleted");</script>';
            echo '<script>window.location.href="../admin/products.php";</script>';
            exit;
        } else {
            echo "<script>alert('No product found');</script>";
            echo '<script>window.location.href="../admin/products.php";</script>';
            exit;
        }
    }
?>
