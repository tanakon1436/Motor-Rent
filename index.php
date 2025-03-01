<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarun MotorBike Rental</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Sarun MotorBike Rental</h2>
        <div class="head-button text-center d-flex p-3" >

            <div class="button-container p-3 ">
                <button type="button" class="btn btn-warning">
                    <a href="index_c_mc.php " class="button text-white ">ข้อมูลรถ</a>
                </button>
            </div>
            <div class="button-container p-3 ">
                <button type="button" class="btn btn-danger ">
                    <a href="index_mc.php" class="button text-white">ข้อมูลลูกค้่า</a>
                </button>
            </div>
            <div class="button-container p-3 ">
                <button type="button" class="btn btn-secondary ary">
                    <a href="index_emp_mc.php" class="button text-white"">ข้อมูลพนักงาน</a>
                </button>
            </div>
            <div class="button-container p-3 ">
                <button type="button" class="btn btn-primary">
                    <a href="index_rep_mc.php" class="button text-white"">ข้อมูลการแจ้งซ่อม</a>
                </button>
            </div>
        </div>
        
</body>
</html>

<?php
$conn->close();
?>
