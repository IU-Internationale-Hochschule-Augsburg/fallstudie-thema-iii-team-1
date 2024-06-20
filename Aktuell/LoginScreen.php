<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Restaurant</title>
    <link rel="stylesheet" href="style_Login.css">
</head>
<body>

<div class="login-container">
    <form action="../../loginMethode.php" method="post" class="login-form">

        <div class="restaurant-title">
            <h1>Willkommen beim Restaurant</h1>
            <img src="https://s.tmimgcdn.com/scr/800x500/266300/restaurant-logo-illustrated-on-a-white-background_266347-original.jpg" alt="Restaurant Logo" class="logo">
        </div>
        <div class="form-group">
            <label for="username">Benutzername:</label>
            <input type="text" id="username" name="username" required 
            <?php
            if ($_GET['success'] == "false"){
                echo "value=".$_GET['login'];
            }
            ?>
            >
        </div>
        <div class="form-group">
            <label for="password">Passwort:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Anmelden</button>
        <div class="neueRegistrierung">
            <a href="neueRegistrierung.html">Noch keinen Account, dann klicke hier</a>
            </div>
    </form>
</div>

</body>
</html>