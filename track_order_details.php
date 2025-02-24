<?php
// ... (database connection, session start) ...

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch tracking information from database or API
    // ... (your code to fetch tracking info) ...
    // Display tracking information
    echo "<h2>Tracking Information for Order #" . htmlspecialchars($order_id) . "</h2>";
    // ... (display tracking details) ...

} else {
    echo "Order ID not provided.";
}
?>