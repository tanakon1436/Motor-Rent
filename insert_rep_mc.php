<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $connection = mysqli_connect('localhost', 'root', '', 'motor_cycle');
    
    if (!$connection) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    mysqli_set_charset($connection, 'utf8');

    // Retrieve and sanitize user inputs
    $rep_id = mysqli_real_escape_string($connection, $_POST['rep_id']);
    $car_id = mysqli_real_escape_string($connection, $_POST['car_id']);
    $emp_id = mysqli_real_escape_string($connection, $_POST['emp_id']);
    $rep_status = mysqli_real_escape_string($connection, $_POST['rep_status']);
    $rep_price = mysqli_real_escape_string($connection, $_POST['rep_price']);
    $rep_detail = mysqli_real_escape_string($connection, $_POST['rep_detail']);

    // Check for empty values (basic validation)
    if (empty($rep_id) || empty($car_id) || empty($emp_id) || empty($rep_status) || empty($rep_price) || empty($rep_detail)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.history.back();</script>";
        exit(); // Stop script execution
    }

    // Check if repair ID already exists
    $check_query = "SELECT rep_id FROM repairment WHERE rep_id = '$rep_id'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('รหัสแจ้งซ้อม ($rep_id) มีอยู่ในระบบแล้ว! กรุณาใช้รหัสอื่น'); window.history.back();</script>";
        exit(); // Stop script execution
    } else {
        // Insert data into the database
        $query = "INSERT INTO repairment (rep_id, car_id, emp_id, rep_status, rep_price, rep_detail) 
                  VALUES ('$rep_id', '$car_id', '$emp_id', '$rep_status', '$rep_price', '$rep_detail')";

        if (mysqli_query($connection, $query)) {
            echo "<script>alert('เพิ่มรายการค้าสำเร็จ!'); window.location='index_rep_mc.php';</script>";
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
    <title>เพิ่มรายการแจ้งซ้อม</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="col-md-6 mx-auto">
            <form action="" method="post">
                <div class="form-group">
                   <label for="rep_id">รหัสแจ้งซ้อม</label>
                   <input id="rep_id" name="rep_id" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="car_id">รหัสรถ</label>
                   <input id="car_id" name="car_id" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="emp_id">รหัสพนักงาน</label>
                   <input id="emp_id" name="emp_id" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="rep_status">สถานะการแจ้งซ้อม</label>
                   <select id="rep_status" name="rep_status" class="form-control" required>
                       <option value="">--เลือกสถานะ--</option>
                       <option value="Pending">pending</option>
                       <option value="Progress">progress</option>
                       <option value="Completed">completed</option>
                   </select>
                </div>
                <div class="form-group">
                   <label for="rep_price">ราคารายการแจ้งซ้อม</label>
                   <input id="rep_price" name="rep_price" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="rep_detail">รายละเอียด</label>
                    <input id="rep_detail" name="rep_detail" type="text" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary">เพิ่มรายการแจ้งซ้อม</button>
            </form>
        </div>
    </div>
</body>
</html>
