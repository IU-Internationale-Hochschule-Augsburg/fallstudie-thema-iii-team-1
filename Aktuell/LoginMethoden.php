<?php

require_once 'Backend/config.php';
$conn1 = new mysqli($servername, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn1->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn1->connect_error);
}

// Funktion zur Verarbeitung von Login-Daten 92
function login($loginBenutzername, $loginPasswort) {
    $stmt = $GLOBALS['conn1']->prepare("SELECT * FROM logins WHERE LoginName = ?");
    $stmt->bind_param("s", $loginBenutzername);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    $hashedPW = $row['password'];


    if ($result->num_rows > 0) {
       if(password_verify($loginPasswort, $hashedPW)){
            return true; // Login erfolgreich
        }
        else {
            return false;
        }
    } 
    else {
        return false; // Login fehlgeschlagen
    }
}

function mitarbeiterAnlegen($name, $password){

    $hashedPW = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $GLOBALS['conn1']->prepare("INSERT INTO logins (LoginName, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $hashedPW);
    $stmt->execute();
    $stmt->close();
}

?>
