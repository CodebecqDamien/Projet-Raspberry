function toggleLed(ledId, switchElement) {
    const led = document.getElementById(ledId);
    const isChecked = switchElement.checked;
    const action = isChecked ? "allumée" : "éteinte";
    const deviceName = ledId === "led1" ? "Salon" : ledId === "led2" ? "Chambre" : ledId === "led3" ? "Salle de bain" : "Cuisine";

    // Mettre à jour la LED
    led.classList.toggle("on", isChecked);
    led.classList.toggle("off", !isChecked);

    // Afficher une notification personnalisée
    showCustomNotification(`La lumière de ${deviceName} a été ${action}.`);

    // Envoyer la commande au serveur
    fetch('http://172.16.16.8:1880/controle-led', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ led: ledId, action: isChecked ? 'on' : 'off' })
    }).then(response => response.json())
      .then(data => console.log('Réponse du serveur:', data))
      .catch(error => console.error('Erreur:', error));
}

function showCustomNotification(message) {
    const container = document.getElementById("notification-container");

    const notification = document.createElement("div");
    notification.classList.add("notification");
    notification.innerText = message;

    container.appendChild(notification);

    // Supprimer la notification après 5 secondes
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

function toggleTheme() {
    // Basculer entre les classes de thème
    document.body.classList.toggle('dark-mode');
    
    // Changer l'icône selon le mode
    const icon = document.getElementById('theme-icon');
    if (document.body.classList.contains('dark-mode')) {
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
    } else {
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
    }
}

function openModal() {
    document.getElementById('helpModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('helpModal').style.display = 'none';
}
