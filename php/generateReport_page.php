<?php

    include "connect.php";

    //  test sending crap to python file
    $command = escapeshellcmd('python ../python/parseData.py');
    $output = shell_exec($command);
    echo $output;
    ///////////////////////////////////////////



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
                WHERE order_date BETWEEN '$startDate' AND '$endDate'  -- select all orders between the two date criteria --
                
                AND order_type IN ($implodedTypesArr)                 -- filter out all the orders whose types where not selected in the checkboxes
                ORDER BY order_date DESC";                           //  order them by newest down to oldest


        if($array = mysqli_query($conn, $sql))
        {

           
            while ($row = mysqli_fetch_assoc($array))
            {
                echo $row['order_date']. "<br>";
                echo $row['order_type']. "<br>";
                echo "<br>";
                $pythonArr[] = $row;    //  add the row to the array that will be sent to parseData.py
            }

            $jsonArr = json_encode($pythonArr);   // encode the array into a json format that can be read by the parseData.py
            
           
            echo "<br><br> START <br><br>";

            $before_json = array("qwe","wer","ert");
            //print_r($before_json );
            echo "<br><br>";
        
            $after_json = json_encode($jsonArr);
            //echo $after_json;
        
            $escaped_json = escapeshellarg($after_json);
            $command = escapeshellcmd("python parseData.py $after_json");
            $output = shell_exec($command);         //execute the parseData.py
            echo $output;
        
            
            echo "<br><br> END";



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