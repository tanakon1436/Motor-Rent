<?php
$conn = new mysqli("localhost", "root", "", "motor_cycle");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rep_id = isset($_GET['id']) ? $_GET['id'] : null;
$repairment = null;
if ($rep_id) {
    $sql = "SELECT * FROM repairment WHERE rep_id = '$rep_id'"; // Fixed table name
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $repairment = $result->fetch_assoc();
    } else {
        echo "ไม่พบข้อมูลลูกค้าดังกล่าว";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="th"> <!-- Changed to Thai for better context -->
<head>
    <title>แก้ไขรายการแจ้งซ้อม</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-3">
    <form method="POST" action="update_rep_mc_back.php">
        
        <div class="mb-2">
            <label class="form-label">รหัสแจ้งซ้อม</label>
            <input type="text" name="rep_id" class="form-control" value="<?= htmlspecialchars($customer['rep_id'] ?? '') ?>" readonly>
        </div>

        <div class="mb-2">
            <label class="form-label">รหัสรถ</label>
            <input type="text" name="car_id" class="form-control" value="<?= htmlspecialchars($customer['car_id'] ?? '') ?>" required>
        </div>

        <div class="mb-2">
            <label class="form-label">รหัสพนักงาาน</label>
            <input type="text" name="emp_id" class="form-control" value="<?= htmlspecialchars($customer['emp_id'] ?? '') ?>" readonly>
        </div>

        <div class="mb-2">
            <label class="form-label">สถานะ</label>
            <select name="rep_status" class="form-control">
                <option value="Pending" <?= ($customer['rep_status'] ?? '') == 'pending' ? 'selected' : '' ?>>pending</option>
                <option value="Progress" <?= ($customer['rep_status'] ?? '') == 'progress' ? 'selected' : '' ?>>progress</option>
                <option value="Completed" <?= ($customer['rep_status'] ?? '') == 'completed' ? 'selected' : '' ?>>completed</option>
            </select>
        </div>

        <div class="form-group">
                   <label for="rep_price">ราคารายการแจ้งซ้อม</label>
                   <input type="text" name="rep_price" class="form-control" value="<?= htmlspecialchars($customer['rep_price'] ?? '') ?>" readonly>
        </div>

        <div class="form-group">
                    <label for="rep_detail">รายละเอียดการแจ้งซ้อม</label>
                    <input type="text" name="rep_detail" class="form-control" value="<?= htmlspecialchars($customer['rep_detail'] ?? '') ?>" readonly>
         </div>
                
         <div class="mt-3">
            <button type="submit" name ="submit" class="btn btn-danger">Submit</button>
            <a href="index_mc.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
</body>
</html>
