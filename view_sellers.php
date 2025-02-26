<?php
require_once 'functions.php';
// Check if admin is logged in
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}
$result = getSellers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Management</title>
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css?v=<?php echo time(); ?>">
</head>
<body>
<section id="header">
    <?php require "navbar.php"; ?>
    </section>
    <div class="body-container">

        <h1 class="header-title">Seller Data</h1>
    
        <table class="table">
            <thead>
                <tr>
                    <th class="table-header">ID</th>
                    <th class="table-header">UserName</th>
                    <th class="table-header">Email</th>
                    <th class="table-header">Phone Number</th>
                 
                    <th class="table-header">Status</th>
                    <th class="table-header">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are results
                if (is_array($result) && count($result) > 0) {
                    // Loop through the data
                    foreach($result as $row) {
                        echo "<tr>";
                        echo "<td class='table-cell'>" . $row['id'] . "</td>";
                        echo "<td class='table-cell'>" . $row['username'] . "</td>";
                        echo "<td class='table-cell'>" . $row['email'] . "</td>";
                        echo "<td class='table-cell'>" . $row['phone_number'] . "</td>";
                        
                        echo "<td class='table-cell status'>" . $row['status'] . "</td>";
                        echo "<td class='table-cell'>";
                        // If the seller is pending, allow admin to approve or delete
                        if ($row['status'] == 'pending') {
                            echo "<a href='approve_seller.php?id=" . $row['id'] . "' class='action-link'>Approve</a> | ";
                        }
                        echo "<a href='delete_seller.php?id=" . $row['id'] . "' class='action-link' onclick='return confirm(\"Are you sure you want to delete this seller?\")'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='no-results'>No sellers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php require "footer.php"; ?>
</body>
</html>
