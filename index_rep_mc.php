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
    <style>
        /* Styles as previously defined */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4cccc;
            text-align: center;
            margin: 20px;
        }
        h2 {
            color: #cc0000;
        }
        .container {
            width: 90%;
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #db4c4c;
            text-align: center;
        }
        th {
            background: #cc0000;
            color: white;
        }
        tr:nth-child(even) {
            background: #f4cccc;
        }
        tr:hover {
            background: #db4c4c;
            color: white;
        }
        a.button {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-weight: bold;
        }
        .add-btn {
            background: #cc0000;
        }
        .edit-btn {
            background: #db4c4c;
        }
        .delete-btn {
            background: #cc0000;
        }
        a.button:hover {
            opacity: 0.8;
        }
        .button-container {
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="but" style="display:flex">

<div class="button-container">
        <a href="index.php" class="button add-btn2" style="background:grey">< ย้อนกลับ</a>
</div>
<div class="button-container">
    <a href="insert_rep_mc.php" class="button add-btn">+ เพิ่มข้อมูลการเเจ้งซ่อม</a>
</div>
</div>
    <div class="container mt-5">
        <h2>รายการแจ้งซ่อม</h2>
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
