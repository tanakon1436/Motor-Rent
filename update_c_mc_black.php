<?php
$conn = new mysqli("localhost", "root", "", "motor_cycle");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_id = $_POST["car_id"] ?? '';
    $car_name = $_POST["car_name"] ?? '';
    $car_status = $_POST["car_status"] ?? '';
    $car_detail = $_POST["car_detail"] ?? '';
    $car_plate = $_POST["car_plate"] ?? '';
    $car_price = $_POST["car_price"] ?? '';

    if (!$car_id || !$car_name || !$car_status || !$car_detail || !$car_plate || !$car_price) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบ!'); window.history.back();</script>";
        exit;
    }

    // ดึงค่า car_img เดิม
    $stmt = $conn->prepare("SELECT car_img FROM Car WHERE car_id = ?");
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $stmt->bind_result($car_img);
    $stmt->fetch();
    $stmt->close();

    // อัปโหลดรูปใหม่ถ้ามี
    if (!empty($_FILES["car_img"]["name"])) {
        $ext = strtolower(pathinfo($_FILES["car_img"]["name"], PATHINFO_EXTENSION));
        if (!in_array($ext, ["jpg", "jpeg", "png", "gif"])) {
            echo "<script>alert('อนุญาตเฉพาะ JPG, JPEG, PNG, GIF!'); window.history.back();</script>";
            exit;
        }
    
        // ใช้ชื่อไฟล์เดิมจากการอัปโหลด
        $car_img = basename($_FILES["car_img"]["name"]);
        move_uploaded_file($_FILES["car_img"]["tmp_name"], "img/$car_img");
    }
    

    // อัปเดตข้อมูล
    $stmt = $conn->prepare("UPDATE Car SET car_name=?, car_status=?, car_detail=?, car_plate=?, car_img=?, car_price=? WHERE car_id=?");
    $stmt->bind_param("ssssssi", $car_name, $car_status, $car_detail, $car_plate, $car_img, $car_price, $car_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('อัปเดตสำเร็จ!'); window.location='index_c_mc.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด!'); window.history.back();</script>";
    }
    $stmt->close();
}
$conn->close();
?>
