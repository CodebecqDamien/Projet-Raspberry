#!/usr/bin/python3

import RPi.GPIO as GPIO

# Configuration des broches GPIO
RED_PIN = 17
GREEN_PIN = 27
BLUE_PIN = 22

# Initialiser la bibliothèque GPIO
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
GPIO.setup(RED_PIN, GPIO.OUT)
GPIO.setup(GREEN_PIN, GPIO.OUT)
GPIO.setup(BLUE_PIN, GPIO.OUT)

# Initialiser le PWM pour chaque couleur
pwm_red = GPIO.PWM(RED_PIN, 100)  # 100Hz
pwm_green = GPIO.PWM(GREEN_PIN, 100)
pwm_blue = GPIO.PWM(BLUE_PIN, 100)

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
