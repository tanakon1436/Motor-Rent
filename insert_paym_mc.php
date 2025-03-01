<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $connection = mysqli_connect('localhost', 'root', '', 'motor_cycle');
    
    if (!$connection) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    mysqli_set_charset($connection, 'utf8');

    // Retrieve and sanitize user inputs
    $rep_id = mysqli_real_escape_string($connection, $_POST['paym_id']);
    $car_id = mysqli_real_escape_string($connection, $_POST['rent_id']);
    $emp_id = mysqli_real_escape_string($connection, $_POST['paym_date']);
    $rep_status = mysqli_real_escape_string($connection, $_POST['paym_total_price']);
    $rep_price = mysqli_real_escape_string($connection, $_POST['paym_status']);
   
    // Check for empty values (basic validation)
    if (empty($paym_id) || empty($rent_id) || empty($paym_date) || empty($paym_total_price) || empty($paym_status)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.history.back();</script>";
        exit(); // Stop script execution
    }

    // Check if repair ID already exists
    $check_query = "SELECT paym_id FROM payment WHERE paym_id = '$paym_id'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('รหัสแจ้งซ้อม ($paym_id) มีอยู่ในระบบแล้ว! กรุณาใช้รหัสอื่น'); window.history.back();</script>";
        exit(); // Stop script execution
    } else {
        // Insert data into the database
        $query = "INSERT INTO payment (paym_id, rent_id, paym_date, payment_total_price,paym_status) 
                  VALUES ('$paym_id', '$rent_id', '$paym_date', '$paym_total_price','$rep_status')";

        if (mysqli_query($connection, $query)) {
            echo "<script>alert('เพิ่มรายการค้าสำเร็จ!'); window.location='index_paym_mc.php';</script>";
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
    <title>เพิ่มรายรายการชำระเงิน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="col-md-6 mx-auto">
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
                   <label for="paym_total_price">วันที่ชำระเงิน</label>
                   <input id="paym_total_price" name="paym_total_price" type="number" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="paym_status">สถานะการแจ้งซ้อม</label>
                   <select id="paym_status" name="paym_status" class="form-control" required>
                       <option value="">--เลือกสถานะ--</option>
                       <option value="Pending">pending</option>
                       <option value="Paid">paid</option>
                       <option value="Failed">failed</option>
                   </select>
                </div>
                
                <button type="submit" class="btn btn-primary">เพิ่มรายการแจ้งซ้อม</button>
            </form>
        </div>
    </div>
</body>
</html>
