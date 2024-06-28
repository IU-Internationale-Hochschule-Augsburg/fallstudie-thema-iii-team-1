<?php

/*
$_SERVER['PHP_AUTH_USER'] = "restaurant";
$_SERVER['PHP_AUTH_PW'] = "passwort";

require_once 'Config/config.php';
*/

require_once 'Backend/config.php';

// Verbindung erstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}


// Überprüfung auf doppelte Buchungen #38
function istDoppelteBuchung($datum, $id_Tisch) {
    $subDate = substr($datum, 0, 10);
    $subHour = substr($datum, 11, 2);
    $subHourPlus = (int) $subHour +1;
    $subHourMinus = (int) $subHour -1;
    $subMin = substr($datum, 14, 2);

    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM buchungen WHERE id_Tisch = ? AND datum > '".$subDate." ".$subHourMinus.":".$subMin.":00' AND datum < '".$subDate." ".$subHourPlus.":".$subMin.":00';");
    $stmt->bind_param("i", $id_Tisch);
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


// Mögliche Tische werden gegen Personenzahl geprüft #64
function pruefenTischgroesse($anzahlPersonen, $id_Tisch) {

 $sql = "SELECT id_Tisch FROM tische WHERE anzahlPlaetze >= " .$anzahlPersonen ;
    $abfrage = $GLOBALS['conn']->query($sql);
    $Ergebnisse = $abfrage->fetch_all(MYSQLI_ASSOC);
 
if (in_array($id_Tisch, $Ergebnisse)) {
   return true;
} else {
   return false;
    }

}

// #69
function pruefenTischgroesseAlle($anzahlPersonen) {

 $sql = "SELECT id_Tisch FROM tische WHERE anzahlPlaetze >= " .$anzahlPersonen ;
    $abfrage = $GLOBALS['conn']->query($sql);
    $Ergebnisse = $abfrage->fetch_all(MYSQLI_ASSOC);

    return $Ergebnisse;
}

// Überprüfung auf doppelte Buchungen beim Editieren #38
function istDoppelteBuchungEdit($datum, $id_Tisch, $id_Buchung) {
    $subDate = substr($datum, 0, 10);
    $subHour = substr($datum, 11, 2);
    $subHourPlus = (int) $subHour +1;
    $subHourMinus = (int) $subHour -1;
    $subMin = substr($datum, 14, 2);

    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM buchungen WHERE id_Tisch = ? AND datum > '".$subDate." ".$subHourMinus.":".$subMin.":00' AND datum < '".$subDate." ".$subHourPlus.":".$subMin.":00' AND NOT id_Buchung = ".$id_Buchung.";");
    $stmt->bind_param("i", $id_Tisch);
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
// Eine bestehende Buchung bearbeiten #40 

function buchungBearbeiten($id_Buchung, $gastName, $datum, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar) {
        $stmt = $GLOBALS['conn']->prepare("UPDATE buchungen SET gastName =  ?, datum =  ?, anzahlPersonen = ?, id_Tisch = ?, id_Mitarbeiter = ?, kommentar =  ?  WHERE id_Buchung = ?");
        $stmt->bind_param("ssiiisi", $gastName, $datum, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar, $id_Buchung);
        $stmt->execute();
        $stmt->close();
/*
    if ($stmt->execute()== TRUE) {
        echo "Reservierung erfolgreich bearbeitet";
    } else {
        echo "Fehler beim Bearbeiten der Reservierung: " . $GLOBALS['conn']->error;
    }
*/
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

// Zu einem bestimmten Datum alle Buchungen für alle Tische zurückliefern
function abfrageBuchungenDatum($datumTest){

    $sql = "SELECT * FROM buchungen WHERE datum LIKE '".$datumTest."%' ORDER BY id_Tisch ASC, datum;";
    $abfrage = $GLOBALS['conn']->query($sql);
    $Ergebnisse = $abfrage->fetch_all(MYSQLI_ASSOC);
    return $Ergebnisse;
}

// Zu einem bestimmten Datum alle Buchungen für einen bestimmten Tisch zurückliefern
function abfrageBuchungenDatumTisch ($tischnummer, $datumTest){
    date_default_timezone_set("Europe/Berlin");

    $sql = "SELECT * FROM buchungen WHERE datum LIKE '".$datumTest."%' AND id_Tisch = ".$tischnummer." ORDER BY datum;";
    $abfrage = $GLOBALS['conn']->query($sql);
    $Ergebnisse = $abfrage->fetch_all(MYSQLI_ASSOC);
    return $Ergebnisse;
}

// Buchungen für einen Tisch vom aktuellen Tag anzeigen
function abfrageReservierungenProTisch ($tischnummer){
    date_default_timezone_set("Europe/Berlin");

    $sql = "SELECT * FROM buchungen WHERE datum LIKE '".date("Y-m-d")."%' AND id_Tisch = ".$tischnummer.";";
    $abfrage = $GLOBALS['conn']->query($sql);
    $Ergebnisse = $abfrage->fetch_all(MYSQLI_ASSOC);
    return $Ergebnisse;
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

// Bearbeitername anhand von Bearbeiternummer bekommen #100
function getMitarbeiternameFromId ($id_Mitarbeiter){
    $sql = "SELECT vorname FROM mitarbeiter WHERE id_Mitarbeiter =".$id_Mitarbeiter.";";
    $abfrage = $GLOBALS['conn']->query($sql);
    $Ergebnis = $abfrage->fetch_all(MYSQLI_ASSOC);
    echo $Ergebnis;
}

// WIP
function getIdFromMitarbeitername($bearbeiter){
    $sql = "SELECT id_Mitarbeiter FROM mitarbeiter WHERE vorname ='".$bearbeiter."';";
    $abfrage = $GLOBALS['conn']->query($sql);
    $Ergebnis = $abfrage->fetch_all(MYSQLI_ASSOC);
    return $Ergebnis;
}


?>
