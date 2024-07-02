<!DOCTYPE html>
<html>
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
        <a href="Startseite.php">
            <img src="LogoFrei.png" alt="Grundriss vom Restaurant">
        </a>
        <ul>
            <li><a href="Startseite.php">Home</a></li>
            <li><a href="Calendar.php">Calendar</a></li>
            <li class="active"><a href="Reservations.php">Reservations</a></li>
            <li><a href="Settings.html">Settings</a></li>
        </ul>
    </nav>


    <div class="container-main">



<?php
require '../../methoden.php';

$searchTerm = ''; //Variable für den Suchbegriff

//Prüfung, ob ein Ssuchbegriff eingegeben und abgesendet wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchTerm = $_POST['search']; //Suchbegriff wird in der Variable gespeichert
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    //angezeigte Buchungen werden nach dem Suchbegriff gefiltert
    $id_Buchung = $_POST['id_Buchung'];
    $gastName = $_POST['name'];
    $uhrzeit = $_POST['uhrzeit'];
    $datum = $_POST['datum'];
    $datetime = $datum." ".$uhrzeit.":00";
    $anzahlPersonen = filter_input(INPUT_POST, 'personen', FILTER_VALIDATE_INT);
    $id_Tisch = filter_input(INPUT_POST, 'tisch', FILTER_VALIDATE_INT);
    $kommentar = $_POST['kommentar'];
    $id_Mitarbeiter = filter_input(INPUT_POST, 'bearbeiter', FILTER_VALIDATE_INT);
    
    //Buchungen werden nach Suchbegriff gefiltert angezeigt
    buchungAktualisieren($id_Buchung, $gastName, $datetime, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar);
    header("Location: ".$_SERVER['PHP_SELF']);
}

//Alle Buchungen werden abgerufen
$test = allesAnzeigenAbHeute();

echo '<form method="POST" action="">';
echo '<input type="text" name="search" placeholder="Suche nach Namen" value="'.htmlspecialchars($searchTerm).'">';
echo '<input type="submit" value="Suchen">';
echo '</form>';

//Suchformular anzeigen
echo '<form method="POST" action="">';
echo '<input type="number" name="search" placeholder="Suche nach ID" value="'.htmlspecialchars($searchTerm).'">';
echo '<input type="submit" value="Suchen">';
echo '</form>';

//Buchungen in Tabellenform darstellen/anzeigen
echo '<table id="buchungstabelle" border="1">';
echo '<tr>';
echo '<th>ID Buchung</th>';
echo '<th>Name</th>';
echo '<th>Datum</th>';
echo '<th>Anzahl Personen</th>';
echo '<th>Tisch</th>';
echo '<th>Bearbeiter</th>';
echo '<th>Kommentar</th>';
echo '</tr>';

//Buchungen werden überprüft, ob sie mit dem Suchbegriff übereinstimmen und nur diese werden dann angezeigt
foreach ($test as $zeile) {
    if ($searchTerm == '' || stripos($zeile["gastName"], $searchTerm) !== false) {
        //Bei Doppelklick auf Zeile wird Aktion gestartet
        echo '<tr ondblclick="editRow(this)">';
        echo '<td>'.htmlspecialchars($zeile["id_Buchung"]).'</td>';
        echo '<td>'.htmlspecialchars($zeile["gastName"]).'</td>';
        echo '<td>'.htmlspecialchars(substr($zeile["datum"], 0, 16)).'</td>';
        echo '<td>'.htmlspecialchars($zeile["anzahlPersonen"]).'</td>';
        echo '<td>'.htmlspecialchars($zeile["id_Tisch"]).'</td>';
        echo '<td>'.htmlspecialchars($zeile["id_Mitarbeiter"]).'</td>';
        echo '<td>'.htmlspecialchars($zeile["kommentar"]).'</td>';
        echo '</tr>';
    }
}

echo '</table>';
?>

<!-- Formular zum Bearbeiten von Buchungen -->
<div id="editModal" style="display:none;">
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
        <input type="number" name="bearbeiter" id="bearbeiter"><br>
        <label for="kommentar">Kommentar:</label>
        <textarea name="kommentar" id="kommentar"></textarea><br>
        <input type="hidden" name="update" value="true">

        <!-- Button zum Aktualisieren -->
        <button type="button" onclick="updateData()">Aktualisieren</button>
        <button type="button" onclick="buchungLoeschen()">Löschen</button>
    </form>

    <!-- Button zum Schließen des Formulars -->
    <button onclick="closeModal()">Schließen</button>
</div>

<script>

//Daten werden aus der Zeile ausgelesen und ins Formular eingefügt (von der Zeile, mit Doppelklick ausgewählt wurde)
function editRow(row) {
    var cells = row.getElementsByTagName("td");
    document.getElementById("id_Buchung").value = cells[0].innerText;
    document.getElementById("name").value = cells[1].innerText;
    document.getElementById("datum").value = cells[2].innerText.split(" ")[0];
    document.getElementById("uhrzeit").value = cells[2].innerText.split(" ")[1];
    document.getElementById("personen").value = cells[3].innerText;
    document.getElementById("tisch").value = cells[4].innerText;
    document.getElementById("bearbeiter").value = cells[5].innerText;
    document.getElementById("kommentar").value = cells[6].innerText;
    //Formular anzeigen
    document.getElementById("editModal").style.display = "block";
}

//Formular schließen
function closeModal() {
    document.getElementById("editModal").style.display = "none";
}

//Backend
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

    xhr.send("function=delete&idBuchung="+ encodeURIComponent(id_Buchung));
}

</script>


</div>

</body>
</html>
