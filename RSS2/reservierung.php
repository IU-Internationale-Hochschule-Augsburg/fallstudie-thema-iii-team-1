<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $guests = htmlspecialchars($_POST['guests']);

    echo "<h1>Vielen Dank für Ihre Reservierung!</h1>";
    echo "<p>Name: $name</p>";
    echo "<p>Email: $email</p>";
    echo "<p>Telefonnummer: $phone</p>";
    echo "<p>Datum: $date</p>";
    echo "<p>Uhrzeit: $time</p>";
    echo "<p>Anzahl der Gäste: $guests</p>";
} else {
    echo "<p>Etwas ist schief gelaufen. Bitte versuchen Sie es erneut.</p>";
}
?>
