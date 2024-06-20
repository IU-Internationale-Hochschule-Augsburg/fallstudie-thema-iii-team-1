<?php
    $anzahlPersonen = filter_input(INPUT_POST, 'anzahl', FILTER_VALIDATE_INT);
    $tischnummer = filter_input(INPUT_POST, 'tischnummer', FILTER_VALIDATE_INT);
    
    // Verbindung zur Datenbank herstellen
    $servername = "sql11.freesqldatabase.com";
    $username = "sql11700785"; // Dein Datenbank-Benutzername
    
    $_SERVER['PHP_AUTH_USER'] = "restaurant";
    $_SERVER['PHP_AUTH_PW'] = "passwort";
    require_once 'Config/config.php';

    $dbname = "sql11700785"; // Dein Datenbankname

    // Verbindung erstellen
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Überprüfen, ob die Verbindung erfolgreich war
    if ($conn->connect_error) {
        die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
    }
    
    function abfrageTischgroesse ($anzahlPersonen){
    $sql = "SELECT id_Tisch FROM tische WHERE anzahlPlaetze >= ".$anzahlPersonen.";";
    $result = $GLOBALS['conn']->query($sql);

    $TischArray = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        $TischArray[] = $row["id_Tisch"];
        }
    }
    print_r($TischArray);
    }

    function abfrageAktuellBelegt ($tischnummer, $datumTest){
    date_default_timezone_set("Europe/Berlin");

    $sql = "SELECT * FROM buchungen WHERE datum LIKE '".$datumTest."%' AND id_Tisch = ".$tischnummer.";";
    $abfrage = $GLOBALS['conn']->query($sql);
    $Ergebnisse = $abfrage->fetch_all(MYSQLI_ASSOC);
    return $Ergebnisse;
    }

    function buchungBearbeiten($id_Buchung, $gastName, $datum, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar) {
        $stmt = $GLOBALS['conn']->prepare("UPDATE buchungen SET gastName =  ?, datum =  ?, anzahlPersonen = ?, id_Tisch = ?, id_Mitarbeiter = ?, kommentar =  ?  WHERE id_Buchung = ?");
        $stmt->bind_param("ssiiisi", $gastName, $datum, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar, $id_Buchung);
        $stmt->execute();
        $stmt->close();
    }
    
    $function = $_POST["function"];
    $datumTest = $_POST["datum"];

    if ($function == "hello"){ 
        abfrageTischgroesse($anzahlPersonen);
    }

    elseif ($function == "belegt"){
        $xxx = abfrageAktuellBelegt($tischnummer, $datumTest);
        foreach ($xxx as $zeile){
            echo "ID Buchung: ".htmlspecialchars($zeile["id_Buchung"]);
            echo " - Uhrzeit: ".htmlspecialchars(substr($zeile["datum"], -8, 5).", ");
        }
    }

    elseif ($function == "update"){

        $id_Buchung = mysqli_real_escape_string($GLOBALS['conn'], $_POST['idBuchung']);
        $name = mysqli_real_escape_string($GLOBALS['conn'], $_POST['name']);
        $uhrzeit = mysqli_real_escape_string($GLOBALS['conn'], $_POST['uhrzeit']);
        $datum = mysqli_real_escape_string($GLOBALS['conn'], $_POST['datum']);
        $datetime = $datum." ".$uhrzeit.":00";
        $anzahlPersonen = filter_input(INPUT_POST, 'personen', FILTER_VALIDATE_INT);
        $id_Tisch = filter_input(INPUT_POST, 'tisch', FILTER_VALIDATE_INT);
        $kommentar = mysqli_real_escape_string($GLOBALS['conn'], $_POST['kommentar']);
        $id_Mitarbeiter = filter_input(INPUT_POST, 'bearbeiter', FILTER_VALIDATE_INT);

        buchungBearbeiten($id_Buchung, $name, $datetime, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar);

    }
    
?>
