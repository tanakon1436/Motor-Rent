<?php
$conn = new mysqli("localhost", "root", "", "motor_cycle");

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ตรวจสอบค่าที่ได้รับจากฟอร์ม
    if (!isset($_POST["emp_id"], $_POST["emp_name"], $_POST["emp_phone"])) {
        echo "<script>alert('ข้อมูลไม่ครบถ้วน กรุณากรอกข้อมูลให้ครบ!'); window.history.back();</script>";
        exit;
    }

    // กำหนดค่าและป้องกัน XSS
    $emp_id = trim($_POST["emp_id"]);
    $emp_name = trim($_POST["emp_name"]);
    $emp_phone = trim($_POST["emp_phone"]);
    
    // ตรวจสอบว่าไม่มีค่าที่เป็นค่าว่าง
    if (empty($emp_id) || empty($emp_name) || empty($emp_phone)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน!'); window.history.back();</script>";
        exit;
    }

    // ใช้ Prepared Statement เพื่อป้องกัน SQL Injection
    $stmt = $conn->prepare("UPDATE employee SET emp_name = ?, emp_phone = ? WHERE emp_id = ?");
    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Binding parameters: 'sss' means three string parameters
    $stmt->bind_param("sss", $emp_name, $emp_phone, $emp_id);

    if ($stmt->execute()) {
        echo "<script>alert('อัปเดตข้อมูลสำเร็จ!'); window.location='index_emp_mc.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล!'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
