<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$connection = mysqli_connect('localhost', 'root', '', 'motor_cycle');
if (!$connection) {
    die('Database Connection Failed: ' . mysqli_connect_error());
}

// ตรวจสอบว่ามีการส่งค่า id หรือไม่
if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<script>alert('ข้อมูลไม่ถูกต้อง!'); window.location='index_emp_mc.php';</script>");
}

$emp_id = (int) $_GET['id']; // แปลงเป็นตัวเลขเพื่อความปลอดภัย

// ตรวจสอบว่ามีพนักงานนี้อยู่จริงหรือไม่
$check_query = "SELECT * FROM employee WHERE emp_id = ?";
$check_stmt = mysqli_prepare($connection, $check_query);

if ($check_stmt) {
    mysqli_stmt_bind_param($check_stmt, "i", $emp_id);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($result) > 0) {
        // ลบพนักงาน
        $query = "DELETE FROM employee WHERE emp_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $emp_id);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('ลบข้อมูลเรียบร้อย'); window.location='index_emp_mc.php';</script>";
            } else {
                die("<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล: " . mysqli_error($connection) . "'); window.location='index_emp_mc.php';</script>");
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        die("<script>alert('ไม่พบข้อมูลพนักงาน'); window.location='index_emp_mc.php';</script>");
    }
    mysqli_stmt_close($check_stmt);
} else {
    die("<script>alert('เกิดข้อผิดพลาด: " . mysqli_error($connection) . "'); window.location='index_emp_mc.php';</script>");
}

mysqli_close($connection);
?>
