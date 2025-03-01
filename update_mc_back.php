<?php
$conn = new mysqli("localhost", "root", "", "motor_cycle");

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ตรวจสอบค่าที่ได้รับจากฟอร์ม
    if (!isset($_POST["cust_id"], $_POST["cust_name"], $_POST["cust_phone"], $_POST["cust_email"], $_POST["cust_address"])) {
        echo "<script>alert('ข้อมูลไม่ครบถ้วน กรุณากรอกข้อมูลให้ครบ!'); window.history.back();</script>";
        exit;
    }

    // กำหนดค่าและป้องกัน XSS
    $cust_id = trim($_POST["cust_id"]);
    $cust_name = trim($_POST["cust_name"]);
    $cust_phone = trim($_POST["cust_phone"]);
    $cust_email = trim($_POST["cust_email"]);
    $cust_address = trim($_POST["cust_address"]);

    // ตรวจสอบว่าไม่มีค่าที่เป็นค่าว่าง
    if (empty($cust_id) || empty($cust_name) || empty($cust_phone) || empty($cust_email) || empty($cust_address)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน!'); window.history.back();</script>";
        exit;
    }

    // ใช้ Prepared Statement เพื่อป้องกัน SQL Injection
    $stmt = $conn->prepare("UPDATE customer 
                            SET cust_name = ?, 
                                cust_phone = ?, 
                                cust_email = ?, 
                                cust_address = ? 
                            WHERE cust_id = ?");
    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $cust_name, $cust_phone, $cust_email, $cust_address, $cust_id);

    if ($stmt->execute()) {
        echo "<script>alert('อัปเดตข้อมูลสำเร็จ!'); window.location='index_c_mc.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล!'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
