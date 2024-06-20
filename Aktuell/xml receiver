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
    
    $function = $_POST["function"];
    $datumTest = $_POST["datum"];

    if ($function == "hello"){ 
        abfrageTischgroesse($anzahlPersonen);
    }

    elseif ($function == "hell"){
        $xxx = abfrageAktuellBelegt($tischnummer, $datumTest);
        foreach ($xxx as $zeile){
            echo "ID Buchung: ".htmlspecialchars($zeile["id_Buchung"]);
            echo " - Uhrzeit: ".htmlspecialchars(substr($zeile["datum"], -8, 5).", ");
        }
    }
    
?>
