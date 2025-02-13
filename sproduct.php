<?php require "functions.php"; 
    if(session_status()== PHP_SESSION_NONE){
        session_start();
    }
    if(isset($_SESSION['seller_id'])) {
        header('location:sellerdashboard.php?error=Access Denied');
    }
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $product = getProductById( $_GET['id']);
    }
  
    $err= [];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $product_name = $_POST['prodname'];
        $price = $_POST['price'];
        $image = $_POST['image'];  
        $size = htmlspecialchars($_POST['size']);

        $valid_sizes = array( "XL", "M", "S", "L");
        if (empty($size) || !in_array($size, $valid_sizes)) {
            $err['size'] = 'Please select a valid size';
        } else {
            $size = htmlspecialchars($_POST['size']);
        }
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $image = $_POST['image'];
        if(count($err) == 0){ 
            if(isset($_SESSION['user_id'])) {
                if (addToCart($product_name, $price, $size, $quantity, $image)) {
                     $err['success'] = 'Added to Cart';   
                 } else {
                 $err['failed'] = 'Failed to add to Cart';
                }    
            } else {
                $err['failed'] = 'Please Login to add to Cart';
                
            }
        }  
    }
   

    $products = getAllProducts();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimplyWear</title>
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css?v=<?php echo time(); ?>">
</head>
<body>
    <section id="header">
    <?php require "navbar.php"; ?>
    </section>

    <form method="post" enctype="multipart/form-data">
    <section id="prodetails" class="section_p1" >
        <div class="single-pro-image">
            <img src="img/products/<?php echo $product['image']?>" width="100%" id="mainimg" alt="<?php echo $product['prodname'] ?>">
            <input type="hidden" name="image" value="<?php echo $product['image'] ?>">
        </div>
        
            
        
        <div class="single-pro-details">
                <h4 name="prodname"><?php echo $product['prodname'] ?></h4>
                <input type="hidden" name="prodname" value="<?php echo $product['prodname'] ?>">
                <h2 name="price">Npr:<?php echo $product['price'] ?></h2>
                <input type="hidden" name="price" value="<?php echo $product['price'] ?>">
                <select name="size">
                    <option value="">Select Size</option>
                    <option value="XL">XL</option>
                    <option value="L">L</option>
                    <option value="M">M</option>
                    <option value="S">S</option>
                </select>
                <?php echo displayErrorMessage($err,'size')?>
                <input type="number" width="10px" name="quantity" min="1" max="<?php echo $product['quantity']?>" value="1" >
                <span>Max Quantity: <?php echo $product['quantity'] ?></span>
                <br/>
                <br/>
                <button type="submit" class="normal" name="submit">Add to cart</button> 
                <?php echo displaySuccessMessage($err,'success')?>
                <?php echo displayErrorMessage($err,'failed')?>
                
                <h4>Product Details</h4>
                <span><?php echo $product['prod_desc'] ?></span>
            </div>
        </section>
    </form>

    <section id="product1" class="section_p1">
        <h2>Featured Products</h2>
        <p>Summer Collection New Morder Design</p>
        <div class="pro-container">

        <?php foreach ($products as $key => $product) { ?>
                <?php if($product['f_stat'] == 1) { ?>
                    <div class="pro" onclick="window.location.href='shop.php'">
                        <img src="img/products/<?php echo $product['image']?>" alt="<?php $product['prodname'] ?>" >
                        <div class="des">
                            <h5><?php echo $product['prodname'] ?></h5>
                            <h4>Npr: <?php echo $product['price'] ?></h4>
                        </div>
                        <a href="shop.php"><i class="bi bi-cart cart"></i></a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>
    <?php require "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>