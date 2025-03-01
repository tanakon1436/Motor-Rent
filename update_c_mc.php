<?php
$conn = new mysqli("localhost", "root", "", "motor_cycle");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$car_id = isset($_GET['id']) ? $_GET['id'] : null;
$car = null;

if ($car_id) {
    $stmt = $conn->prepare("SELECT * FROM Car WHERE car_id = ?");
    $stmt->bind_param("s", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $car = $result->fetch_assoc();
    } else {
        echo "ไม่พบข้อมูลรถ";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <title>แก้ไขข้อมูลรถ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-3">
    <h2 class="text-center">แก้ไขข้อมูลรถ</h2>
    <form method="POST" action="update_c_mc_black.php" enctype="multipart/form-data">
        
        <!-- ซ่อนค่ารหัสรถ -->
        <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['car_id'] ?? '') ?>">

        <div class="mb-2">
            <label class="form-label">รุ่นรถ</label>
            <input type="text" name="car_name" class="form-control" value="<?= htmlspecialchars($car['car_name'] ?? '') ?>" required>
        </div>

        <div class="mb-2">
            <label class="form-label">สถานะ</label>
            <select name="car_status" class="form-control" required>
                <option value="available" <?= (isset($car['car_status']) && $car['car_status'] == 'available') ? 'selected' : '' ?>>Available</option>
                <option value="rented" <?= (isset($car['car_status']) && $car['car_status'] == 'rented') ? 'selected' : '' ?>>Rented</option>
            </select>
        </div>

        <div class="mb-2">
            <label class="form-label">รายละเอียด</label>
            <textarea name="car_detail" class="form-control" required><?= htmlspecialchars($car['car_detail'] ?? '') ?></textarea>
        </div>

        <div class="mb-2">
            <label class="form-label">เลขป้ายทะเบียน</label>
            <input type="text" name="car_plate" class="form-control" value="<?= htmlspecialchars($car['car_plate'] ?? '') ?>" required>
        </div>
        
        <label>ราคา(บาท/วัน): </label>
        <input type="number" name="car_price" required class="form-control">

        <div class="mb-2">
            <label class="form-label">อัปโหลดรูปใหม่</label>
            <input type="file" name="car_img" class="form-control">
        </div>

        <div class="mt-3 text-center">
            <button type="submit" name="submit" class="btn btn-danger">บันทึก</button>
            <a href="index_c_mc.php" class="btn btn-secondary">ย้อนกลับ</a>
        </div>
    </form>
</div>
</body>
</html>
