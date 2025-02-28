<?php
$connection = mysqli_connect('localhost', 'root', '', 'sales');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$connection) {
    die("🔴 Database Connection Failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $cust_fname = $_POST['cust_fname'];
    $cust_lname = $_POST['cust_lname'];
    $cust_address = $_POST['cust_address'];
    $cust_tel = $_POST['cust_tel'];
    $cust_sex = $_POST['cust_sex'];
    $cust_email = $_POST['cust_email'];
    $cust_type_id = $_POST['cust_type_id'];

    $query = "INSERT INTO customer (cust_fname, cust_lname, cust_address, cust_tel, cust_sex, cust_email, cust_type_id) 
              VALUES ('$cust_fname', '$cust_lname', '$cust_address', '$cust_tel', '$cust_sex', '$cust_email', '$cust_type_id')";

    if (mysqli_query($connection, $query)) {
        echo "<script>alert('เพิ่มลูกค้าสำเร็จ!'); window.location='index_ass6.php'</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด');</script>" . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <title>เพิ่มข้อมูลลูกค้า</title>
</head>
<body style="margin:10px">
    <h3>📝 เพิ่มข้อมูลลูกค้า</h3>
    
    <form method="POST" action="insert_ass6.php">
        <label>ชื่อลูกค้า:</label>
        <input type="text" name="cust_fname" required class="form-control">
        
        <label>นามสกุลลุกค้า:</label>
        <input type="text" name="cust_lname" required class="form-control">
        
        <label>ที่อยู่ลูกค้า:</label>
        <input type="text" name="cust_address" required class="form-control">
        
        <label>เบอร์โทรลูกค้า:</label>
        <input type="text" name="cust_tel" required class="form-control">
        <br>
        <label>เพศลูกค้า:</label>
        <select name="cust_sex" required>
            <option value="ชาย">ชาย</option>
            <option value="หญิง">หญิง</option>
        </select>
        <br>
        
        <label>อีเมลลูกค้า:</label>
        <input type="email" name="cust_email" required class="form-control">
        
        <label>ประเภทลูกค้า:</label>
        <select name="cust_type_id" required class="form-control">
            <option value="">-- เลือกประเภท --</option>
            <?php
            $connection = mysqli_connect('localhost', 'root', '', 'sales');
            $type_query = "SELECT * FROM customer_type";
            $type_result = mysqli_query($connection, $type_query);
            
            while ($row = mysqli_fetch_assoc($type_result)) {
                echo "<option value='{$row['cust_type_id']}'>{$row['cust_type_name']}</option>";
            }

            mysqli_close($connection);
            ?>
        </select>
        <br>
        <button name ="submit" type="submit" class="btn btn-success">เพิ่มข้อมูล</button>
    </form>

</body>
</html>
