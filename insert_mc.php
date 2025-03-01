<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $connection = mysqli_connect('localhost', 'root', '', 'motor_cycle');
    
    if (!$connection) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    mysqli_set_charset($connection, 'utf8');

    // Retrieve and sanitize user inputs
    $cust_id = mysqli_real_escape_string($connection, $_POST['cust_id']);
    $cust_name = mysqli_real_escape_string($connection, $_POST['cust_fname']); // Match form field
    $cust_phone = mysqli_real_escape_string($connection, $_POST['cust_tel']);   // Match form field
    $cust_email = mysqli_real_escape_string($connection, $_POST['cust_email']);
    $cust_gender = mysqli_real_escape_string($connection, $_POST['cust_gender']); // Added gender
    $cust_address = mysqli_real_escape_string($connection, $_POST['cust_address']);

    // Check for empty values (basic validation)
    if (empty($cust_id) || empty($cust_name) || empty($cust_phone) || empty($cust_email) || empty($cust_gender) || empty($cust_address)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.history.back();</script>";
        exit(); // Stop script execution
    }

    // Check if customer ID already exists (Fixed table name)
    $check_query = "SELECT cust_id FROM customer WHERE cust_id = '$cust_id'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('รหัสลูกค้า ($cust_id) มีอยู่ในระบบแล้ว! กรุณาใช้รหัสอื่น'); window.history.back();</script>";
        exit(); // Stop script execution
    } else {
        // Insert data into the database (Fixed query)
        $query = "INSERT INTO customer (cust_id, cust_name, cust_phone, cust_email, cust_gender, cust_address) 
                  VALUES ('$cust_id', '$cust_name', '$cust_phone', '$cust_email', '$cust_gender', '$cust_address')";

        if (mysqli_query($connection, $query)) {
            echo "<script>alert('เพิ่มลูกค้าสำเร็จ!'); window.location='index_mc.php';</script>";
            exit();
        } else {
            echo "Query failed: " . mysqli_error($connection);
        }
    }

    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มลูกค้า</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="col-md-6 mx-auto">
            <form action="" method="post">
                <div class="form-group">
                   <label for="cust_id">รหัสลูกค้า</label>
                   <input id="cust_id" name="cust_id" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="cust_name">ชื่อลูกค้า</label>
                   <input id="cust_name" name="cust_name" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="cust_phone">เบอร์โทรลูกค้า</label>
                   <input id="cust_phone" name="cust_phone" type="tel" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="cust_email">Email ลูกค้า</label>
                   <input id="cust_email" name="cust_email" type="email" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="cust_gender">เพศลูกค้า</label>
                   <select id="cust_gender" name="cust_gender" class="form-control" required>
                       <option value="">--เลือกเพศ--</option>
                       <option value="male">ชาย</option>
                       <option value="female">หญิง</option>
                   </select>
                </div>
                <div class="form-group">
                   <label for="cust_address">ที่อยู่ลูกค้า</label>
                   <textarea id="cust_address" name="cust_address" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">เพิ่มลูกค้า</button>
            </form>
        </div>
    </div>
</body>
</html>


