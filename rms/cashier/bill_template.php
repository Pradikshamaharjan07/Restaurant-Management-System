<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <link rel="stylesheet" href="../css/bill_style.css">
</head>
<body>

<div class="logo">
    <img src="../images/logo.png" width="120">
</div>

<h2>Restaurant Management System</h2>
<p class="center">Invoice</p>

<p>
Order ID: <?php echo $order_id; ?><br>
Customer: <?php echo $customer_name; ?><br>
Date: <?php echo date("Y-m-d"); ?><br>
Payment Method: <?php echo $payment_method; ?>
</p>

<table>
    <tr>
        <th>Item</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Subtotal</th>
    </tr>

    <?php foreach ($items as $item) { ?>
    <tr>
        <td><?php echo $item['item_name']; ?></td>
        <td><?php echo $item['quantity']; ?></td>
        <td><?php echo $item['price']; ?></td>
        <td><?php echo $item['subtotal']; ?></td>
    </tr>
    <?php } ?>

    <tr>
        <td colspan="3">Sub Total</td>
        <td><?php echo $total; ?></td>
    </tr>

    <tr>
        <td colspan="3">VAT (13%)</td>
        <td><?php echo $vat; ?></td>
    </tr>

    <tr class="total">
        <td colspan="3">Grand Total</td>
        <td><?php echo $grand_total; ?></td>
    </tr>
</table>

<br>

<p class="center">Thank You!!! Visit Again </p>

<button onclick="window.print()">Print Bill</button>

</body>
</html>
