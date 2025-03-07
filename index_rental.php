<?php
$connection = mysqli_connect('localhost', 'root', '', 'motor_cycle');

if (!$connection) {
    die("🔴 Database Connection Failed: " . mysqli_connect_error());
}

// คำสั่ง SQL ใช้ JOIN เพื่อดึงข้อมูลที่เกี่ยวข้อง
$query = "
SELECT rental.*, 
       customer.cust_name, 
       car.car_name, 
       employee.emp_name 
FROM Rental
JOIN customer ON rental.cust_id = customer.cust_id
JOIN car ON rental.car_id = car.car_id
JOIN employee ON rental.emp_id = employee.emp_id
ORDER BY Rental.rent_id ASC"; // เรียงลำดับน้อยสุดไปมากสุด สามารถปรับเป็น DESC เพื่อเป็นมากสุดไปน้อยสุด

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
        .but{
            display:flex;
        }
        .add-btn2{
            background:grey;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="text-center">
        <h2>📋 รายการเช่ารถ</h2>
    </div><br>
    <div class="but" style="display:flex">
        <div class="button-container">
        <a href="index.php" class="button add-btn2" style="background:grey">< ย้อนกลับ</a>
    </div>
    <div class="button-container">
    <a href="insert_rental.php" class="button add-btn">+ เพิ่มข้อมูลการเช่ารถ</a>
</div>
    </div>
    <table >
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
                <th>การจัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr >
                    <td><?= htmlspecialchars($row['rent_id']); ?></td>
                    <td><?= htmlspecialchars($row['cust_name']); ?></td>
                    <td><?= htmlspecialchars($row['car_name']); ?></td>
                    <td><?= htmlspecialchars($row['emp_name']); ?></td>
                    <td><?= htmlspecialchars($row['rent_start_date']); ?></td>
                    <td><?= htmlspecialchars($row['rent_return_date']); ?></td>
                    <td>
                        <span class="badge badge-<?php 
                            switch ($row['rent_status']) {
                                case 'รอดำเนินการ': echo 'warning'; break;
                                case 'กำลังดำเนินการ': echo 'primary'; break;
                                case 'ดำเนินการเสร็จสิ้น': echo 'success'; break;
                                case 'ยกเลิก': echo 'danger'; break;
                            } 
                        ?>">
                            <?= htmlspecialchars($row['rent_status']); ?>
                        </span>
                    </td>
                    <td ><?= number_format($row['rent_total_price'], 2); ?> ฿</td>
                    <td >
                        <a href="update_rental.php?id=<?= $row['rent_id']; ?>" class="btn btn-danger btn-block">✏️ แก้ไข</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php mysqli_close($connection); ?>
