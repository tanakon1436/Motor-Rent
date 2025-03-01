CREATE DATABASE motor_cycle;
USE motor_cycle;

CREATE TABLE Customer (
    cust_id INT PRIMARY KEY AUTO_INCREMENT,
    cust_name VARCHAR(100) NOT NULL,
    cust_phone VARCHAR(10) UNIQUE NOT NULL,
    cust_email VARCHAR(100) UNIQUE NOT NULL,
    cust_gender ENUM('Male', 'Female', 'Other'),
    cust_address TEXT
);

CREATE TABLE Car (
    car_id INT PRIMARY KEY AUTO_INCREMENT,
    car_name VARCHAR(100) NOT NULL,
    car_status ENUM('Available', 'Rented', 'In Maintenance') NOT NULL,
    car_detail VARCHAR(255),
    car_img VARCHAR(255),
    car_plate VARCHAR(20) UNIQUE NOT NULL
);

CREATE TABLE Employee (
    emp_id INT PRIMARY KEY AUTO_INCREMENT,
    emp_name VARCHAR(100) NOT NULL,
    emp_phone VARCHAR(10) UNIQUE NOT NULL
);

CREATE TABLE Rental (
    rent_id INT PRIMARY KEY AUTO_INCREMENT,
    cust_id INT NOT NULL,
    car_id INT NOT NULL,
    emp_id INT NOT NULL,
    rent_start_date DATE NOT NULL,
    rent_return_date DATE NOT NULL,
    rent_status ENUM('Pending', 'Ongoing', 'Completed', 'Canceled') NOT NULL,
    rent_total_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (cust_id) REFERENCES Customer(cust_id),
    FOREIGN KEY (car_id) REFERENCES Car(car_id),
    FOREIGN KEY (emp_id) REFERENCES Employee(emp_id)
);

CREATE TABLE Payment (
    paym_id INT PRIMARY KEY AUTO_INCREMENT,
    rent_id INT NOT NULL,
    paym_date DATE NOT NULL,
    paym_total_price DECIMAL(10,2) NOT NULL,
    paym_status ENUM('Pending', 'Paid', 'Failed') NOT NULL,
    FOREIGN KEY (rent_id) REFERENCES Rental(rent_id)
);

CREATE TABLE Repairment (
    rep_id INT PRIMARY KEY AUTO_INCREMENT,
    car_id INT NOT NULL,
    emp_id INT NOT NULL,
    rep_status ENUM('Pending', 'In Progress', 'Completed') NOT NULL,
    rep_price DECIMAL(10,2) NOT NULL,
    rep_detail TEXT,
    FOREIGN KEY (car_id) REFERENCES Car(car_id),
    FOREIGN KEY (emp_id) REFERENCES Employee(emp_id)
);