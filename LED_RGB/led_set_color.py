#!/usr/bin/python3

import RPi.GPIO as GPIO
import sys
import time

GPIO.setwarnings(False)

# Configuration des broches GPIO
RED_PIN = 17
GREEN_PIN = 27
BLUE_PIN = 22

# Initialiser la bibliothèque GPIO
GPIO.setmode(GPIO.BCM)
GPIO.setup(RED_PIN, GPIO.OUT)
GPIO.setup(GREEN_PIN, GPIO.OUT)
GPIO.setup(BLUE_PIN, GPIO.OUT)

# Initialiser le PWM pour chaque couleur
pwm_red = GPIO.PWM(RED_PIN, 100)  # 100Hz
pwm_green = GPIO.PWM(GREEN_PIN, 100)
pwm_blue = GPIO.PWM(BLUE_PIN, 100)

# Démarrer le PWM avec un rapport cyclique de 0
pwm_red.start(0)
pwm_green.start(0)
pwm_blue.start(0)

# Variable de contrôle pour la boucle
running = True

# Boucle pour maintenir le script actif tant que le bouton éteindre n'est pas pressé
while running:
    # Vérifier si le script doit éteindre les LEDs
    if len(sys.argv) > 1:
        if(sys.argv[1] == 'off'):
            # Éteindre toutes les LEDs
            GPIO.output(RED_PIN, GPIO.LOW)
            GPIO.output(GREEN_PIN, GPIO.LOW)
            GPIO.output(BLUE_PIN, GPIO.LOW)

            # Nettoyer les broches GPIO
            pwm_red.stop()
            pwm_green.stop()
            pwm_blue.stop()
            GPIO.cleanup()

            print("Lumière éteinte et GPIO nettoyées")
            running = False  # Mettre fin à la boucle
            print(running)
        else:
            # Récupérer les valeurs RGB depuis les arguments ou mettre à zéro
            red = int(sys.argv[1]) if len(sys.argv) > 1 else 0
            green = int(sys.argv[2]) if len(sys.argv) > 2 else 0
            blue = int(sys.argv[3]) if len(sys.argv) > 3 else 0


            print(f"Valeurs RGB: Rouge={red}, Vert={green}, Bleu={blue}")

            # Régler la luminosité en fonction des valeurs RGB
            pwm_red.ChangeDutyCycle(red / 255 * 100)  # Convertir en pourcentage
            pwm_green.ChangeDutyCycle(green / 255 * 100)
            pwm_blue.ChangeDutyCycle(blue / 255 * 100)


# Éteindre les LEDs et nettoyer les broches GPIO
print("Arrêt des LEDs...")
pwm_red.ChangeDutyCycle(0)
pwm_green.ChangeDutyCycle(0)
pwm_blue.ChangeDutyCycle(0)

# Arrêter le PWM et nettoyer les broches GPIO à la fin
pwm_red.stop()
pwm_green.stop()
pwm_blue.stop()
GPIO.cleanup()
