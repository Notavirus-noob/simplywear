<?php
require_once 'functions.php';

// Check if admin is logged in
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

$orders = getOrders();

// Group orders by user_id
$groupedOrders = [];
foreach ($orders as $order) {
    $groupedOrders[$order['user_id']][] = $order;
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
    <h2 class="mb-4">Admin Order Management</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th class="text-center">S. No.</th>
                <th class="text-center">User ID</th>
                <th class="text-center">ID</th>
                <th class="text-center">Product Name</th>
                <th class="text-center">Price</th>
                <th class="text-center">Size</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Total</th>
                <th class="text-center">Subtotal</th>
                <th class="text-center">Order Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $serialNo = 1; ?>
            <?php foreach ($groupedOrders as $userId => $orders) : ?>
                <?php
                    $subtotal = array_sum(array_column($orders, 'total'));
                    $orderStatus = $orders[0]['order_status'];
                    $rowCount = count($orders);
                ?>
                <?php foreach ($orders as $index => $order) : ?>
                    <tr>
                        <?php if ($index === 0) : ?>
                            <td rowspan="<?= $rowCount ?>" class="align-middle text-center"><strong><?= $serialNo++ ?></strong></td>
                            <td rowspan="<?= $rowCount ?>" class="align-middle text-center"><strong><?= htmlspecialchars($userId) ?></strong></td>
                        <?php endif; ?>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($order['product_name']) ?></td>
                        <td>Rs: <?= number_format($order['price'], 2) ?></td>
                        <td><?= htmlspecialchars($order['size']) ?></td>
                        <td><?= $order['quantity'] ?></td>
                        <td>Rs: <?= number_format($order['total'], 2) ?></td>
                        <?php if ($index === 0) : ?>
                            <td rowspan="<?= $rowCount ?>" class="align-middle text-center"><strong>Rs: <?= number_format($subtotal, 2) ?></strong></td>
                            <td rowspan="<?= $rowCount ?>" class="align-middle text-center">
                                <form method="POST" action="update_order_status.php">
                                    <input type="hidden" name="user_id" value="<?= $userId ?>">
                                    <select name="order_status" class="form-select">
                                        <option value="Pending" <?= $orderStatus == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="Approve" <?= $orderStatus == 'Approve' ? 'selected' : '' ?>>Approve</option>
                                        <option value="Rejected" <?= $orderStatus == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm mt-1">Update</button>
                                </form>
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
