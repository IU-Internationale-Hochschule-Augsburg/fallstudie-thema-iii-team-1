<?php

require_once 'Config/config.php';


// Verbindung erstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

// Login-Daten 91
$loginBenutzername = $_POST['username'];
$loginPasswort = $_POST['password'];


// Funktion zur Verarbeitung von Login-Daten 92
function login($username, $password) {
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM logins WHERE benutzername = ? AND passwort = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return true; // Login erfolgreich
    } else {
        return false; // Login fehlgeschlagen
    }
}

?>