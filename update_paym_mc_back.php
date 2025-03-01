<?php
$conn = new mysqli("localhost", "root", "", "motor_cycle");

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ตรวจสอบค่าที่ได้รับจากฟอร์ม
    if (!isset($_POST["paym_id"], $_POST["rent_id"], $_POST["paym_date"],$_POST["paym_total_price"],$_POST["paym_status"])) {
        echo "<script>alert('ข้อมูลไม่ครบถ้วน กรุณากรอกข้อมูลให้ครบ!'); window.history.back();</script>";
        exit;
    }

    // กำหนดค่าและป้องกัน XSS  
    $paym_id = trim($_POST["paym_id"]);
    $rent_id = trim($_POST["rent_id"]);
    $paym_date = trim($_POST["paym_date"]);
    $paym_total_price = trim($_POST["paym_total_price"]);
    $paym_status = trim($_POST["paym_status	"]);
    
    // ตรวจสอบว่าไม่มีค่าที่เป็นค่าว่าง
    if (empty($paym_id) || empty($rent_id) || empty($paym_date) || empty($paym_total_price) || empty($paym_status)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน!'); window.history.back();</script>";
        exit;
    }

    // ใช้ Prepared Statement เพื่อป้องกัน SQL Injection
    $stmt = $conn->prepare("UPDATE payment SET rent_id = ?, paym_date = ?, paym_total_price = ?, paym_status = ? WHERE paym_id = ?");

    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Binding parameters: 'sss' means three string parameters
    $stmt->bind_param("sss", $rent_id, $paym_date, $paym_total_price, $paym_status, $paym_id);

    if ($stmt->execute()) {
        echo "<script>alert('อัปเดตข้อมูลสำเร็จ!'); window.location='index_paym_mc.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล!'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>