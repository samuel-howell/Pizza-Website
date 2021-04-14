<?php

    include "connect.php";

?>

<!DOCTYPE html>
            <html lang="en-US">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Fatima's Pizzeria - transitional page</title>
                <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat&display=swap" rel="stylesheet">
                <link rel = "stylesheet" href = "../css/checkStatusPage_styles.css"> <!-- the ../ moves up a folder, then finds the css-->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!--have to include this jquery CDN import call above local js file-->
                <script src = "../js/checkStatus_page.js" defer></script>  <!--deferring means that JS will be downloaded, but it will not be executed until all the HTML and CSS have been loaded -->
            </head>

            <body>
            

<?php
    if(isset($_POST['startDate']) && isset($_POST['endDate']))
    {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
    }

    else if (isset($_POST['allDates']))
    {
        $dates = $_POST['allDates'];  //FIXME:its not recognizing allDates       
    }
    else
    {
        echo "<script type = 'text/javascript'>alert('Dates cannot be empty'); </script>"; // display alert message over page
        header('Refresh: .1; URL=http://localhost/Pizza%20Website/HTML/generateReport_page.html'); //  redirects to the same login page to try again after .1 second(so it can show the failure message)
        die();
    }
    
    if(isset($_POST['orderType']))
    {
        $order = $_POST['orderType'];
        $typesArr = array();        //  create an array to hold the orderTypes chosen in checkbox

        //  go through each element in the orderType[] sent to the php through POST, and add it to a php array
        foreach ($order as $orderType)
        {
            array_push($typesArr, "'" . $orderType . "'");          //  go through the checkbox input sent to the php and push each selected orderType to the php array 
                                                                    //  instead of the imploded list lookin like "delivery, dinein, takeout" it needs to look like "'delivery', 'dinein', 'takeout'" in order to be read properly
                                                                    //  Why did I add "'" ?^^^^
        }
        
      
        echo "<br>";
        echo "<br>";

       //  implode the typesArr to put it in a string format understandable by the IN condition in the SQL statement GOOD INFO -> https://www.geeksforgeeks.org/how-to-bind-an-array-to-an-in-condition-in-php/ 
       $implodedTypesArr = implode(', ', $typesArr);

        $sql = "SELECT * FROM pizza_order
                INNER JOIN pizza ON pizza_order.pizza_id = pizza.id  -- join the pizza table so we can tell wich kinds of pizza have been ordered
                WHERE order_date BETWEEN '$startDate' AND '$endDate'  -- select all orders between the two date criteria --   
                AND order_type IN ($implodedTypesArr)                 -- filter out all the orders whose types where not selected in the checkboxes
                ORDER BY order_date DESC";                           //  order them by newest down to oldest


        $firstDate  =    "9999-99-99";      #  create a generic date format startDate (with irregularly high numbers)
        $lastDate    =    "1111-11-11";      #  create a generic date format endDate (with irregularly low numbers)

        if($array = mysqli_query($conn, $sql))
        { 
            while ($row = mysqli_fetch_assoc($array))
            {
                #compare current date in row against endDate, to find the newest Date in the array
                if($row['order_date'] > $lastDate)
                {
                    $lastDate = $row['order_date'];
                }

                #compare current date in row against startDate, to find the oldest Date in the array
                if($row['order_date'] < $firstDate)
                {
                    $firstDate = $row['order_date'];
                }

                 //echo $row['order_date']. "<br>";
                // echo $row['order_type']. "<br>";
                // echo "<br>";
                $pythonArr[] = $row;    //  add the row to the array that will be sent to parseData.py
            }

            $jsonArr = json_encode($pythonArr);   // encode the array into a json format that can be read by the parseData.py
            
            //  find the number of days between the startDate and endDate
            $start = strtotime($firstDate);
            $end = strtotime($lastDate);

            $days_between = floor(abs($end - $start) / 86400);

            //  find the number of hours that the pizza shop is open (assuming its open 11am to 11pm )
            $hours_between = $days_between * 12;

            //  lets assume that the pizzeria has 5 employees, each paid $8/hr.
            $employee_pay = ($hours_between * 8) * 5;




            echo "<br><br> Financial Report for Fatima's Pizzeria between " . $firstDate . " and ". $lastDate ."<br><br>";

        
            $after_json = json_encode($jsonArr);
        
            $escaped_json = escapeshellarg($after_json);
            $command = escapeshellcmd("python parseData.py $after_json $employee_pay $startDate $endDate"); //  pass the vars to the parseData.py file.... sys.argv[1] ==> $after_json, sys.argv[2] ==> $employee_pay, etc.
            $output = shell_exec($command);         //execute the parseData.py
            echo $output;
    ?>

            <img src = "../css/images/orderType_pie_chart.png">
            <img src = "../css/images/toppingType_pie_chart.png">
            <!-- Sometimes we have to ctrl+F5 to do a hard reload of the page in order to see the updated graphs -->


    <?php

        }
        else
        {
            echo "failure";
        }   
    }
    else
    {
        echo "<script type = 'text/javascript'>alert('Order Types cannot be empty'); </script>"; // display alert message over page
        header('Refresh: .1; URL=http://localhost/Pizza%20Website/HTML/generateReport_page.html'); //  redirects to the same login page to try again after .1 second(so it can show the failure message)
        die();
    }
    
    $conn->close();

?>

            </body>
        </html>