CREATE DATABASE IF NOT EXISTS courier_schedule;
USE courier_schedule;

CREATE TABLE IF NOT EXISTS regions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    travel_duration INT NOT NULL
);

CREATE TABLE IF NOT EXISTS couriers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    courier_id INT NOT NULL,
    region_id INT NOT NULL,
    departure_date DATE NOT NULL,
    arrival_date DATE NOT NULL,
    CONSTRAINT fk_courier FOREIGN KEY (courier_id) REFERENCES couriers(id),
    CONSTRAINT fk_region FOREIGN KEY (region_id) REFERENCES regions(id)
);
