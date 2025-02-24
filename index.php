<?php
// Main page for the courier scheduling application.
?>
<!DOCTYPE html>
<html lang="utf-8">
<head>
    <meta charset="UTF-8">
    <title>Courier Schedule</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Расписание курьеров</h1>
    
    <!-- Form for adding a new trip -->
    <section id="add-trip-section">
        <h2>Добавить поездку</h2>
        <form id="add-trip-form">
            <label for="region">Куда:</label>
            <select name="region" id="region">
                <!-- The list of regions is filled from the database using PHP -->
                <?php
                require_once 'db.php';
                $stmt = $pdo->query("SELECT id, name, travel_duration FROM regions ORDER BY name ASC");
                while ($row = $stmt->fetch()):
                ?>
                    <!-- The travel_duration value is stored in a data attribute for JavaScript calculations -->
                    <option value="<?= $row['id'] ?>" data-duration="<?= $row['travel_duration'] ?>">
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
                <!-- Fill couriers from database -->
                <?php
                $stmt = $pdo->query("SELECT id, full_name FROM couriers ORDER BY full_name ASC");
                while ($row = $stmt->fetch()):
                ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['full_name']) ?></option>
                <?php endwhile; ?>
            </select>
            <br>
            <!-- The arrival date is calculated client-side based on departure date and region travel duration -->
            <label for="arrival_date">Дата прибытия:</label>
            <input type="date" name="arrival_date" id="arrival_date" readonly>
            <br>
            <button type="submit">Добавить поездку</button>
        </form>
        <div id="add-trip-result"></div>
    </section>

    <hr>

    <!-- Section for filtering and viewing trips -->
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
