<?php 
require 'functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// If session is not empty
if (!empty($_SESSION)) {
    if (isset($_SESSION['seller_id']) || isset($_SESSION['admin_id'])) {
        session_unset();
        session_destroy();
        header('Location: user_signuplogin.php');
        exit;
    }

    if (!isset($_SESSION['user_id'])) {
        header('Location: user_signuplogin.php');
        exit;
    }
}

// Delete cart item with confirmation
if (isset($_GET['delid']) && is_numeric($_GET['delid'])) {
    if (getCartById($_GET['delid'])) {
        if(deleteCart($_GET['delid'])){
            $err['success'] = 'Cart deleted successfully';
        } else {
            $err['failed'] = 'Cart delete failed';
        }
    } else {
        $err['failed'] = 'Product not found';
    }
}

if (isset($_SESSION['user_id'])) {
    $user = getUserById($_SESSION['user_id']);
    $carts = getAllCart($_SESSION['user_id']);
}

// Process Order Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id']) && !empty($_POST)) {
    $user_id = $_POST['user_id'] ?? null;
    $finalTotal = $_POST['finalTotal'] ?? 0;

    if (!empty($_POST['cart_id']) && is_array($_POST['cart_id'])) {
        $cart_ids = $_POST['cart_id'];
        $product_ids = $_POST['product_id'];
        $product_names = $_POST['product_name'];
        $sizes = $_POST['size'];
        $prices = $_POST['price'];
        $quantities = $_POST['quantity'];

        // Insert order with status "Pending Approval"

        $order_id = createOrder($user_id, $finalTotal);

        if ($order_id) {
            for ($i = 0; $i < count($product_ids); $i++) {
                if (!addOrderItem($order_id, $product_ids[$i], $product_names[$i], $sizes[$i], $prices[$i], $quantities[$i])) {
                    error_log("Failed to add order item for order id: " . $order_id);
                }
                deleteCart($cart_ids[$i]);
            }
            $_SESSION['order_success_message'] = "Your order has been sent for approval.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $_SESSION['order_error_message'] = "Order submission failed. Please try again.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

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
    <!-- technique to show alert message in php after header  -->
    <?php if (isset($_SESSION['order_success_message'])): ?>
    <div class="alert alert-success">
        <?php $orderSuccess= htmlspecialchars($_SESSION['order_success_message']); 
        echo "<script>alert('" . addslashes($orderSuccess) . "');</script>";?>
    </div>
    <?php unset($_SESSION['order_success_message']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['order_error_message'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_SESSION['order_error_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php unset($_SESSION['order_error_message']); ?>
    <?php endif; ?>
    <!-- end -->

    <section id="header">
        <?php require "navbar.php"; ?>
    </section>
    <section id="page-header" class="about-header">
        <h2>#Let's talk</h2>
        <p>LEAVE A MESSAGE, We love to hear from you!</p>
    </section>
    
    <?php if (!isset($user['username'])): ?>
        <h2 class="text-center">Welcome Guest. <a href="user_signuplogin.php">Please login</a></h2>
    <?php else: ?>
        <h2 class="text-center">Welcome <?php echo htmlspecialchars($user['username']); ?>.</h2>
    <?php endif; ?>

    <section id="cart" class="section_p1">
        <?php if (!empty($carts)): ?>
        <table width="100%">
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
                <?php $final = 0; ?>
                <?php foreach ($carts as $cart): 
                    $subtotal = $cart['price'] * $cart['quantity'];
                    $final += $subtotal;
                ?>
                <tr>
                    <td>
                        <a href="cart.php?delid=<?php echo $cart['cart_id']; ?>" onclick="return confirm('Are you sure you want to delete this item from the cart?');">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </td>
                    <td><img src="img/products/<?php echo htmlspecialchars($cart['image']); ?>" alt="<?php echo htmlspecialchars($cart['product_name']); ?>"></td>
                    <td><?php echo htmlspecialchars($cart['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($cart['size']); ?></td>
                    <td><?php echo number_format($cart['price'], 2); ?></td>
                    <td><?php echo (int)$cart['quantity']; ?></td>
                    <td><strong><?php echo number_format($subtotal, 2); ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <h3 class="text-center">Your cart is empty.</h3>
        <?php endif; ?>
    </section>

    <?php if (!empty($carts)): ?>
    <section id="cart-add" class="section_p1">
        <div></div>
        <div id="subtotal">
            <h3>Cart Total</h3>
            <table>
                <tr>
                    <td>Cart SubTotal</td>
                    <td><strong>Rs: <?php echo number_format($final, 2); ?></strong></td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>Rs: <?php echo number_format($final, 2); ?></strong></td>
                </tr>
            </table>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                <input type="hidden" name="finalTotal" value="<?php echo $final; ?>">

                <?php foreach ($carts as $cart): ?>
                    <input type="hidden" name="cart_id[]" value="<?php echo $cart['cart_id']; ?>">
                    <input type="hidden" name="product_id[]" value="<?php echo $cart['prod_id']; ?>">
                    <input type="hidden" name="product_name[]" value="<?php echo htmlspecialchars($cart['product_name']); ?>">
                    <input type="hidden" name="size[]" value="<?php echo htmlspecialchars($cart['size']); ?>">
                    <input type="hidden" name="price[]" value="<?php echo $cart['price']; ?>">
                    <input type="hidden" name="quantity[]" value="<?php echo $cart['quantity']; ?>">
                <?php endforeach; ?>

                <button class="normal" type="submit" onclick="return confirm('You want to place an order?');">Place Order</button>
            </form>
        </div>
    </section>
    <?php endif; ?>

    <?php require "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
