<?php
include("../config/db.php");

if (!isset($_GET['order_id'])) {
    echo "Invalid Order";
    exit();
}

$order_id = $_GET['order_id'];

/* ORDER DETAILS*/
$order_query = mysqli_query($conn, "SELECT * FROM orders WHERE order_id = '$order_id'");
$order = mysqli_fetch_assoc($order_query);

$customer_name = $order['customer_name'];

/*ORDER ITEMS*/
$item_query = mysqli_query($conn, "
SELECT m.item_name, m.price, oi.quantity
FROM order_items oi
JOIN menu m ON oi.menu_id = m.menu_id
WHERE oi.order_id = '$order_id'
");

$items = [];
$total = 0;

while ($row = mysqli_fetch_assoc($item_query)) {
    $row['subtotal'] = $row['quantity'] * $row['price'];
    $total += $row['subtotal'];
    $items[] = $row;
}

/*PAYMENT DETAILS*/
$payment_query = mysqli_query($conn,
"SELECT * FROM payments WHERE order_id = '$order_id'"
);
$payment = mysqli_fetch_assoc($payment_query);

$payment_method = $payment['payment_method'];

/*VAT & DISCOUNT*/
$vat_rate = 0.13; // 13%

$vat = $total * $vat_rate;
$grand_total = $total + $vat;
?>
