<?php

$_SERVER['PHP_AUTH_USER'] = "restaurant";
$_SERVER['PHP_AUTH_PW'] = "passwort";

require_once 'Config/config.php';

// Verbindung erstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

// Funktionen hier einfügen...

// Such- und Filterfunktion
function sucheBuchungen($name, $datum, $tisch) {
    $sql = "SELECT * FROM buchungen WHERE 1=1";
    
    if (!empty($name)) {
        $sql .= " AND gastName LIKE '%" . $GLOBALS['conn']->real_escape_string($name) . "%'";
    }
    
    if (!empty($datum)) {
        $sql .= " AND DATE(datum) = '" . $GLOBALS['conn']->real_escape_string($datum) . "'";
    }
    
    if (!empty($tisch)) {
        $sql .= " AND id_Tisch = " . (int)$tisch;
    }
    
    $result = $GLOBALS['conn']->query($sql);
    $Ergebnisse = $result->fetch_all(MYSQLI_ASSOC);
    return $Ergebnisse;
}

// Suchanfragen verarbeiten
$searchName = isset($_POST['searchName']) ? $_POST['searchName'] : '';
$searchDate = isset($_POST['searchDate']) ? $_POST['searchDate'] : '';
$searchTisch = isset($_POST['searchTisch']) ? $_POST['searchTisch'] : '';

$suchErgebnisse = sucheBuchungen($searchName, $searchDate, $searchTisch);

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Reservations</title>
</head>
<body>

    <!-- Suchformular -->
    <form method="POST" action="reservations.php">
        <label for="searchName">Name:</label>
        <input type="text" id="searchName" name="searchName" value="<?php echo htmlspecialchars($searchName); ?>">
        
        <label for="searchDate">Datum:</label>
        <input type="date" id="searchDate" name="searchDate" value="<?php echo htmlspecialchars($searchDate); ?>">
        
        <label for="searchTisch">Tisch Nummer:</label>
        <input type="number" id="searchTisch" name="searchTisch" value="<?php echo htmlspecialchars($searchTisch); ?>">
        
        <button type="submit">Suchen</button>
    </form>

    <!-- Suchergebnisse anzeigen -->
    <h2>Suchergebnisse:</h2>
    <?php if (!empty($suchErgebnisse)) : ?>
        <ul>
            <?php foreach ($suchErgebnisse as $buchung) : ?>
                <li><?php echo "id: " . $buchung['id_Buchung'] . " - Name: " . $buchung['gastName'] . " - Datum: " . $buchung['datum'] . " - Anzahl Personen: " . $buchung['anzahlPersonen'] . " - Tischnummer: " . $buchung['id_Tisch'] . " - Mitarbeiter: " . $buchung['id_Mitarbeiter'] . " - Kommentar: " . $buchung['kommentar']; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Keine Ergebnisse gefunden.</p>
    <?php endif; ?>

</body>
</html>