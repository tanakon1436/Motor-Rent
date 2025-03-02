<?php
$connection = mysqli_connect('localhost', 'root', '', 'motor_cycle');

if (!$connection) {
    die("🔴 Database Connection Failed: " . mysqli_connect_error());
}

// ดึงข้อมูลลูกค้า
$customers = mysqli_query($connection, "SELECT * FROM customer");

// ดึงข้อมูลรถที่สถานะ Available เท่านั้น
$cars = mysqli_query($connection, "SELECT * FROM car WHERE car_status = 'ว่าง'");

// ดึงข้อมูลพนักงาน
$employees = mysqli_query($connection, "SELECT * FROM employee");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cust_id = $_POST['cust_id'];
    $car_id = $_POST['car_id'];
    $emp_id = $_POST['emp_id'];
    $rent_start_date = $_POST['rent_start_date'];
    $rent_return_date = $_POST['rent_return_date'];

    // ดึงราคาของรถที่เลือก
    $car_query = mysqli_query($connection, "SELECT car_price FROM car WHERE car_id = $car_id");
    $car = mysqli_fetch_assoc($car_query);
    $car_price = $car['car_price'];

    // คำนวณจำนวนวันเช่า
    $date1 = new DateTime($rent_start_date);
    $date2 = new DateTime($rent_return_date);
    $diff = $date1->diff($date2)->days;
    if ($diff == 0) $diff = 1; // ถ้าเช่าวันเดียว ให้คิดเป็น 1 วัน

    // คำนวณราคารวม
    $rent_total_price = $car_price * $diff;

    // เพิ่มข้อมูลการเช่า
    $insert_rent = "
        INSERT INTO rental (cust_id, car_id, emp_id, rent_start_date, rent_return_date, rent_status, rent_total_price)
        VALUES ($cust_id, $car_id, $emp_id, '$rent_start_date', '$rent_return_date', 'กำลังดำเนินการ', $rent_total_price)
    ";
    
    if (mysqli_query($connection, $insert_rent)) {
        // อัปเดตสถานะรถเป็น "ถูกเช่า"
        mysqli_query($connection, "UPDATE car SET car_status = 'ถูกเช่า' WHERE car_id = $car_id");
        echo "<script>alert('✅ เพิ่มข้อมูลเช่าสำเร็จ!'); window.location.href='index_rental.php';</script>";
    } else {
        echo "<script>alert('❌ เกิดข้อผิดพลาด: " . mysqli_error($connection) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <title>เพิ่มข้อมูลการเช่ารถ</title>
</head>
<body style="margin:10px">
    <div class="text-center">
        <h3>📋 เพิ่มข้อมูลการเช่ารถ</h3>
    </div>

    <form method="POST" class="container">
        <div class="form-group">
            <label>👤 ลูกค้า:</label>
            <select name="cust_id" class="form-control" required>
                <option value="" disabled selected>เลือกลูกค้า</option>
                <?php while ($row = mysqli_fetch_assoc($customers)) { ?>
                    <option value="<?= $row['cust_id']; ?>"><?= $row['cust_name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>🚗 รถที่ต้องการเช่า:</label>
            <select name="car_id" class="form-control" required>
                <option value="" disabled selected>เลือกรถ</option>
                <?php while ($row = mysqli_fetch_assoc($cars)) { ?>
                    <option value="<?= $row['car_id']; ?>"><?= $row['car_name']; ?> (<?= number_format($row['car_price'], 2); ?> ฿/วัน)</option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>👨‍💼 พนักงานที่รับผิดชอบ:</label>
            <select name="emp_id" class="form-control" required>
                <option value="" disabled selected>เลือกพนักงาน</option>
                <?php while ($row = mysqli_fetch_assoc($employees)) { ?>
                    <option value="<?= $row['emp_id']; ?>"><?= $row['emp_name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>📅 วันที่เริ่มเช่า:</label>
            <input type="date" name="rent_start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label>📆 วันที่คืนรถ:</label>
            <input type="date" name="rent_return_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-danger btn-block">✅ บันทึกการเช่า</button>
        <a href="index_rental.php" class="btn btn-secondary btn-block">⬅️ กลับ</a>
    </form>
</body>
</html>

<?php mysqli_close($connection); ?>
