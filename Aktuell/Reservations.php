<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link rel="stylesheet" type="text/css" href="Source/CSS/CSS.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400;1,700&family=Raleway:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .search-container {
            margin-bottom: 20px;
            margin-left: 10px;
        }
        .search-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            //box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
            font-size: 14px;
        }
        .table-container {
            width: 60%;
            margin-top: 20px;
            margin-left: 20px;
        }
        .buchungsTabelle {
            width: 100%;
        }
        table {
            border-collapse: collapse;
        }
        th, td {
            padding: 8px; //Abstand vom Text von der Zellenlinie
            text-align: left;
            border: 1px solid black;
            border-collapse: collapse;
        }
        th {
            background-color: #f4f4f4;
            border: 2px solid black;
        }
        #editModal {
            position: sticky;
            display: none;
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
        <li><a href="Calendar.php">Calendar</a></li>
        <li class="active"><a href="Reservations.php">Reservations</a></li>
        <li><a href="Settings.php">Settings</a></li>
    </ul>
</nav>

<div class="container-main">

    <!-- Suchleiste -->
    <div class="search-container">
        <form method="POST" action="">
            <input type="text" name="search" id="searchInput" class="search-input" placeholder="Suche nach Namen" value="<?= htmlspecialchars($searchTerm) ?>">
            <input type="submit" value="Suchen">
        </form>
    </div>

    <div class="table-container">
        <table id="buchungsTabelle">
            <thead>
                <tr>
                    <th>ID Buchung</th>
                    <th>Name</th>
                    <th>Datum</th>
                    <th>Anzahl Personen</th>
                    <th>Tisch</th>
                    <th>Bearbeiter</th>
                    <th>Kommentar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require '../../methoden.php';

                $searchTerm = ''; // Variable für den Suchbegriff

                // Prüfung, ob ein Suchbegriff eingegeben und abgesendet wurde
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
                    $searchTerm = $_POST['search']; // Suchbegriff wird in der Variable gespeichert
                }

                // Alle Buchungen werden abgerufen
                $test = allesAnzeigenAbHeute();

                // Buchungen werden überprüft, ob sie mit dem Suchbegriff übereinstimmen und nur diese werden dann angezeigt
                foreach ($test as $zeile) {
                    if ($searchTerm == '' || stripos($zeile["gastName"], $searchTerm) !== false) {
                        // Bei Doppelklick auf Zeile wird Aktion gestartet
                        echo '<tr ondblclick="editRow(this)">';
                        echo '<td>'.htmlspecialchars($zeile["id_Buchung"]).'</td>';
                        echo '<td>'.htmlspecialchars($zeile["gastName"]).'</td>';
                        echo '<td>'.htmlspecialchars(substr($zeile["datum"], 0, 16)).'</td>';
                        echo '<td>'.htmlspecialchars($zeile["anzahlPersonen"]).'</td>';
                        echo '<td>'.htmlspecialchars($zeile["id_Tisch"]).'</td>';
                        echo '<td>'.htmlspecialchars(getMitarbeiternameFromId($zeile["id_Mitarbeiter"])).'</td>';
                        echo '<td>'.htmlspecialchars($zeile["kommentar"]).'</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Formular zum Bearbeiten von Buchungen -->
    <div id="editModal">
        <form id="editForm">
            <input type="hidden" name="id_Buchung" id="id_Buchung">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name"><br>
            <label for="datum">Datum:</label>
            <input type="date" name="datum" id="datum"><br>
            <label for="uhrzeit">Uhrzeit:</label>
            <input type="time" name="uhrzeit" id="uhrzeit"><br>
            <label for="personen">Anzahl Personen:</label>
            <input type="number" name="personen" id="personen"><br>
            <label for="tisch">Tisch:</label>
            <input type="number" name="tisch" id="tisch"><br>
            <label for="bearbeiter">Bearbeiter:</label>
            <!-- <input type="number" name="bearbeiter" id="bearbeiter"><br> --->
            <select id="bearbeiter" name="bearbeiter" required>
                <option value="" disabled selected>Bitte auswählen</option>
                <option value="1">Florian</option>
                <option value="2">Aurelius</option>
                <option value="4">Tanja</option>
                <option value="5">Pascal</option>
                <option value="6">Tim</option>
            </select>
            <label for="kommentar">Kommentar:</label>
            <input name="kommentar" id="kommentar"></textarea><br>
            <input type="hidden" name="update" value="true">

            <!-- Button zum Aktualisieren -->
            <button type="button" onclick="updateData()">Aktualisieren</button>
            <button type="button" style="background-color: #F52011" onclick="buchungLoeschen()">Löschen</button>
        </form>

        <!-- Button zum Schließen des Formulars -->
        <button onclick="closeModal()">Schließen</button>
    </div>

</div>

<script>
    // Daten werden aus der Zeile ausgelesen und ins Formular eingefügt (von der Zeile, mit Doppelklick ausgewählt wurde)
    function editRow(row) {
        var cells = row.getElementsByTagName("td");
        document.getElementById("id_Buchung").value = cells[0].innerText;
        document.getElementById("name").value = cells[1].innerText;
        document.getElementById("datum").value = cells[2].innerText.split(" ")[0];
        document.getElementById("uhrzeit").value = cells[2].innerText.split(" ")[1];
        document.getElementById("personen").value = cells[3].innerText;
        document.getElementById("tisch").value = cells[4].innerText;
        //document.getElementById("bearbeiter").value =
        getMitarbeiterID(cells[5].innerText);
        document.getElementById("kommentar").value = cells[6].innerText;
        // Formular anzeigen
        document.getElementById("editModal").style.display = "block";
    }

    // Formular schließen
    function closeModal() {
        document.getElementById("editModal").style.display = "none";
    }

    // Backend
    function updateData() {
        var id_Buchung = document.getElementById("id_Buchung").value;
        var name = document.getElementById('name').value;
        var datum = document.getElementById('datum').value;
        var uhrzeit = document.getElementById('uhrzeit').value;
        var kommentar = document.getElementById('kommentar').value;
        var bearbeiter = document.getElementById('bearbeiter').value;
        var tisch = document.getElementById('tisch').value;
        var personen = document.getElementById('personen').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../../Controller.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                location.reload();
            }
        };

        var params = 'function=update&idBuchung=' + encodeURIComponent(id_Buchung) + '&name=' + encodeURIComponent(name) + '&datum=' + encodeURIComponent(datum) + '&uhrzeit=' + encodeURIComponent(uhrzeit) + '&kommentar=' + encodeURIComponent(kommentar) + '&bearbeiter=' + encodeURIComponent(bearbeiter) + '&tisch=' + encodeURIComponent(tisch) + '&personen=' + encodeURIComponent(personen);
        xhr.send(params);
    }

    function buchungLoeschen() {
        var id_Buchung = document.getElementById("id_Buchung").value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../../Controller.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                location.reload();
            }
        };

        var params = 'function=delete&idBuchung=' + encodeURIComponent(id_Buchung);
        xhr.send(params);
    }

    function getMitarbeiterID(nameTest){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById("bearbeiter").value = response;
            }
        };
        xhr.open('POST', "../../Controller.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send("function=mitarbeiterID&name=" + nameTest);
    }

</script>

</body>
</html>
