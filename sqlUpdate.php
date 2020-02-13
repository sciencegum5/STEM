<?php
# Import pymysql library
import pymysql

# Open database connection
db = pymysql.connect(host="localhost", user="user", passwd="password", db="school")

# Create a cursor object using cursor() method
cursor = db.cursor()

cur = db.cursor()

# Select everything
sql = "UPDATE students SET age=15, gradeLevel=10 WHERE name='Bartholomew'"

# Execute sql statement
cur.execute(sql)

#rows = cur.fetchall() #request all data from rows
#for row in rows: #output all data
#	print(row)

# Disconnect from server
cur.close()
db.close()
?>