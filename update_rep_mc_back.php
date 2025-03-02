<?php
$conn = new mysqli("localhost", "root", "", "motor_cycle");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rep_id = $_POST['rep_id'] ?? null;
    $car_id = $_POST['car_id'] ?? null;
    $emp_id = $_POST['emp_id'] ?? null;
    $rep_status = $_POST['rep_status'] ?? null;
    $rep_price = $_POST['rep_price'] ?? null;
    $rep_detail = $_POST['rep_detail'] ?? null;

    if ($rep_id && $car_id && $emp_id && $rep_status && $rep_price && $rep_detail) {
        // ใช้ Prepared Statement ป้องกัน SQL Injection
        $stmt = $conn->prepare("UPDATE Repairment SET car_id = ?, emp_id = ?, rep_status = ?, rep_price = ?, rep_detail = ? WHERE rep_id = ?");
        $stmt->bind_param("iisssi", $car_id, $emp_id, $rep_status, $rep_price, $rep_detail, $rep_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('อัปเดตรายการแจ้งซ่อมสำเร็จ'); window.location.href = 'index_rep_mc.php';</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล'); history.back();</script>";
        }
        
        $stmt->close();
    } else {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); history.back();</script>";
    }
} else {
    echo "<script>alert('ไม่รองรับการเข้าถึงโดยตรง'); window.location.href = 'index_rep_mc.php';</script>";
}

$conn->close();
?>
