<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] != 'kitchen') {
    echo "Access Denied";
    exit();
}

//Update order status
if (isset($_GET['order_id']) && isset($_GET['status'])) {
    $order_id = $_GET['order_id'];
    $status = $_GET['status'];

    mysqli_query($conn, "UPDATE orders SET order_status = '$status' WHERE order_id = '$order_id'");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Kitchen Display</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Kitchen Display Panel</h1>

        <table border="1" cellspacing="0">
            <tr>
                <th>Order ID</th>
                <th>Tables</th>
                <th>Items</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
            $sql = "SELECT * FROM orders WHERE order_status != 'Paid' ORDER BY order_date DESC";
            $result = mysqli_query($conn, $sql);

            while ($order = mysqli_fetch_assoc($result)) {
                $order_id = $order['order_id'];
                $table_id = $order['table_id'];

                echo "<tr>";
                echo "<td>$order_id</td>";
                echo "<td>Table $table_id</td>";

                //Fetch items
                echo "<td>";
                $items = mysqli_query($conn,
                "SELECT m.item_name, oi.quantity
                FROM order_items oi
                JOIN menu m ON oi.menu_id = m.menu_id
                WHERE oi.order_id ='$order_id'"
                );
                while ($item = mysqli_fetch_assoc($items)) {
                    echo $item['item_name']." (".$item['quantity'].")<br>";
                }
                echo "</td>";
                echo "<td>".$order['order_status']."</td>";;

                echo "<td>";
                if($order['order_status'] == 'Pending') {
                    echo "<a href='kitchen.php?order_id=$order_id&status=Preparing'>Preparing</a>";
                }elseif ($order['order_status'] == 'Preparing') {
                    echo "<a href='kitchen.php?order_id=$order_id&status=Ready'>Ready</a>";
                }else {
                    echo "Done";
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <br>
        <a href="../auth/logout.php">Logout</a>
    </body>
</html>