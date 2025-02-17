
<?php
require 'functions.php';
$err=[];
$address = '';
if(session_status()== PHP_SESSION_NONE){
    session_start();
}
if(!isset($_SESSION['user_id'])) {
    header('location:user_signuplogin.php');
    exit;
}
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $address = getAddressByUserId($_GET['user_id']);
    
    // If user already has an address, show alert and redirect
    if ($address !== ''&& $address!== null && $address !== false) {
        echo "<script>alert('Sent Request for order approval.'); window.location.href = 'index.php';</script>";
        exit;  // Stop further execution of the code
    }

    // If no address, proceed with normal flow
    if ($address === false) {
        $address = '';  // Or set to null, as needed
    }
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (checkRequiredField('userAddress')) {
        
        if (matchPattern($_POST['userAddress'],"/^[A-Za-z\s'-]+$/")){
            $userAddress = $_POST['userAddress'];
        }
        else{
            $err['userAddress'] = 'Enter Valid Address';    
        }
        
    } else {
        $err['userAddress'] = 'Enter Address';
    }
    if(count($err) == 0){

        if (updateUserAddress($userAddress,$_SESSION['user_id'])) {
            $err['success'] = 'Sent to Admin For Approval';   
        } else {
        $err['failed'] = 'Address Failed';
        }
        
    }  

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimplyWear.</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css?v=<?php echo time(); ?>">
</head>
<body>
    <section id="header">
    <?php require "navbar.php"; ?>
    </section>
    <section class="userAddress">
        <div class="address-container">
            <h2>Delivery Address</h2>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" >
                <label for="userAddress">Enter your address:</label>
                <input type="text" id="userAddress" name="userAddress" >
                <?php  echo displayErrorMessage($err,'userAddress')?>
                <button type="submit" class="addressbutton">Send for Approval</button>
                <div class="msg">
                    <?php  echo displaySuccessMessage($err,'success')?>
                    <?php  echo displayErrorMessage($err,'failed')?>
                </div>
            </form>
        </div>
    </section>
    <?php require "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>