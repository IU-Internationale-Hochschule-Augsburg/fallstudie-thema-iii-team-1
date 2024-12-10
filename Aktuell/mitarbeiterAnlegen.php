<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Restaurant</title>
    <link rel="stylesheet" href="style_Login.css">
</head>
<body>

<div class="mitarbeiterAnlegen">
    <form action="../../Controller.php" method="post">
        <div class="restaurant-title">
            <h1>Neuen Website-User erstellen</h1>
        </div>
        <input type="hidden" id="aktion" name="aktion" value="mitarbeiter">
        <div class="form-group">
            <label for="name">User-Name:</label>
            <input type="text" id="name" name="name" required>  
        </div>
        <div class="form-group">
            <label for="password">User-Passwort:</label>
            <input type="text" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="adminPW">Admin-Passwort</label>
            <input type="text" id="adminPW" name="adminPW" required>
        </div>
        <button type="submit">Zugang erstellen</button>
        
    </form>

    <?php
    if(isset($_GET['success'])&& $_GET['success'] == "false"){
        echo "<br>";
        echo "Ungültiges Admin-Passwort - User konnte nicht erstellt werden";
    }
    ?>
</div>



</body>
</html>


