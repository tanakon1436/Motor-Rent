<?php
// เชื่อมต่อฐานข้อมูล
$connection = mysqli_connect('localhost', 'root', '', 'sales');

if (!$connection) {
    die("🔴 Database Connection Failed: " . mysqli_connect_error());
}


$query = "
    SELECT c.cust_id, c.cust_fname, c.cust_lname, c.cust_address, 
           c.cust_tel, c.cust_sex, c.cust_email, ct.cust_type_name 
    FROM customer c
    LEFT JOIN customer_type ct ON c.cust_type_id = ct.cust_type_id";

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
    <title>รายการลูกค้า</title>
</head>
<body style="margin:10px">
    <div class="text-center">
        <h3>📋 รายการลูกค้า</h3>
    </div>
    <div class="text-center">
        <a href="insert_ass6.php" class="btn btn-primary mb-3">เพิ่มลูกค้าใหม่</a>
    </div>
    <table class='table table-striped table-success'>
        <thead>
            <tr>
                <th>รหัสลูกค้า</th>
                <th>ชื่อลูกค้า</th>
                <th>นามสกุลลูกค้า</th>
                <th>ที่อยู่ลูกค้า</th>
                <th>เบอร์โทรลูกค้า</th>
                <th>เพศลูกค้า</th>
                <th>อีเมลลูกค้า</th>
                <th>ประเภทลูกค้า</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['cust_id']); ?></td>
                    <td><?= htmlspecialchars($row['cust_fname']); ?></td>
                    <td><?= htmlspecialchars($row['cust_lname']); ?></td>
                    <td><?= htmlspecialchars($row['cust_address']); ?></td>
                    <td><?= htmlspecialchars($row['cust_tel']); ?></td>
                    <td><?= htmlspecialchars($row['cust_sex']); ?></td>
                    <td><?= htmlspecialchars($row['cust_email']); ?></td>
                    <td><?= htmlspecialchars($row['cust_type_name']); ?></td>
                    <td>
                        <a href="update_ass6.php?id=<?= $row['cust_id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                        <a href="delete.php?id=<?= $row['cust_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this record?');">ลบ</a>
                    </td>
                    
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>

<?php mysqli_close($connection); ?>
