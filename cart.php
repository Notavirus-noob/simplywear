
<?php 
require 'functions.php'; 
if(session_status()==PHP_SESSION_NONE){
    session_start();
}
if(isset($_SESSION['seller_id'])){
    header('location:sellerdashboard.php?error=Access Denied');
}

if (isset($_GET['delid']) && is_numeric($_GET['delid'])) {
    if (getCartById($_GET['delid'])) {
        if(deleteCart($_GET['delid'])){
            $err['success'] =  'Cart deleted success';
        } else {
            $err['failed'] = 'Cart delete Failed';
        }
    } else {
        $err['failed'] = 'product not found';
    }
}
if(isset($_SESSION['user_id'])){
    $user = getUserById($_SESSION['user_id']);
    $carts = getAllCart($_SESSION['user_id']);
}
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

    <section id="page-header" class="about-header">
        <h2>#Let's talk</h2>
        <p>LEAVE A MESSAGE,We love to hear from you!</p>
    </section>
    <?php if (!isset($user['username'])): ?>
        <h2 class="text-center">Welcome Guest. <a href="user_signuplogin.php">Please login</a></h2>
    <?php elseif (isset($user)): ?>

            <h2 class="text-center">Welcome <?php echo htmlspecialchars($user['username']) ; ?>.</h2>
    <?php endif; ?>

    <section id="cart" class="section_p1">
        <table  width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Size</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>SubTotal</td>
                </tr>
            </thead>
            <tbody>
                <?php $final=0; ?>
                <?php if (isset($carts)): ?>
                    <?php foreach ($carts as $index => $cart) { ?>
                        <tr>
                        <td><a href="cart.php?delid=<?php echo $cart['id']?>"><i class="bi bi-x-circle"></i></a></td>
                            <td><img src="img/products/<?php echo $cart['image'] ?>" alt="<?php echo $cart['product_name'] ?>"></td>
                            <td><?php echo $cart['product_name'] ?></td>
                            <td><?php echo $cart['size'] ?></td>
                            <td><?php echo $cart['price'] ?></td>
                            <td><?php echo $cart['quantity'] ?></td>
                            <td><?php echo $cart['total'] ?></td>
                            <?php $final += $cart['total']; ?>
                        </tr>
                    <?php } ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <section id="cart-add" class="section_p1">
        <div>
        </div>
        <div id="subtotal">
            <h3>Cart Total</h3>
            <table>
                <tr>
                    <td>Cart SubTotal</td>
                    <td><strong>Rs: <?php echo $final ?></strong></td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>Rs: <?php echo $final ?></strong></td>
                    
                </tr>
            </table>
            <?php if (isset($user)): ?>
            <a href="checkout.php?user_id=<?php $user ?>"> <button class="normal">Procced to Checkout</button></a>
            <?php else: ?>
                <a href="#" onclick="alert('Login First!!')"> <button class="normal">Procced to Checkout</button></a>
            <?php endif; ?>
           
        </div>
    </section>
    <?php require "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>