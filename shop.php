<?php
require 'functions.php';
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

    <section id="page-header">
        <h2>#stayhome</h2>
        <p>Save more with counpons, prom-code and up to 70% off! </p>
    </section>

    <section id="product1" class="section_p1">
        <div class="pro-container">
        <?php foreach ($products as $key => $product) { ?>
                    <div class="pro" onclick="window.location.href='sproduct.php?id=<?php echo $product['prod_id'] ?>'">
                        <img src="img/products/<?php echo $product['image']?>" alt="<?php $product['prodname'] ?>">
                        <div class="des">
                            <h5><?php echo $product['prodname'] ?></h5>
                            <h4>Rs:<?php echo $product['price'] ?></h4>
                        </div>
                        <a href="sproduct.php?id=<?php echo $product['prod_id'] ?>"><i class="bi bi-cart cart"></i></a>
                    </div>
                <?php } ?>
        </div>
    </section>
    <?php require "footer.php"; ?>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>