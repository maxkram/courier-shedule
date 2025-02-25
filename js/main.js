document.addEventListener('DOMContentLoaded', function() {
    // Добавления поездки
    const regionSelect = document.getElementById('region');
    const departureDateInput = document.getElementById('departure_date');
    const arrivalDateInput = document.getElementById('arrival_date');
    // Рассчет дату прибытия
    function calculateArrivalDate() {
        const departureDate = departureDateInput.value;
        if (!departureDate) {
            arrivalDateInput.value = "";
            return;
        }
        const selectedOption = regionSelect.options[regionSelect.selectedIndex];
        const duration = parseInt(selectedOption.getAttribute('data-duration'));
        let depDate = new Date(departureDate);
        depDate.setDate(depDate.getDate() + duration);

        const year = depDate.getFullYear();
        const month = ("0" + (depDate.getMonth() + 1)).slice(-2);
        const day = ("0" + depDate.getDate()).slice(-2);
        arrivalDateInput.value = `${year}-${month}-${day}`;
    }
    // event listeners для пересчета даты прибытия
    regionSelect.addEventListener('change', calculateArrivalDate);
    departureDateInput.addEventListener('change', calculateArrivalDate);

    // отправка формы добавления поездки
    document.getElementById('add-trip-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('add_trip.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('add-trip-result').innerHTML = data.message;
        })
        .catch(error => {
            document.getElementById('add-trip-result').innerHTML = "Error: " + error;
        });
    });
    
    // отправка формы фильтрации поездок
    document.getElementById('filter-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const filterDate = document.getElementById('filter_date').value;
        if (!filterDate) {
            alert("Пожалуйста, выберите дату.");
            return;
        }
        fetch(`view_schedule.php?date=${encodeURIComponent(filterDate)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Неполадки с подключением');
            }
            return response.text();
        })
            .then(html => {
                document.getElementById('schedule-result').innerHTML = html;
            })
            .catch(error => {
                // console.error('Error:', error);
                document.getElementById('schedule-result').innerHTML = "Ошибка: " + error;
            });
    });
});
