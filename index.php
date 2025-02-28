<?php
$connection = mysqli_connect('localhost', 'root', '', 'motor_cycle');

if (!$connection) {
    die("🔴 Database Connection Failed: " . mysqli_connect_error());
}


$query = "
SELECT * FROM `Car`";

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
    <title>รายการรถ</title>
</head>
<body style="margin:10px">
    <div class="text-center">
        <h3>🚗 รายการลูกค้า</h3>
    </div>
    <div class="text-center">
        <a href="insert_ass6.php" class="btn btn-danger mb-3">➕ เพิ่มรถใหม่</a>
    </div>
    <table class='table table-striped table-success'>
        <thead style="background-color:red">
            <tr >
                <th>รหัสรถ</th>
                <th>รุ่นรถ</th>
                <th>สถานะ</th>
                <th>รายละเอียด</th>
                <th>ทะเบียนรถ</th>
                <th>รูปรถ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="align-middle">
                    <td class="align-middle"><?= htmlspecialchars($row['car_id']); ?></td>
                    <td class="align-middle"><?= htmlspecialchars($row['car_name']); ?></td>
                    <td class="align-middle"><?= htmlspecialchars($row['car_status']); ?></td>
                    <td class="align-middle"><?= htmlspecialchars($row['car_detail']); ?></td>
                    <td class="align-middle"><?= htmlspecialchars($row['car_plate']); ?></td>
                    <td class="align-middle"><img src="img/<?= htmlspecialchars($row['car_img']); ?>" alt="Car Image" style="max-width: 100px; height: auto;"></td>
                    <td class="align-middle">
                        <a href="update_car.php?id=<?= $row['car_id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                        <a href="delete.php?id=<?= $row['car_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this record?');">ลบ</a>
                    </td>
                    
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>

<?php mysqli_close($connection); ?>
