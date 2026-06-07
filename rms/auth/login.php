<?php
session_start();
include("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: login.html");
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users 
        WHERE username='$username' 
        AND password='$password'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {

    $user = mysqli_fetch_assoc($result);

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
    } elseif ($user['role'] == 'waiter') {
        header("Location: ../waiter/order.php");
    } elseif ($user['role'] == 'kitchen') {
        header("Location: ../kitchen/kitchen.php");
    } elseif ($user['role'] == 'cashier') {
        header("Location: ../cashier/payment.php");
    }
    exit();

} else {
    echo "<h3 style='color:red;text-align:center;'>Invalid username or password</h3>";
    echo "<a href='login.html'>Try Again</a>";
}
?>

