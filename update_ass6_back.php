<?php

$connection = mysqli_connect('localhost', 'root', '', 'sales');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$connection) {
    die("🔴 Database Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $cust_id = $_POST['cust_id'];
    $cust_fname = $_POST['cust_fname'];
    $cust_lname = $_POST['cust_lname'];
    $cust_address = $_POST['cust_address'];
    $cust_tel = $_POST['cust_tel'];
    $cust_sex = $_POST['cust_sex'];
    $cust_email = $_POST['cust_email'];
    $cust_type_id = $_POST['cust_type_id'];

    $query = "UPDATE customer 
              SET cust_fname = '$cust_fname', cust_lname = '$cust_lname', cust_address = '$cust_address', 
                  cust_tel = '$cust_tel', cust_sex = '$cust_sex', cust_email = '$cust_email', cust_type_id = '$cust_type_id' 
              WHERE cust_id = '$cust_id'";

    if (mysqli_query($connection, $query)) {
        echo "<script>alert('Update Successfuly!'); window.location='index_ass6.php'</script>";
    } else {
        echo "<script>alert('ERROR');</script>" . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>
