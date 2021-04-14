import random
import datetime

file = open("sqloutput.txt", "w")
sqlStatementList = []



def convertOrderTypeToStr(i):
    switcher = {
        1: 'delivery',
        2: 'takeout',
        3: 'dinein'
    }
    return switcher.get(i,"not a valid orderType")

def toppingType(i):
    switcher = {
        1: 'meat',
        2: 'veggie',
        3: 'cheese'
    }
    return switcher.get(i,"not a valid orderType")

def getDate():
    start_date = datetime.date(2020, 1, 1)
    end_date = datetime.date(2020, 12, 25)

    time_between_dates = end_date - start_date
    days_between_dates = time_between_dates.days
    random_number_of_days = random.randrange(days_between_dates)
    random_date = start_date + datetime.timedelta(days=random_number_of_days)

    return random_date


for x in range(20):  # change this number to get more random combinations
    quantity = random.randint(1, 100)
    orderType = random.randint(1, 3)
    topping = random.randint(1,3)
    pizza_id = random.randint(301, 900)   # we'll know that these ids were generated in the DB because they will be so big
    customer_id = random.randint(301, 900)   # we'll know that these ids were generated in the DB because they will be so big


    topping_type = toppingType(topping)
    order_type  = convertOrderTypeToStr(orderType)
    fname = ''.join(random.choice('ABCDEFGHIJKLMNOPQRSTUV') for _ in range(5))
    lname = ''.join(random.choice('ABCDEFGHIJKLMNOPQRSTUV') for _ in range(5))
    address = ''.join(random.choice('ABCDEFGHIJKLMNOPQRSTUV') for _ in range(5))
    zip = ''.join(random.choice('0123456789') for _ in range(5))


    date = getDate()

    sqlStatementList.append(
        "INSERT INTO customer (First_Name, Last_Name, Address, ZIP, id) VALUES ('" + fname + "', '" + lname + "', '" + address + "', '" + zip + "', '" + str(customer_id) + "');"
         + '\n' + 
        "INSERT INTO pizza (topping_type, id) VALUES ('" + topping_type + "', '" + str(pizza_id) + "');"
        + '\n' +
        "INSERT INTO pizza_order (order_type, order_date, quantity, pizza_id, customer_id) VALUES ('" + order_type + "', '" + str(date) + "', '" + str(quantity) + "', '" + str(pizza_id) + "', '" + str(customer_id) + "');"  
        + '\n\n'  

        )



file.writelines(sqlStatementList)