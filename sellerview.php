
<?php 
require 'functions.php'; 
if(session_status()=== PHP_SESSION_NONE){
    session_start();

}
if(!isset($_SESSION['seller_id'])) {
    header('location:seller_signuplogin.php');
  }
$err=[];
if (isset($_GET['delid']) && is_numeric($_GET['delid'])) {
    if (getProductById($_GET['delid'])) {
        if(deleteProduct($_GET['delid'])){
            $err['prod_s'] =  'Product deleted success';
        } else {
            $err['prod_f'] = 'product delete Failed';
        }
    } else {
        $err['prod_f'] = 'product not found';
    }
}

$products=getProductsBySellerId($_SESSION['seller_id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css?v=<?php echo time(); ?>">
</head>
<body>
    <section id="header">
        <?php require "navbar.php"; ?>
    </section>

    <section id="cart" class="section_p1">
    <?php  echo displayErrorMessage($err,'prod_s'); ?>
    <?php echo displayErrorMessage($err,'prod_f'); ?>
        <table  width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Edit</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                </tr>
            </thead>
            <tbody>
                <?php $cartsubtotal=0; ?>
                <?php if (isset($products) && is_array($products) && !empty($products)): ?>
                    <?php foreach ($products as $index => $product) { ?> 
                        <tr>
                            <td><a href="sellerview.php?delid=<?php echo $product['prod_id']?>"><i class="bi bi-x-circle"></i></a></td>
                            <td><a href="editProduct.php?edtid=<?php echo $product['prod_id']?>"><i class="bi bi-pencil-fill"></i></a></td>
                            <td><img src="img/products/<?php echo $product['image']?>" alt="<?php echo $product['prodname'] ?>"></td>
                            <td><?php echo $product['prodname'] ?></td>
                            <td><?php echo $product['price'] ?></td>
                            <td><?php echo $product['quantity'] ?></td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No products available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
    <?php require "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>