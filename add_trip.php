<?php

require_once 'db.php';

$region_id = isset($_POST['region']) ? intval($_POST['region']) : 0;
$departure_date = isset($_POST['departure_date']) ? $_POST['departure_date'] : '';
$courier_id = isset($_POST['courier_name']) ? intval($_POST['courier_name']) : 0;

if (!$region_id || !$departure_date || !$courier_id) {
    echo json_encode(['message' => 'Invalid input.']);
    exit;
}

$stmt = $pdo->prepare("SELECT travel_duration FROM regions WHERE id = ?");
$stmt->execute([$region_id]);
$region = $stmt->fetch();

if (!$region) {
    echo json_encode(['message' => 'Region not found.']);
    exit;
}

$duration = (int)$region['travel_duration'];

$arrival_date = date('Y-m-d', strtotime($departure_date . " + $duration days"));

$stmt = $pdo->prepare("SELECT * FROM trips WHERE courier_id = ? AND (
    (departure_date <= ? AND arrival_date >= ?) OR 
    (departure_date <= ? AND arrival_date >= ?)
)");
$stmt->execute([$courier_id, $departure_date, $departure_date, $arrival_date, $arrival_date]);
$overlap = $stmt->fetch();

if ($overlap) {
    echo json_encode(['message' => 'Error: This courier is already scheduled for another trip during this period.']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO trips (courier_id, region_id, departure_date, arrival_date) VALUES (?, ?, ?, ?)");
if ($stmt->execute([$courier_id, $region_id, $departure_date, $arrival_date])) {
    echo json_encode(['message' => 'Trip successfully added!']);
} else {
    echo json_encode(['message' => 'Error adding trip.']);
}
?>
