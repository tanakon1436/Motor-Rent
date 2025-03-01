<?php
$conn = new mysqli("localhost", "root", "", "motor_cycle");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$emp_id = isset($_GET['id']) ? $_GET['id'] : null;
$employee = null;

if ($emp_id) {
    $sql = "SELECT * FROM employee WHERE emp_id = '$emp_id'"; // Fixed table name
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        echo "ไม่พบข้อมูลพนักงานดังกล่าว";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <title>แก้ไขข้อมูลพนักงาน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-3">
    <form method="POST" action="update_emp_mc_back.php">
        
        <div class="mb-2">
            <label class="form-label">รหัสพนักงาน</label>
            <input type="text" name="emp_id" class="form-control" value="<?= htmlspecialchars($employee['emp_id'] ?? '') ?>" readonly>
        </div>

        <div class="mb-2">
            <label class="form-label">ชื่อพนักงาน</label>
            <input type="text" name="emp_name" class="form-control" value="<?= htmlspecialchars($employee['emp_name'] ?? '') ?>" required>
        </div>

        <div class="mb-2">
            <label class="form-label">เบอร์โทรพนักงาน</label>
            <input type="tel" name="emp_phone" class="form-control" value="<?= htmlspecialchars($employee['emp_phone'] ?? '') ?>" required> <!-- Fixed column name -->
        </div>

        <div class="mt-3">
            <button type="submit" name="submit" class="btn btn-danger">Submit</button>
            <a href="index_emp_mc.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
</body>
</html>
