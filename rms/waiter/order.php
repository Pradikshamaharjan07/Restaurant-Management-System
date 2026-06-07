<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] != 'waiter') {
    echo "Access Denied";
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Take Order</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <h2>Take Order</h2>
        <form action="order_process.php" method="post">
            <label>Select Table: </label>
            <select name="table_id" required>
                <option value="">-- Select Table --</option>
                <?php
                $tables = mysqli_query($conn, "SELECT * FROM restaurant_tables WHERE status='Available'");
                while($t = mysqli_fetch_assoc($tables)) {
                    echo "<option value = '{$t['table_id']}'> Table {$t['table_number']} </option>";
                }
                ?>
            </select>

            <div id="items">
                <div class="item-row">
                    <label>Select Item: </label>
                    <select name="menu_id[]" required>
                        <option value="">-- Select Item --</option>
                        <?php
                        $menu = mysqli_query($conn, "SELECT * FROM menu");
                        while($m = mysqli_fetch_assoc($menu)) {
                            echo "<option value = '{$m['menu_id']}'>
                            {$m['item_name']} - Rs {$m['price']} </option>";
                        }
                        ?>
                    </select>

                    <label>Quantity: </label>
                    <input type="number" name="quantity[]" min="1" required>
                </div>
            </div>

            <br>
            <button type="button" onclick="addItem()">AddAnother Item</button>
            <br>

            <button type="submit">Place Order to Kitchen</button>
        </form>
        <br>
        <a href="../auth/logout.php">Logout</a>
        
        <!-- Js code to copy the item row and add a new one below. -->
         <script>
            function addItem() {
                var container = document.getElementById("items");
                
                var newRow = document.createElement("div");
                
                newRow.innerHTML = `
                <label>Select Item:</label>
                <select name="menu_id[]" required>
                <?php
                $menu = mysqli_query($conn, "SELECT * FROM menu");
                while($m = mysqli_fetch_assoc($menu)) {
                    echo "<option value='{$m['menu_id']}'>
                    {$m['item_name']} - Rs {$m['price']}
                    </option>";
                }
                ?>
                </select>

                <label>Quantity:</label>
                <input type="number" name="quantity[]" min="1" required>
                <br><br>
                `;

                container.appendChild(newRow);
            }
        </script>
    </body>
</html>