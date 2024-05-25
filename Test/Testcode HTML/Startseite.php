<!DOCTYPE html>
<html lang="de">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Übersichtsseite</title>
        <link rel="stylesheet" type="text/css" href="Source/CSS/CSS.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400;1,700&family=Raleway:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    </head>

    <body>

        <!-- NAVIGATIONSLEISTE -->

        <nav class="header-nav">

            <a href="WD_WDMS_HTML_Index.html">
                <img src="LogoFrei.png" alt="Grundriss vom Restaurant">
            </a>

            <ul>
                <li class="active"><a href="WD_WDMS_HTML_Index.html">Home</a></li>
                <li ><a href="Calendar.html">Calendar</a></li>
                <li ><a href="Reservations.html">Reservations</a></li>
                <li ><a href="Settings.html">Settings</a></li>
            </ul>

        </nav>


        <div class="boxleft">
            
            <h2 class="Reservierungsüberschrift">Neue Reservierung:</h2>

<div class="formular">
            <form action="verarbeiten.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <br>
                <label for="datum">Datum:</label>
                <input type="date" id="datum" name="datum" required>
                <br>
                <label for="zeit">Zeit:</label>
                <input type="time" id="zeit" name="zeit" required>
                <br>
                <label for="tisch">Tisch:</label>
                <input type="text" id="tisch" name="tisch" required>
                <br>
                <input type="submit" value="Reservieren">
            </form>

        </div>
</div>



        <!-- HEADER BANNER-->

        <div class="wrapper">

            <div class="container">

                <div class="tisch" onclick="selectTisch(this)">Tisch 1</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 2</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 3</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 4</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 5</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 6</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 7</div>
                <div class="tisch" onclick="selectTisch(this)">Tisch 8</div>

            </div>
        </div>

        <script>
        function selectTisch(element) {
            // Alle Tische zurücksetzen
            let tische = document.querySelectorAll('.tisch');
            tische.forEach(function (tisch) {
                tisch.classList.remove('selected');
            });

            // Den ausgewählten Tisch markieren
            element.classList.add('selected');
        }
    </script>

 


        

    </body>

</html>