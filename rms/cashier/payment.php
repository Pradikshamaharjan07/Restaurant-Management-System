<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] != 'cashier') {
    echo "Access Denied";
    exit();
}

// Handle payment
if (isset($_POST['pay'])) {
    $order_id = intval($_POST['order_id']);
    $total = floatval($_POST['total']);

    // Insert payment record
    mysqli_query(
         $conn,
        "INSERT INTO payments (order_id, total_amount) 
         VALUES ('$order_id', '$total')"
    );

    // Update order status
    mysqli_query(
        $conn,
        "UPDATE orders 
         SET order_status = 'Paid' 
         WHERE order_id = '$order_id'"
    );

    // Get table ID from orders table (FIXED)
    $table = mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT table_id FROM orders WHERE order_id = '$order_id'"
        )
    );

    // Free the table
    mysqli_query(
        $conn,
        "UPDATE restaurant_tables 
         SET status = 'Available' 
         WHERE table_id = '{$table['table_id']}'"
    );

    echo "<p><b>Payment Successful</b></p>";
    echo "<a href='print_bill.php?order_id=$order_id' target='_blank'>
    <button>Print Bill</button>
    </a>";
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>Cashier Panel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>Cashier Payment Panel</h1>

    <table border="1" cellpadding="10">
        <tr>
            <th>Order ID</th>
            <th>Items</th>
            <th>Total (Rs)</th>
            <th>Action</th>
        </tr>

        <?php
        $orders = mysqli_query(
            $conn,
            "SELECT * FROM orders WHERE order_status='Ready'"
        );

        while ($order = mysqli_fetch_assoc($orders)) {
            $order_id = $order['order_id'];
            $total = 0;

            echo "<tr>";
                echo "<td>$order_id</td>";

                echo "<td>";
                $items = mysqli_query($conn, "
                SELECT m.item_name, m.price, oi.quantity
                FROM order_items oi
                JOIN menu m ON oi.menu_id = m.menu_id
                WHERE oi.order_id = '$order_id'
                ");

                while ($item = mysqli_fetch_assoc($items)) {
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                    echo "{$item['item_name']} x {$item['quantity']} = Rs $subtotal<br>";
                }
                echo "</td>";

                echo "<td>Rs $total</td>";

                echo "<td>
                    <form method='post'>
                        <input type='hidden' name='order_id' value='$order_id'>
                        <input type='hidden' name='total' value='$total'>
                        <button type='submit' name='pay'>Pay</button>
                    </form>
                </td>";
            echo "</tr>";
        }
        ?>
    </table>
    

    <br>
    <a href="../auth/logout.php">Logout</a> \

</body>
</html>
