
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

totalDeliveryCount  = 0
totalDineinCount    = 0
totalTakeoutCount   = 0

totalCheeseCount    = 0
totalMeatCount      = 0
totalVeggieCount    = 0

#  specifically for delivery
deliveryCheeseCount = 0
deliveryMeatCount   = 0
deliveryVeggieCount = 0

#  specifically for dinein
dineinCheeseCount   = 0
dineinMeatCount     = 0
dineinVeggieCount   = 0

#  specifically for takeout
takeoutCheeseCount  = 0
takeoutMeatCount    = 0
takeoutVeggieCount  = 0



for i in range(len(jsonArr)):
    row = json.loads(jsonArr[i])            #take the JSON string (jsonArr[i]) and turn it into an object, so you can call for the individual fields in it
    print(jsonArr[i])
    
    #find how many of each total order type there were
    if (row["order_type"] == 'delivery'):
        totalDeliveryCount += int(row["quantity"])
    elif (row["order_type"] == 'dinein'):
        totalDineinCount += int(row["quantity"])
    elif (row["order_type"] == 'takeout'):
        totalTakeoutCount += int(row["quantity"])

    #find how many of each total pizza there were
    if (row["topping_type"] == 'cheese'):
        totalCheeseCount += int(row["quantity"])
    elif (row["topping_type"] == 'meat'):
        totalMeatCount += int(row["quantity"])
    elif (row["topping_type"] == 'veggies'):
        totalVeggieCount += int(row["quantity"])


    #find out delivery cheese
    if ((row["topping_type"] == 'cheese') and (row["order_type"] == 'delivery')):
        deliveryCheeseCount += int(row["quantity"])
    #find out delivery meat
    if ((row["topping_type"] == 'meat') and (row["order_type"] == 'delivery')):
        deliveryMeatCount += int(row["quantity"])
    #find out delivery veggie
    if ((row["topping_type"] == 'veggies') and (row["order_type"] == 'delivery')):
        deliveryVeggieCount += int(row["quantity"])



    #find out takeout cheese
    if ((row["topping_type"] == 'cheese') and (row["order_type"] == 'takeout')):
        takeoutCheeseCount += int(row["quantity"])
    #find out takeout meat
    if ((row["topping_type"] == 'meat') and (row["order_type"] == 'takeout')):
        takeoutCheeseCount += int(row["quantity"])
    #find out takeout veggie
    if ((row["topping_type"] == 'veggies') and (row["order_type"] == 'takeout')):
        takeoutVeggieCount += int(row["quantity"])



    #find out dinein cheese
    if ((row["topping_type"] == 'cheese') and (row["order_type"] == 'dinein')):
        dineinCheeseCount += int(row["quantity"])
    #find out dinein meat
    if ((row["topping_type"] == 'meat') and (row["order_type"] == 'dinein')):
        dineinMeatCount += int(row["quantity"])
    #find out dinein veggie
    if ((row["topping_type"] == 'veggies') and (row["order_type"] == 'dinein')):
        dineinVeggieCount += int(row["quantity"])



       

# simulate how many of the takeout orders were not picked up within 30 minutes
#FIXME:Add a category to the DB specifically for takeout that randomly decides if the order
# was picked up late or early.  That way, that entire quantity column is tagged for a 15% increase

latePickups = random.randint(0, (totalTakeoutCount / 3))     #TODO: take this number and add 15% order charge on all of these orders



#calculate delivery profits
grossDeliveryPizzaProfit = totalDeliveryCount * 21        # $18 per pizza + $3 for delivery. cost to make is $7 + topping cost
deliveryCheeseCost = deliveryCheeseCount * 2            # $2 for cheese topping
deliveryMeatCost = deliveryMeatCount * 3                # $3 for meat topping
deliveryVeggieCost = deliveryVeggieCount * 3            # $3 for veggie topping
deliveryMiscCost = totalDeliveryCount * 4               # $2 for crust, $1 for sauce, $1 for box
totalCostToMake = deliveryCheeseCost + deliveryMeatCost + deliveryVeggieCost + deliveryMiscCost

netDeliveryPizzaProfit = grossDeliveryPizzaProfit - totalCostToMake
print('the gross profit for delivery pizza is ', grossDeliveryPizzaProfit, ' and after fees of ', totalCostToMake, ' the net profits are ', netDeliveryPizzaProfit)

# -------------------------------------------------------------------------------------------------------

#run this in powershell to start the virtual environment
#1.  py -3 -m venv .venv
#2. .venv\scripts\activate

#  link with good information concerning python and databases-> https://tutorialslides.com/how-to-connect-and-create-database-on-mysql-phpmyadmin-using-python/ 