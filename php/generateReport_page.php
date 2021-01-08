<?php

    include "connect.php";


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

        //  prints out which of the check boxes where selected
        // echo "you chose the following types: <br>";

        // foreach ($order as $orderType)
        // {
        //     echo $orderType. "<br>";
        // }
        // echo $startDate. "<br>";
        // echo $endDate. "<br>";


       
        //  select all orders between the two date criteria, then order them by newest down to oldest
        $sql = "SELECT * FROM pizza_order WHERE order_date BETWEEN '$startDate' AND '$endDate' ORDER BY order_date DESC";   

        //TODO:  Modify above sql query to only include db entries that have the order types specified by the user

        //  print them out JUST TO PROVE YOU CAN.
        if($array = mysqli_query($conn, $sql))
        {

            //  TODO: send the neccesary data to python script to process it.
            while ($row = mysqli_fetch_assoc($array))
            {
                echo $row['order_date']. "<br>";
                echo $row['order_type']. "<br>";
                echo "<br>";
            }
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
    
    

?>