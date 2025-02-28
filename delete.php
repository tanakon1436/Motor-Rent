<?php

$connection = mysqli_connect('localhost', 'root', '', 'sales');

if (!$connection) {
    die("🔴 Database Connection Failed: " . mysqli_connect_error());
}


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("🔴 No customer data");
}

$cust_id = $_GET['id'];


$delete_query = "DELETE FROM customer WHERE cust_id = $cust_id";

if (mysqli_query($connection, $delete_query)) {
    echo "<script>alert(' Delete Successfuly'); window.location='index_ass6.php';</script>";
} else {
    echo "🔴 Error: " . mysqli_error($connection);
}

mysqli_close($connection);
?>
