<?php

require_once 'Config/config.php';

// Verbindung erstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

// Login-Daten
$loginBenutzername = $_POST['username'];
$loginPasswort = $_POST['password'];

// Funktion zur Verarbeitung von Login-Daten
function login($loginBenutzername, $loginPasswort) {
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM logins WHERE LoginName = ? AND password = ?");
    $stmt->bind_param("ss", $loginBenutzername, $loginPasswort);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return true; // Login erfolgreich
    } else {
        return false; // Login fehlgeschlagen
    }
}

// Login verarbeiten und Weiterleitung
if (login($loginBenutzername, $loginPasswort)) {
    // Login erfolgreich, Weiterleitung zur Startseite
    header("Location: startseite.php");
    exit();
} else {
    echo "Login fehlgeschlagen. Bitte überprüfen Sie Ihre Eingaben.";
}

?>