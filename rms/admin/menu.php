<?php
include("../includes/auth_check.php");
include("../config/db.php");

if($_SESSION['role'] != 'admin') {
    echo "Access Denied";
    exit();
}

// Add menu item (prevent duplicate)
if (isset($_POST['add_menu'])) {

    $item_name = trim($_POST['item_name']);
    $price = floatval($_POST['price']);

    if (!empty($item_name) && $price > 0) {

        // Check duplicate item
        $check = mysqli_query($conn,
        "SELECT * FROM menu WHERE item_name='$item_name'");

        if (mysqli_num_rows($check) == 0) {

            mysqli_query($conn,
            "INSERT INTO menu (item_name, price)
             VALUES ('$item_name','$price')");

            echo "<script>alert('Item added successfully');</script>";

        } else {
            echo "<script>alert('Item already exists');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu Management</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h2>Menu Management</h2>

    <form method="post">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="number" name="price" placeholder="Price" min="1" required>
        <button name="add_menu">Add Item</button>
    </form>

    <h3>Menu Items</h3>

    <div class="data-box">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM menu");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<p>".$row['item_name']." Rs ".$row['price']."</p>";
        }
        ?>
    </div>

    <a class="btn" href="dashboard.php">Back to Dashboard</a>

</body>
</html>