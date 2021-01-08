import pymysql

# -------------------------------------------------------------------------------------------------------
#  an example on how to insert data into the mysql database using python
#database connection
connection = pymysql.connect(host="localhost",user="root",passwd="",database="pizzeriadb" )
cursor = connection.cursor()
# some other statements  with the help of cursor

insert1 = "INSERT INTO loginform(username, password) VALUES ('terrygg', 'password123');"    #sql statemeent

cursor.execute(insert1)

connection.commit()
connection.close()

#  sort the orders by date (oldest to newest)
#  isolate the orders between the 2 dates specified on the HTML page 
#  put these orders in a new table
#  In that table, remove all orders that don't pertain to one of the options selected in the order type.


# -------------------------------------------------------------------------------------------------------

#run this in powershell to start the virtual environment
#1.  py -3 -m venv .venv
#2. .venv\scripts\activate

#  link with good information concerning python and databases-> https://tutorialslides.com/how-to-connect-and-create-database-on-mysql-phpmyadmin-using-python/ 