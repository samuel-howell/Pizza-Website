
import pymysql
import sys
import json
import random
import numpy as np
from matplotlib import pyplot as plt
# -------------------------------------------------------------------------------------------------------
#  an example on how to insert data into the mysql database using python
#database connection

# connection = pymysql.connect(host="localhost",user="root",passwd="",database="pizzeriadb" )
# cursor = connection.cursor()

# some other statements  with the help of cursor



# connection.commit()
# connection.close()


#  NOTE:will print out on the generateReport_page.php page, not in the console.
#  TODO:  Take all of the final python data on this page and somehow toss it back to the php page as vars, so that you can format it with html and css and make it look better


after_json = sys.argv[1]                    #takes in the json php array sent from the generateReport_page.php
employee_pay = sys.argv[2]
startDate = sys.argv[3]
endDate = sys.argv[4]
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

    













#find out total orders
totalPizzasSold = totalDeliveryCount + totalDineinCount +totalTakeoutCount

# simulate how many of the takeout orders were not picked up within 30 minutes
latePickups = random.randint(0, totalTakeoutCount)    #FIXME:we don't want the program to ever simulate all takeout orders being late. so perhaps once we get a bunch of TO orders in the db we can make this random.randint(0, (totalTakeoutCount / 3))
latePickupFees = ((latePickups * 18) * .15)     # take late pickups, multiply it  by the base price of the pizza, then add 15%



#calculate delivery profits
grossDeliveryPizzaProfit = totalDeliveryCount * 21        # $18 per pizza + $3 for delivery. therefor, cost to make is $4 + topping cost
deliveryCheeseCost = deliveryCheeseCount * 2            # $2 for cheese topping
deliveryMeatCost = deliveryMeatCount * 3                # $3 for meat topping
deliveryVeggieCost = deliveryVeggieCount * 3            # $3 for veggie topping
deliveryMiscCost = totalDeliveryCount * 4               # $2 for crust, $1 for sauce, $1 for box
totalCostToMakeDelivery = deliveryCheeseCost + deliveryMeatCost + deliveryVeggieCost + deliveryMiscCost

netDeliveryPizzaProfit = grossDeliveryPizzaProfit - totalCostToMakeDelivery

#calculate takeout profits
grossTakeoutPizzaProfit = (totalTakeoutCount * 18) + latePickupFees      # $18 per pizza + the late pickup fees
takeoutCheeseCost = takeoutCheeseCount * 2            # $2 for cheese topping
takeoutMeatCost = takeoutMeatCount * 3                # $3 for meat topping
takeoutVeggieCost = takeoutVeggieCount * 3            # $3 for veggie topping
takeoutMiscCost = totalTakeoutCount * 4               # $2 for crust, $1 for sauce, $1 for box
totalCostToMakeTakeout = takeoutCheeseCost + takeoutMeatCost + takeoutVeggieCost + takeoutMiscCost

netTakeoutPizzaProfit = grossTakeoutPizzaProfit - totalCostToMakeTakeout

#TODO:calculate dinein profits
grossDineinPizzaProfit = ((totalDineinCount * 18) + ((totalDineinCount * 18) * .05))       # $18 per pizza. and there is a 5% service charge on every pizza ordered
dineinCheeseCost = dineinCheeseCount * 2            # $2 for cheese topping
dineinMeatCost = dineinMeatCount * 3                # $3 for meat topping
dineinVeggieCost = dineinVeggieCount * 3            # $3 for veggie topping
dineinMiscCost = totalDineinCount * 4               # $2 for crust, $1 for sauce, $1 for box
totalCostToMakeDinein = dineinCheeseCost + dineinMeatCost + dineinVeggieCost + dineinMiscCost

netDineinPizzaProfit = grossDineinPizzaProfit - totalCostToMakeDinein

















# make the orderType pie chart
labels = 'Delivery', 'Dine-in', 'Takeout'

deliveryWedge = totalDeliveryCount / totalPizzasSold
dineinWedge = totalDineinCount / totalPizzasSold
takeoutWedge = totalTakeoutCount / totalPizzasSold

sizes = [deliveryWedge, dineinWedge, takeoutWedge]

fig1, ax1 = plt.subplots()
ax1.pie(sizes, labels=labels, autopct='%1.1f%%',
        shadow=True, startangle=90)
ax1.axis('equal')  # Equal aspect ratio ensures that pie is drawn as a circle.
ax1.set_title("Sales between " + str(startDate) + " and " + str(endDate) + " by Order Type")

plt.savefig('C:/xampp/htdocs/Pizza Website/css/images/orderType_pie_chart.png', dpi=100) #saves an updated png pie chart that can then be called via href to show on the php or html page


# make the toppingType pie chart
labels = 'Meat', 'Cheese', 'Veggie'

meatWedge = (deliveryMeatCount + takeoutMeatCount + dineinMeatCount) / totalPizzasSold
cheeseWedge = (deliveryCheeseCount + takeoutCheeseCount + dineinCheeseCount) / totalPizzasSold
veggieWedge = (deliveryVeggieCount + takeoutVeggieCount + dineinVeggieCount) / totalPizzasSold

sizes = [meatWedge, cheeseWedge, veggieWedge]

fig1, ax1 = plt.subplots()
ax1.pie(sizes, labels=labels, autopct='%1.1f%%',
        shadow=True, startangle=90)
ax1.axis('equal')  # Equal aspect ratio ensures that pie is drawn as a circle.
ax1.set_title("Sales between " + str(startDate) + " and " + str(endDate) + " by Topping Type")

plt.savefig('C:/xampp/htdocs/Pizza Website/css/images/toppingType_pie_chart.png', dpi=100) #saves an updated png pie chart that can then be called via href to show on the php or html page





















#  print all the output  TODO:add padding maybe??? ==> https://www.w3resource.com/python/python-format.php 
print("<br><br>")


print("QUICK SUMMARY    -------------------------------------------------------------------------------------- <br><br>")

print("Total Pizzas Sold: ", (totalPizzasSold), "<br><br>")
print("Total Meat Pizzas Sold: ", (totalMeatCount), "<br>")
print("Total Cheese Pizzas Sold: ", (totalCheeseCount), "<br>")
print("Total Veggie Pizzas Sold: ", (totalVeggieCount), "<br><br>")

print("Gross Sales Figures: ${:.2f}".format(grossDeliveryPizzaProfit + grossDineinPizzaProfit + grossTakeoutPizzaProfit), "<br>")
print("Net Sales Figures: ${:.2f}".format((netDeliveryPizzaProfit + netDineinPizzaProfit + netTakeoutPizzaProfit) - int(employee_pay)), "<br><br>")

print("DELIVERY  -------------------------------------------------------------------------------------- <br><br>")

print("Total Delivery Orders: ", totalDeliveryCount, "<br>")
print("____Meat Delivery Pizzas: ", (deliveryMeatCount), "<br>")
print("____Cheese Delivery Pizzas: ", (deliveryCheeseCount), "<br>")
print("____Veggie Delivery Pizzas: ", (deliveryVeggieCount), "<br><br>")

print("Net Delivery Profit : ${:.2f}".format(netDeliveryPizzaProfit), "<br><br><br>")  #{:.2f} is formatting that rounds the float to 2 decimal places

print("TAKEOUT   -------------------------------------------------------------------------------------- <br><br>")

print('Total Takeout Orders: ', totalTakeoutCount, "<br>")
print('Late Pickup Orders: ', latePickups, "<br>")
print("____Meat Takeout Pizzas: ", (takeoutMeatCount), "<br>")
print("____Cheese Takeout Pizzas: ", (takeoutCheeseCount), "<br>")
print("____Veggie Takeout Pizzas: ", (takeoutVeggieCount), "<br><br>")

print("Net Takeout Profit : ${:.2f}".format(netTakeoutPizzaProfit), "<br><br><br>")

print("DINE-IN   -------------------------------------------------------------------------------------- <br><br>")

print("Total Dine-in Orders: ", totalDineinCount, "<br>")
print("____Meat Dine_in Pizzas: ", (dineinMeatCount), "<br>")
print("____Cheese Dine_in Pizzas: ", (dineinCheeseCount), "<br>")
print("____Veggie Dine_in Pizzas: ", (dineinVeggieCount), "<br><br>")


print("Net Dine-in Profit : ${:.2f}".format(netDineinPizzaProfit), "<br><br><br>")

print("EXPENDITURES   -------------------------------------------------------------------------------------- <br><br>")
print('Employee Pay: ${:.2f}'.format(int(employee_pay)), "<br>")
print('Delivery Costs: ${:.2f}'.format(totalCostToMakeDelivery), "<br>")
print('Takeout Costs: ${:.2f}'.format(totalCostToMakeTakeout), "<br>")
print('Dine-in Costs: ${:.2f}'.format(totalCostToMakeDinein), "<br><br>")
print("Total Expenditures: ${:.2f}".format(totalCostToMakeDelivery + totalCostToMakeTakeout + totalCostToMakeDinein + int(employee_pay)), "<br><br><br>")


print("GRAPHS   -------------------------------------------------------------------------------------- <br><br>")





# -------------------------------------------------------------------------------------------------------

#run this in powershell to start the virtual environment
#1.  py -3 -m venv .venv
#2. .venv\scripts\activate

#  link with good information concerning python and databases-> https://tutorialslides.com/how-to-connect-and-create-database-on-mysql-phpmyadmin-using-python/ 