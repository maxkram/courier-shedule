-- Создание базы данных, если она не существует
CREATE DATABASE IF NOT EXISTS courier_schedule;
USE courier_schedule;

-- Создание таблицы регионов
CREATE TABLE IF NOT EXISTS regions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    travel_duration INT NOT NULL,
    UNIQUE (name)
);

-- Создание таблицы курьеров
CREATE TABLE IF NOT EXISTS couriers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    UNIQUE (full_name)
);

-- Создание таблицы поездок
CREATE TABLE IF NOT EXISTS trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    courier_id INT NOT NULL,
    region_id INT NOT NULL,
    departure_date DATE NOT NULL,
    arrival_date DATE NOT NULL,
    CONSTRAINT fk_courier FOREIGN KEY (courier_id) REFERENCES couriers(id) ON DELETE CASCADE,
    CONSTRAINT fk_region FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE,
    INDEX idx_departure_date (departure_date)
);