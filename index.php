<?php
require 'functions.php';
$products = getAllProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BridgeCourier.</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css?v=<?php echo time(); ?>">
</head>
<body>
    <section id="header">
    <?php require "navbar.php"; ?>
    </section>
        <div class="hero">
            <h4>FASHION & CLOTHINGS</h4>
            <h2>Super value deals</h2>
            <h1>On all products</h1>
            <p>Save more with counpons, prom-code and up to 70% off! </p>
            <button onclick="window.location.href='shop.php'">Shop Now</button>
        </div>
    </section>
    
    <section id="feature" class="section_p1">
        <div class="fe-box">
            <img src="img/features/f1.png" alt="">
            <h6>Free Shipping</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f2.png" alt="">
            <h6>Online Order</h6>
        </div> 
        <div class="fe-box">
            <img src="img/features/f3.png" alt="">
            <h6>Save Money</h6>
        </div> 
        <div class="fe-box">
            <img src="img/features/f4.png" alt="">
            <h6>Promotion</h6>
        </div> 
        <div class="fe-box">
            <img src="img/features/f5.png" alt="">
            <h6>Happy Sell</h6>
        </div> 
        <div class="fe-box">
            <img src="img/features/f6.png" alt="">
            <h6>Support</h6>
        </div>
    </section>

    <section id="product1" class="section_p1">
        <h2>Featured Product</h2>
        <p>Summer Collection New Morder Design</p>
        <div class="pro-container">
            <?php foreach ($products as $key => $product) { ?>
                <?php if($product['f_stat'] == 1) { ?>
                    <div class="pro" onclick="window.location.href='shop.php'">
                        <img src="img/products/<?php echo $product['image']?>" alt="<?php $product['prodname'] ?>">
                        <div class="des">
                            <h5><?php echo $product['prodname'] ?></h5>
                            <h4>Npr:<?php echo $product['price'] ?></h4>
                        </div>
                        <a href="sproduct.php?id=<?php echo $product['prod_id'] ?>"><i class="bi bi-cart cart"></i></a>
                    </div>
                <?php } ?>
            <?php } ?>
                    
        </div>
    </section>

    <section id="banner" class="section_m1">
        <h4>Repair Services</h4>
        <h2>Up to <span>70% Off</span> - All T-shirts & Accessories</h2>
        <button class="normal">Explore More</button>
    </section>

    <section id="product1" class="section_p1">
        <h2>New Arrivals</h2>
        <p>Summer Collection New Morder Design</p>
        <div class="pro-container">
        <?php foreach ($products as $key => $product) { ?>
                <?php if($product['na_stat'] == 1) { ?>
                    <div class="pro" onclick="window.location.href='shop.php'">
                        <img src="img/products/<?php echo $product['image']?>" alt="<?php $product['prodname'] ?>">
                        <div class="des">
                            <h5><?php echo $product['prodname'] ?></h5>
                            <h4>Npr: <?php echo $product['price'] ?></h4>
                        </div>
                        <a href="sproduct.php?id=<?php echo $product['prod_id'] ?>"><i class="bi bi-cart cart"></i></a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>

    <section id="sm-banner" class="section_p1">
        <div class="banner-box">
            <h4>crazy deals</h4>
            <h2>Buy 1 get 1 free</h2>
            <span>The best classic dress is on the sale at cara</span>
            <button class="white">Learn More</button>
        </div>
        <div class="banner-box banner-box2">
            <h4>Spring/Summer </h4>
            <h2>Upcoming Season</h2>
            <span>The best classic dress is on the sale at cara</span>
            <button class="white">Collection
            </button>
        </div>
    </section>

    <section id="banner3">
        <div class="banner-box">
            <h2>Seasononal sale</h2>
            <h3>Winter Collection -50% OFF</h3>
        </div>
        <div class="banner-box banner-box2">
            <h2>New Footwear Collection</h2>
            <h3>Spring/Summer 2024</h3>
        </div>
        <div class="banner-box banner-box3">
            <h2>T-Shirts</h2>
            <h3>New Trendy Styles</h3>
        </div>
    </section>
    <?php require "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>