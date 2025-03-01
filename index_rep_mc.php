<?php
// Connect to the database
$connection = mysqli_connect('localhost', 'root', '', 'motor_cycle');

if (!$connection) {
    die('Database connection failed: ' . mysqli_connect_error());
}

mysqli_set_charset($connection, 'utf8');

// Retrieve records from the database
$query = "SELECT * FROM repairment";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายการแจ้งซ้อม</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>รายการแจ้งซ้อม</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>รหัสแจ้งซ้อม</th>
                    <th>รหัสรถ</th>
                    <th>รหัสพนักงาน</th>
                    <th>สถานะ</th>
                    <th>ราคา</th>
                    <th>รายละเอียด</th>
                    <th>แก้ไข</th>
                    <th>ลบ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['rep_id']; ?></td>
                        <td><?php echo $row['car_id']; ?></td>
                        <td><?php echo $row['emp_id']; ?></td>
                        <td><?php echo $row['rep_status']; ?></td>
                        <td><?php echo $row['rep_price']; ?></td>
                        <td><?php echo $row['rep_detail']; ?></td>
                        <td><a href="update_rep_mc.php?id=<?= $row['rep_id']; ?>" class="button edit-btn">แก้ไข</a></td>
                        <td><a href="delete_rep_mc.php?id=<?= $row['rep_id']; ?>" class="button delete-btn" onclick="return confirm('คุณแน่ใจหรือไม่?')">ลบ</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
mysqli_close($connection);
?>
