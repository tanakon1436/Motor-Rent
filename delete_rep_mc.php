<?php
$connection = mysqli_connect('localhost', 'root', '', 'motor_cycle');
if (!$connection) {
    die('Database Connection Failed: ' . mysqli_connect_error());
}



if (isset($_GET['id'])) {
    $rep_id = $_GET['id'];

    
    
    $check_query = "SELECT * FROM repairmant WHERE rep_id = ?";
    if ($check_stmt = mysqli_prepare($connection, $check_query)) {
        mysqli_stmt_bind_param($check_stmt, "i", $rep_id);
        mysqli_stmt_execute($check_stmt);
        $result = mysqli_stmt_get_result($check_stmt);
        
        if (mysqli_num_rows($result) > 0) {
            
            $query = "DELETE FROM repairment WHERE rep_id = ?";
            if ($stmt = mysqli_prepare($connection, $query)) {
                mysqli_stmt_bind_param($stmt, "i", $rep_id);
                if (mysqli_stmt_execute($stmt)) {
                    echo "<script>alert('ลบข้อมูลเรียบร้อย'); window.location='index_rep_mc.php';</script>";
                } else {
                    echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล'); window.location='index_rep_mc.php';</script>";
                }
                mysqli_stmt_close($stmt);
            }
        } else {
            echo "<script>alert('ไม่พบข้อมูลลูกค้าที่ต้องการลบ'); window.location='index_rep_mc.php';</script>";
        }
        mysqli_stmt_close($check_stmt);
    }
} else {
    echo "<script>alert('ไม่พบรหัสลูกค้า'); window.location='index_rep_mc.php';</script>";
}


mysqli_close($connection);
?>
