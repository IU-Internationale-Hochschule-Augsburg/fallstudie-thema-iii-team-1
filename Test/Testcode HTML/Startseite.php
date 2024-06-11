<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Übersichtsseite</title>
    <link rel="stylesheet" type="text/css" href="Source/CSS/CSS.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400;1,700&family=Raleway:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">    
</head>
<body>

    <!-- NAVIGATIONSLEISTE -->
    <nav class="header-nav">
        <a href="WD_WDMS_HTML_Index.html">
            <img src="LogoFrei.png" alt="Grundriss vom Restaurant">
        </a>
        <ul>
            <li class="active"><a href="WD_WDMS_HTML_Index.html">Home</a></li>
            <li><a href="Calendar.html">Calendar</a></li>
            <li><a href="Reservations.html">Reservations</a></li>
            <li><a href="Settings.html">Settings</a></li>
        </ul>
    </nav>

    <div class="container-main">
        <div class="boxleft">
            <h2 class="Reservierungsüberschrift">Neue Reservierung:</h2>
            <form action="#" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="uhrzeit">Uhrzeit:</label>
                    <input type="time" id="uhrzeit" name="uhrzeit" required>
                </div>
                <div class="form-group">
                    <label for="personen">Personen:</label>
                    <input type="number" id="personen" name="personen" min="1" required>
                </div>
                <div class="form-group">
                    <label for="tisch">Tisch Nummer:</label>
                    <input type="text" id="tisch" name="tisch" required>
                </div>
                <div class="form-group">
                    <label for="bearbeiter">Bearbeiter:</label>
                    <select id="bearbeiter" name="bearbeiter" required>
                        <option value="1">Tanja</option>
                        <option value="2">Tim</option>
                        <option value="3">Pascal</option>
                    </select>
                </div>
                <button type="submit">Reservierung erstellen</button>
            </form>
        </div>

        <div class="wrapper">
            <div class="container">
                <div class="tisch" onclick="selectTisch(this)">Tisch 1</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 2</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 3</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 4</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 5</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 6</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 7</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 8</div>
            </div>
        </div>
    </div>

    <script>
        let clickCount = {}; // Objekt zur Verfolgung der Klicks auf jeden Tisch

        function selectTisch(element) {
            if (!clickCount[element.textContent]) {
                clickCount[element.textContent] = 1;
            } else {
                clickCount[element.textContent]++;
            }
            toggleTischColor(element);
        }

        function toggleTischColor(element) {
            if (clickCount[element.textContent] === 1) {
                element.style.backgroundColor = 'green';
            } else if (clickCount[element.textContent] === 2) {
                element.style.backgroundColor = 'red';
            } else {
                element.style.backgroundColor = '';
                clickCount[element.textContent] = 0;
            }
        }
    </script>
</body>
</html>
