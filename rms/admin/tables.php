<?php
include("../includes/auth_check.php");
include("../config/db.php");

if ($_SESSION['role'] != 'admin') {
    echo "Access Denied";
    exit();
}

// Initialize message variable
$message = "";

// Add table (prevent duplicate)
if (isset($_POST['add_table'])) {

    $table_number = intval($_POST['table_number']);

    if ($table_number > 0) {

        $check = mysqli_query($conn,
        "SELECT * FROM restaurant_tables WHERE table_number='$table_number'");

        if (mysqli_num_rows($check) == 0) {

            mysqli_query(
                $conn,
                "INSERT INTO restaurant_tables (table_number, status)
                 VALUES ('$table_number', 'Available')"
            );

            // Show success popup
            echo "<script>alert('Table added successfully');</script>";

        } else {
            // Show duplicate popup
            echo "<script>alert('Table already exists');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Table Management</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Table Management</h2>

    <!-- Optional: Inline message display -->
    <?php if (!empty($message)) { ?>
        <p style="color:red;"><?php echo $message; ?></p>
    <?php } ?>

    <form method="post">
        <input type="number" name="table_number" placeholder="Table Number" min="1" required>
        <button name="add_table">Add Tables</button>
    </form>

    <h3>Available Tables</h3>
    <div class="data-box">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM restaurant_tables");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<p>Table ".$row['table_number']." - ".$row['status']."</p>";
        }
        ?>
    </div>

    <a class="btn" href="dashboard.php">Back to Dashboard</a>
</body>
</html>