<?php

$connection = mysqli_connect('localhost', 'root', '', 'sales');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$connection) {
    die("🔴 Database Connection Failed: " . mysqli_connect_error());
}

$cust_id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$cust_id) {
    die("🔴 No customer data");
}

$query = "SELECT * FROM customer WHERE cust_id = '$cust_id'";
$result = mysqli_query($connection, $query);
$customer = mysqli_fetch_assoc($result);

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลลูกค้า</title>
</head>
<body style="margin:10px">
    <h3>📝 แก้ไขข้อมูลลูกค้า</h3>
    
    <form method="POST" action="update_ass6_back.php">
        <input type="hidden" name="cust_id" value="<?php echo $customer['cust_id']; ?>">

        <label>ชื่อลูกค้า:</label>
        <input type="text" name="cust_fname" value="<?php echo $customer['cust_fname']; ?>" required class="form-control">
        
        <label>นามสกุลลูกค้า:</label>
        <input type="text" name="cust_lname" value="<?php echo $customer['cust_lname']; ?>" required class="form-control">
        
        <label>ที่อยู่ลูกค้า:</label>
        <input type="text" name="cust_address" value="<?php echo $customer['cust_address']; ?>" required class="form-control">
        
        <label>เบอร์โทรลูกค้า:</label>
        <input type="text" name="cust_tel" value="<?php echo $customer['cust_tel']; ?>" required class="form-control">
        <br>
        
        <label>เพศลูกค้า:</label>
        <select name="cust_sex" required class="form-control">
            <option value="ชาย" <?php echo ($customer['cust_sex'] == 'ชาย') ? 'selected' : ''; ?>>ชาย</option>
            <option value="หญิง" <?php echo ($customer['cust_sex'] == 'หญิง') ? 'selected' : ''; ?>>หญิง</option>
        </select>
        <br>
        
        <label>อีเมลลูกค้า:</label>
        <input type="email" name="cust_email" value="<?php echo $customer['cust_email']; ?>" required class="form-control">
        
        <label>ประเภทลูกค้า:</label>
        <select name="cust_type_id" required class="form-control">
            <option value="">-- เลือกประเภท --</option>
            <?php
            $connection = mysqli_connect('localhost', 'root', '', 'sales');
            $type_query = "SELECT * FROM customer_type";
            $type_result = mysqli_query($connection, $type_query);
            
            while ($row = mysqli_fetch_assoc($type_result)) {
                $selected = ($row['cust_type_id'] == $customer['cust_type_id']) ? 'selected' : '';
                echo "<option value='{$row['cust_type_id']}' $selected>{$row['cust_type_name']}</option>";
            }
            mysqli_close($connection);
            ?>
        </select>
        <br>
        <button name="submit" type="submit" class="btn btn-success">Update</button>
    </form>

</body>
</html>
