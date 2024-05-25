<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Reservierungssystem</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Restaurant Reservierung</h1>
        <form action="reservierung.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Telefonnummer:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="date">Datum:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Uhrzeit:</label>
            <input type="time" id="time" name="time" required>

            <label for="guests">Anzahl der Gäste:</label>
            <input type="number" id="guests" name="guests" required min="1">

            <input type="submit" value="Reservieren">
        </form>
    </div>
</body>
</html>
