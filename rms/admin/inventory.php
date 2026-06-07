<?php
include("../includes/auth_check.php");
include("../config/db.php");

if($_SESSION['role'] != 'admin') {
    echo "Access Denied";
    exit();
}

// Add inventory (prevent duplicate)
if (isset($_POST['add_inventory'])) {

    $item_name = trim($_POST['item_name']);
    $quantity  = intval($_POST['quantity']); 

    if (!empty($item_name) && $quantity > 0) {

        // Check duplicate item
        $check = mysqli_query($conn,
        "SELECT * FROM inventory WHERE item_name='$item_name'");

        if (mysqli_num_rows($check) == 0) {

            mysqli_query(
                $conn,
                "INSERT INTO inventory (item_name, quantity)
                 VALUES ('$item_name', '$quantity')"
            );

            echo "<script>alert('Inventory added successfully');</script>";

        } else {
            echo "<script>alert('Item already exists in inventory');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Management</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h2>Inventory Management</h2>

    <form method="post">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="number" name="quantity" placeholder="Quantity" min="1" required>
        <button name="add_inventory">Add Inventory</button>
    </form>

    <h3>Inventory Stock</h3>

    <div class="data-box">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM inventory");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<p>".$row['item_name']." Qty: ".$row['quantity']."</p>";
        }
        ?>
    </div>

    <a class="btn" href="dashboard.php">Back to Dashboard</a>

</body>
</html>