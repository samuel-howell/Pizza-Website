<?php
        
$username = $_POST['username'];
$password = $_POST['password'];

if (!empty($username)){
    if (!empty($password))
    {
    //     // default configuration
    //     $host = "localhost";
    //     $dbusername = "root";
    //     $dbpassword = "";
    //     $dbname = "pizzeriadb";

    //     //  create a connection
    //     $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
        
    // //  handles if the connection fails
    //     if ($conn->connect_error)
    //     {
    //         die('Connection failed : '.$conn->connect_error);
    //     }
    //     else
    //     {

        include "connect.php"; // use the database connection file.
            $stmt = $conn->prepare("insert into loginform(username, password) 
            values(?, ?)");
            //the s stands for string. tells me to bind the username value (of string type) to database?
            $stmt->bind_param("ss",$username, $password);
            $stmt->execute();
            echo "registration successful";
            $stmt->close();
            $conn->close();
        //   }
    }
    else{
        echo "Password should not be empty";
        die();
    }

}
else{
    echo "Username should not be empty";
    die();
}
?>