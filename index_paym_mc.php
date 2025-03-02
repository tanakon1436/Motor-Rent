<?php
$conn = new mysqli('localhost', 'root', '', 'motor_cycle');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fetch payment data from the database
$sql = "SELECT paym_id,	rent_id, paym_date, paym_total_price, paym_status FROM payment";
$result = $conn->query($sql);

// Check if the SQL query was successful
if (!$result) {
    die('Query failed: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การชำระเงิน</title>
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
    <div class="container">
        <h2>การชำระเงิน</h2>
        <div class="button-container">
            <a href="insert_paym_mc.php" class="button add-btn">+ เพิ่มรายการชำระเงิน</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>รหัสการชำระเงิน</th>
                    <th>รหัสการเช่า</th>
                    <th>วันที่ชำระเงิน</th>
                    <th>จำนวนเงินที่ต้องชำระ</th>
                    <th>สถานะการชำระเงิน</th>
                    <th>แก้ไข</th>
                    <th>ลบ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['paym_id']; ?></td>
                    <td><?= $row['rent_id']; ?></td>
                    <td><?= $row['paym_date']; ?></td>
                    <td><?= $row['paym_total_price']; ?></td>
                    <td><?= $row['paym_status']; ?></td>
                    <td><a href="update_paym_mc.php?id=<?= $row['paym_id']; ?>" class="button edit-btn">แก้ไข</a></td>
                    <td><a href="delete_paym_mc.php?id=<?= $row['paym_id']; ?>" class="button delete-btn" onclick="return confirm('คุณแน่ใจหรือไม่?')">ลบ</a></td>
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