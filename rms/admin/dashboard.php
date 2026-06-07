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
        <title>Admin Dashboard</title>
        <link rel = "stylesheet" href="../css/style.css">
    </head>
    <body>
        <h1>Admin Dashboard</h1>

        <ul>
            <li><a href = "tables.php">Table Management</a></li>
            <li><a href="menu.php">Menu Management</a></li>
            <li><a href="inventory.php">Inventory Management</a></li>
            <li><a href="../admin/report.php">Sales Report</a></li>
            <li><a href="../auth/logout.php">Logout</a></li>
        </ul>
    </body>
</html>