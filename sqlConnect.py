#!/usr/bin/python
import pymysql
db = pymysql.connect(host="localhost", user="user", passwd="password", db="school")
#create cursor
cursor = db.cursor()

cur = db.cursor()



#rows = cur.fetchall()
sql = "SELECT * FROM students"

cur.execute(sql)# execute SQL query using execute() method.

#fetch all data and print 
rows = cur.fetchall()

for row in rows:
    print(row)
#if (sql != null):
#    print("you fucked up")
# disconnect from server
db.close()
cursor.close()
