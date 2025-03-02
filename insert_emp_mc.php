<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $connection = mysqli_connect('localhost', 'root', '', 'motor_cycle');
    
    if (!$connection) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    mysqli_set_charset($connection, 'utf8');

    // Retrieve and sanitize user inputs
    $emp_id = mysqli_real_escape_string($connection, $_POST['emp_id']);
    $emp_name = mysqli_real_escape_string($connection, $_POST['emp_name']);
    $emp_phone = mysqli_real_escape_string($connection, $_POST['emp_phone']);
    
    // Check for empty values (basic validation)
    if (empty($emp_id) || empty($emp_name) || empty($emp_phone)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.history.back();</script>";
        exit(); // Stop script execution
    }

    // Check if employee ID already exists
    $check_query = "SELECT emp_id FROM employee WHERE emp_id = '$emp_id'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('รหัสพนักงาน ($emp_id) มีอยู่ในระบบแล้ว! กรุณาใช้รหัสอื่น'); window.history.back();</script>";
        exit(); // Stop script execution
    } else {
        // Insert data into the database
        $query = "INSERT INTO employee (emp_id, emp_name, emp_phone) 
                  VALUES ('$emp_id', '$emp_name', '$emp_phone')";

        if (mysqli_query($connection, $query)) {
            echo "<script>alert('เพิ่มพนักงานค้าสำเร็จ!'); window.location='index_emp_mc.php';</script>";
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
    <title>เพิ่มพนักงาน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="col-md-6 mx-auto">
            <form action="" method="post">
                <div class="form-group">
                   <label for="emp_id">รหัสพนักงาน</label>
                   <input id="emp_id" name="emp_id" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="emp_name">ชื่อพนักงาน</label>
                   <input id="emp_name" name="emp_name" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                   <label for="emp_phone">เบอร์โทรพนักงาน</label>
                   <input id="emp_phone" name="emp_phone" type="tel" class="form-control" required>
                </div>
                <a href="index_emp_mc.php" class="btn btn-secondary text-white">กลับสู่หน้าหลัก</a>
                <button type="submit" class="btn btn-primary">เพิ่มพนักงาน</button>
            </form>
        </div>
    </div>
</body>
</html>
