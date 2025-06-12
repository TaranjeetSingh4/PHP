-- Run this SQL in phpMyAdmin or MySQL CLI
CREATE DATABASE IF NOT EXISTS blood_treatment_system;
USE blood_treatment_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'user', 'blood_center', 'treatment_center') NOT NULL
);
