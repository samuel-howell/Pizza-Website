import mariadb
import sys  #  imported so I can use the sys.exit command

#  attempt a connection
try:
    conn = mariadb.connect(
        user = "root",
        password = "",
        host = "localhost",
        port = 3306)
except mariadb.Error as e:
    print(f"Error connecting to MariaDB Platform: {e}")
    sys.exit(1)

#  instantiate a cursor
cur = conn.cursor()

def add(cur, n, p):
    cur.execute("INSERT INTO pizzeriadb.loginform(username, password) VALUES (?, ?)", (n, p))

n = "Jaems"
p = "rinbainboa"

add(cur, n, p)