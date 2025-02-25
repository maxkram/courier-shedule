USE courier_schedule;

-- Вставка данных в таблицу регионов
INSERT INTO regions (name, travel_duration) VALUES 
('Saint Petersburg', 2),
('Ufa', 3),
('Nizhniy Novgorod', 1),
('Vladimir', 2),
('Kostroma', 2),
('Ekaterinburg', 4),
('Kovrov', 1),
('Voronezh', 2),
('Samara', 3),
('Astrakhan', 5)
ON DUPLICATE KEY UPDATE name = name;

-- Вставка данных в таблицу курьеров
INSERT INTO couriers (full_name) VALUES
('Amina Safina'),
('Amir Shakirov'),
('Yasmina Khayrullina'),
('Timur Zaripov'),
('Sofia Zakirova'),
('Karim Karimov'),
('Diana Ibragimova'),
('Artem Khasanov'),
('Alisa Sabirova'),
('Matvey Valeev')
ON DUPLICATE KEY UPDATE full_name = full_name;

-- Вставка данных в таблицу поездок
INSERT INTO trips (courier_id, region_id, departure_date, arrival_date) VALUES
(1, 1, '2025-03-01', DATE_ADD('2025-03-01', INTERVAL (SELECT travel_duration FROM regions WHERE id = 1) DAY)),
(2, 2, '2025-03-05', DATE_ADD('2025-03-05', INTERVAL (SELECT travel_duration FROM regions WHERE id = 2) DAY)),
(3, 3, '2025-03-10', DATE_ADD('2025-03-10', INTERVAL (SELECT travel_duration FROM regions WHERE id = 3) DAY)),
(4, 4, '2025-03-15', DATE_ADD('2025-03-15', INTERVAL (SELECT travel_duration FROM regions WHERE id = 4) DAY)),
(5, 5, '2025-03-20', DATE_ADD('2025-03-20', INTERVAL (SELECT travel_duration FROM regions WHERE id = 5) DAY)),
(6, 6, '2025-04-01', DATE_ADD('2025-04-01', INTERVAL (SELECT travel_duration FROM regions WHERE id = 6) DAY)),
(7, 7, '2025-04-05', DATE_ADD('2025-04-05', INTERVAL (SELECT travel_duration FROM regions WHERE id = 7) DAY)),
(8, 8, '2025-04-10', DATE_ADD('2025-04-10', INTERVAL (SELECT travel_duration FROM regions WHERE id = 8) DAY)),
(9, 9, '2025-04-15', DATE_ADD('2025-04-15', INTERVAL (SELECT travel_duration FROM regions WHERE id = 9) DAY)),
(10, 10, '2025-04-20', DATE_ADD('2025-04-20', INTERVAL (SELECT travel_duration FROM regions WHERE id = 10) DAY));
