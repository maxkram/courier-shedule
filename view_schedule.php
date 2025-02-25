<?php

require_once 'db.php';

header('Content-Type: text/html; charset=utf-8');

$filter_date = isset($_GET['date']) ? $_GET['date'] : '';

if (!$filter_date) {
    http_response_code(400);
    echo "No date specified.";
    exit;
}

// Получение данных о поездках
$stmt = $pdo->prepare("
    SELECT t.*, c.full_name, r.name AS region_name 
    FROM trips t
    JOIN couriers c ON t.courier_id = c.id
    JOIN regions r ON t.region_id = r.id
    WHERE t.departure_date = ?
    ORDER BY t.departure_date ASC
");
$stmt->execute([$filter_date]);
$trips = $stmt->fetchAll();

if (!$trips) {
    echo "No trips found for " . htmlspecialchars($filter_date);
    exit;
}

// Вывод данных в виде таблицы
echo "<h3>Trips for " . htmlspecialchars($filter_date) . ":</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr>
        <th>Courier</th>
        <th>Region</th>
        <th>Departure Date</th>
        <th>Arrival Date</th>
      </tr>";

foreach ($trips as $trip) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($trip['full_name']) . "</td>";
    echo "<td>" . htmlspecialchars($trip['region_name']) . "</td>";
    echo "<td>" . htmlspecialchars($trip['departure_date']) . "</td>";
    echo "<td>" . htmlspecialchars($trip['arrival_date']) . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
