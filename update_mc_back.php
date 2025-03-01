<?php
$conn = new mysqli("localhost", "root", "", "motor_cycle");

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ตรวจสอบค่าที่ได้รับจากฟอร์ม
    if (!isset($_POST["cust_id"], $_POST["cust_name"], $_POST["cust_phone"], $_POST["cust_email"], $_POST["cust_gender"], $_POST["cust_address"])) {
        echo "<script>alert('ข้อมูลไม่ครบถ้วน กรุณากรอกข้อมูลให้ครบ!'); window.history.back();</script>";
        exit;
    }

    // กำหนดค่าและป้องกัน XSS
    $cust_id = trim($_POST["cust_id"]);
    $cust_name = trim($_POST["cust_name"]);
    $cust_phone = trim($_POST["cust_phone"]);
    $cust_email = trim($_POST["cust_email"]);
    $cust_gender = trim($_POST["cust_gender"]); // เพิ่มเพศลูกค้า
    $cust_address = trim($_POST["cust_address"]);

    // ตรวจสอบว่าไม่มีค่าที่เป็นค่าว่าง
    if (empty($cust_id) || empty($cust_name) || empty($cust_phone) || empty($cust_email) || empty($cust_gender) || empty($cust_address)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน!'); window.history.back();</script>";
        exit;
    }

    // ตรวจสอบว่าเบอร์โทรซ้ำหรือไม่
    $check_phone_query = "SELECT cust_phone FROM customer WHERE cust_phone = ? AND cust_id != ?";
    $stmt = $conn->prepare($check_phone_query);
    $stmt->bind_param("ss", $cust_phone, $cust_id);
    $stmt->execute();
    $check_phone_result = $stmt->get_result();

    if ($check_phone_result->num_rows > 0) {
        echo "<script>alert('เบอร์โทรศัพท์นี้ ($cust_phone) มีอยู่ในระบบแล้ว! กรุณาใช้เบอร์อื่น'); window.history.back();</script>";
        exit();
    }

    // ใช้ Prepared Statement เพื่ออัปเดตข้อมูลลูกค้า
    $stmt = $conn->prepare("UPDATE customer 
                            SET cust_name = ?, 
                                cust_phone = ?, 
                                cust_email = ?, 
                                cust_gender = ?, 
                                cust_address = ? 
                            WHERE cust_id = ?");
    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $cust_name, $cust_phone, $cust_email, $cust_gender, $cust_address, $cust_id);

    if ($stmt->execute()) {
        echo "<script>alert('อัปเดตข้อมูลสำเร็จ!'); window.location='index_mc.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล!'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
