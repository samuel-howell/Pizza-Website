
import pymysql
import sys
import json
import random
# -------------------------------------------------------------------------------------------------------
#  an example on how to insert data into the mysql database using python
#database connection

# connection = pymysql.connect(host="localhost",user="root",passwd="",database="pizzeriadb" )
# cursor = connection.cursor()

# some other statements  with the help of cursor



# connection.commit()
# connection.close()


#  NOTE:will print out on the generateReport_page.php page, not in the console.

after_json = sys.argv[1]                    #takes in the json php array sent from the generateReport_page.php
jsonObj = json.loads(after_json)        # takes in a json string and returns a json object
jsonStr = json.dumps(after_json)      # takes in a json object and returns a string


#Formatting the JSON String into an array ---

#remove the first and last "
if jsonStr.startswith('"') and jsonStr.endswith('"'):
    jsonStr = jsonStr[1:-1]

#remove the first and last []
if jsonStr.startswith('[') and jsonStr.endswith(']'):
    jsonStr = jsonStr[1:-1]

#remove the \ escape chars
jsonStr = jsonStr.replace("\\", "")

# make a python array with all of the JSON data for easier manipulation, splitting at every },
jsonArr = jsonStr.split('},')


# replace the } that was lost in the split (necessary to make a valid JSON string)
for i in range(len(jsonArr)-1):     # its length -1 because the last } was not removed in the split bc it was not followed by a ,
    jsonArr[i] = jsonArr[i] + "}"



#PROCESS THE DARN DATA ---

deliveryCount = 0
dineinCount = 0
takeoutCount = 0




for i in range(len(jsonArr)):
    row = json.loads(jsonArr[i])            #take the JSON string (jsonArr[i]) and turn it into an object, so you can call for the individual fields in it

    #find how many of each order type there were
    if (row["order_type"] == 'delivery'):
        deliveryCount += 1
    elif (row["order_type"] == 'dinein'):
        dineinCount += 1
    elif (row["order_type"] == 'takeout'):
        takeoutCount += 1
       

# simulate how many of the takeout orders were not picked up within 30 minutes
latePickups = random.randint(0, takeoutCount)
print(latePickups)
#TODO: take this number and add an higher % charge on all of these orders


# -------------------------------------------------------------------------------------------------------

#run this in powershell to start the virtual environment
#1.  py -3 -m venv .venv
#2. .venv\scripts\activate

#  link with good information concerning python and databases-> https://tutorialslides.com/how-to-connect-and-create-database-on-mysql-phpmyadmin-using-python/ 