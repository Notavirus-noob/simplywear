<?php
require_once 'functions.php';

// Check if admin is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:user_signuplogin.php');
    exit();
}

$orders = getOrderanditemsById($_SESSION['user_id']);

// Group orders by created_at
$groupedOrders = [];
foreach ($orders as $order) {
    $groupedOrders[$order['Created At']][] = $order;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Order Management</title>
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css?v=<?php echo time(); ?>">
    <style>
        /* Fix dropdown width issue */
        select.form-select {
            width: auto;
            display: inline-block;
        }
    </style>
</head>
<body>
<section id="header">
    <?php require "navbar.php"; ?>
</section>

<div class="container mt-4">
    <h2 class="mb-4">Order Status</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th class="text-center">S. No.</th>
                <th class="text-center">Created At</th>
                <th class="text-center">ID</th>
                <th class="text-center">Product Name</th>
                <th class="text-center">Price</th>
                <th class="text-center">Size</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Subtotal</th>
                <th class="text-center">Total</th>
                <th class="text-center">Order Status</th>
                <th class="text-center">Track Order</th>
            </tr>
        </thead>
        <tbody>
            <?php $serialNo = 1; ?>
            <?php foreach ($groupedOrders as $createdAt => $orders) : ?>
                <?php

                    $orderStatus = $orders[0]['Order Status'];
                    $rowCount = count($orders);
                ?>
                <?php foreach ($orders as $index => $order) : ?>
                    <tr>
                        <?php if ($index === 0) : ?>
                            <td rowspan="<?= $rowCount ?>" class="align-middle text-center"><strong><?= $serialNo++ ?></strong></td>
                            <td rowspan="<?= $rowCount ?>" class="align-middle text-center"><strong><?= htmlspecialchars($createdAt) ?></strong></td>
                        <?php endif; ?>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($order['product_name']) ?></td>
                        <td>Rs: <?= number_format($order['price'], 2) ?></td>
                        <td><?= htmlspecialchars($order['size']) ?></td>
                        <td><?= $order['quantity'] ?></td>
                        <td>Rs: <?= number_format($order['subtotal'], 2) ?></td>
                        <?php if ($index === 0) : ?>
                            <td rowspan="<?= $rowCount ?>" class="align-middle text-center"><strong>Rs: <?= number_format($order['total'], 2) ?></strong></td>
                            <td rowspan="<?= $rowCount ?>" class="align-middle text-center"><?=$order['Order Status'] ?></td>
                            <td rowspan="<?= $rowCount ?>" class="align-middle text-center">
                            <?php if ($order['Order Status'] == 'shipped' || $order['Order Status'] == 'approved'|| $order['Order Status'] == 'delivered'): ?>
                                    <a href="track_order_details.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-primary btn-sm">Track</a>
                            <?php else: ?>
                                    <span class="text-muted">Tracking not available</span>
                            <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require "footer.php"; ?>
</body>
</html>