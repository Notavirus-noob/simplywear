<?php
require_once 'functions.php';

// Check if admin is logged in
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

$orders = getOrderanditems();
// Group orders by created_at
$groupedOrders = [];
foreach ($orders as $order) {
    $groupedOrders[$order['Created At']][] = $order;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['updateID'])) {
    if (isset($_GET['updateID']) && is_numeric($_GET['updateID'])) {
        if (getOrderById($_GET['updateID'])) {
            if (updateOrderStatus($_GET['updateID'], $_POST['status'])) {
                $err['success'] = 'Order Status updated successfully';
            } else {
                $err['failed'] = 'Order update Failed';
            }
        } else {
            $err['failed'] = 'Order not found';
        }
    } else {
        $err['failed'] = 'Invalid Order ID';
    }
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

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_SESSION['success_message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_SESSION['error_message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th class="text-center">S. No.</th>
                <th class="text-center">Created At</th>
                <th class="text-center">User ID</th>
                <th class="text-center">ID</th>
                <th class="text-center">Product Name</th>
                <th class="text-center">Price</th>
                <th class="text-center">Size</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Subtotal</th>
                <th class="text-center">Total</th>
                <th class="text-center">Order Status</th>
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
                        <td><?= htmlspecialchars($order['UserID']) ?></td>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($order['product_name']) ?></td>
                        <td>Rs: <?= number_format($order['price'], 2) ?></td>
                        <td><?= htmlspecialchars($order['size']) ?></td>
                        <td><?= $order['quantity'] ?></td>
                        <td>Rs: <?= number_format($order['subtotal'], 2) ?></td>
                        <?php if ($index === 0) : ?>
                            <td rowspan="<?= $rowCount ?>" class="align-middle text-center"><strong>Rs: <?= number_format($order['total'], 2) ?></strong></td>
                            <td rowspan="<?= $rowCount ?>" class="align-middle text-center">
                            <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?updateID=<?= $order['ID'] ?>">
                                <input type="hidden" name="user_id" value="<?= $order['UserID'] ?>">
                                <select name="status" class="form-select" value="<?= $orderStatus; ?>">
                                    <?php if ($orderStatus == 'pending'): ?>
                                        <option value="pending" selected>pending</option>
                                        <option value="approved">Approve</option>
                                        <option value="rejected">Rejected</option>
                                    <?php elseif ($orderStatus == 'approved'): ?>
                                        <option value="approved" selected>Approved</option>
                                        <option value="shipped">Shipped</option>
                                        <option value="delivered">Delivered</option>
                                    <?php elseif ($orderStatus == 'shipped'): ?>
                                        <option value="shipped" selected>Shipped</option>
                                        <option value="delivered">Delivered</option>
                                    <?php elseif ($orderStatus == 'delivered'): ?>
                                        <option value="delivered" selected>Delivered</option>
                                    <?php elseif ($orderStatus == 'cancelled'): ?>
                                    <?php else: ?>
                                        <option value="pending">Pending</option>
                                    <?php endif; ?>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm mt-1" onclick="return confirm('do you want to update this order?');">Update</button>
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