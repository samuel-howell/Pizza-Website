<?php


//  assign these vars the input from the appropriate input boxes on the index.html page (the "name" in the tag)
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$address = $_POST['address'];
$zip = $_POST['zip'];

if(isset($_POST['orderType']))
{
    $orderType = $_POST['orderType'];
}

if(isset($_POST['toppingType']))
{
    $toppingType = $_POST['toppingType'];
}


if (!empty($fname)){
    if(!empty($lname)){
        if (!empty($address)){
            if(!empty($zip)){

                include "connect.php"; // use the database connection file.

                $query1 = "INSERT INTO customer (First_Name, Last_Name, Address, ZIP) VALUES ('$fname', '$lname', '$address', '$zip')";    // create a query to insert into "customer" table
                $query2 = "INSERT INTO pizza (topping_type) VALUES ('$toppingType')";
                $query3 = "INSERT INTO pizzaorder (order_type) VALUES ('$orderType')";  // why is this one line not working??!!!!

                if(mysqli_query($conn, $query3))
                {
                    echo "query 3 success";
                }
                else
                {
                   echo $orderType;
                }
                //  if query insertion is successful (mysqli_query() is an execute command basically)
                if(mysqli_query($conn, $query1) && mysqli_query($conn, $query2) )
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
                echo "<script type = 'text/javascript'>alert('zip cannot be empty'); </script>"; // display alert message over page
                die();
            }
        }
        else{
            echo "<script type = 'text/javascript'>alert('Address cannot be empty'); </script>"; // display alert message over page
            die();
        }
    }
    else{
        echo "<script type = 'text/javascript'>alert('last name cannot be empty'); </script>"; // display alert message over page
        die();
    }
}
else{
    echo "<script type = 'text/javascript'>alert('first name cannot be empty'); </script>";    
    die();
}
?>