<?php

$usernameError = "";
$passwordError = "";

//  assign these vars the input from the appropriate input boxes on the index.html page (the "name" in the tag)
$username = $_POST['username'];
$password = $_POST['password'];

if (!empty($username)){
    if (!empty($password))
    {

        include "connect.php"; // use the database connection file.

        $query = "INSERT INTO loginform (username, password) VALUES ('$username', '$password')";    // create a query to insert into "loginform" table

        //  if query insertion is successful
        if(mysqli_query($conn, $query))
        {
            echo "<script type = 'text/javascript'>alert('Success'); </script>"; // display alert message over page
        }

        //  if query insertion is failure
        else
        {
            echo "<script type = 'text/javascript'>alert('Failure'); </script>"; // display alert message over page
        }
        mysqli_close($conn);

    }
    else{
        echo "<script type = 'text/javascript'>alert('Password cannot be empty'); </script>"; // display alert message over page
        die();
    }

}
else{
    echo "<script type = 'text/javascript'>alert('Username cannot be empty'); </script>";    
    die();
}
?>