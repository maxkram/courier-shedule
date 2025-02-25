<?php
    // Подключение к базе данных
    require_once 'db.php';

    // Проверка соединения с базой данных
    if (!$pdo) {
        die("Не удалось подключиться к базе данных.");
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Расписание курьеров</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Расписание курьеров</h1>
    
    <section id="add-trip-section">
        <h2>Добавить поездку</h2>
        <!-- <form id="add-trip-form"> -->
        <form id="add-trip-form" action="add_trip.php" method="POST">
            <label for="region">Куда:</label>
            <select name="region" id="region" required>
                <?php
                // Запрос регионов из базы данных
                $stmt = $pdo->query("SELECT id, name, travel_duration FROM regions ORDER BY name ASC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                    <option value="<?= htmlspecialchars($row['id']) ?>" data-duration="<?= htmlspecialchars($row['travel_duration']) ?>">
                        <?= htmlspecialchars($row['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <br>
            <label for="departure_date">Дата отправления:</label>
            <input type="date" name="departure_date" id="departure_date" required>
            <br>
            <label for="courier_name">Имя курьера:</label>
            <select name="courier_name" id="courier_name">
                <?php
                $stmt = $pdo->query("SELECT id, full_name FROM couriers ORDER BY full_name ASC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                    <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['full_name']) ?></option>
                <?php endwhile; ?>
            </select>
            <br>
            <label for="arrival_date">Дата прибытия:</label>
            <input type="date" name="arrival_date" id="arrival_date" readonly>
            <br>
            <button type="submit">Добавить поездку</button>
        </form>
        <div id="add-trip-result"></div>
    </section>

    <hr>

    <section id="view-schedule-section">
        <h2>Посмотреть поездки</h2>
        <form id="filter-form">
            <label for="filter_date">Выбрать дату:</label>
            <input type="date" name="filter_date" id="filter_date" required>
            <button type="submit">Посмотреть расписание</button>
        </form>
        <div id="schedule-result"></div>
    </section>

    <script src="js/main.js"></script>
</body>
</html>
