<?php
$connection = mysqli_connect('localhost', 'root', '', 'motor_cycle');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$car_price = $_POST['car_price'] ?? null;

if (!$connection) {
    die("🔴 Database Connection Failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $car_name = $_POST['car_name'];
    $car_status = $_POST['car_status'];
    $car_detail = $_POST['car_detail'];
    $car_plate = $_POST['car_plate'];
    $car_img = $_POST['car_img'];

    $query = "INSERT INTO Car (car_name, car_status, car_detail, car_plate, car_img, car_price) 
              VALUES ('$car_name', '$car_status', '$car_detail', '$car_plate', '$car_img','$car_price')";

    if (mysqli_query($connection, $query)) {
        echo "<script>alert('เพิ่มรถสำเร็จ!'); window.location='index_c_mc.php'</script>";
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
    <title>เพิ่มข้อมูลรถ</title>
</head>
<body style="margin:10px">
    <h3>🚗 เพิ่มข้อมูลรถ</h3>
    
    <form method="POST" action="insert_c_mc.php">
        <label>รุ่นรถ:</label>
        <input type="text" name="car_name" required class="form-control">
        
        <label for="car_status">สถานะรถ:</label>
        <select name="car_status" class="form-control" required>
            <option value="">-- เลือกสถานะ --</option>
            <option value="Available">พร้อม</option>
            <option value="Rented">ติดเช่า</option>
            <option value="In Maintenance">ซ่อม</option>
        </select><br>
        
        <label>รายละเอียด</label>
        <input type="text" name="car_detail" required class="form-control">
        
        <label>เลขป้ายทะเบียน</label>
        <input type="text" name="car_plate" required class="form-control">
        <br>
        <label>ราคา(บาท/วัน): </label>
        <input type="number" name="car_price" required class="form-control">
        <br>
        <div class="mb-2">
            <label class="form-label">รูป</label>
            <input type="file" name="car_img" class="form-control">
        </div>
        <br>
        <div class="text-center">
            <a href="index_c_mc.php" class="btn btn-secondary text-white">กลับสู่หน้าหลัก</a>
            <button name ="submit" type="submit" class="btn btn-danger">เพิ่มข้อมูล</button>
        </div>


    </form>

</body>
</html>

