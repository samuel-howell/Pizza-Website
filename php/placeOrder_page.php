<?php

// input validation function for the form data put in by the user
function test_input($data) {
    $data = trim($data);                //  strip whitespace from beginning and end
    $data = stripslashes($data);        //  unquotes a quoted string
    $data = htmlspecialchars($data);    //  converts special characters to HTML entities, thereby breaking their purpose if used maliciously
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//  assign these vars the input from the appropriate input boxes on the index.html page (the "name" in the tag)
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$address = $_POST['address'];
$zip = $_POST['zip'];
$quantity = $_POST['quantity'];
$date = $_POST['date'];
}

//  these two issets make sure that the user has selected something from the dropdowns
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
            if(!empty($zip) && is_numeric($zip)){
                if(!empty($quantity) && is_numeric($quantity)){
                    if(!empty($date)){

                        include "connect.php"; // use the database connection file.
                        
                        //TODO: Find out why you can't create foreign key relationships in the phpmyadmin console

                        ////////////////////////////////////////////////////////////   Adding the customer and pizza IDs from their tables to the pizza_order table   ///////////////////////////////////////////////

                        $cSql = "SELECT * FROM customer ORDER BY id DESC LIMIT 1";    // gets the latest row in the customer id table
                        $cResult = $conn->query($cSql);
                        $customerID_fk = $cResult->fetch_array()['id'] ?? '';       // gets the cell in the id column in the last row
                        $customerID_fk++;                                           //  we have to +1, because technically customerID_fk is read BEFORE the latest customer is added

                        $pSql = "SELECT * FROM pizza ORDER BY id DESC LIMIT 1";       // gets the latest row in the pizza table 
                        $pResult = $conn->query($pSql);
                        $pizzaID_fk = $pResult->fetch_array()['id'] ?? '';       // gets the id column in the last row
                        $pizzaID_fk++;                                           //  we have to +1, because technically pizzaID_fk is read BEFORE the latest pizza is added

                        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                        //TODO: Make sure to rebuild the tables at some point to reset all the auto-increments to 0
                        $query1 = "INSERT INTO customer (First_Name, Last_Name, Address, ZIP) VALUES ('$fname', '$lname', '$address', '$zip')";    // create a query to insert into "customer" table
                        $query2 = "INSERT INTO pizza (topping_type) VALUES ('$toppingType')";
                        $query3 = "INSERT INTO pizza_order (order_type, customer_id, pizza_id, order_date, quantity) VALUES ('$orderType', '$customerID_fk', '$pizzaID_fk', '$date', '$quantity')";


                        //  if every query insertion is successful... (mysqli_query() is an execute command basically)
                        if(mysqli_query($conn, $query1) && mysqli_query($conn, $query2) && mysqli_query($conn, $query3))
                        {
                            echo "<script type = 'text/javascript'>alert('Success'); </script>"; // display alert message over page
                            echo $pizzaID_fk;

                        }

                        //  if query insertion is failure
                        else
                        {
                            echo "<script type = 'text/javascript'>alert('Failure'); </script>"; // display alert message over page

                        
                        }
                        mysqli_close($conn);
                        header('Refresh: .1; URL=http://localhost/Pizza%20Website/HTML/transitional_page.html');  //TODO: Figure out a way to know whether to switch back to transitional_page (for manager) or eTransitional_page (for employee)   
                    }
                    else{
                        echo "<script type = 'text/javascript'>alert('date cannot be empty'); </script>"; // display alert message over page
                        header('Refresh: .1; URL=http://localhost/Pizza%20Website/HTML/placeOrder_page.html'); //  redirects to the same  page to try again after .1 second(so it can show the failure message)    
                        die();
                    }
                }
                else{
                    echo "<script type = 'text/javascript'>alert('quantity cannot be empty or noninteger'); </script>"; // display alert message over page
                    header('Refresh: .1; URL=http://localhost/Pizza%20Website/HTML/placeOrder_page.html'); //  redirects to the same  page to try again after .1 second(so it can show the failure message)    
                    die();
                }
            }
            else{
                echo "<script type = 'text/javascript'>alert('zip cannot be empty or noninteger'); </script>"; // display alert message over page
                header('Refresh: .1; URL=http://localhost/Pizza%20Website/HTML/placeOrder_page.html'); //  redirects to the same  page to try again after .1 second(so it can show the failure message)    
                die();
            }
        }
        else{
            echo "<script type = 'text/javascript'>alert('Address cannot be empty'); </script>"; // display alert message over page
            header('Refresh: .1; URL=http://localhost/Pizza%20Website/HTML/placeOrder_page.html'); //  redirects to the same  page to try again after .1 second(so it can show the failure message)    
            die();
        }
    }
    else{
        echo "<script type = 'text/javascript'>alert('last name cannot be empty'); </script>"; // display alert message over page
        header('Refresh: .1; URL=http://localhost/Pizza%20Website/HTML/placeOrder_page.html'); //  redirects to the same  page to try again after .1 second(so it can show the failure message)    
        die();
    }
}
else{
    echo "<script type = 'text/javascript'>alert('first name cannot be empty'); </script>";
    header('Refresh: .1; URL=http://localhost/Pizza%20Website/HTML/placeOrder_page.html'); //  redirects to the same  page to try again after .1 second(so it can show the failure message)        
    die();
}
?>