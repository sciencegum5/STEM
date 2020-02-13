# Import pymysql library
import pymysql
import RPi.GPIO as GPIO
import time 

#setup GPIO settings
GPIO.setmode(GPIO.BCM) 
GPIO.setwarnings(False) 
GPIO.setup(21,GPIO.OUT) 

offdata = "((1,),)" #store string to compare with asso. arry.
print("Loop starting...") #lets us know loop is running
while 0 == 0: #create a loop that will constantly check the database 
# Open database connection
    db = pymysql.connect(host="localhost", user="root", passwd="guzzo", db="gpioControl")

# Create a cursor object using cursor() method
    cur = db.cursor()

# Select desired value from the table
    sql = "SELECT toggleOne FROM led"

    # Execute sql statement
    cur.execute(sql)
    
    rows = cur.fetchall() #retrive output from the sql statement 
     
    print(rows) #show us our sql statement
    
    r = str(rows) #stringify our sql statement to compare with our offdata string
    if r == offdata: #check our data to turn off light 
        print("LED off") #show we are turning off our led in console
        GPIO.output(21,GPIO.LOW)#Turn off led here
        time.sleep(1) #Wait a bit so we dont DDOS the database
    else: #if it doesnt match turn on led
        print("LED on") 
        GPIO.output(21,GPIO.HIGH)#Turn on led here
        time.sleep(1) 

# Disconnect from server
    cur.close()
    db.close()
