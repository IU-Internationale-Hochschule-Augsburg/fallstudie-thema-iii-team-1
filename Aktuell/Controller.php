<?php
    $anzahlPersonen = filter_input(INPUT_POST, 'anzahl', FILTER_VALIDATE_INT);
    $tischnummer = filter_input(INPUT_POST, 'tischnummer', FILTER_VALIDATE_INT);
    $datumTest = $_POST["datum"];

    require_once 'methoden.php';

    // Prüfen welche Anfrage übermittelt wird (function=X / $_POST["aktion"]=X)
    $function = $_POST["function"];

    if ($function == "hello"){ 
        abfrageTischgroesse($anzahlPersonen);
    }

    elseif ($function == "belegt"){
        $xxx = abfrageBuchungenDatumTisch($tischnummer, $datumTest);
        foreach ($xxx as $zeile){
            echo " ".htmlspecialchars(substr($zeile["datum"], -8, 5))." Uhr: ";
            echo "ID ".htmlspecialchars($zeile["id_Buchung"]).PHP_EOL;            
        }
    }

    elseif ($function == "belegt2"){
        
        $xxx = abfrageBuchungenDatum($datumTest);
        foreach ($xxx as $zeile){
            echo "Tisch: ".htmlspecialchars($zeile["id_Tisch"]);
            echo " - Uhrzeit: ".htmlspecialchars(substr($zeile["datum"], -8, 5));
            echo " - ID ".htmlspecialchars($zeile["id_Buchung"])." +++++ ";       
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


        if (!istDoppelteBuchungEdit($datetime, $id_Tisch, $id_Buchung)){
        buchungBearbeiten($id_Buchung, $name, $datetime, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar); 
        echo 'Erfolgreich aktualisiert';
        }
        else{
            echo 'Tisch zu dieser Zeit belegt';
        }
    }


    elseif ($function == "delete"){

        $id_Buchung = mysqli_real_escape_string($GLOBALS['conn'], $_POST['idBuchung']);

        // Buchung löschen #41
        buchungLoeschen($id_Buchung);

        echo 'Reservierung wurde gelöscht';

    }

    elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["aktion"] == "insert"){
    $gastName = $_POST['name'];
    $uhrzeit = $_POST['uhrzeit'];
    $datum = $_POST['datum'];
    $datetime = $datum." ".$uhrzeit.":00";
    $anzahlPersonen = filter_input(INPUT_POST, 'personen', FILTER_VALIDATE_INT);
    $id_Tisch = filter_input(INPUT_POST, 'tisch', FILTER_VALIDATE_INT);
    $kommentar = $_POST['kommentar'];
    $id_Mitarbeiter = filter_input(INPUT_POST, 'bearbeiter', FILTER_VALIDATE_INT);

    if (!istDoppelteBuchung($datetime, $id_Tisch)&&pruefenTischgroesse($anzahlPersonen, $id_Tisch)){
    buchungEinfuegen($gastName, $datetime, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar);
    header("Location: Test/Testcode HTML/Startseite.php?success=true");
    }
    elseif(!pruefenTischgroesse($anzahlPersonen, $id_Tisch)) {
        header("Location: Test/Testcode HTML/Startseite.php?success=false&fehler=zuKlein&name=".$gastName."&datum=".$datum."&uhrzeit=".$uhrzeit."&anzahl=".$anzahlPersonen."&tisch=".$id_Tisch."&bearbeiter=".$id_Mitarbeiter."&kommentar=".$kommentar);
 }

        else {
        header("Location: Test/Testcode HTML/Startseite.php?success=false&fehler=doppelt&name=".$gastName."&datum=".$datum."&uhrzeit=".$uhrzeit."&anzahl=".$anzahlPersonen."&tisch=".$id_Tisch."&bearbeiter=".$id_Mitarbeiter."&kommentar=".$kommentar);

        /*
        $data = array(
        'success' => false,
        'name' => $gastName,
        'datum' => $datum,
        'uhrzeit' => $uhrzeit,
        'anzahl' => $anzahlPersonen,
        'tisch' => $id_Tisch,
        'bearbeiter' => $id_Mitarbeiter,
        'kommentar' => $kommentar
        );
        $jsonData = urlencode(json_encode($data));

        header("Location: Startseite.php?data=".$jsonData);
        */
    }
}
    
?>
