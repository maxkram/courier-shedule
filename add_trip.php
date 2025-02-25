<?php

require_once 'db.php';

header('Content-Type: application/json');

// Валидация входных данных
$region_id = isset($_POST['region']) ? intval($_POST['region']) : 0;
$departure_date = isset($_POST['departure_date']) ? $_POST['departure_date'] : '';
$courier_id = isset($_POST['courier_name']) ? intval($_POST['courier_name']) : 0;

if (!$region_id || !$departure_date || !$courier_id) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input.']);
    exit;
}

// Проверка существования региона
$stmt = $pdo->prepare("SELECT travel_duration FROM regions WHERE id = ?");
$stmt->execute([$region_id]);
$region = $stmt->fetch();

if (!$region) {
    http_response_code(404);
    echo json_encode(['message' => 'Region not found.']);
    exit;
}

// Расчет даты прибытия
$duration = (int)$region['travel_duration'];
$arrival_date = date('Y-m-d', strtotime($departure_date . " + $duration days"));

// Проверка наложения поездок
$stmt = $pdo->prepare("SELECT * FROM trips WHERE courier_id = ? AND (
    (departure_date <= ? AND arrival_date >= ?) OR 
    (departure_date <= ? AND arrival_date >= ?)
)");
$stmt->execute([$courier_id, $departure_date, $departure_date, $arrival_date, $arrival_date]);
$overlap = $stmt->fetch();

if ($overlap) {
    http_response_code(409);
    echo json_encode(['message' => 'Ошибка: Этот курьер уже занят в другой поездке.']);
    exit;
}

// Добавление поездки
$stmt = $pdo->prepare("INSERT INTO trips (courier_id, region_id, departure_date, arrival_date) VALUES (?, ?, ?, ?)");
if ($stmt->execute([$courier_id, $region_id, $departure_date, $arrival_date])) {
    echo json_encode(['message' => 'Поездка успешно добавлена!']);
} else {
    echo json_encode(['message' => 'Ошибка добавления поездки.']);
}
?>
