<?php 
//  connect to database
include "connect.php";

//  find the last name column in the customer table and the order_id column in the pizza_order table

/* This sql statement joins the pizza_order and customer tables where the "id" column in the customer table matches the 
    "order_id" column in the pizza_order table... I think so anyway....  It orders by descending so the latest orders are at the
    top of the table */
$sql = "SELECT * FROM customer INNER JOIN pizza_order ON customer.id = pizza_order.customer_id ORDER BY id DESC"; 
$result = mysqli_query($conn, $sql);


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

<section class = "orderStatus">
        <!--header thingy on the page-->
        <h1 class = "title">Order Status</h1> <!--FIXME:Make all of the title class able to adapt to the viewport size-->


    <!--This table shows the output from the database --> 
    <table>
        <tr>
            <th>Last Name</th> 
            <th>Order ID</th>
            <th>Status</th>
           
        </tr>
        <tr>
            <?php
                $count = 0;
                if(mysqli_num_rows($result) > 0)
                {
                  while($row = mysqli_fetch_array($result))
                  {
                    if($count != 8) // this allows us to only show the 8 latest orders at any time, and thus prevents this table from growing extremely long.
                    {
                        $count++;
            ?>
                        <tr>
                            <td class = "table_cell"><?php echo $row['Last_Name'];?></td>
                            <td class = "table_cell"><?php echo '(' . $row['order_id'] . ')';?></td>
                            <td class = "table_cell"><button id="statusBtn" name = "fulfilled" onclick="changeStatusBtn()">In Progress</button></td>
                        </tr>
            <?php
            //  the code below will not work because all statusBtns have "fulfilled" as their name.  how do I isolate? 
            /*  TODO:
                    Perhaps use AJAX in my js?
                    if the button is clicked.
                        1. find row 9tr) that has the statusBtn cell (td) that was clicked
                        2. find the order id that is on that same row
                        3. match that^ order id to the order id in the pizza_order table in DB. Note the row in the table
                        4. change the value in that "fulfilled" column in the row from 0 to 1

                        This will allow me to check whether any orders on the checkStatus page have already been completed when the page is 
                        loaded, so I can go ahead and turn them green and have them say "completed" when the page initially loads.

            */
                 if(isset($_POST['fulfilled']))
                 {
                     $fulfilledQuery = "INSERT INTO pizza_order (fulfilled) VALUES ('1')";
                     $fResult = mysqli_query($conn, $fulfilledQuery);

                     if($fResult)
                     {
                         mysqli_close($conn);
                     }
                     else
                     {
                        echo "<script type = 'text/javascript'>alert('fulfill entry failed'); </script>"; // display alert message over page
                        header('Refresh: .1; URL=http://localhost/Pizza%20Website/php/checkStatus_page.php'); //  redirects to the same  page to try again after .1 second(so it can show the failure message)    
                        die();
                     }
                 }
                    }
                  }  
                }
            ?>
    </table>
    
    

    </section>


     <!--access this page with http://localhost/Pizza%20Website/php/checkStatus_page.php -->


    <a href = "../HTML/transitional_page.html" class = "home_btn"> 
        <img src = "../css/images/homeBtn.svg" alt = "home button">
    </a>
   
</body> 

</html>
