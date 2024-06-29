<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Übersichtsseite</title>
    <link rel="stylesheet" type="text/css" href="Source/CSS/CSS.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400;1,700&family=Raleway:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">

    <style>
        .day-settings {
            display: inline-block;
            width: 13%;
            margin-right: 20px;
            margin-bottom: 20px;
        }
        .day-settings label {
            display: block;
            margin-bottom: 5px;
        }
        .day-settings input {
            margin-bottom: 10px;
        }
        .Settings {
            margin-top: 60px;
        }
        form {
            text-align: left;
        }
    </style>


  

</head>
<body>
  
    <!-- NAVIGATIONSLEISTE -->
    <nav class="header-nav">
        <a href="Startseite.php">
            <img src="LogoFrei.png" alt="Grundriss vom Restaurant">
        </a>
        <ul>
            <li><a href="Startseite.php">Home</a></li>
            <li><a href="Calendar.html">Calendar</a></li>
            <li><a href="Reservations.php">Reservations</a></li>
            <li class="active"><a href="Settings.html">Settings</a></li>
        </ul>
    </nav>

    <!-- Einstellungen -->
    <h1 class="Settings">Einstellungen</h1>
    <form id="settingsForm" action="../../Controller.php" method="post">
        <input type="hidden" id="aktion" name="aktion" value="settings">
        <!-- Montag -->
        <div class="day-settings" data-day="monday">
            <label for="monday">Montag:</label>
            <input type="time" id="0-start" name="monday-start"> bis 
            <input type="time" id="0-end" name="monday-end">
            <br>
            Mittagspause:
            <input type="time" id="0-lunch-start" name="monday-lunch-start"> bis 
            <input type="time" id="0-lunch-end" name="monday-lunch-end">
        </div>
        <!-- Dienstag -->
        <div class="day-settings" data-day="tuesday">
            <label for="tuesday">Dienstag:</label>
            <input type="time" id="1-start" name="tuesday-start"> bis 
            <input type="time" id="1-end" name="tuesday-end">
            <br>
            Mittagspause:
            <input type="time" id="1-lunch-start" name="tuesday-lunch-start"> bis 
            <input type="time" id="1-lunch-end" name="tuesday-lunch-end">
        </div>
        <!-- Mittwoch -->
        <div class="day-settings" data-day="wednesday">
            <label for="wednesday">Mittwoch:</label>
            <input type="time" id="2-start" name="wednesday-start"> bis 
            <input type="time" id="2-end" name="wednesday-end">
            <br>
            Mittagspause:
            <input type="time" id="2-lunch-start" name="wednesday-lunch-start"> bis 
            <input type="time" id="2-lunch-end" name="wednesday-lunch-end">
        </div>
        <!-- Donnerstag -->
        <div class="day-settings" data-day="thursday">
            <label for="thursday">Donnerstag:</label>
            <input type="time" id="3-start" name="thursday-start"> bis 
            <input type="time" id="3-end" name="thursday-end">
            <br>
            Mittagspause:
            <input type="time" id="3-lunch-start" name="thursday-lunch-start"> bis 
            <input type="time" id="3-lunch-end" name="thursday-lunch-end">
        </div>
        <!-- Freitag -->
        <div class="day-settings" data-day="friday">
            <label for="friday">Freitag:</label>
            <input type="time" id="4-start" name="friday-start"> bis 
            <input type="time" id="4-end" name="friday-end">
            <br>
            Mittagspause:
            <input type="time" id="4-lunch-start" name="friday-lunch-start"> bis 
            <input type="time" id="4-lunch-end" name="friday-lunch-end">
        </div>
        <!-- Samstag -->
        <div class="day-settings" data-day="saturday">
            <label for="saturday">Samstag:</label>
            <input type="time" id="5-start" name="saturday-start"> bis 
            <input type="time" id="5-end" name="saturday-end">
            <br>
            Mittagspause:
            <input type="time" id="5-lunch-start" name="saturday-lunch-start"> bis 
            <input type="time" id="5-lunch-end" name="saturday-lunch-end">
        </div>
        <!-- Sonntag -->
        <div class="day-settings" data-day="sunday">
            <label for="sunday">Sonntag:</label>
            <input type="time" id="6-start" name="sunday-start"> bis 
            <input type="time" id="6-end" name="sunday-end">
            <br>
            Mittagspause:
            <input type="time" id="6-lunch-start" name="sunday-lunch-start"> bis 
            <input type="time" id="6-lunch-end" name="sunday-lunch-end">
        </div>
        <button type="submit">Speichern</button>
    </form>
  <?php

                if (isset($_GET["gespeichert"]) && $_GET["gespeichert"]=="true"){
                    echo "<br>";    
                    echo "Erfolgreich gespeichert";
                }    
    ?>

    <script>

    function settingsLaden(element){
    var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        element.value = xhr.responseText;
                    }
                };
    xhr.open('POST', "../../Controller.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("function=settingsLaden&feld="+element.id);
    }

    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        var ids = [0, 1, 2, 3, 4, 5, 6]; // IDs to iterate through

        // Loop through each ID
        ids.forEach(function(id) {
            $.ajax({
                url: '../../Controller.php',
                type: 'GET',
                data: { id_Wochentag: id },
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        
                        var maxLength = 5; // Change this to the desired length

                        // Cut the fetched data to the specified length and populate the input fields
                        var vormStart = data.vormStart.substring(0, maxLength);
                        var vormEnde = data.vormEnde.substring(0, maxLength);
                        var nachmStart = data.nachmStart.substring(0, maxLength);
                        var nachmEnde = data.nachmEnde.substring(0, maxLength);

                        $('#'+id+'-start').val(vormStart);
                        $('#'+id+'-end').val(vormEnde);
                        $('#'+id+'-lunch-start').val(nachmStart);
                        $('#'+id+'-lunch-end').val(nachmEnde);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', status, error);
                }
            });
        });
    });
    </script>
</body>
</html>
