#!/usr/bin/python3

import RPi.GPIO as GPIO
import time

GPIO.setmode(GPIO.BCM)
GPIO.setup(17, GPIO.OUT, initial=GPIO.LOW)

GPIO.output(17, GPIO.HIGH)          # Allumer la LED
#time.sleep(10)  
#GPIO.cleanup()
