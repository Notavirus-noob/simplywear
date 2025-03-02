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

    function addUser($username, $email, $address, $mobile_no, $pwd) {
        try {
            // Enable error reporting for MySQLi
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
            // Connect to the database
            $connection = new mysqli('localhost', 'root', '', 'simply_wear_Fashion');
    
            // Escape user input to prevent SQL Injection
            $username = $connection->real_escape_string($username);
            $email = $connection->real_escape_string($email);
            $mobile_no = $connection->real_escape_string($mobile_no);
    
            // Construct the SQL query
            $insertsql = "INSERT INTO user_credentials (username, email, mobile, password,Address) 
                          VALUES ('$username', '$email', '$mobile_no', '$pwd','$address')";
    
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
            $connection = mysqli_connect('localhost','root','','simply_wear_Fashion');
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
            $connection = mysqli_connect('localhost','root','','simply_wear_Fashion');          
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
    function addToCart($product_id,$product_name, $price, $size, $quantity,$image) {
        try {
            $connection = mysqli_connect('localhost', 'root', '', 'simply_wear_Fashion');          
            $user_id = $_SESSION['user_id'];
            $insertsql = "INSERT INTO cart(prod_id,product_name, price, size, quantity, user_id,image) VALUES(?, ?, ?, ?, ?,?,?)";
            $stmt = $connection->prepare($insertsql);
            $stmt->bind_param("isdsiis",$product_id, $product_name, $price, $size, $quantity, $user_id,$image);
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
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
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
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
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
            $connect = new mysqli( 'localhost','root','','simply_wear_Fashion');
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
            $connect = new mysqli('localhost', 'root', '', 'simply_wear_Fashion');
            
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
            $connect = new mysqli( 'localhost','root','','simply_wear_Fashion');
            $sql = "select * from cart where cart_id=$id";
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
    function getOrderById($id){
        try {
            $connect = new mysqli( 'localhost','root','','simply_wear_Fashion');
            $sql = "select * from orders where order_id=$id";
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
    
    
   function deleteProduct($del_id) {
    try {
        $connect = new mysqli('localhost', 'root', '', 'simply_wear_Fashion');
        if ($connect->connect_error) {
            die('Connection failed: ' . $connect->connect_error);
        }

        // Check if the product has existing orders
        $orderCheckQuery = "SELECT COUNT(*) as order_count FROM order_items WHERE prod_id = ?";
        $stmt = $connect->prepare($orderCheckQuery);
        $stmt->bind_param("i", $del_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        if ($result['order_count'] > 0) {
            return 'Product cannot be deleted as there are existing orders associated with it.';
        }

        // Proceed with deletion if no orders exist
        $sql = "DELETE FROM productdetails WHERE prod_id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $del_id);
        $stmt->execute();

        if ($stmt->affected_rows == 1) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

    function deleteCart($del_id){
        try {
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
            $sql = "delete from cart where cart_id=$del_id";
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
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
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
            $connect = new mysqli('localhost', 'root', '', 'simply_wear_Fashion');
            
            // Queries for user, seller, and cart counts
            $userQuery = "SELECT COUNT(*) as count FROM user_credentials";
            $sellerQuery = "SELECT COUNT(*) as count FROM seller_credentials";
            $pendingSellerQuery = "SELECT COUNT(*) as count FROM seller_credentials WHERE status = 'pending'";
            $activeSellerQuery = "SELECT COUNT(*) as count FROM seller_credentials WHERE status = 'active'";
    
            // Query to get cart count for unique user_id
            $pendingCartQuery = "SELECT COUNT(*) AS count FROM orders WHERE status = 'pending'";
            $approvedCartQuery = "SELECT COUNT(*) as count FROM orders WHERE status='approved'";
            $rejectedCartQuery = "SELECT COUNT(*) as count FROM orders WHERE status='rejected'";;
    
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
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
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
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
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
    function getOrderanditems() {
        $connect = new mysqli('localhost', 'root', '', 'simply_wear_Fashion');
    
        if ($connect->connect_error) {
            error_log("Database connection failed: " . $connect->connect_error);
            return false; // Or throw an exception
        }
    
        $sql = "SELECT
                    o.user_id AS UserID,
                    o.order_id AS ID,
                    oi.product_name AS `product_name`,
                    oi.price AS price,
                    oi.size AS size,
                    oi.quantity AS quantity,
                    (oi.price * oi.quantity) AS subtotal,
                    o.total_price AS total,
                    o.status AS `Order Status`,
                    o.created_at AS `Created At`
                FROM
                    orders o
                JOIN
                    order_items oi ON o.order_id = oi.order_id
                ORDER BY
                    o.created_at ASC";
        $result = $connect->query($sql);
    
        if (!$result) {
            error_log("Query execution failed: " . $connect->error);
            $connect->close();
            return false; // Or throw an exception
        }
    
        $orders = [];
        if ($result->num_rows > 0) {
            while ($record = $result->fetch_assoc()) {
                $orders[] = $record;
            }
        }
    
        $result->free_result();
        $connect->close();
    
        return $orders;
    }
    function getOrderanditemsById($id) {
        $connect = new mysqli('localhost', 'root', '', 'simply_wear_Fashion');
    
        if ($connect->connect_error) {
            error_log("Database connection failed: " . $connect->connect_error);
            return false; // Or throw an exception
        }
    
        $sql = "SELECT
                    o.user_id AS UserID,
                    o.order_id AS ID,
                    oi.product_name AS `product_name`,
                    oi.price AS price,
                    oi.size AS size,
                    oi.quantity AS quantity,
                    (oi.price * oi.quantity) AS subtotal,
                    o.total_price AS total,
                    o.status AS `Order Status`,
                    o.created_at AS `Created At`
                FROM
                    orders o
                JOIN
                    order_items oi ON o.order_id = oi.order_id
                WHERE  o.user_id = $id
                ORDER BY
                    o.created_at ASC";
        $result = $connect->query($sql);
    
        if (!$result) {
            error_log("Query execution failed: " . $connect->error);
            $connect->close();
            return false; // Or throw an exception
        }
    
        $orders = [];
        if ($result->num_rows > 0) {
            while ($record = $result->fetch_assoc()) {
                $orders[] = $record;
            }
        }
    
        $result->free_result();
        $connect->close();
    
        return $orders;
    }

    function getSellerById($id){
        try {
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
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
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
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
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
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
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
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
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
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
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
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
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
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
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
    
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
    
    function createOrder($user_id, $finalTotal) {
        try {
            $connect = new mysqli('localhost', 'root', '', 'simply_wear_Fashion');
    
            if ($connect->connect_error) {
                throw new Exception("Connection failed: " . $connect->connect_error);
            }
    
            $sql = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)"; // Added order_date for completeness
            $stmt = $connect->prepare($sql);
    
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $connect->error);
            }
    
            $stmt->bind_param("id", $user_id, $finalTotal);
    
            if ($stmt->execute()) {
                $order_id = $connect->insert_id; // Get the last inserted ID
                $stmt->close();
                $connect->close();
                return $order_id; // Return the order ID
            } else {
                $stmt->close();
                $connect->close();
                return false; // Or throw an exception
            }
        } catch (Exception $e) {
            error_log("Error in createOrder: " . $e->getMessage());
            return false;
        }
    }

    function addOrderItem($order_id, $product_id, $product_name, $size, $price, $quantity){
        try {
            $connect = new mysqli('localhost','root','','simply_wear_Fashion');
            $sql = "INSERT INTO order_items (order_id, prod_id, product_name, size, price, quantity) VALUES ($order_id, $product_id, '$product_name', '$size', $price, $quantity)";
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

    function checkUserOrder($user) {
        try {
            $connect = new mysqli('localhost', 'root', '', 'simply_wear_Fashion');
    
            if ($connect->connect_error) {
                throw new Exception("Database connection failed: " . $connect->connect_error);
            }
    
            $sql = "SELECT COUNT(*) AS order_count FROM orders WHERE user_id = ?";
            $stmt = $connect->prepare($sql);
    
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $connect->error);
            }
    
            $stmt->bind_param("i", $user);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['order_count'] > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
    
        } catch (Exception $e) {
            error_log("Error in checkUserOrder: " . $e->getMessage());
            return false;
        }
    }

    function updateOrderStatus($order_id, $status) {
        try {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
    
            if (!isset($_SESSION['admin_id'])) {
                throw new Exception("Admin ID is not set in session.");
            }
    
            $admin_id = $_SESSION['admin_id'];
            $cdate = date('Y-m-d H:i:s');
    
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
            $connect = new mysqli('localhost', 'root', '', 'simply_wear_Fashion');
    
            $sql = "UPDATE orders SET status = ?, modified_by = ?, modified_at = ? WHERE order_id = ?";
            $stmt = $connect->prepare($sql);
    
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $connect->error);
            }
    
            $stmt->bind_param("sisi", $status, $admin_id, $cdate, $order_id);
    
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
    
            if ($stmt->affected_rows === 0) {
                throw new Exception("No rows updated. Check if the order ID exists.");
            }
    
            return true;
        } catch (Exception $e) {
            error_log("Error in updateOrderStatus: " . $e->getMessage());
            echo "Error: " . $e->getMessage(); // Show error message
            return false;
        } finally {
            if (isset($stmt) && $stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
            if (isset($connect) && $connect instanceof mysqli) {
                $connect->close();
            }
        }
    }
    
    