<?php
$error = null;
$success = null;

require_once('../controllers/database/db.php'); // Update this path as necessary


$product_id = $name = $category = $description = $price = $stock = $photo = '';

// Fetch product details if product_id is provided
if (isset($_GET['product_id']) && !empty($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $query = $db->prepare('SELECT * FROM products WHERE product_id = ?');
    $query->execute([$product_id]);
    $product = $query->fetch();
    function generateSlug($name) {
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }
    if ($product) {
        $name = $product['name'];
        $category = $product['category'];
        $description = $product['description'];
        $price = $product['price'];
        $stock = $product['stock'];
        $photo = $product['photo'];
    } else {
        echo '<script>alert("Product  not found.");</script>';
        echo '<script>window.location.href="index.php";</script>';
        exit;
    }
} else {
    echo '<script>alert("Product  not found.");</script>';
    echo '<script>window.location.href="index.php";</script>';
    exit;
}

// Process the update form submission
if (isset($_POST['update_product'])) {
    $name = htmlspecialchars($_POST['name']);
    $category = htmlspecialchars($_POST['category']);
    $description = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);
    $stock = htmlspecialchars($_POST['stock']);

    $filename = $_FILES['uploadfile']['name'];
    $tempname = $_FILES['uploadfile']['tmp_name'];
    $folder = "../pages/products_images/" . $filename;
    $slug = generateSlug($name);
  
    // Validation
    if (empty($name) || empty($category) || empty($description) || empty($price) || empty($stock)) {
        $error = "Please fill all fields!";
    } elseif ($_FILES['uploadfile']['size'] > 5000000) {
        $error = "Your photo should not exceed 5MB";
    } else {
        // Use the previous photo if no new photo is uploaded
        if (empty($filename)) {
            $filename = $photo;
        } else {
            // Move the uploaded file
            if (!move_uploaded_file($tempname, $folder)) {
                $error = "Error uploading file";
            }
        }

        // Update the product details
        $update_query = $db->prepare('UPDATE products SET name=?, category=?, description=?, price=?, stock=?, photo=?,product=? WHERE product_id=?');
        $update_result = $update_query->execute([$name, $category, $description, $price, $stock, $filename,$slug, $product_id]);

        if ($update_result) {
            $success = "Product details updated successfully";
            echo "<script>alert('$success');</script>";
            echo '<script>window.location.href="../admin/products.php";</script>';
            exit;
        } else {
            $error = "Failed to update product details";
        }
    }
}
?>
