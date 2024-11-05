<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrôle de Lumière</title>
    <link rel="stylesheet" href="style.css">
    <script>
        let responses = [];

        // Charger le fichier JSON une seule fois
        fetch("boutton.json")
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau lors du chargement du fichier JSON');
                }
                return response.json();
            })
            .then(data => {
                responses = data;
                console.log('Données JSON chargées:', responses);
            })
            .catch(error => console.error('Erreur lors du chargement du JSON:', error));

        // Fonction pour allumer la lumière
        function turnOn() {
            fetch('index.php?action=on')
            .then(response => response.text())
            .then(data => {
                console.log("Lumière allumée");
                document.getElementById("light-status").innerText = responses[0].message;
                document.getElementById("light-image").innerHTML = responses[0].image; // Changez la source de l'image
            });
        }
                
            
        

        // Fonction pour éteindre la lumière
        function turnOff() {
            fetch('index.php?action=off')
            .then(response => response.text())
            .then(data => {
                console.log("Lumière éteinte");
                document.getElementById("light-status").innerText = responses[1].message;
                document.getElementById("light-image").innerHTML = responses[1].image; // Changez la source de l'image
            });
        }

              
            
    </script>
</head>

<body>

    <div class="container">
        <h1>Contrôle de Lumière</h1>
        <div id="light-status"></div>
        <div id="light-image" style="font-size: 48px;"></div>
        <button class="button on-btn" onclick="turnOn()">Allumer</button>
        <button class="button off-btn" onclick="turnOff()">Éteindre</button>
    </div>
    <?php
    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        if ($action == 'on') {
            // Exécuter le script Python pour allumer la lumière
            $command = 'sudo -u www-data /var/www/html/led_on.py';
            $output = shell_exec($command);

        } elseif ($action == 'off') {
            // Exécuter le script Python pour éteindre la lumière
            $command = 'sudo -u www-data /var/www/html/led_off.py';
            $output = shell_exec($command);

        } else {
            echo "<p>Action non reconnue</p>";
        }
    }
    ?>
    


</body>
</html>