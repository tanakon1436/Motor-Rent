CREATE DATABASE IF NOT EXISTS motor_cycle;
USE motor_cycle;

CREATE TABLE car (
  car_id INT(11) NOT NULL AUTO_INCREMENT,
  car_name VARCHAR(100) NOT NULL,
  car_status ENUM('ว่าง','ถูกเช่า','กำลังซ่อมบำรุง') NOT NULL,
  car_detail VARCHAR(255) DEFAULT NULL,
  car_img VARCHAR(255) DEFAULT NULL,
  car_plate VARCHAR(20) NOT NULL UNIQUE,
  car_price DECIMAL(10,0) NOT NULL,
  PRIMARY KEY (car_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE customer (
  cust_id INT(11) NOT NULL AUTO_INCREMENT,
  cust_name VARCHAR(100) NOT NULL,
  cust_phone VARCHAR(10) NOT NULL UNIQUE,
  cust_email VARCHAR(100) NOT NULL UNIQUE,
  cust_gender ENUM('ชาย','หญิง','อื่นๆ') DEFAULT NULL,
  cust_address TEXT DEFAULT NULL,
  PRIMARY KEY (cust_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE employee (
  emp_id INT(11) NOT NULL AUTO_INCREMENT,
  emp_name VARCHAR(100) NOT NULL,
  emp_phone VARCHAR(10) NOT NULL UNIQUE,
  PRIMARY KEY (emp_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE rental (
  rent_id INT(11) NOT NULL AUTO_INCREMENT,
  cust_id INT(11) NOT NULL,
  car_id INT(11) NOT NULL,
  emp_id INT(11) NOT NULL,
  rent_start_date DATE NOT NULL,
  rent_return_date DATE NOT NULL,
  rent_status ENUM('รอดำเนินการ','กำลังดำเนินการ','ดำเนินการเสร็จสิ้น','ยกเลิก') NOT NULL,
  rent_total_price DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (rent_id),
  FOREIGN KEY (cust_id) REFERENCES customer(cust_id),
  FOREIGN KEY (car_id) REFERENCES car(car_id),
  FOREIGN KEY (emp_id) REFERENCES employee(emp_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE payment (
  paym_id INT(11) NOT NULL AUTO_INCREMENT,
  rent_id INT(11) NOT NULL,
  paym_date DATE NOT NULL,
  paym_total_price DECIMAL(10,2) NOT NULL,
  paym_status ENUM('รอดำเนินการ','ชำระเงินแล้ว','ชำระเงินไม่สำเร็จ') NOT NULL,
  PRIMARY KEY (paym_id),
  FOREIGN KEY (rent_id) REFERENCES rental(rent_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE repairment (
  rep_id INT(11) NOT NULL AUTO_INCREMENT,
  car_id INT(11) NOT NULL,
  emp_id INT(11) NOT NULL,
  rep_status ENUM('รอดำเนินการ','กำลังดำเนินการ','ดำเนินการเสร็จสิ้น') NOT NULL,
  rep_price DECIMAL(10,2) NOT NULL,
  rep_detail TEXT DEFAULT NULL,
  PRIMARY KEY (rep_id),
  FOREIGN KEY (car_id) REFERENCES car(car_id),
  FOREIGN KEY (emp_id) REFERENCES employee(emp_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
