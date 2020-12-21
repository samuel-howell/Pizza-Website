<?php

//  establish connection
include "connect.php";

$sql = "SELECT * FROM loginform";
$result = $conn->query($sql);

if($result->num_rows > 0)
{
    //output data of each row
    while($row = $result->fetch_assoc())
    {
        echo "id: ". $row["id"]. " - Name: " . $row["username"]. " - password: " . $row["password"] . "<br>";
    }
}
else
{
    echo "0 results";
}

//close connection
$conn->close();
?>
