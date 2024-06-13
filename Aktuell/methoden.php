<?php

//Variablen für Daten aus Eingabefeldern
$gastName = $_POST['name'];
$datum = $_POST['datum'];
$anzahlPersonen = filter_input(INPUT_POST, 'anzahl', FILTER_VALIDATE_INT);
$id_Tisch = filter_input(INPUT_POST, 'idTisch', FILTER_VALIDATE_INT);
$id_Mitarbeiter = filter_input(INPUT_POST, 'idMitarbeiter', FILTER_VALIDATE_INT);
$kommentar = $_POST['kommentar'];

// Verbindung erstellen
require_once 'config.php'; //korrekten Unterordner angeben
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

// Eine neue Buchung erstellen #36
function buchungEinfuegen($gastName, $datum, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar){
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO buchungen (gastName, datum, anzahlPersonen, id_Tisch, id_Mitarbeiter, kommentar) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiis", $gastName, $datum, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar);

    if ($stmt->execute()== TRUE) {
        echo "Reservierung erfolgreich gespeichert";
    } else {
        echo "Fehler beim Speichern der Reservierung: " . $GLOBALS['conn']->error;
    }

    $stmt->close();
}

// Zu einer Buchungsnummer die Details ausgeben #67
function detailsAbfragen($id_Buchung){
    $sql = "SELECT * FROM buchungen WHERE id_Buchung = ".$id_Buchung.";";
    // $ql->bind_param("i", $id_Buchung);
    $result = $GLOBALS['conn']->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        return "id: " . $row["id_Buchung"]. " - Name: " . $row["gastName"]. " - Datum: " . $row["datum"]. " - Anzahl Personen: ". $row["anzahlPersonen"]. " - Tischnummer: ". $row["id_Tisch"]. " - eingetragen durch Mitarbeiter: ". $row["id_Mitarbeiter"]. " - Kommentar: ". $row["kommentar"];
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
        $Auflistung = array();
        while ($row = $result->fetch_assoc()) {
        $Auflistung[] = "id: " . $row["id_Buchung"]. " - Name: " . $row["gastName"]. " - Datum: " . $row["datum"];
        }
        return $Auflistung;
    }
    else {
        return "Keine Ergebnisse";
    }
}

// Alle Buchungen ausgeben - liefert Array, für Ausgabe Methode in Array speichern und mit $variable["Spaltenname"] zugreifen #47
function allesAnzeigen() {
    $sql = "SELECT * FROM buchungen";
    $abfrage = $GLOBALS['conn']->query($sql);
    $Ergebnisse = $abfrage->fetch_all(MYSQLI_ASSOC);
    return $Ergebnisse;
}

// Buchung löschen #41
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


// Aktuell belegte Tische anzeigen #66
function abfrageAktuellBelegt (){
    date_default_timezone_set("Europe/Berlin");

    $sql = "SELECT * FROM buchungen WHERE datum LIKE '".date("Y-m-d")." ".date("H").":%';";
    $result = $GLOBALS['conn']->query($sql);

    $TischArray = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        $TischArray[] = $row["id_Tisch"];
        }
    }
    return $TischArray;
}

// Mögliche Tische aufgrund der Personenzahl liefern #64
function abfrageTischgroesse ($anzahlPersonen){
    $sql = "SELECT id_Tisch FROM tische WHERE anzahlPlaetze >= $anzahlPersonen;";
    $result = $GLOBALS['conn']->query($sql);

    $TischArray = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        $TischArray[] = $row["id_Tisch"];
        }
    }
    return $TischArray;
}

// Überprüfung auf doppelte Buchungen #38
function istDoppelteBuchung($datum, $id_Tisch) {
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM buchungen WHERE datum = ? AND id_Tisch = ?");
    $stmt->bind_param("si", $datum, $id_Tisch);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        return true; // Doppelte Buchung gefunden
    } else {
        $stmt->close();
        return false; // Keine doppelte Buchung
    }
}

// Eine bestehende Buchung bearbeiten #40 
function buchungBearbeiten($id_Buchung, $gastName, $datum, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar) {
    $stmt = $GLOBALS['conn']->prepare("UPDATE buchungen SET gastName =  ?, datum =  ?, anzahlPersonen = ?, id_Tisch = ?, id_Mitarbeiter = ?, kommentar =  ?  WHERE id_Buchung = ?");
    $stmt->bind_param("ssiiisi", $gastName, $datum, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar, $id_Buchung);

    if ($stmt->execute()== TRUE) {
        echo "Reservierung erfolgreich bearbeitet";
    } else {
        echo "Fehler beim Bearbeiten der Reservierung: " . $GLOBALS['conn']->error;
    }

    $stmt->close();
}

?>
