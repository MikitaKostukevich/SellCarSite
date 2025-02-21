CREATE DATABASE car_market;

USE car_market;

CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand VARCHAR(50),
    model VARCHAR(50),
    year INT,
    price DECIMAL(10,2),
    body_type VARCHAR(50),
    transmission VARCHAR(50),
    engine_type VARCHAR(50),
    drive_type VARCHAR(50),
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
