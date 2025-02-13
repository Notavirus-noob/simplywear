<?php
require('functions.php');  

if(session_status()=== PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['admin_id'])){
    header('location:admin_login.php');
    exit;
}
if(isset($_SESSION['admin_id'])==2 ){
    echo '<script>alert("Welcome My Master");</script>';
}
$getCount = getCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css?v=<?php echo time(); ?>">
</head>
<body>
<section id="header">
    <?php require "navbar.php"; ?>
    </section>

    <div class="dashboard">
        <h1>Admin Dashboard</h1>

        <div class="stats">
            <div class="stat-box">
                <h3>Total Users</h3>
                <p><?php echo $getCount['userCount']; ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Sellers</h3>
                <p><?php echo $getCount['sellerCount'] ?></p>
            </div>
            <div class="stat-box">
                <h3>Pending Sellers</h3>
                <p><?php echo $getCount['pendingSellerCount'] ?></p>
            </div>
            <div class="stat-box">
                <h3>Active Sellers</h3>
                <p><?php echo $getCount['activeSellerCount'] ?></p>
            </div>
        </div>

        <div class="buttons">
            <a href="view_users.php" class="btn">View User Data</a>
            <a href="view_sellers.php" class="btn">View Seller Data</a>
        </div>
    </div>
    <?php require "footer.php"; ?>

</body>
</html>
