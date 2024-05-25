<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Willkommen</title>
</head>
<body>
    <h1>Willkommen, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Sie sind erfolgreich eingeloggt.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
