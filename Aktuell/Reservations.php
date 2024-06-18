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
        <a href="WD_WDMS_HTML_Index.html">
            <img src="LogoFrei.png" alt="Grundriss vom Restaurant">
        </a>
        <ul>
            <li><a href="Startseite.php">Home</a></li>
            <li><a href="Calendar.html">Calendar</a></li>
            <li class="active"><a href="Reservations.php">Reservations</a></li>
            <li><a href="Settings.html">Settings</a></li>
        </ul>
    </nav>


    <div class="container-main">

<?php
require '../../methoden.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $gastName = $_POST['name'];
    $uhrzeit = $_POST['uhrzeit'];
    $datum = $_POST['datum'];
    $datetime = $datum." ".$uhrzeit.":00";
    $datumBisStunde = $datum." ".substr($uhrzeit, 0, 2);
    $anzahlPersonen = filter_input(INPUT_POST, 'personen', FILTER_VALIDATE_INT);
    $id_Tisch = filter_input(INPUT_POST, 'tisch', FILTER_VALIDATE_INT);
    $kommentar = $_POST['kommentar'];
    $id_Mitarbeiter = filter_input(INPUT_POST, 'bearbeiter', FILTER_VALIDATE_INT);;

    if (!istDoppelteBuchung($datetime, $id_Tisch)){
    buchungEinfuegen($gastName, $datetime, $anzahlPersonen, $id_Tisch, $id_Mitarbeiter, $kommentar);
    header("Location: Startseite.php?success=true");
    }
    else {
        header("Location: Startseite.php?success=false&name=".$gastName."&datum=".$datum."&uhrzeit=".$uhrzeit."&anzahl=".$anzahlPersonen."&tisch=".$id_Tisch."&bearbeiter=".$id_Mitarbeiter."&kommentar=".$kommentar);
    }
}


echo "<br>";
echo "<br>";
$test = allesAnzeigen();
foreach ($test as $zeile){
    echo "<br> ID Buchung: ".htmlspecialchars($zeile["id_Buchung"]);
    echo " - Name: ".htmlspecialchars($zeile["gastName"]);
    echo " - Datum: ".htmlspecialchars($zeile["datum"]);
    echo " - Anzahl Personen: ".htmlspecialchars($zeile["anzahlPersonen"]);
    echo " - Tisch: ".htmlspecialchars($zeile["id_Tisch"]);
    echo " - Bearbeiter: ".htmlspecialchars($zeile["id_Mitarbeiter"]);
    echo " - Kommentar: ".htmlspecialchars($zeile["kommentar"]);
}
?>

</div>

</body>
</html>
