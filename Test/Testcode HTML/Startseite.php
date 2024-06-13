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
    <style>
        .tisch {
            margin: 10px;
            padding: 20px;
            background-color: #f0f0f0;
            cursor: pointer;
            position: relative;
        }
        .text-field {
            margin-top: 10px;
        }
    </style>
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
                    <label for="datum">Datum:</label>
                    <input type="date" id="datum" name="datum" required>
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
        function selectTisch(element) {
            // Überprüfen, ob das Textfeld bereits existiert
            if (!element.nextElementSibling || !element.nextElementSibling.classList.contains('text-field')) {
                // Textfeld erstellen und einfügen
                const textField = document.createElement('textarea');
                textField.className = 'text-field';
                textField.rows = 4;
                textField.cols = 50;
                textField.placeholder = 'Informationen zum Tisch eingeben...';
                element.parentNode.insertBefore(textField, element.nextSibling);
            } else {
                // Textfeld ein- oder ausblenden
                const textField = element.nextElementSibling;
                textField.style.display = textField.style.display === 'none' ? 'block' : 'none';
            }
        }
    </script>
</body>
</html>
