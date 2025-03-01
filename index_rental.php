<?php
$connection = mysqli_connect('localhost', 'root', '', 'motor_cycle');

if (!$connection) {
    die("🔴 Database Connection Failed: " . mysqli_connect_error());
}

// คำสั่ง SQL ใช้ JOIN เพื่อดึงข้อมูลที่เกี่ยวข้อง
$query = "
SELECT Rental.*, 
       Customer.cust_name, 
       Car.car_name, 
       Employee.emp_name 
FROM Rental
JOIN Customer ON Rental.cust_id = Customer.cust_id
JOIN Car ON Rental.car_id = Car.car_id
JOIN Employee ON Rental.emp_id = Employee.emp_id
ORDER BY Rental.rent_id DESC"; 

$result = mysqli_query($connection, $query);

if (!$result) {
    die("🔴 Query Failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <title>รายการเช่ารถ</title>
</head>
<body style="margin:10px">
    <div class="text-center">
        <h2>📋 รายการเช่ารถ</h2>
    </div><br>
    <div class="text-center">
        <a href="insert_rental.php" class="btn btn-danger mb-3">➕ เพิ่มรายการเช่า</a>
    </div><br>
    <table class='table table-striped table-bordered'>
        <thead class="thead-dark">
            <tr>
                <th>รหัสเช่า</th>
                <th>ชื่อผู้เช่า</th>
                <th>รุ่นรถ</th>
                <th>พนักงานที่รับผิดชอบ</th>
                <th>วันที่เริ่มเช่า</th>
                <th>วันที่คืนรถ</th>
                <th>สถานะ</th>
                <th>ราคารวม (บาท)</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="align-middle">
                    <td class="align-middle"><?= htmlspecialchars($row['rent_id']); ?></td>
                    <td class="align-middle"><?= htmlspecialchars($row['cust_name']); ?></td>
                    <td class="align-middle"><?= htmlspecialchars($row['car_name']); ?></td>
                    <td class="align-middle"><?= htmlspecialchars($row['emp_name']); ?></td>
                    <td class="align-middle"><?= htmlspecialchars($row['rent_start_date']); ?></td>
                    <td class="align-middle"><?= htmlspecialchars($row['rent_return_date']); ?></td>
                    <td class="align-middle">
                        <span class="badge badge-<?php 
                            switch ($row['rent_status']) {
                                case 'Pending': echo 'warning'; break;
                                case 'Ongoing': echo 'primary'; break;
                                case 'Completed': echo 'success'; break;
                                case 'Canceled': echo 'danger'; break;
                            } 
                        ?>">
                            <?= htmlspecialchars($row['rent_status']); ?>
                        </span>
                    </td>
                    <td class="align-middle"><?= number_format($row['rent_total_price'], 2); ?> ฿</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

<?php mysqli_close($connection); ?>
