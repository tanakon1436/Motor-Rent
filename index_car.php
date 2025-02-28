<?php
$conn = new mysqli('localhost', 'root', '', 'motor_cycle');

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// ดึงข้อมูลลูกค้าจากฐานข้อมูล
$sql = "
SELECT * FROM `Car`";
$result = $conn->query($sql);

// ตรวจสอบว่าคำสั่ง SQL ทำงานถูกต้อง
if (!$result) {
    die('Query failed: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายชื่อลูกค้า</title>
    <style>
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
    <div class="container">
        <h2>รายการลูกค้า</h2>
        <div class="button-container">
            <a href="insert_ts.php" class="button add-btn">+ เพิ่มลูกค้า</a>
        </div>
        <table style="border-radius: 10px; overflow: hidden; border: 1px solid #ddd;">
            <thead >
                <tr>
                    <th>รหัสลูกค้า</th>
                    <th>ชื่อลูกค้า</th>
                    <th>เบอร์โทร</th>
                    <th>อีเมล</th>
                    <th>เพศ</th>
                    <th>ที่อยู่ลูกค้า</th>
                    <th>แก้ไข</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="align-middle">
                    <td class="align-middle"><?= htmlspecialchars($row['car_id']); ?></td>
                    <td class="align-middle"><?= htmlspecialchars($row['car_name']); ?></td>
                    <td class="align-middle"><?= htmlspecialchars($row['car_status']); ?></td>
                    <td class="align-middle"><?= htmlspecialchars($row['car_detail']); ?></td>
                    <td class="align-middle"><?= htmlspecialchars($row['car_plate']); ?></td>
                    <td class="align-middle"><img src="img/<?= htmlspecialchars($row['car_img']); ?>" alt="Car Image" style="max-width: 100px; height: auto;"></td>
                    <td class="align-middle">
                        <a href="update_car.php?id=<?= $row['car_id']; ?>" class="btn btn-warning btn-sm"><img src="./img/edit2.svg" alt=""> </a>
                        <a href="delete.php?id=<?= $row['car_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this record?');"><img src="./img/delete.svg" alt=""></a>
                    </td>
                    
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>