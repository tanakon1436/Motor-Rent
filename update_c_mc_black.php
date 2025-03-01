<?php
$conn = new mysqli("localhost", "root", "", "motor_cycle");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["car_id"], $_POST["car_name"], $_POST["car_status"], $_POST["car_detail"], $_POST["car_plate"])) {
        echo "<script>alert('ข้อมูลไม่ครบถ้วน กรุณากรอกข้อมูลให้ครบ!'); window.history.back();</script>";
        exit;
    }

    $car_id = trim($_POST["car_id"]);
    $car_name = trim($_POST["car_name"]);
    $car_status = trim($_POST["car_status"]);
    $car_detail = trim($_POST["car_detail"]);
    $car_plate = trim($_POST["car_plate"]);
    $car_img = null;

    if (empty($car_id) || empty($car_name) || empty($car_status) || empty($car_detail) || empty($car_plate)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน!'); window.history.back();</script>";
        exit;
    }

    if (!empty($_FILES["car_img"]["name"])) {
        $target_dir = "img/";
        $car_img = basename($_FILES["car_img"]["name"]);
        $target_file = $target_dir . $car_img;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_types)) {
            echo "<script>alert('อนุญาตเฉพาะไฟล์รูปภาพ JPG, JPEG, PNG, GIF เท่านั้น!'); window.history.back();</script>";
            exit;
        }

        if (!move_uploaded_file($_FILES["car_img"]["tmp_name"], $target_file)) {
            echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดรูป!'); window.history.back();</script>";
            exit;
        }
    }

    if ($car_img) {
        $stmt = $conn->prepare("UPDATE Car SET car_name = ?, car_status = ?, car_detail = ?, car_plate = ?, car_img = ? WHERE car_id = ?");
        $stmt->bind_param("ssssss", $car_name, $car_status, $car_detail, $car_plate, $car_img, $car_id);
    } else {
        $stmt = $conn->prepare("UPDATE Car SET car_name = ?, car_status = ?, car_detail = ?, car_plate = ? WHERE car_id = ?");
        $stmt->bind_param("sssss", $car_name, $car_status, $car_detail, $car_plate, $car_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('อัปเดตข้อมูลรถสำเร็จ!'); window.location='index_c_mc.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล!'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
