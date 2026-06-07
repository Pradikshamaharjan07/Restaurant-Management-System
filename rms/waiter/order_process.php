<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] != 'waiter') {
    echo "Access Denied";
    exit();
}

$table_id = intval($_POST['table_id']);
$menu_ids  = $_POST['menu_id'];      // array
$quantities = $_POST['quantity'];    // array

if ($table_id > 0 && !empty($menu_ids)) {

    // Create order
    mysqli_query($conn, "INSERT INTO orders (table_id) VALUES ('$table_id')");
    $order_id = mysqli_insert_id($conn);

    // Loop through all selected items
    for ($i = 0; $i < count($menu_ids); $i++) {

        $menu_id = intval($menu_ids[$i]);
        $quantity = intval($quantities[$i]);

        if ($menu_id > 0 && $quantity > 0) {

            // Insert order items
            mysqli_query(
                $conn,
                "INSERT INTO order_items (order_id, menu_id, quantity)
                 VALUES ('$order_id', '$menu_id', '$quantity')"
            );

            // Get item name for inventory reduction
            $menu = mysqli_fetch_assoc(
                mysqli_query($conn, "SELECT item_name FROM menu WHERE menu_id = '$menu_id'")
            );

            $item_name = $menu['item_name'];

            // Reduce inventory
            mysqli_query(
                $conn,
                "UPDATE inventory 
                 SET quantity = quantity - $quantity 
                 WHERE item_name = '$item_name'"
            );
        }
    }

    // Update table status
    mysqli_query(
        $conn,
        "UPDATE restaurant_tables 
         SET status='Occupied' 
         WHERE table_id='$table_id'"
    );

    echo "<h3>Order Placed Successfully!</h3>";
    echo "<a href='order.php'>Place Another Order</a>";

} else {
    echo "Invalid order data";
}
?>
