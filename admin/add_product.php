<?php
    require_once('../controllers/add_product.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="icon" href="../asset/images/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="../asset/css/login.css">
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
    <section class="login-section">
        <form action="" method="post" enctype="multipart/form-data">
            <a href="products.php" style="color: #3c8cc9; font-size:1.2rem" title="Return back to dashboard"><i class="bi bi-arrow-left-circle-fill"></i></a>
            <h3>Add a Product</h3>
            <div>
                <input type="text" name="name" placeholder="Product Name" value="<?= isset($name) ? $name : '' ?>" >
                <select name="category" id="">
                    <option value="select">Select a category</option>
                    <option value="Peppers">Peppers</option>
                    <option value="Chocolates">Chocolates</option>
                    <option value="Cigars">Cigars</option>
                    <option value="Other">Other</option>
                </select>
                <textarea name="description" placeholder="Product description" rows="4" ><?= isset($description) ? $description : '' ?></textarea>
                <input type="number" name="stock" placeholder="Stock Quantity" value="<?= isset($stock) ? $stock : '' ?>" min="0" />
                <input type="number" name="price" placeholder="Product price">
                <p style="text-align: left;">Product Photo</p>
                <input type="file" name="uploadfile" accept="image/*" >
                <input class="button" type="submit" name="add_product" value="Add Product">
                <div class="errors-management">
                    <p class="error"><?=$error?></p>
                    <p class="success"><?=$success?></p>
                </div>
            </div>
        </form>
    </section>
</body>
</html>
