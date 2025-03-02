<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $connection = new mysqli('localhost', 'root', '', 'motor_cycle');

    if ($connection->connect_error) {
        die('Database connection failed: ' . $connection->connect_error);
    }

    $connection->set_charset('utf8');

    // ✅ แก้ชื่อให้ตรงกับ form fields
    $cust_name = $connection->real_escape_string($_POST['cust_name']); 
    $cust_phone = $connection->real_escape_string($_POST['cust_phone']); 
    $cust_email = $connection->real_escape_string($_POST['cust_email']);
    $cust_gender = $connection->real_escape_string($_POST['cust_gender']); 
    $cust_address = $connection->real_escape_string($_POST['cust_address']);

    // ✅ ตรวจสอบค่าว่าง
    if ( empty($cust_name) || empty($cust_phone) || empty($cust_email) || empty($cust_gender) || empty($cust_address)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.history.back();</script>";
        exit();
    }

    // ✅ ตรวจสอบว่ามีรหัสลูกค้าซ้ำหรือไม่
    $check_query = "SELECT cust_id FROM customer WHERE cust_id = ?";
    $stmt = $connection->prepare($check_query);
    $stmt->bind_param("s", $cust_id);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('รหัสลูกค้า ($cust_id) มีอยู่ในระบบแล้ว! กรุณาใช้รหัสอื่น'); window.history.back();</script>";
        exit();
    }

    // ✅ ใช้ Prepared Statement ป้องกัน SQL Injection
    $query = "INSERT INTO customer (cust_id, cust_name, cust_phone, cust_email, cust_gender, cust_address) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssssss", $cust_id, $cust_name, $cust_phone, $cust_email, $cust_gender, $cust_address);

    if ($stmt->execute()) {
        echo "<script>alert('เพิ่มลูกค้าสำเร็จ!'); window.location='index_mc.php';</script>";
        exit();
    } else {
        echo "Query failed: " . $stmt->error;
    }

    // ✅ ปิด Connection
    $stmt->close();
    $connection->close();
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
                       <option value="ชาย">ชาย</option>
                       <option value="หญิง">หญิง</option>
                       <option value="อื่นๆ">อื่นๆ</option>
                   </select>
                </div>
                <div class="form-group">
                   <label for="cust_address">ที่อยู่ลูกค้า</label>
                   <textarea id="cust_address" name="cust_address" class="form-control" required></textarea>
                </div>
                <a href="index_mc.php" class="btn btn-secondary text-white">ย้อนกลับ</a>
                <button type="submit" class="btn btn-primary">เพิ่มลูกค้า</button>
            </form>
        </div>
    </div>
</body>
</html>
