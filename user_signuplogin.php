<?php 
	require_once 'functions.php';
    $err = [];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      
        if (isset($_POST['signup'])) {
        if (checkRequiredField('username')) {
        
            if (matchPattern($_POST['username'],"/^[A-Za-z\s'-]+$/")){
                $username = $_POST['username'];
            }
            else{
                $err['username'] = 'Enter Valid username';    
            }
            
        } else {
            $err['username'] = 'Enter username';
        }

        if (checkRequiredField('email')) {
        
            if (matchPattern($_POST['email'],"/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/i")){
                $email = $_POST['email'];
            }
            else{
                $err['email'] = 'Enter Valid email';    
            }
            
        } else {
            $err['email'] = 'Enter email';
        }

        if (checkRequiredField('mobile_no')) {
        
            if (matchPattern($_POST['mobile_no'],"/^(97|98|96)\d{8}$/")){
                $mobile_no = $_POST['mobile_no'];
            }
            else{
                $err['mobile_no'] = 'Enter Valid mobile_no';    
            }
            
        } else {
            $err['mobile_no'] = 'Enter mobile_no';
        }

        if (checkRequiredField('pwd')) {
        
            if (matchPattern($_POST['pwd'],"/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/")){
                $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
            }
            else{
                $err['pwd'] = 'Password must be at least 8 characters, a number, and a special character.';    
            }
            
        } else {
            $err['pwd'] = 'Enter pwd';
        }


        if(count($err) == 0){
            if (addUser($username,$email,$mobile_no,$pwd)) {
                $err['success'] = 'User detail add success now click below';   
            } else {
            $err['failed'] = 'User detail add Failed';
            }
            
        }  
    }
    else if(isset($_POST['login'])){
        if (checkRequiredField('email_login')) {
            $email_login = $_POST['email_login'];
            
        } else {
            $err['email_login'] = 'Enter email';
        }
        
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
				<div class="signup">
					<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" id="signup">
						<label for="chk" aria-hidden="true">User Signup</label>
						<input type="text" name="username" id="username" placeholder="User name">
						<?php  echo displayErrorMessage($err,'username')?>
						<input type="email" name="email" id="email" placeholder="Email">
						<?php  echo displayErrorMessage($err,'email')?>
						<input type="number" name="mobile no" id="mobile_no" placeholder="mobile no">
						<?php  echo displayErrorMessage($err,'mobile_no')?>
						<input type="password" name="pwd" id="pwd" placeholder="Password">
						<?php  echo displayErrorMessage($err,'pwd')?>
						<button type="submit" name="signup">Sign up</button>
                        <div class="msg">
                            <?php  echo displaySuccessMessage($err,'success')?>
                            <?php  echo displayErrorMessage($err,'failed')?>
                        </div>
					</form>
				</div>

				<div class="login" id="login_form">
					<form method="post" action="<?php $_SERVER['PHP_SELF']?>"  >
                        <label for="chk" aria-hidden="true" class="text-center" >Already have an account?</label>
                        <input type="hidden" name="form_origin" value="user_form"> <!-- Hidden field for specific origin -->

						<input type="email" name="email_login" id="email_login" placeholder="Email">
                        <input type="password" name="pwd_login" id="pwd_login" placeholder="Password">
						<button type="submit" name="login">Login</button>
						<?php  echo displayErrorMessage($err,'invalid')?>
					</form>
				</div>
		</div>
	</div>
	<?php require "footer.php"; ?>
</body>
</html>