CREATE DATABASE booking_db;
USE booking_db;

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100),
    booking_date DATE,
    booking_time TIME,
    service VARCHAR(100),
    status VARCHAR(50)
);