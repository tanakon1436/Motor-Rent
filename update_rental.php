<?php
$connection = mysqli_connect('localhost', 'root', '', 'motor_cycle');

if (!$connection) {
    die("🔴 Database Connection Failed: " . mysqli_connect_error());
}

// รับค่า ID จาก URL
if (isset($_GET['id'])) {
    $rent_id = $_GET['id'];

    // ดึงข้อมูลการเช่าจากฐานข้อมูล
    $query = "SELECT * FROM Rental WHERE rent_id = $rent_id";
    $result = mysqli_query($connection, $query);
    $rental = mysqli_fetch_assoc($result);

    if (!$rental) {
        die("❌ ไม่พบข้อมูลการเช่ารถ");
    }
} else {
    die("❌ ไม่มีข้อมูล ID ที่ระบุ");
}

// ดึงข้อมูลลูกค้า
$customers = mysqli_query($connection, "SELECT * FROM Customer");

// ดึงข้อมูลรถที่ Available + รถที่ถูกเช่าในรายการนี้
$cars = mysqli_query($connection, "SELECT * FROM Car WHERE car_status = 'Available' OR car_id = " . $rental['car_id']);

// ดึงข้อมูลพนักงาน
$employees = mysqli_query($connection, "SELECT * FROM Employee");

// อัปเดตข้อมูลการเช่า
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cust_id = $_POST['cust_id'];
    $car_id_new = $_POST['car_id'];
    $emp_id = $_POST['emp_id'];
    $rent_start_date = $_POST['rent_start_date'];
    $rent_return_date = $_POST['rent_return_date'];

    // ดึงราคาของรถใหม่
    $car_query = mysqli_query($connection, "SELECT car_price FROM Car WHERE car_id = $car_id_new");
    $car = mysqli_fetch_assoc($car_query);
    $car_price = $car['car_price'];

    // คำนวณจำนวนวันเช่า
    $date1 = new DateTime($rent_start_date);
    $date2 = new DateTime($rent_return_date);
    $diff = $date1->diff($date2)->days;
    if ($diff == 0) $diff = 1;

    // คำนวณราคารวม
    $rent_total_price = $car_price * $diff;

    // อัปเดตข้อมูลการเช่า
    $update_rent = "
        UPDATE Rental 
        SET cust_id = $cust_id, car_id = $car_id_new, emp_id = $emp_id, 
            rent_start_date = '$rent_start_date', rent_return_date = '$rent_return_date', 
            rent_total_price = $rent_total_price
        WHERE rent_id = $rent_id
    ";

    if (mysqli_query($connection, $update_rent)) {
        // ถ้าเปลี่ยนรถ ให้คืนสถานะรถเก่า และอัปเดตรถใหม่เป็น "Rented"
        if ($rental['car_id'] != $car_id_new) {
            mysqli_query($connection, "UPDATE Car SET car_status = 'Available' WHERE car_id = " . $rental['car_id']);
            mysqli_query($connection, "UPDATE Car SET car_status = 'Rented' WHERE car_id = $car_id_new");
        }

        echo "<script>alert('✅ อัปเดตข้อมูลสำเร็จ!'); window.location.href='index_rental.php';</script>";
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
    <title>อัปเดตข้อมูลการเช่า</title>
</head>
<body style="margin:10px">
    <div class="text-center">
        <h3>✏️ อัปเดตข้อมูลการเช่ารถ</h3>
    </div>

    <form method="POST" class="container">
        <div class="form-group">
            <label>👤 ลูกค้า:</label>
            <select name="cust_id" class="form-control" required>
                <?php while ($row = mysqli_fetch_assoc($customers)) { ?>
                    <option value="<?= $row['cust_id']; ?>" <?= $row['cust_id'] == $rental['cust_id'] ? 'selected' : ''; ?>>
                        <?= $row['cust_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>🚗 รถที่เช่า:</label>
            <select name="car_id" class="form-control" required>
                <?php while ($row = mysqli_fetch_assoc($cars)) { ?>
                    <option value="<?= $row['car_id']; ?>" <?= $row['car_id'] == $rental['car_id'] ? 'selected' : ''; ?>>
                        <?= $row['car_name']; ?> (<?= number_format($row['car_price'], 2); ?> ฿/วัน)
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>👨‍💼 พนักงานที่รับผิดชอบ:</label>
            <select name="emp_id" class="form-control" required>
                <?php while ($row = mysqli_fetch_assoc($employees)) { ?>
                    <option value="<?= $row['emp_id']; ?>" <?= $row['emp_id'] == $rental['emp_id'] ? 'selected' : ''; ?>>
                        <?= $row['emp_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>📅 วันที่เริ่มเช่า:</label>
            <input type="date" name="rent_start_date" class="form-control" value="<?= $rental['rent_start_date']; ?>" required>
        </div>

        <div class="form-group">
            <label>📆 วันที่คืนรถ:</label>
            <input type="date" name="rent_return_date" class="form-control" value="<?= $rental['rent_return_date']; ?>" required>
        </div>

        <button type="submit" class="btn btn-danger btn-block">✅ อัปเดตข้อมูล</button>
        <a href="index_rental.php" class="btn btn-secondary btn-block">⬅️ กลับ</a>
    </form>
</body>
</html>

<?php mysqli_close($connection); ?>
