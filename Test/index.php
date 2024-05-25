<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservierungssystem</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .reservierungen {
            width: 45%;
            padding: 20px;
            box-sizing: border-box;
        }
        .restaurant {
            width: 50%;
            padding: 20px;
            box-sizing: border-box;
        }
        h2 {
            margin-top: 0;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        .tisch {
            width: 80px;
            height: 80px;
            border: 1px solid #000;
            background-color: #ccc;
            margin-bottom: 10px;
            display: inline-block;
            cursor: pointer;
            text-align: center;
            line-height: 80px;
            font-weight: bold;
        }
        .tisch-besetzt {
            background-color: #ff0000; /* Rot für besetzt */
        }
    </style>
</head>
<body>
    <div class="reservierungen">
        <h2>Reservierungen</h2>
        <form action="neu 1.php" method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name"><br>
			
            <label for="datum">Datum:</label><br>
            <input type="text" id="datum" name="datum"><br>
			
            <label for="zeit">Zeit:</label><br>
            <input type="text" id="zeit" name="zeit"><br>
			
			<label for="Tisch">Tisch:</label><br>
            <input type="text" id="Tisch" name="Tisch"><br><br>
			
            <input type="submit" value="Reservierung speichern">
        </form>
        <h3>Alle Reservierungen:</h3>
        <ul>
            <?php
            // Verbindung zur Datenbank herstellen
            $servername = "sql11.freesqldatabase.com";
            $username = "sql11700785"; // Dein Datenbank-Benutzername
            $password = "restaurantteam1backend"; // Dein Datenbank-Passwort
            $dbname = "sql11700785"; // Dein Datenbankname
            $port = 3306; // Portnummer

            // Verbindung erstellen
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            // Überprüfen, ob die Verbindung erfolgreich war
            if ($conn->connect_error) {
                die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
            }
			
			$sql = "SELECT * FROM buchungen";
			$result = mysqli_query($conn, $sql);

			while($row = mysqli_fetch_assoc($result)) {
			echo "idBuchung: " . $row["id_Buchung"]. " - Name: " . $row["gastName"]. " - Datum: " . $row["datum"]. " - idTisch: " . $row["id_Tisch"]." - idMitarbeiter: " . $row["id_Mitarbeiter"]. " - Anzahl Personen: " . $row["anzahlPersonen"]. "<br> <br>";
			}

            // Verbindung schließen
            $conn->close();
			
            ?>
        </ul>
    </div>
    <div class="restaurant">
        <h2>Restaurant</h2>
        <?php
        // Ausgabe der Tische als Kästchen
        for ($i = 1; $i <= 5; $i++) {
            echo "<div class='tisch'>Tisch $i</div>";
        }
        ?>
    </div>
</body>
</html>