<?php 

	require_once 'functions.php';
    if(session_status()=== PHP_SESSION_NONE){
        session_start();
    }

  if(!isset($_SESSION['seller_id'])) {
    header('location:seller_signuplogin.php');
  }
    $err = [];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (checkRequiredField('product_name')) {
        
            if (matchPattern($_POST['product_name'],"/^[a-zA-Z0-9\s\-]+$/")){
                $product_name = $_POST['product_name'];
            }
            else{
                $err['product_name'] = 'Enter Valid product_name';    
            }
            
        } else {
            $err['product_name'] = 'Enter Product Name';
        }

        if (checkRequiredField('proddesc')) {
        
            if (matchPattern($_POST['proddesc'],"/^[a-zA-Z0-9\s\.\,\!\?\-\(\)\'\"]{1,500}$/")){
                $proddesc = $_POST['proddesc'];
            }
            else{
                $err['proddesc'] = 'Enter Valid proddesc';    
            }
            
        } else {
            $err['proddesc'] = 'Enter product description';
        }

        if (checkRequiredField('price')) {
        
            if (matchPattern($_POST['price'],"/^\d+(\.\d{1,2})?$/")){
                $price = $_POST['price'];
            }
            else{
                $err['price'] = 'Enter Valid price';    
            }
            
        } else {
            $err['price'] = 'Enter price';
        }

        if (checkRequiredField('quantity')) {
        
            if (matchPattern($_POST['quantity'],"/^[0-9]\d{0,2}$/")){
                $quantity = $_POST['quantity'];
            }
            else{
                $err['quantity'] = 'Enter Valid quantity';    
            }
            
        } else {
            $err['quantity'] = 'Enter quantity';
        }

        if (checkRequiredField('image')) {

            if (matchPattern($_POST['image'],"/^[a-zA-Z0-9_\-]+\.(jpg|jpeg|png|gif)$/i")){
                $image = $_POST['image'];
            }
            else{
                $err['image'] = 'Enter Valid image';
            }

        } else {
            $err['image'] = 'Enter image';
        }
        $f_stat= $_POST['f_stat'];
        $na_stat= $_POST['na_stat'];


        if(count($err) == 0){
            if (addProduct($product_name,$proddesc,$price,$quantity,$image,$f_stat,$na_stat)) {
                $err['success'] = 'Add Product Success';   
            } else {
            $err['failed'] = 'Product add failed';
            }
            
        }  
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/add_prod.css?v<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css?v=<?php echo time(); ?>">
</head>
<body>
    <section id="header">
        <?php require 'navbar.php'; ?>
    </section>
    <!--Product data add -->
    <div class="container">
        <div class="main">  	
            <?php if (isset($user)): ?>
                <h2 class="text-center">Welcome <?php echo htmlspecialchars($user['username']) ; ?>.</h2>
            <?php endif; ?>
            <button onclick="location.href='addProduct.php'">Add Product</button>
            <button onclick="location.href='sellerview.php'">View Product</button>
            
				
		</div>
	</div>
	<?php require "footer.php"; ?>

</body>
</html>