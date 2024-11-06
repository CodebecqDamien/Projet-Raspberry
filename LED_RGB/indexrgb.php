<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrôle de Lumière</title>
    <link rel="stylesheet" href="stylergb.css">
    <script>
        // Fonction pour éteindre la lumière et remettre les curseurs à 0
        function turnOff() {
            fetch('indexrgb.php?action=off')
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    
                    // Mettre à jour l'affichage de l'ampoule (noir = lumière éteinte)
                    document.getElementById('light-bulb').style.backgroundColor = `rgb(0, 0, 0)`;
                    
                    // Remettre les curseurs à 0
                    document.getElementById('red-slider').value = 0;
                    document.getElementById('green-slider').value = 0;
                    document.getElementById('blue-slider').value = 0;
                })
                .catch(error => console.error('Erreur:', error));
        }

        // Fonction pour allumer la LED à la couleur choisie
        function turnOn() {
            const red = document.getElementById('red-slider').value;
            const green = document.getElementById('green-slider').value;
            const blue = document.getElementById('blue-slider').value;
            
            fetch(`indexrgb.php?action=setColor&red=${red}&green=${green}&blue=${blue}`)
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    // Mettre à jour l'affichage de l'ampoule en fonction de la couleur choisie
                    document.getElementById('light-bulb').style.backgroundColor = `rgb(${red}, ${green}, ${blue})`;
                })
                .catch(error => console.error('Erreur:', error));
        }
    </script>
</head>
<body>

    <div class="container">
        <h1>Contrôle de la Couleur</h1>
        <div class="light-bulb" id="light-bulb" style="width: 100px; height: 100px; border: 1px solid #000;"></div>

        <h2>Modifier la couleur</h2>
        <label for="red-slider">Rouge:</label>
        <input type="range" id="red-slider" min="0" max="255" value="0" onchange="changeColor()">
        <br>
        <label for="green-slider">Vert:</label>
        <input type="range" id="green-slider" min="0" max="255" value="0" onchange="changeColor()">
        <br>
        <label for="blue-slider">Bleu:</label>
        <input type="range" id="blue-slider" min="0" max="255" value="0" onchange="changeColor()">
        <br>
        
        <!-- Bouton pour allumer la LED à la couleur choisie -->
        <button class="button on-btn" onclick="turnOn()">Allumer la LED</button>

        <!-- Bouton pour éteindre la LED -->
        <button class="button off-btn" onclick="turnOff()">Éteindre</button>
    </div>

    <?php
    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        if ($action == 'setColor') {
            // Récupérer les valeurs des couleurs
            $red = isset($_GET['red']) ? (int)$_GET['red'] : 0;
            $green = isset($_GET['green']) ? (int)$_GET['green'] : 0;
            $blue = isset($_GET['blue']) ? (int)$_GET['blue'] : 0;

            // Exécuter un script pour changer la couleur de la LED
            $command = 'sudo python3 /var/www/html/Projet-Raspberry/LED_RGB/led_set_color.py ' . $red . ' ' . $green . ' ' . $blue;
            $output = shell_exec($command);
        } 
        elseif ($action == 'off') {
            // Exécuter le script Python pour éteindre la lumière et nettoyer les broches GPIO
            $command = 'sudo python3 /var/www/html/Projet-Raspberry/LED_RGB/ledrgb_off.py';
            $output = shell_exec($command);
        } else {
            echo "<p>Action non reconnue</p>";
        }
    }
    ?>

</body>
</html>
