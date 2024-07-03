<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="stylesheet" type="text/css" href="Source/CSS/CSS.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400;1,700&family=Raleway:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">

     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riesenkalender</title>
    <style>
    body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #D1D1D1;
            margin: 0;
            flex-direction: column;
        }

        .calendar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            align-items: center;
        }

        .logo-container {
            width: 300px;
            height: auto;
            margin-bottom: 20px;
        }

        .calendar-wrapper {
            display: flex;
        }

        .calendar {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            max-width: 90%;
            text-align: center;
        }

        .month-year {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            color: #333;
        }

        .month-year select {
            padding: 5px;
            font-size: 16px;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            text-align: center;
        }

        .calendar-grid .day {
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .calendar-grid .current-day {
            background-color: #007BFF;
            color: #fff;
        }

        .calendar-grid .day:hover {
            background-color: #f0f0f0;
        }

        .date-info {
            background-color: #ffffff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: none;
            width: 300px;
            margin-left: 20px;
            align-self: flex-start; /* Ensure it aligns with the top of the calendar */
        }

        .date-info button {
    background-color: #007BFF;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.date-info button:hover {
    background-color: #0056b3;
}


        .date-info.active {
            display: block;
        }

        .date-info h3 {
            margin-top: 0;
        }

        .navigation-icons {
            font-size: 24px;
            cursor: pointer;
            color: #007BFF;
        }
    </style>

</head>
<body>
  
    <!-- NAVIGATIONSLEISTE -->
    <nav class="header-nav">
        <a href="Startseite.php">
            <img src="LogoRestaurantmitOutlineWeiß1.png" alt="Grundriss vom Restaurant">
        </a>
        <ul>
            <li><a href="Startseite.php">Home</a></li>
            <li class="active"><a href="Calendar.php">Calendar</a></li>
            <li><a href="Reservations.php">Reservations</a></li>
            <li><a href="Settings.php">Settings</a></li>
        </ul>
    </nav>

    <div class="calendar-container">
        <div class="logo-container">
            <img src="LogoRestaurantmitOutline.png" alt="Logo" width="300">
        </div>
        <div class="calendar-wrapper">
            <div class="calendar" id="calendar">
                <div class="month-year">
                    <i class="navigation-icons fas fa-chevron-left" onclick="previousMonth()"></i>
                    <div>
                        <span id="month-name">Juni</span>
                        <select id="year-select" onchange="changeYear()">
                            <option value="2023">2023</option>
                            <option value="2024" selected>2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    <i class="navigation-icons fas fa-chevron-right" onclick="nextMonth()"></i>
                </div>

                <div class="calendar-grid" id="calendar-grid">
                    <!-- Days will be populated dynamically -->
                </div>
            </div>

            <div class="date-info" id="date-info">
                <h3 id="selected-date">Selected Date</h3>
                <p id="selected-day-info">Day information goes here...</p>
                <p id="selected-day-info2">Buchungen goes here...</p>
                <!-- Tischinformationen -->
                <p id="table1">Tisch1: </p>
                <p id="table2">Tisch2: </p>
                <p id="table3">Tisch3: </p>
                <p id="table4">Tisch4: </p>
                <p id="table5">Tisch5: </p>
                <p id="table6">Tisch6: </p>
                <p id="table7">Tisch7: </p>
                <p id="table8">Tisch8: </p>
                <button onclick="closeDateInfo()">Close</button>
            </div>
        </div>
    </div>

    <script>
        const monthNames = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
        const today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();

        function generateCalendar(month, year) {
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDayOfMonth = new Date(year, month, 1).getDay();
            const grid = document.getElementById('calendar-grid');
            grid.innerHTML = '';

            for (let i = firstDayOfMonth - 1; i >= 0; i--) {
                const day = document.createElement('div');
                day.classList.add('day', 'other-month');
                day.textContent = new Date(year, month, -i).getDate();
                grid.appendChild(day);
            }

            for (let i = 1; i <= daysInMonth; i++) {
                const day = document.createElement('div');
                day.classList.add('day', 'current-month');
                if (i === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    day.classList.add('current-day');
                }
                day.textContent = i;
                day.onclick = function() {
                    selectDate(day.textContent);
                };
                grid.appendChild(day);
            }

            const totalDays = grid.children.length;
            const remainingDays = 42 - totalDays;
            for (let i = 1; i <= remainingDays; i++) {
                const day = document.createElement('div');
                day.classList.add('day', 'other-month');
                day.textContent = i;
                grid.appendChild(day);
            }
        }

        function previousMonth() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            updateCalendar();
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            updateCalendar();
        }

        function changeYear() {
            currentYear = parseInt(document.getElementById('year-select').value);
            updateCalendar();
        }

        function updateCalendar() {
            const monthName = monthNames[currentMonth];
            document.getElementById('month-name').textContent = monthName;
            generateCalendar(currentMonth, currentYear);
        }

/*
        function selectDate(day) {
            const dateInfo = document.getElementById('date-info');
            const selectedDateInfo = document.getElementById('selected-day-info');
            const selectedDateDisplay = document.getElementById('selected-date');

            const selectedDateInfo2 = document.getElementById('selected-day-info2');
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var tables = xhr.responseText.split(',');
                    selectedDateInfo2.textContent = tables[0]; // Gesamte Buchungen
                    document.getElementById('table1').textContent = "Tisch1: " + tables[1];
                    document.getElementById('table2').textContent = "Tisch2: " + tables[2];
                    document.getElementById('table3').textContent = "Tisch3: " + tables[3];
                    document.getElementById('table4').textContent = "Tisch4: " + tables[4];
                    document.getElementById('table5').textContent = "Tisch5: " + tables[5];
                    document.getElementById('table6').textContent = "Tisch6: " + tables[6];
                    document.getElementById('table7').textContent = "Tisch7: " + tables[7];
                    document.getElementById('table8').textContent = "Tisch8: " + tables[8];
                }
            };
            var formattedMonth = currentMonth + 1 < 10 ? "0" + (currentMonth + 1) : currentMonth + 1;
            xhr.open('POST', "../../Controller.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send("function=belegt2&datum=" + currentYear + "-" + formattedMonth + "-" + day);

            selectedDateDisplay.textContent = `${day}. ${monthNames[currentMonth]} ${currentYear}`;
            selectedDateInfo.textContent = `Informationen über ${day}. ${monthNames[currentMonth]} ${currentYear}:`;

            dateInfo.classList.add('active');
        }
        */

        function selectDate(day) {
            const dateInfo = document.getElementById('date-info');
            const selectedDateInfo = document.getElementById('selected-day-info');
            const selectedDateDisplay = document.getElementById('selected-date');

            const selectedDateInfo2 = document.getElementById('selected-day-info2');
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var tables = JSON.parse(xhr.responseText); // Assuming the response is JSON encoded
                    selectedDateInfo2.textContent = "Gesamte Buchungen: " + tables.totalBookings;
                    for (var i = 1; i <= 8; i++) {
                        var tableElement = document.getElementById('table' + i);
                        if (tables["table" + i]) {
                            tableElement.innerHTML = "Tisch" + i + ":<br>" + tables["table" + i].replace(/\n/g, '<br>');
                        } else {
                            tableElement.textContent = "Tisch" + i + ": Keine Buchungen";
                        }
                    }
                }
            };
            var formattedMonth = currentMonth + 1 < 10 ? "0" + (currentMonth + 1) : currentMonth + 1;
            let hilfsvariable = day;
            if (day<=9){
                hilfsvariable = "0"+day;
            }
            xhr.open('POST', "../../Controller.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send("function=belegt3&datum=" + currentYear + "-" + formattedMonth + "-" + hilfsvariable);

            selectedDateDisplay.textContent = `${day}. ${monthNames[currentMonth]} ${currentYear}`;
            selectedDateInfo.textContent = `Informationen über ${day}. ${monthNames[currentMonth]} ${currentYear}:`;

            dateInfo.classList.add('active');
        }

        function closeDateInfo() {
            const dateInfo = document.getElementById('date-info');
            dateInfo.classList.remove('active');
        }

        updateCalendar();
    </script>

</body>
</html>

