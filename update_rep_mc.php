<?php
$conn = new mysqli("localhost", "root", "", "motor_cycle");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rep_id = isset($_GET['id']) ? $_GET['id'] : null;
$repairment = null;

if ($rep_id) {
    // ใช้ Prepared Statement ป้องกัน SQL Injection
    $stmt = $conn->prepare("SELECT * FROM repairment WHERE rep_id = ?");
    $stmt->bind_param("s", $rep_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $repairment = $result->fetch_assoc();
    } else {
        echo "ไม่พบข้อมูลแจ้งซ่อมดังกล่าว";
        exit;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขรายการแจ้งซ่อม</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-3">
    <h3>แก้ไขรายการแจ้งซ่อม</h3>
    <form method="POST" action="update_rep_mc_back.php">
        
        <div class="mb-2">
            <label class="form-label">รหัสแจ้งซ้อม</label>
            <input type="text" name="rep_id" class="form-control" value="<?= htmlspecialchars($repairment['rep_id'] ?? '') ?>" readonly>
        </div>

        <div class="mb-2">
            <label class="form-label">รหัสรถ</label>
            <input type="text" name="car_id" class="form-control" value="<?= htmlspecialchars($repairment['car_id'] ?? '') ?>" required>
        </div>

        <div class="mb-2">
            <label class="form-label">รหัสพนักงาน</label>
            <input type="text" name="emp_id" class="form-control" value="<?= htmlspecialchars($repairment['emp_id'] ?? '') ?>" required>
        </div>

        <div class="mb-2">
            <label class="form-label">สถานะ</label>
            <select name="rep_status" class="form-control">
                <option value="Pending" <?= ($repairment['rep_status'] ?? '') == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Progress" <?= ($repairment['rep_status'] ?? '') == 'Progress' ? 'selected' : '' ?>>Progress</option>
                <option value="Completed" <?= ($repairment['rep_status'] ?? '') == 'Completed' ? 'selected' : '' ?>>Completed</option>
            </select>
        </div>

        <div class="mb-2">
            <label for="rep_price" class="form-label">ราคารายการแจ้งซ่อม</label>
            <input type="text" name="rep_price" class="form-control" value="<?= htmlspecialchars($repairment['rep_price'] ?? '') ?>" required>
        </div>

        <div class="mb-2">
            <label for="rep_detail" class="form-label">รายละเอียดการแจ้งซ่อม</label>
            <textarea name="rep_detail" class="form-control" required><?= htmlspecialchars($repairment['rep_detail'] ?? '') ?></textarea>
        </div>
                
        <div class="mt-3">
            <button type="submit" name="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
            <a href="index_mc.php" class="btn btn-secondary">ย้อนกลับ</a>
        </div>
    </form>
</div>
</body>
</html>

