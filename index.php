<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarun MotorBike Rental</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .container {
            margin-top: 50px;
        }
        .button-container {
            margin: 10px;
        }
        .btn-custom {
            width: 200px;
            height: 60px;
            font-size: 18px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-custom a {
            color: white;
            text-decoration: none;
        }
        .btn-custom:hover {
            background-color: #007bff;
            cursor: pointer;
        }
        .heading {
            margin-bottom: 30px;
            text-align: center;
        }
        .row {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="heading">
            <h2>Sarun MotorBike Rental</h2>
        </div>

        <div class="row">
            <div class="col-md-2 button-container">
                <div class="btn btn-warning btn-custom">
                    <a href="index_c_mc.php">ข้อมูลรถ</a>
                </div>
            </div>
            <div class="col-md-2 button-container">
                <div class="btn btn-danger btn-custom">
                    <a href="index_mc.php">ข้อมูลลูกค้า</a>
                </div>
            </div>
            <div class="col-md-2 button-container">
                <div class="btn btn-secondary btn-custom">
                    <a href="index_emp_mc.php">ข้อมูลพนักงาน</a>
                </div>
            </div>
            <div class="col-md-2 button-container">
                <div class="btn btn-primary btn-custom">
                    <a href="index_rep_mc.php">ข้อมูลการแจ้งซ่อม</a>
                </div>
            </div>
            <div class="col-md-2 button-container">
                <div class="btn btn-danger btn-custom">
                    <a href="index_rental.php">ข้อมูลการเช่า</a>
                </div>
            </div>
        </div>
        <div class="ceo-pic text-center">
            <img src="./img/char.jpg" alt="">
        </div>
    </div>
</body>
</html>
