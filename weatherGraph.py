#Imports
import Adafruit_DHT
import pymysql
import time
import RPi.GPIO as GPIO
print("...Loading")
GPIO.setmode(GPIO.BCM) 
GPIO.setwarnings(False) 
GPIO.setup(21,GPIO.OUT) 
print("......Loading")
prevHum = 0
prevTemp = 0
print(".........Loading")
# Loop
print("###Please note: If the code appears to stall at this point please check your sensor,")
print("if there is no output from your sensor the adafruit library wil keep retrying to read from it causing the stall")
while True:
	sensor = Adafruit_DHT.DHT11
	pin = 18
	hum, temp = Adafruit_DHT.read_retry(sensor, pin)
	if hum != None and temp != None:
		if temp != prevTemp or hum != prevHum:
			#print ("LED on") 
			print("     Humidity: " + str(hum) + "      Temperature: " + str(temp))
			print("Past Humidity: " + str(prevHum) + " Past Temperature: " + str(prevTemp))
			print()
			prevHum = hum
			prevTemp = temp
			GPIO.output(21,GPIO.HIGH) 
			#Open database connection
			db = pymysql.connect(host="192.168.0.200", user="humid", passwd="raspberry", db="gpioControl")

			#Create cursor object using cursor() method
			cur = db.cursor()
		
			#Create insert statement 
			sql = "INSERT INTO DHT (humidity,temperature) VALUES (%f,%f) "%(hum, temp)
		
			#Execute statement
			cur.execute(sql)
			db.commit()

			#Disconnect from server
			cur.close()
			db.close()
			#print ("LED off") 
			GPIO.output(21,GPIO.LOW) 
			#time.sleep(3)
		
