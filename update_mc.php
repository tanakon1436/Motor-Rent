<?php
$conn = new mysqli("localhost", "root", "", "motor_cycle");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cust_id = isset($_GET['id']) ? $_GET['id'] : null;
$customer = null;
if ($cust_id) {
    $sql = "SELECT * FROM customer WHERE cust_id = '$cust_id'"; // Fixed table name
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
    } else {
        echo "ไม่พบข้อมูลลูกค้าดังกล่าว";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="th"> <!-- Changed to Thai for better context -->
<head>
    <title>แก้ไขข้อมูลลูกค้า</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-3">
    <form method="POST" action="update_mc_back.php">
        
        <div class="mb-2">
            <label class="form-label">รหัสลูกค้า</label>
            <input type="text" name="cust_id" class="form-control" value="<?= htmlspecialchars($customer['cust_id'] ?? '') ?>" readonly>
        </div>

        <div class="mb-2">
            <label class="form-label">ชื่อลูกค้า</label>
            <input type="text" name="cust_name" class="form-control" value="<?= htmlspecialchars($customer['cust_name'] ?? '') ?>" required>
        </div>

        <div class="mb-2">
            <label class="form-label">เบอร์โทรลูกค้า</label>
            <input type="text" name="cust_phone" class="form-control" value="<?= htmlspecialchars($customer['cust_phone'] ?? '') ?>" required> <!-- Fixed column name -->
        </div>

        <div class="mb-2">
            <label class="form-label">Email ลูกค้า</label>
            <input type="email" name="cust_email" class="form-control" value="<?= htmlspecialchars($customer['cust_email'] ?? '') ?>" required>
        </div>

        <div class="mb-2">
            <label class="form-label">เพศ</label>
            <select name="cust_gender" class="form-control" required>
                <option value="male" <?= (isset($customer['cust_gender']) && $customer['cust_gender'] == 'male') ? 'selected' : '' ?>>ชาย</option>
                <option value="female" <?= (isset($customer['cust_gender']) && $customer['cust_gender'] == 'female') ? 'selected' : '' ?>>หญิง</option>
            </select>
        </div>

        <div class="mb-2">
            <label class="form-label">ที่อยู่ลูกค้า</label>
            <input type="text" name="cust_address" class="form-control" value="<?= htmlspecialchars($customer['cust_address'] ?? '') ?>" required>
        </div>

        <div class="mt-3">
            <button type="submit" name ="submit" class="btn btn-danger">Submit</button>
            <a href="index_mc.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
</body>
</html>
