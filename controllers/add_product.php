<?php
    $error = null;
    $success = null;
    require_once('database/db.php');
    //a function to generate a slug
    function generateSlug($name) {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }
    if (isset($_POST['add_product'])) {
        // Retrieve and sanitize input
        $name = htmlspecialchars($_POST['name']);
        $category = htmlspecialchars($_POST['category']);
        $description = htmlspecialchars($_POST['description']);
        $stock = htmlspecialchars($_POST['stock']);
        $price = htmlspecialchars($_POST['price']);
        // Handle file upload
        $filename = $_FILES["uploadfile"]["name"];
        $filesize = $_FILES["uploadfile"]["size"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "../pages/products_images/" . $filename;
        $allowed_formats = array('jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG');
        $slug = generateSlug($name);
        // Check for duplicate entry
        $existing_product = $db->prepare('SELECT * FROM products WHERE name = :name AND category = :category');
        $existing_product->execute(['name' => $name, 'category' => $category]);
        $get_product = $existing_product->fetch();

        if (empty($name) || empty($category) || empty($description) || empty($stock) || empty($price) || empty($filename)) {
            $error = "Please fill all fields!";
        } elseif($category == 'select'){
            $error = "Please select the category";
        } elseif ($filesize > 5000000) {
            $error = "Your photo should not exceed 5MB.";
        } elseif (!in_array(pathinfo($filename, PATHINFO_EXTENSION), $allowed_formats)) {
            $error = "Only JPG, JPEG, and PNG formats are allowed.";
        }  elseif ($get_product) {
            $error = "The product <strong>" . $name . "</strong> already exists.";
        } else {
            // Move uploaded file
            if (!move_uploaded_file($tempname, $folder)) {
                $error = "Error uploading the file.";
            } else {
                // Insert into products table
                $query = $db->prepare('INSERT INTO products (name, category, description, stock,price, photo,product) VALUES (:name, :category, :description, :stock,:price, :photo,:product)');
                $query->bindParam(':name', $name);
                $query->bindParam(':category', $category);
                $query->bindParam(':description', $description);
                $query->bindParam(':stock', $stock);
                $query->bindParam(':price',$price);
                $query->bindParam(':photo', $filename);
                $query->bindParam(':product',$slug);

                if ($query->execute()) {
                    $success = "Product added successfully ✅";
                } else {
                    $error = "Error adding the product.";
                }
            }
        
        }
    }
?>
