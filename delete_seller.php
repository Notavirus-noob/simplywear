<?php
// Start the session
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bridge_courier";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the seller ID from URL
$seller_id = $_GET['id'];

// Delete the seller from the database
$sql = "DELETE FROM seller_credentials WHERE id = $seller_id";

if ($conn->query($sql) === TRUE) {
    echo "Seller deleted successfully.";
    header('Location: view_sellers.php'); // Redirect back to seller management page
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


// Close the database connection
$conn->close();
?>
