<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Restaurant</title>
    <link rel="stylesheet" href="style_Login.css">
    <!-- Einbindung von Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="login-container">
    <form action="../../Controller.php" method="post" class="login-form">
        <input type="hidden" id="aktion" name="aktion" value="login">
        <div class="restaurant-title">
            <h1>Willkommen beim Restaurant</h1>
            <img src="https://s.tmimgcdn.com/scr/800x500/266300/restaurant-logo-illustrated-on-a-white-background_266347-original.jpg" alt="Restaurant Logo" class="logo">
        </div>
        <div class="form-group">
            <label for="username">Benutzername:</label>
            <div class="input-icon">
                <i class="fa fa-user icon"></i>
                <input type="text" id="username" name="username" required 
                <?php
                if ($_GET['success'] == "false"){
                    echo "value=".$_GET['login'];
                }
                ?>
                >
            </div>
        </div>
        <div class="form-group">
            <label for="password">Passwort:</label>
            <div class="input-icon">
                <i class="fa fa-lock icon"></i>
                <input type="password" id="password" name="password" required>
            </div>
        </div>
        <button type="submit">Anmelden</button>
        <div class="neueRegistrierung">
        <br>
            <a href="neueRegistrierung.html">Noch keinen Account, dann klicke hier</a>
        </div>
    </form>

<?php
    echo "<br>";
    if ($_GET['success']=="false"){
        echo "Ungültige Eingabe";
    }
    elseif (isset($_GET['erstellt'])){
        echo "User ".$_GET['user']." wurde erstellt";
    }
    elseif ($_GET['logout'] == "true"){
        echo "Erfolgreich ausgeloggt";
    }
    elseif ($_GET['timeout'] == "true"){
        echo "Sitzung abgelaufen";
    }
?>

</div>

</body>
</html>
