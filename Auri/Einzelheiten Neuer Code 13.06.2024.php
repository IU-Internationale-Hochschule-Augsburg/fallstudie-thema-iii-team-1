 
// Login-Daten
$loginBenutzername = $_POST['loginBenutzername'];
$loginPasswort = $_POST['loginPasswort'];


// Funktion zur Verarbeitung von Login-Daten
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

// Beispielverwendung der Login-Funktion
if (login($loginBenutzername, $loginPasswort)) {
    echo "Login erfolgreich.";
} else {
    echo "Login fehlgeschlagen.";
}


// Beispielabfrage für Login-Daten
function getLoginDetails($username) {
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM logins WHERE benutzername = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return "Benutzername: " . $row["benutzername"] . " - Rolle: " . $row["rolle"];
    } else {
        return "Keine Login-Daten gefunden";
    }
}


// Beispielverwendung der Login-Daten-Abfrage
$loginDetails = getLoginDetails($loginBenutzername);
echo $loginDetails;