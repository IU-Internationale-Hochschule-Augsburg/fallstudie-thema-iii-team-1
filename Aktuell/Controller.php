<?php

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
    
    $tischnummer = filter_input(INPUT_POST, 'tischnummer', FILTER_VALIDATE_INT);
    $datumTest = $_POST["datum"];

    require_once 'methoden.php';
    require_once 'loginMethode.php';

    // Prüfen welche Anfrage übermittelt wird (function=X / $_POST["aktion"]=X)
    $function = $_POST["function"];

    if ($function == "hello"){ 
        $anzahlPersonen = filter_input(INPUT_POST, 'anzahl', FILTER_VALIDATE_INT);
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

        if (!istDoppelteBuchung($datetime, $id_Tisch) && pruefenTischgroesse($anzahlPersonen, $id_Tisch)){
            buchungEinfuegen($gastName, $datetime, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar);
            header("Location: Test/Testcode HTML/Startseite.php?success=true");
        }
        elseif(!pruefenTischgroesse($anzahlPersonen, $id_Tisch)) {
            header("Location: Test/Testcode HTML/Startseite.php?success=false&fehler=zuKlein&name=".$gastName."&datum=".$datum."&uhrzeit=".$uhrzeit."&anzahl=".$anzahlPersonen."&tisch=".$id_Tisch."&bearbeiter=".$id_Mitarbeiter."&kommentar=".$kommentar);
        }

        elseif(istDoppelteBuchung($datetime, $id_Tisch)) {
            header("Location: Test/Testcode HTML/Startseite.php?success=false&fehler=doppelt&name=".$gastName."&datum=".$datum."&uhrzeit=".$uhrzeit."&anzahl=".$anzahlPersonen."&tisch=".$id_Tisch."&bearbeiter=".$id_Mitarbeiter."&kommentar=".$kommentar);
        }

        else{
            header("Location: Test/Testcode HTML/Startseite.php?success=false&fehler=ungueltig");
        }

        /* JSON test
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

    elseif ($function == "name"){
        $id_Mitarbeiter = filter_input(INPUT_POST, 'mitarbeiterId', FILTER_VALIDATE_INT);
        getMitarbeiternameFromId($id_Mitarbeiter);
    }

    elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["aktion"] == "login"){
        
        // Login-Daten #91
        $loginBenutzername = $_POST['username'];
        $loginPasswort = $_POST['password'];


        if (login($loginBenutzername, $loginPasswort)){
            header("Location: Test/Testcode HTML/Startseite.php");
        }
        else{
            header("Location: Test/Testcode HTML/LoginScreen.php?success=false&login=".$loginBenutzername);
        }
    }

    elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['aktion'] == 'mitarbeiter'){

        $name = $_POST['name'];
        $password = $_POST['password'];
        $adminPW = $_POST['adminPW'];

        if(login("admin", $adminPW)){
            mitarbeiterAnlegen($name, $password);
            header("Location: Test/Testcode HTML/LoginScreen.php?erstellt=true&user=".$name);
            exit();
        }
        else{
            header("Location: Test/Testcode HTML/mitarbeiterAnlegen.php?success=false");
            exit();
        }
    }

    
    
    elseif ($function=="dynamisch"){
        $anzahlP = filter_input(INPUT_POST, 'personen', FILTER_VALIDATE_INT);
        $test = pruefenTischgroesseAlle($anzahlP);
        $uhrzeit = $_POST['uhrzeit'];
        $datum = $_POST['datum'];
        $datetime = $datum." ".$uhrzeit.":00";

        foreach ($test as $zeile){
            if (istDoppelteBuchung($datetime, $zeile["id_Tisch"])){
                echo $zeile["id_Tisch"].": belegt".PHP_EOL;
                }
            else {
                    echo $zeile["id_Tisch"].": nicht belegt".PHP_EOL;
            }
        }
    }


    elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['aktion'] == 'settings'){
            
            $moVormStart = $_POST['monday-start'].":00";
            $moVormEnd = $_POST['monday-end'].":00";
            $moNachmStart = $_POST['monday-lunch-start'].":00";
            $moNachmEnd = $_POST['monday-lunch-end'].":00";

            updateSettings(0, $moVormStart, $moVormEnd, $moNachmStart, $moNachmEnd);

            $diVormStart = $_POST['tuesday-start'].":00";
            $diVormEnd = $_POST['tuesday-end'].":00";
            $diNachmStart = $_POST['tuesday-lunch-start'].":00";
            $diNachmEnd = $_POST['tuesday-lunch-end'].":00";

            updateSettings(1, $diVormStart, $diVormEnd, $diNachmStart, $diNachmEnd);

            $miVormStart = $_POST['wednesday-start'].":00";
            $miVormEnd = $_POST['wednesday-end'].":00";
            $miNachmStart = $_POST['wednesday-lunch-start'].":00";
            $miNachmEnd = $_POST['wednesday-lunch-end'].":00";

            updateSettings(2, $miVormStart, $miVormEnd, $miNachmStart, $miNachmEnd);

            $doVormStart = $_POST['thursday-start'].":00";
            $doVormEnd = $_POST['thursday-end'].":00";
            $doNachmStart = $_POST['thursday-lunch-start'].":00";
            $doNachmEnd = $_POST['thursday-lunch-end'].":00";

            updateSettings(3, $doVormStart, $doVormEnd, $doNachmStart, $doNachmEnd);

            $frVormStart = $_POST['friday-start'].":00";
            $frVormEnd = $_POST['friday-end'].":00";
            $frNachmStart = $_POST['friday-lunch-start'].":00";
            $frNachmEnd = $_POST['friday-lunch-end'].":00";

            updateSettings(4, $frVormStart, $frVormEnd, $frNachmStart, $frNachmEnd);

            $saVormStart = $_POST['saturday-start'].":00";
            $saVormEnd = $_POST['saturday-end'].":00";
            $saNachmStart = $_POST['saturday-lunch-start'].":00";
            $saNachmEnd = $_POST['saturday-lunch-end'].":00";

            updateSettings(5, $saVormStart, $saVormEnd, $saNachmStart, $saNachmEnd);

            $soVormStart = $_POST['sunday-start'].":00";
            $soVormEnd = $_POST['sunday-end'].":00";
            $soNachmStart = $_POST['sundaylunch-start'].":00";
            $soNachmEnd = $_POST['sunday-lunch-end'].":00";

            updateSettings(6, $soVormStart, $soVormEnd, $soNachmStart, $soNachmEnd);

            header("Location: Test/Testcode HTML/Settings.php?gespeichert=true");

        }


        elseif (isset($_GET['id_Wochentag'])) {
            
            $id_Wochentag = intval($_GET['id_Wochentag']);
            $data = settingsLaden($id_Wochentag);

            header('Content-Type: application/json');
            echo json_encode($data);
        }


        elseif ($function=="settingsLaden"){
            $day = $_POST['day'];
            /*
            $timeID= $_POST['timeID'];

             $hilfe="vormStart";
            if ($timeID == 2){
                $hilfe="vormEnde";
            }
            elseif ($timeID == 3){
                $hilfe="nachmStart";
            }
            elseif ($timeID == 4){
                $hilfe="nachmEnde";
            }
            */

            $data = settingsLadenEinzeln($day);

            $response = [
                'vormStart' => substr($data['vormStart'], 0, 2),
                'vormEnde' => substr($data['vormEnde'], 0, 2),
                'nachmStart' => substr($data['nachmStart'], 0, 2),
                'nachmEnde' => substr($data['nachmEnde'], 0, 2),
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        }

?>
