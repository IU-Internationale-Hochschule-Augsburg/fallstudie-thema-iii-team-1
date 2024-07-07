<?php

    require_once 'phpini.php';
    //session_start();

    function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    require_once 'methoden.php';
    require_once 'loginMethode.php';


    // AJAX-Requests

    // Prüfen welche Anfrage übermittelt wird (function=X)
    $function = $_POST["function"];

    if($function){

        if ($function == "hello"){ 
            $anzahlPersonen = filter_input(INPUT_POST, 'anzahl', FILTER_VALIDATE_INT);
            abfrageTischgroesse($anzahlPersonen);
        }

        elseif ($function == "belegt"){
            $tischnummer = filter_input(INPUT_POST, 'tischnummer', FILTER_VALIDATE_INT);
            $datumTest = sanitizeInput($_POST["datum"]);
            $xxx = abfrageBuchungenDatumTisch($tischnummer, $datumTest);
            foreach ($xxx as $zeile){
                echo " ".htmlspecialchars(substr($zeile["datum"], -8, 5))." Uhr: ";
                echo "ID ".htmlspecialchars($zeile["id_Buchung"]).PHP_EOL;            
            }
        }

        elseif ($function == "belegt3") {
            $datumTest = sanitizeInput($_POST['datum']);
            $tables = [];
            $totalBookings = 0;

            for ($i = 1; $i <= 8; $i++) {
                $tableBookings = abfrageBuchungenDatumTisch($i, $datumTest);
                $totalBookings += count($tableBookings);

                $bookings = [];
                foreach ($tableBookings as $zeile) {
                    $bookings[] = "Uhrzeit: " . substr($zeile["datum"], -8, 5) . " - ID: " . $zeile["id_Buchung"] . " - Personen: " . $zeile["anzahlPersonen"];
                }

                $tables["table" . $i] = implode("\n", $bookings);
            }

            $tables['totalBookings'] = $totalBookings;

            echo json_encode($tables);
        }

        elseif ($function == "update"){

            $id_Buchung = sanitizeInput($_POST['idBuchung']);
            $name = sanitizeInput($_POST['name']);
            $uhrzeit = sanitizeInput($_POST['uhrzeit']);
            $datum = sanitizeInput($_POST['datum']);
            $datetime = $datum." ".$uhrzeit.":00";
            $anzahlPersonen = filter_input(INPUT_POST, 'personen', FILTER_VALIDATE_INT);
            $id_Tisch = filter_input(INPUT_POST, 'tisch', FILTER_VALIDATE_INT);
            $kommentar = sanitizeInput($_POST['kommentar']);
            $id_Mitarbeiter = filter_input(INPUT_POST, 'bearbeiter', FILTER_VALIDATE_INT);


            if (!istDoppelteBuchungEdit($datetime, $id_Tisch, $id_Buchung) && pruefenTischgroesse($anzahlPersonen, $id_Tisch)){
                buchungBearbeiten($id_Buchung, $name, $datetime, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar); 
                echo 'Erfolgreich aktualisiert';
            }
            elseif(!pruefenTischgroesse($anzahlPersonen, $id_Tisch)) {
                echo 'Tisch zu klein';
            }
            else{
                echo 'Tisch zu dieser Zeit belegt';
            }
        }


        elseif ($function == "delete"){

            $id_Buchung = sanitizeInput($_POST['idBuchung']);

            // Buchung löschen #41
            buchungLoeschen($id_Buchung);

            echo 'Reservierung wurde gelöscht';

        }


        elseif ($function == "name"){
            $id_Mitarbeiter = filter_input(INPUT_POST, 'mitarbeiterId', FILTER_VALIDATE_INT);
            getMitarbeiternameFromId($id_Mitarbeiter);
        }


        elseif ($function == "mitarbeiterID"){
            $name = sanitizeInput($_POST['name']);
            $test = getIDfromMitarbeitername($name);
            header('Content-Type: application/json');
            echo json_encode($test);
        }

    
        elseif ($function=="dynamisch"){
            $anzahlP = filter_input(INPUT_POST, 'personen', FILTER_VALIDATE_INT);
            $test = pruefenTischgroesseAlle($anzahlP);
            $uhrzeit = sanitizeInput($_POST['uhrzeit']);
            $datum = sanitizeInput($_POST['datum']);
            $datetime = $datum." ".$uhrzeit.":00";

            foreach ($test as $zeile){
                if (istDoppelteBuchung($datetime, $zeile["id_Tisch"])){
                        echo $zeile["id_Tisch"].": belegt".PHP_EOL;
                    }
                else {
                        echo $zeile["id_Tisch"].": frei".PHP_EOL;
                }
            }
        }


        elseif ($function=="settingsLaden"){
            $day = sanitizeInput($_POST['day']);

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
        
    }

    // POST-Requests

    elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){

        if ($_POST["aktion"] == "insert"){
            $gastName = sanitizeInput($_POST['name']);
            $uhrzeit = sanitizeInput($_POST['uhrzeit']);
            $datum = sanitizeInput($_POST['datum']);
            $datetime = $datum." ".$uhrzeit.":00";
            $anzahlPersonen = filter_input(INPUT_POST, 'personen', FILTER_VALIDATE_INT);
            $id_Tisch = filter_input(INPUT_POST, 'tisch', FILTER_VALIDATE_INT);
            $kommentar = sanitizeInput($_POST['kommentar']);
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
        }


        elseif ($_POST["aktion"] == "login"){
        
            // Login-Daten #91
            $loginBenutzername = sanitizeInput($_POST['username']);
            $loginPasswort = sanitizeInput($_POST['password']);


            if (login($loginBenutzername, $loginPasswort)){
                $_SESSION["Angemeldet"] = true; 
                $_SESSION["username"] = $loginBenutzername;
                header("Location: Test/Testcode HTML/Startseite.php");
            }
            else{
                $_SESSION["Angemeldet"] = false;
                header("Location: Test/Testcode HTML/LoginScreen.php?success=false&login=".$loginBenutzername);
            }
        }


        elseif (isset($_POST['logout'])) {
            // Invalidate session
            session_unset();
            session_destroy();

            // Clear cookies
            setcookie('PHPSESSID', '', time() - 3600, '/');

            // Redirect to login page
            header('Location: Test/Testcode HTML/LoginScreen.php?logout=true');
            exit();
        }


        elseif ($_POST['aktion'] == 'mitarbeiter'){

            $name = sanitizeInput($_POST['name']);
            $password = sanitizeInput($_POST['password']);
            $adminPW = sanitizeInput($_POST['adminPW']);

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


        elseif ($_POST['aktion'] == 'settings'){
            
            $moVormStart = sanitizeInput($_POST['monday-start']).":00";
            $moVormEnd = sanitizeInput($_POST['monday-end']).":00";
            $moNachmStart = sanitizeInput($_POST['monday-lunch-start']).":00";
            $moNachmEnd = sanitizeInput($_POST['monday-lunch-end']).":00";

            updateSettings(0, $moVormStart, $moVormEnd, $moNachmStart, $moNachmEnd);

            $diVormStart = sanitizeInput($_POST['tuesday-start']).":00";
            $diVormEnd = sanitizeInput($_POST['tuesday-end']).":00";
            $diNachmStart = sanitizeInput($_POST['tuesday-lunch-start']).":00";
            $diNachmEnd = $_POST['tuesday-lunch-end'].":00";

            updateSettings(1, $diVormStart, $diVormEnd, $diNachmStart, $diNachmEnd);

            $miVormStart = sanitizeInput($_POST['wednesday-start']).":00";
            $miVormEnd = sanitizeInput($_POST['wednesday-end']).":00";
            $miNachmStart = sanitizeInput($_POST['wednesday-lunch-start']).":00";
            $miNachmEnd = sanitizeInput($_POST['wednesday-lunch-end']).":00";

            updateSettings(2, $miVormStart, $miVormEnd, $miNachmStart, $miNachmEnd);

            $doVormStart = sanitizeInput($_POST['thursday-start']).":00";
            $doVormEnd = sanitizeInput($_POST['thursday-end']).":00";
            $doNachmStart = sanitizeInput($_POST['thursday-lunch-start']).":00";
            $doNachmEnd = sanitizeInput($_POST['thursday-lunch-end']).":00";

            updateSettings(3, $doVormStart, $doVormEnd, $doNachmStart, $doNachmEnd);

            $frVormStart = sanitizeInput($_POST['friday-start']).":00";
            $frVormEnd = sanitizeInput($_POST['friday-end']).":00";
            $frNachmStart = sanitizeInput($_POST['friday-lunch-start']).":00";
            $frNachmEnd = sanitizeInput($_POST['friday-lunch-end']).":00";

            updateSettings(4, $frVormStart, $frVormEnd, $frNachmStart, $frNachmEnd);

            $saVormStart = sanitizeInput($_POST['saturday-start']).":00";
            $saVormEnd = sanitizeInput($_POST['saturday-end']).":00";
            $saNachmStart = sanitizeInput($_POST['saturday-lunch-start']).":00";
            $saNachmEnd = sanitizeInput($_POST['saturday-lunch-end']).":00";

            updateSettings(5, $saVormStart, $saVormEnd, $saNachmStart, $saNachmEnd);

            $soVormStart = sanitizeInput($_POST['sunday-start']).":00";
            $soVormEnd = sanitizeInput($_POST['sunday-end']).":00";
            $soNachmStart = sanitizeInput($_POST['sunday-lunch-start']).":00";
            $soNachmEnd = sanitizeInput($_POST['sunday-lunch-end']).":00";

            updateSettings(6, $soVormStart, $soVormEnd, $soNachmStart, $soNachmEnd);

            header("Location: Test/Testcode HTML/Settings.php?gespeichert=true");

        }

    }

    // GET-Requests

    elseif (isset($_GET['id_Wochentag'])) {
            
            $id_Wochentag = intval(sanitizeInput($_GET['id_Wochentag']));
            $data = settingsLaden($id_Wochentag);

            header('Content-Type: application/json');
            echo json_encode($data);
    }
?>
