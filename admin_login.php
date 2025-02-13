<?php 
	require_once 'functions.php';
$err = [];
if(session_status()=== PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['seller_id']) || isset($_SESSION['user_id'])){
    header('location:logout_confirm.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['login'])){
        if (checkRequiredField('email_login')) {
            $email_login = $_POST['email_login'];
            
        } else {
            $err['email_login'] = 'Enter email';
        }

        if (checkRequiredField('pwd_login')) {
            $pwd_login = $_POST['pwd_login'];
            
        } else {
            $err['pwd_login'] = 'Enter pwd';
        }
        if(count($err) == 0){
            $form_origin = $_POST['form_origin']; // Origin from hidden field
            $check=checkData($email_login,$pwd_login,$form_origin);
            if(!$check){
                $err['invalid']='email or password wrong';
            }
        }
    }  
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>login&Signup</title>
	<link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="css/login.css?v<?php echo time(); ?>">
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css?v=<?php echo time(); ?>">
</head>
<body>
	<section id="header">
    <?php require "navbar.php"; ?>
    </section>
	<div class="container">
		<div class="main">  	
			<input type="checkbox" id="chk" aria-hidden="true">
				<div class="signup" id="login_form">
					<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
                        <input type="hidden" name="form_origin" value="admin_form"> <!-- Hidden field for specific origin -->
						<label for="chk" aria-hidden="true" class="text-center" >Admin login</label>
						<input type="email" name="email_login" id="email_login" placeholder="Email">
						<?php  echo displayErrorMessage($err,'email_login')?>
                        <input type="password" name="pwd_login" id="pwd_login" placeholder="Password">
						<?php  echo displayErrorMessage($err,'pwd_login')?>
						<button type="submit" name="login">Login</button>
						<?php  echo displayErrorMessage($err,'invalid')?>
					</form>
				</div>
		</div>
	</div>
	<?php require "footer.php"; ?>
</body>
</html>