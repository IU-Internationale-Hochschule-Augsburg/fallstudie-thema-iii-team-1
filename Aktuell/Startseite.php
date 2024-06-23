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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        .info-text {
            font-size: 0.9em;
            color: #555;
            margin-top: 5px;
        }
        .refresh-button {
            position: fixed;
            bottom: 10px;
            right: 10px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            //#007BFF
            background-color: #f0f0f0;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        #uhrzeit option[disabled][selected] {
    color: gray;
}
#bearbeiter option[disabled][selected] {
    color: gray;
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
            <li class="active"><a href="Startseite.php">Home</a></li>
            <li><a href="Calendar.php">Calendar</a></li>
            <li><a href="Reservations.php">Reservations</a></li>
            <li><a href="Settings.html">Settings</a></li>
        </ul>
    </nav>

    <div class="container-main">
        <div class="boxleft">
            <h2 class="Reservierungsüberschrift">Neue Reservierung:</h2>
            <form action="../../Controller.php" method="post">
                <div class="form-group">
                    <input type="hidden" id="aktion" name="aktion" value="insert">
                    <label for="name">Name:</label>
                    <?php
                    if (isset($_GET["success"]) && $_GET["success"]=="false"){
                        echo '<input type="text" id="name" name="name" required value='.$_GET['name'].'>';
                    }
                    else {
                        echo '<input type="text" id="name" name="name" required>';
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="datum">Datum:</label>
                    <input type="date" id="datum" name="datum" required
                        <?php
                    if (isset($_GET["success"]) && $_GET["success"]=="false"){ 
                        echo 'value='.$_GET["datum"];
                        }
                    ?>
                    onchange="selectTisch2(document.getElementById('2')); selectTisch2(document.getElementById('1')); selectTisch2(document.getElementById('3')); selectTisch2(document.getElementById('4')); selectTisch2(document.getElementById('5')); selectTisch2(document.getElementById('6')); selectTisch2(document.getElementById('7')); selectTisch2(document.getElementById('8'))">
                </div>
                <div class="form-group">
                    <label for="uhrzeit">Uhrzeit:</label>
                    <select id="uhrzeit" name="uhrzeit" required>
                     <option value="" disabled selected>Bitte auswählen</option>
                    </select>
                    <div class="info-text">Bis 5 Personen wird der Tisch 1,5h reserviert, ab 5 für 2,5h</div>
                </div>
                <div class="form-group">
                    <label for="personen">Personen:</label>
                    <input type="number" id="personen" name="personen" min="1" required 
                    <?php
                    if (isset($_GET["success"]) && $_GET["success"]=="false"){ 
                        echo 'value='.$_GET["anzahl"];
                        }
                    ?>
                    >
                </div>
                <div class="form-group">
                    <label for="tisch">Tisch Nummer:</label>
                    <input type="text" id="tisch" name="tisch" required
                    <?php
                    if (isset($_GET["success"]) && $_GET["success"]=="false"){
                        echo 'value='.$_GET["tisch"];
                    }
                    ?>
                    >
                </div>
                <div class="form-group">
    <label for="bearbeiter">Bearbeiter:</label>
    <select id="bearbeiter" name="bearbeiter" required>
        <option value="" disabled selected>Bitte auswählen</option>
        <option value="1"
        <?php
        if (isset($_GET["success"]) && $_GET["success"]=="false" && $_GET["bearbeiter"] == 1){
            echo 'selected="selected"';
        }
        ?>
        >Tanja</option>
        <option value="2"
        <?php
        if (isset($_GET["success"]) && $_GET["success"]=="false" && $_GET["bearbeiter"] == 2){
            echo 'selected="selected"';
        }
        ?>
        >Tim</option>
        <option value="3"
        <?php
        if (isset($_GET["success"]) && $_GET["success"]=="false" && $_GET["bearbeiter"] == 3){
            echo 'selected="selected"';
        }
        ?>
        >Pascal</option>
    </select>
</div>

                 <div class="form-group">
                    <label for="kommentar">Kommentar:</label>
                    <input type="text" id="kommentar" name="kommentar" required
                    <?php
                    if (isset($_GET["success"]) && $_GET["success"]=="false"){
                        echo 'value='.$_GET["kommentar"];
                    }
                    ?>
                    >
                </div>
                <button type="submit">Reservierung erstellen</button>
            </form>
            <?php

                if (isset($_GET["success"]) && $_GET["success"]=="false"&& $_GET["fehler"]=="zuKlein"){
                    echo "<br>";    
                    echo "Tisch ist zu klein";
                }    

                elseif (isset($_GET["success"]) && $_GET["success"]=="false"&& $_GET["fehler"]=="doppelt"){
                    echo "<br>";    
                    echo "Tisch ist um ".$_GET["uhrzeit"]." Uhr belegt";
                }
                elseif (isset($_GET["success"]) && $_GET["success"]=="true"){
                    echo "<br>";    
                    echo "Buchung eingetragen";
                }

                
            ?>
        </div>

        <div class="wrapper">
            <div class="container">
                <div class="tisch" id="1" onclick="selectTisch(this)">Tisch 1</div>
                <div class="tisch" id="2" onclick="selectTisch(this)">Tisch 2</div>
                <div class="tisch" id="3" onclick="selectTisch(this)">Tisch 3</div>
                <div class="tisch" id="4" onclick="selectTisch(this)">Tisch 4</div>
                <div class="tisch" id="5" onclick="selectTisch(this)">Tisch 5</div>
                <div class="tisch" id="6" onclick="selectTisch(this)">Tisch 6</div>
                <div class="tisch" id="7" onclick="selectTisch(this)">Tisch 7</div>
                <div class="tisch" id="8" onclick="selectTisch(this)">Tisch 8</div>
            </div>
        </div>

       <!-- RefreshButton -->
        <button class="refresh-button" onclick="refreshPage()">
            <i class="fas fa-sync-alt"></i>
        </button>

    </div>

    <script>
    
    const today123 = new Date();
    const testest = today123.getFullYear()+"-0"+(today123.getMonth() + 1)+"-"+today123.getDate();
    

     function refreshPage() {
            location.reload();
        }

        
        function selectTisch(element) {
            // Überprüfen, ob das Textfeld bereits existiert
            let textField;
            if (!element.nextElementSibling || !element.nextElementSibling.classList.contains('text-field')) {
                // Textfeld erstellen und einfügen
                textField = document.createElement('textarea');
                textField.className = 'text-field';
                textField.rows = 4;
                textField.cols = 50;
                textField.placeholder = 'Informationen zum Tisch eingeben...';
                element.parentNode.insertBefore(textField, element.nextSibling);

            } else {
                // Textfeld ein- oder ausblenden
                textField = element.nextElementSibling;
                textField.style.display = textField.style.display === 'none' ? 'block' : 'none';
            }

            // Backend Code
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    textField.value = xhr.responseText;
                }
            };

            

            xhr.open('POST', "../../Controller.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send("function=belegt&tischnummer=" + element.id + "&datum=" + testest);
        }

        // Zweite Funktion, die bei Datumsauswahl immer alle öffnet
        function selectTisch2(element) {
            // Überprüfen, ob das Textfeld bereits existiert
            let textField;
            if (!element.nextElementSibling || !element.nextElementSibling.classList.contains('text-field')) {
                // Textfeld erstellen und einfügen
                textField = document.createElement('textarea');
                textField.className = 'text-field';
                textField.rows = 4;
                textField.cols = 50;
                textField.placeholder = 'Informationen zum Tisch eingeben...';
                element.parentNode.insertBefore(textField, element.nextSibling);

            } else {
                // Textfeld ein- oder ausblenden
                textField = element.nextElementSibling;
                textField.style.display = 'block';
            }

            // Backend Code
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    textField.value = xhr.responseText;
                }
            };
            xhr.open('POST', "../../Controller.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send("function=belegt&tischnummer=" + element.id + "&datum=" + document.getElementById('datum').value);
        }


// Funktion zur Generierung der Zeitoptionen
function generateTimeOptions() {
    const select = document.getElementById('uhrzeit');
    const times = [
        { label: 'Mittags', start: 10, end: 15 },
        { label: 'Abends', start: 15, end: 22.5 }
    ];

    times.forEach(time => {
        const optGroup = document.createElement('optgroup');
        optGroup.label = time.label;

        for (let hour = time.start; hour < time.end; hour++) {
            for (let minute = 0; minute < 60; minute += 15) {
                if (hour === Math.floor(time.end) && minute > 0) break;

                const option = document.createElement('option');
                const hourStr = String(Math.floor(hour)).padStart(2, '0');
                const minuteStr = String(minute).padStart(2, '0');
                option.value = `${hourStr}:${minuteStr}`;
                option.text = `${hourStr}:${minuteStr}`;
                optGroup.appendChild(option);
            }
        }

        select.appendChild(optGroup);
    });

    // Entferne das selected Attribut von allen Optionen
    Array.from(select.options).forEach(option => {
        option.removeAttribute('selected');
    });
}

// Zeitoptionen generieren, wenn das Dokument geladen ist
document.addEventListener('DOMContentLoaded', function() {
    generateTimeOptions();
    // Setze das Uhrzeit-Feld auf leer, indem die erste Option ausgewählt wird
    document.getElementById('uhrzeit').selectedIndex = 0;
});


    </script>

</body>
</html>
