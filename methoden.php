<?php
$name = $_POST['name'];
$datum = $_POST['datum'];
$zeit = $_POST['zeit'];
$tisch = $_POST['Tisch'];

// Serverdaten
$servername = "sql11.freesqldatabase.com";
$username = "sql11700785"; // Dein Datenbank-Benutzername
$password = "restaurantteam1backend"; // Dein Datenbank-Passwort
$dbname = "sql11700785"; // Dein Datenbankname

// Verbindung erstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

// SQL-Befehl zum Einfügen der Reservierung in die Datenbank
$sql = "INSERT INTO reservierungen (name, datum, zeit, Tisch) VALUES ('$name', '$datum', '$zeit', '$tisch')";

if ($GLOBALS['conn']->query($sql) === TRUE) {
    echo "Reservierung erfolgreich gespeichert";
} else {
    echo "Fehler beim Speichern der Reservierung: " . $GLOBALS['conn']->error;
}


// Eine neue Buchung erstellen
function buchungEinfuegen($gastName, $datum, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar){
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO buchungen (gastName, datum, anzahlPersonen, id_Tisch, id_Mitarbeiter, kommentar) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiis", $gastName, $datum, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar);
    $stmt->execute();
    $stmt->close();
}

// Zu einer Buchungsnummer die Details ausgeben
function detailsAbfragen($id_Buchung){
    $sql = "SELECT * FROM buchungen WHERE id_Buchung = ".$id_Buchung.";";
    // $ql->bind_param("i", $id_Buchung);
    $result = $GLOBALS['conn']->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        return "id: " . $row["id_Buchung"]. " - Name: " . $row["gastName"]. " - Datum: " . $row["datum"]. " - Anzahl Personen: ". $row["anzahlPersonen"]. " - Tischnummer: ". $row["idTisch"]. " - eingetragen durch Mitarbeiter: ". $row["idMitarbeiter"]. " - Kommentar: ". $row["kommentar"];
        }
    }
    else {
        return "Keine Ergebnisse";
    }
}

// Eingabe von Nachname um Buchungen zu finden
function buchungSuchen($eingabe) {
    $sql = "SELECT * FROM buchungen WHERE gastName LIKE '%".$eingabe."%';";
    $result = $GLOBALS['conn']->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        return "id: " . $row["id_Buchung"]. " - Name: " . $row["gastName"]. " - Datum: " . $row["datum"];
        }
    }
    else {
        return "Keine Ergebnisse";
    }
}

// Alle Buchungen ausgeben
function allesAnzeigen() {
    $sql = "SELECT * FROM buchungen";
    $result = $GLOBALS['conn']->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        return "id: " . $row["id_Buchung"]. " - Name: " . $row["gastName"]. " - Datum: " . $row["datum"];
        }
    }
    else {
        return "Keine Ergebnisse";
    }
}

// Buchung löschen
function buchungLoeschen($id_Buchung){
    $stmt = $GLOBALS['conn']->prepare("DELETE FROM buchungen WHERE id_Buchung = ?");
    $stmt->bind_param("i", $id_Buchung);
    $stmt->execute();
    $stmt->close();
}


// Verbindung schließen
function trennen(){
    $GLOBALS['conn']->close();
}

?>