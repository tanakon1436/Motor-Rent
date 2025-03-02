<?php 
$conn = new mysqli("localhost", "root", "", "motor_cycle");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$paym_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($paym_id) {
    $stmt = $conn->prepare("SELECT * FROM payment WHERE paym_id = ?");
    $stmt->bind_param("s", $paym_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $payment = $result->fetch_assoc();
    } else {
        echo "ไม่พบรายการชำระ";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <title>แก้ไขข้อมูลการชำระเงิน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-3">
    <h2 class="text-center">แก้ไขข้อมูลการชำระเงิน</h2>
    <form method="POST" action="update_paym_mc_back.php" enctype="multipart/form-data">
        
        <input type="hidden" name="paym_id" value="<?= htmlspecialchars($payment['paym_id'] ?? '') ?>">
        
        <div class="mb-2">
            <label class="form-label">รหัสการเช่า</label>
            <input type="text" name="rent_id" class="form-control" value="<?= htmlspecialchars($payment['rent_id'] ?? '') ?>" required>
        </div>
        <div class="mb-2">
            <label class="form-label">วันชำระ</label>
            <input type="date" name="paym_date" class="form-control" value="<?= htmlspecialchars($payment['paym_date'] ?? '') ?>" required>
        </div>
        <div class="mb-2">
            <label class="form-label">จำนวนเงินที่ชำระ</label>
            <input type="number" name="paym_total_price" class="form-control" value="<?= htmlspecialchars($payment['paym_total_price'] ?? '') ?>" required>
        </div>
        <div class="mb-2">
            <label class="form-label">สถานะ</label>
            <select name="paym_status" class="form-control" required>
                <option value="paid" <?= (isset($payment['paym_status']) && $payment['paym_status'] == 'paid') ? 'selected' : '' ?>>ชำระแล้ว</option>
                <option value="pending" <?= (isset($payment['paym_status']) && $payment['paym_status'] == 'pending') ? 'selected' : '' ?>>รอชำระ</option>
            </select>
        </div>
        <div class="mt-3 text-center">
            <button type="submit" name="submit" class="btn btn-danger">บันทึก</button>
            <a href="index_paym_mc.php" class="btn btn-secondary">ย้อนกลับ</a>
        </div>
    </form>
</div>
</body>
</html>