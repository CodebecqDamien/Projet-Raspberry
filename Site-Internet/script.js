function led_on(ledId) {
    var led = document.getElementById(ledId);
    led.classList.remove('off');
    led.classList.add('on');
    console.log(ledId + " allumée");

    // Envoie de la requête pour allumer la LED via Node-RED
    fetch('http://172.16.16.8:1880/controle-led', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            led: ledId,
            action: 'on'
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Réponse du serveur:', data);
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}

function led_off(ledId) {
    var led = document.getElementById(ledId);
    led.classList.remove('on');
    led.classList.add('off');
    console.log(ledId + " éteinte");

    // Envoie de la requête pour éteindre la LED via Node-RED
    fetch('http://172.16.16.8:1880/controle-led', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            led: ledId,
            action: 'off'
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Réponse du serveur:', data);
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}