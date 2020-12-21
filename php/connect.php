<?php

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "pizzeriadb";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if(!$db)
{
    die("Connection failed: " . mysqli_connect_error());
}

?>