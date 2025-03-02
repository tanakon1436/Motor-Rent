<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // เชื่อมต่อฐานข้อมูล
    $connection = new mysqli('localhost', 'root', '', 'motor_cycle');
    
    if ($connection->connect_error) {
        die("Database connection failed: " . $connection->connect_error);
    }
    $connection->set_charset('utf8');

    // รับค่าจากฟอร์ม
    $paym_id = $connection->real_escape_string($_POST['paym_id']);
    $rent_id = $connection->real_escape_string($_POST['rent_id']);
    $paym_date = $connection->real_escape_string($_POST['paym_date']);
    $paym_total_price = $connection->real_escape_string($_POST['paym_total_price']);
    $paym_status = $connection->real_escape_string($_POST['paym_status']);

    // ตรวจสอบค่าที่ว่าง
    if (empty($paym_id) || empty($rent_id) || empty($paym_date) || empty($paym_total_price) || empty($paym_status)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.history.back();</script>";
        exit();
    }

    // ตรวจสอบว่ารหัสซ้ำหรือไม่
    $check_query = $connection->query("SELECT paym_id FROM payment WHERE paym_id = '$paym_id'");
    if ($check_query->num_rows > 0) {
        echo "<script>alert('รหัสชำระเงิน ($paym_id) มีอยู่ในระบบแล้ว! กรุณาใช้รหัสอื่น'); window.history.back();</script>";
        exit();
    }

    // บันทึกข้อมูลลงฐานข้อมูล
    $query = "INSERT INTO payment (paym_id, rent_id, paym_date, paym_total_price, paym_status) 
              VALUES ('$paym_id', '$rent_id', '$paym_date', '$paym_total_price', '$paym_status')";

    if ($connection->query($query)) {
        echo "<script>alert('เพิ่มรายการชำระเงินสำเร็จ!'); window.location='index_paym_mc.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด: " . $connection->error . "'); window.history.back();</script>";
    }

    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มรายการชำระเงิน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f7f7f7; }
        .container { margin-top: 50px; }
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-md-6 mx-auto form-container">
            <h3 class="text-center">เพิ่มรายการชำระเงิน</h3>
            <form action="" method="post">
                <div class="form-group">
                   <label for="paym_id">รหัสการชำระเงิน</label>
                   <input id="paym_id" name="paym_id" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="rent_id">รหัสการเช่า</label>
                   <input id="rent_id" name="rent_id" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="paym_date">วันที่ชำระเงิน</label>
                   <input id="paym_date" name="paym_date" type="date" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="paym_total_price">ราคารวมที่ต้องชำระ</label>
                   <input id="paym_total_price" name="paym_total_price" type="number" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="paym_status">สถานะการชำระเงิน</label>
                   <select id="paym_status" name="paym_status" class="form-control" required>
                       <option value="">--เลือกสถานะ--</option>
                       <option value="Pending">Pending</option>
                       <option value="Paid">Paid</option>
                       <option value="Failed">Failed</option>
                   </select>
                </div>
                <a href="index_paym_mc.php" class="btn btn-secondary">ย้อนกลับ</a>
                <button type="submit" class="btn btn-primary">เพิ่มรายการชำระเงิน</button>
            </form>
        </div>
    </div>
</body>
</html>
