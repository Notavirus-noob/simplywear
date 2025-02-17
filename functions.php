<?php
    function checkRequiredField($index){
        if (isset($_POST[$index]) && !empty($_POST[$index]) && trim($_POST[$index]) && htmlspecialchars($index)) {
            return true;
        } else {
            return false;
        }
    }
    
    function displayErrorMessage($error,$index){
        if (array_key_exists($index,$error)) {
            return "<span class='err'>" . $error[$index] . " </span>";
        }
        return false;
    }
    function displaySuccessMessage($error,$index){
        if (array_key_exists($index,$error)) {
            return "<span class='success'>" . $error[$index] . " </span>";
        }
        return false;
    }
    
    function matchPattern($var,$pattern){
        if (preg_match($pattern,$var)) {
            return true;
        }
        return false;
    }

    function addUser($username, $email, $mobile_no, $pwd) {
        try {
            // Enable error reporting for MySQLi
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
            // Connect to the database
            $connection = new mysqli('localhost', 'root', '', 'bridge_courier');
    
            // Escape user input to prevent SQL Injection
            $username = $connection->real_escape_string($username);
            $email = $connection->real_escape_string($email);
            $mobile_no = $connection->real_escape_string($mobile_no);
    
            // Construct the SQL query
            $insertsql = "INSERT INTO user_credentials (username, email, mobile, password) 
                          VALUES ('$username', '$email', '$mobile_no', '$pwd')";
    
            // Execute the query
            if ($connection->query($insertsql) === TRUE) {
                $connection->close();
                return true;
            } else {
                $connection->close();
                return false;
            }
        } catch (mysqli_sql_exception $ex) {
            // Handle duplicate entry errors
            if (strpos($ex->getMessage(), "Duplicate entry") !== false) {
                if (strpos($ex->getMessage(), "for key 'username'") !== false) {
                    return "username";
                } elseif (strpos($ex->getMessage(), "for key 'email'") !== false) {
                    return "email";
                } elseif (strpos($ex->getMessage(), "for key 'mobile'") !== false) {
                    return "mobile";
                }
            }
            return "Database error: " . $ex->getMessage();
        }
    }
    
    function addSeller($username,$address,$email,$mobile_no,$pwd){
        try{
            $connection = mysqli_connect('localhost','root','','bridge_courier');
            $insertsql = "INSERT INTO seller_credentials(username,address, email,phone_number, password) VALUES('$username','$address', '$email' ,$mobile_no, '$pwd')";
            mysqli_query($connection,$insertsql);
            if ($connection->insert_id > 0 && $connection->affected_rows == 1) {
                return true;
            } else {
                return false;
            }
        }catch(Exception $ex){
            if (str_contains($ex->getMessage(), "Duplicate entry") && str_contains($ex->getMessage(), "for key 'username'")) {
                echo "Error: The username '{$username}' already exists.";
            }
            elseif(str_contains($ex->getMessage(), "Duplicate entry") && str_contains($ex->getMessage(), "for key 'email'")) {
                echo "Error: The email '{$email}' already exists.";
            } 
            elseif(str_contains($ex->getMessage(), "Duplicate entry") && str_contains($ex->getMessage(), "for key 'mobile'")) {
                echo "Error: The mobile no '{$mobile_no}' already exists.";
            } 
            else {
                echo "Database error: " . $ex->getMessage();
            }
        }
    }
    function addProduct($product_name,$proddesc,$price,$quantity,$image,$f_stat,$na_stat){
        try{
            if(session_status()== PHP_SESSION_NONE){
                session_start();
            }
            $connection = mysqli_connect('localhost','root','','bridge_courier');          
            $created_by= $_SESSION['seller_id'];
            $cdate = date('Y-m-d H:i:s');
            $insertsql = "INSERT INTO productdetails(prodname,prod_desc, image,price, quantity,f_stat,na_stat,created_by,created_at) VALUES('$product_name','$proddesc','$image',$price,$quantity,$f_stat,$na_stat,$created_by,'$cdate')";
            mysqli_query($connection,$insertsql);
                if ($connection->insert_id > 0 && $connection->affected_rows == 1) {
                    return true;
                } else {
                    return false;
                }
        }catch(Exception $ex){
            echo "Database error: " . $ex->getMessage();
        }
    }
    function addToCart($product_name, $price, $size, $quantity,$image) {
        try {
            $connection = mysqli_connect('localhost', 'root', '', 'bridge_courier');          
            $user_id = $_SESSION['user_id'];
            $insertsql = "INSERT INTO cart(product_name, price, size, quantity, user_id,image) VALUES(?, ?, ?, ?, ?,?)";
            $stmt = $connection->prepare($insertsql);
            $stmt->bind_param("sdsiis", $product_name, $price, $size, $quantity, $user_id,$image);
            $stmt->execute();
            
            if ($connection->insert_id > 0 && $connection->affected_rows == 1) {
                return true;
            } else {
                return false;
            }
        } catch(Exception $ex) {
            echo "Database error: " . $ex->getMessage();
        }
    }    
    function checkData($email_login,$pwd_login,$form_origin){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            //select query
            if($form_origin=='user_form'){
                $sql = sprintf(
                    "SELECT * FROM user_credentials WHERE email='%s' limit 1", 
                    $connect->real_escape_string($email_login)
                );
                $result = $connect->query($sql);
                $user = $result->fetch_assoc();
                if($user){
                    if(password_verify($pwd_login,$user['password'])){
                        session_start();
                        session_regenerate_id();
                        $_SESSION['user_id']=$user['id'];
                        header('location:cart.php');
                        
                    }
                }
                return false;
                
            }
            elseif($form_origin=='seller_form'){
                $sql = sprintf(
                    "SELECT * FROM seller_credentials WHERE email='%s' limit 1", 
                    $connect->real_escape_string($email_login)
                );
                $result = $connect->query($sql);
                $seller = $result->fetch_assoc();
                if($seller){
                    if(password_verify($pwd_login,$seller['password'])){
                        session_start();
                        session_regenerate_id();
                        $_SESSION['seller_id']=$seller['id'];
                        $_SESSION['status']=$seller['status'];
                        if($seller['status']=='active'){
                            header('location:sellerdashboard.php');
                            exit;
                        }else{
                            die("Your account is not active. Please contact the admin.");   
                        }
                    }
                }
                return false;
            }
            elseif($form_origin=='admin_form'){
                $sql = sprintf(
                    "SELECT * FROM admin WHERE email='%s' limit 1", 
                    $connect->real_escape_string($email_login)
                );
                $result = $connect->query($sql);
                $admin = $result->fetch_assoc();
                if($admin){
                    if(hash('sha256',$pwd_login)==$admin['password']){
                        session_start();
                        session_regenerate_id();
                        $_SESSION['admin_id']=$admin['admin_id'];
                        header('location:admin_dashboard.php');
                        exit;
                    }
                }
                return false;
            }
            return false;
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }
  
    function printStatus($status)  {
        if ($status == 1) {
            return 'Active';
        } else {
            return 'Pending';
        }
    }
    function getAllProducts(){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            $sql = "select * from productdetails";
            $result = $connect->query($sql);
            $products = [];
            if ($result->num_rows > 0) {
                //fetch products
                while ($record= $result->fetch_assoc()) {
                    array_push($products,$record);
                }
            }
            return $products;
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }
    
    
    function getProductById($id){
        try {
            $connect = new mysqli( 'localhost','root','','bridge_courier');
            $sql = "select * from productdetails where prod_id=$id";
            $result = $connect->query($sql);
            if ($result->num_rows == 1) {
                $recordById= $result->fetch_assoc();
                return $recordById;
            }
            return false;
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }
    function getProductsBySellerId($seller_id){
        try {
            // Connect to the database
            $connect = new mysqli('localhost', 'root', '', 'bridge_courier');
            
            // SQL query to fetch products created or modified by the seller
            $sql = "SELECT * FROM productdetails WHERE created_by = $seller_id OR modified_by = $seller_id";
            
            // Execute the query
            $result = $connect->query($sql);
    
            // Check if there are any products
            if ($result->num_rows > 0) {
                $products = [];
                // Fetch all rows as an associative array
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
                return $products; // Return all products
            } else {
                return false; // No products found
            }
    
        } catch (\Throwable $th) {
            // Handle any errors
            die('Error: ' . $th->getMessage());
        }
    }
    
    function getCartById($id){
        try {
            $connect = new mysqli( 'localhost','root','','bridge_courier');
            $sql = "select * from cart where id=$id";
            $result = $connect->query($sql);
            if ($result->num_rows == 1) {
                $recordById= $result->fetch_assoc();
                return $recordById;
            }
            return false;
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }
    
    
    function deleteProduct($del_id){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            $sql = "delete from productdetails where prod_id=$del_id";
            $connect->query($sql);
            if ($connect->affected_rows == 1) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }
    function deleteCart($del_id){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            $sql = "delete from cart where id=$del_id";
            $connect->query($sql);
            if ($connect->affected_rows == 1) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }
    
    function updateProduct($product_name,$proddesc,$price,$quantity,$image,$f_stat,$na_stat,$edtid){
        try {
            if(session_status()==PHP_SESSION_NONE) {
                session_start();
            }
            $connect = new mysqli('localhost','root','','bridge_courier');
            $cdate = date('Y-m-d H:i:s');
            $modified_by= $_SESSION['seller_id'];
            $sql = "update productdetails set prodname='$product_name', prod_desc='$proddesc', price=$price, quantity=$quantity, image='$image', f_stat=$f_stat, na_stat=$na_stat, modified_by=$modified_by, modified_at='$cdate' where prod_id=$edtid";           
            $connect->query($sql);
            if ($connect->affected_rows == 1) {
                header('location:sellerview.php');
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }


    function getCount(){
        try {
            $connect = new mysqli('localhost', 'root', '', 'bridge_courier');
            
            // Queries for user, seller, and cart counts
            $userQuery = "SELECT COUNT(*) as count FROM user_credentials";
            $sellerQuery = "SELECT COUNT(*) as count FROM seller_credentials";
            $pendingSellerQuery = "SELECT COUNT(*) as count FROM seller_credentials WHERE status = 'pending'";
            $activeSellerQuery = "SELECT COUNT(*) as count FROM seller_credentials WHERE status = 'active'";
    
            // Query to get cart count for unique user_id
            $pendingCartQuery = "SELECT COUNT(DISTINCT user_id) as count FROM cart WHERE user_id != '' and order_status='pending'";
            $approvedCartQuery = "SELECT COUNT(DISTINCT user_id) as count FROM cart WHERE user_id != '' and order_status='approved'";
            $rejectedCartQuery = "SELECT COUNT(DISTINCT user_id) as count FROM cart WHERE user_id != '' and order_status='rejected'";;
    
            // Execute all queries
            $userCount = $connect->query($userQuery)->fetch_assoc()['count'];
            $sellerCount = $connect->query($sellerQuery)->fetch_assoc()['count'];
            $pendingSellerCount = $connect->query($pendingSellerQuery)->fetch_assoc()['count'];
            $activeSellerCount = $connect->query($activeSellerQuery)->fetch_assoc()['count'];
            $PendingCartCount = $connect->query($pendingCartQuery)->fetch_assoc()['count'];
            $approvedCartCount = $connect->query($approvedCartQuery)->fetch_assoc()['count'];
            $rejectedCartCount = $connect->query($rejectedCartQuery)->fetch_assoc()['count'];
    
            return [
                'userCount' => $userCount,
                'sellerCount' => $sellerCount,
                'activeSellerCount' => $activeSellerCount,
                'pendingSellerCount' => $pendingSellerCount,
                'pendingCartCount' => $PendingCartCount,
                'approvedCartCount' => $approvedCartCount,
                'rejectedCartCount' => $rejectedCartCount,
            ];
        } catch (\Throwable $th) {
            die('Error: ' . $th->getMessage());
        }
    }
    
  
    function getSellers(){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            $sql = "select * from seller_credentials";
            $result = $connect->query($sql);
            $sellers = [];
            if ($result->num_rows > 0) {
                //fetch products
                while ($record= $result->fetch_assoc()) {
                    array_push($sellers,$record);
                }
            }
            return $sellers;
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }

    function getUsers(){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            $sql = "select * from user_credentials";
            $result = $connect->query($sql);
            $users = [];
            if ($result->num_rows > 0) {
                //fetch products
                while ($record= $result->fetch_assoc()) {
                    array_push($users,$record);
                }
            }
            return $users;
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }
    function getOrders(){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            $sql = "select * from cart";
            $result = $connect->query($sql);
            $users = [];
            if ($result->num_rows > 0) {
                //fetch products
                while ($record= $result->fetch_assoc()) {
                    array_push($users,$record);
                }
            }
            return $users;
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }

    function getSellerById($id){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            $sql = "select * from seller_credentials where id=$id";
            $result = $connect->query($sql);
            if ($result->num_rows == 1) {
                $record = $result->fetch_assoc();
                return $record;
            }
            return false;
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }
    function getUserById($id){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            $sql = "select * from user_credentials where id=$id";
            $result = $connect->query($sql);
            if ($result->num_rows == 1) {
                $record = $result->fetch_assoc();
                return $record;
            }
            return false;
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }
    function deleteSeller($del_id){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            $sql = "delete from seller_credentials where seller_id=$del_id";
            $connect->query($sql);
            if ($connect->affected_rows == 1) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }
    function deleteUser($del_id){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            $sql = "delete from user_credentials where id=$del_id";
            $connect->query($sql);
            if ($connect->affected_rows == 1) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }
   function getAdminById($id){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            $sql = "select * from admin where admin_id=$id";
            $result = $connect->query($sql);
            if ($result->num_rows == 1) {
                $record = $result->fetch_assoc();
                return $record;
            }
            return false;
        } catch (\Throwable $th) {
           die('Error: ' . $th->getMessage());
        }
    }
    function getAllCart($id){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            $sql = "select * from cart where user_id=$id";
            $result = $connect->query($sql);
            $cart = [];
            if ($result->num_rows > 0) {
                //fetch products
                while ($record= $result->fetch_assoc()) {
                    array_push($cart,$record);
                }
            }
            return $cart;
        } catch (\Throwable $th) {
            die('Error: ' . $th->getMessage());
        }
    }
    function updateUserAddress($userAddress,$id){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
            $sql = "UPDATE user_credentials SET address='$userAddress' WHERE id=$id";
            $connect->query($sql);
            if ($connect->affected_rows == 1) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            die('Error: ' . $th->getMessage());
        }
    }
    
    function getAddressByUserId($id){
        try {
            $connect = new mysqli('localhost','root','','bridge_courier');
    
            if ($connect->connect_error) {
                throw new Exception('Connection failed: ' . $connect->connect_error);
            }
    
            $sql = "SELECT address FROM user_credentials WHERE id = $id";
            $result = $connect->query($sql);
    
            if ($result->num_rows == 1) {
                $record = $result->fetch_assoc();
                return $record['address'];  // Return only the address
            }
    
            return false;  // If no address found
    
        } catch (\Throwable $th) {
            // Log error instead of die()
            error_log('Error: ' . $th->getMessage());
            return false;
        }
    }
    
    ?>