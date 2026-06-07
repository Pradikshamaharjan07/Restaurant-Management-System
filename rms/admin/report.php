<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] != 'admin') {
    echo "Access Denied";
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sales Report</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h2>Sales Report</h2>

        <table border="1" cellpadding="10">
            <tr>
                <th>Payment ID</th>
                <th>Order ID</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>

            <?php
            $totalSales = 0;
            $result = mysqli_query($conn, "SELECT * FROM payments ORDER BY payment_date DESC");
            while ($row = mysqli_fetch_assoc($result)) {
                // Add total_amount to totalSales
                $totalSales += $row['total_amount'];
                echo "<tr>
                <td>{$row['payment_id']}</td>
                <td>{$row['order_id']}</td>
                <td>Rs {$row['total_amount']}</td>
                <td>{$row['payment_date']}</td>
                </tr>";
            }
            ?>
        </table>
        <h3>Total Sales: Rs <?php echo $totalSales; ?></h3>

        <!-- <a href="dashboard.php">Back</a> -->
         <a class="btn" href="dashboard.php">Back to Dashboard</a>
    </body>
</html>