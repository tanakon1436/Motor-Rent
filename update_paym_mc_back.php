<?php
// เปิด error reporting เพื่อ debug
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli("localhost", "root", "", "motor_cycle");

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตั้งค่าการเข้ารหัสข้อมูลเป็น UTF-8
$conn->set_charset("utf8mb4");

// ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ตรวจสอบว่าฟอร์มส่งค่ามาครบถ้วน
    if (!isset($_POST["paym_id"], $_POST["rent_id"], $_POST["paym_date"], $_POST["paym_total_price"], $_POST["paym_status"])) {
        die(json_encode(["status" => "error", "message" => "ข้อมูลไม่ครบถ้วน!"]));
    }

    // รับค่าและป้องกัน XSS
    $paym_id = intval($_POST["paym_id"]); // ID ควรเป็นตัวเลข
    $rent_id = trim($_POST["rent_id"]);
    $paym_date = trim($_POST["paym_date"]);
    $paym_total_price = trim($_POST["paym_total_price"]);
    $paym_status = trim($_POST["paym_status"]);

    // ตรวจสอบว่าข้อมูลไม่เป็นค่าว่าง
    if (empty($paym_id) || empty($rent_id) || empty($paym_date) || empty($paym_total_price) || empty($paym_status)) {
        die(json_encode(["status" => "error", "message" => "กรุณากรอกข้อมูลให้ครบถ้วน!"]));
    }

    // ตรวจสอบว่า `paym_total_price` เป็นตัวเลขหรือไม่
    if (!is_numeric($paym_total_price)) {
        die(json_encode(["status" => "error", "message" => "จำนวนเงินต้องเป็นตัวเลข!"]));
    }

    // ใช้ Prepared Statement ป้องกัน SQL Injection
    $stmt = $conn->prepare("UPDATE payment SET rent_id = ?, paym_date = ?, paym_total_price = ?, paym_status = ? WHERE paym_id = ?");

    if ($stmt === false) {
        die(json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL!"]));
    }

    // Binding parameters (String, String, Double, String, Integer)
    $stmt->bind_param("ssdsi", $rent_id, $paym_date, $paym_total_price, $paym_status, $paym_id);

    if ($stmt->execute()) {
        echo "<script>alert('แก้ไขข้อมูลสำเร็จ'); window.location.href='index_paym_mc.php'</script>";
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล!"]);
    }

    $stmt->close();
}

$conn->close();
?>
