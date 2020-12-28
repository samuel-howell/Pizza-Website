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
                        //TODO: figure out a way to concatenate the count valuse to the button id.  That way you can reference by ID in the JS
            ?>
                        <tr>
                            <td class = "table_cell"><?php echo $row['Last_Name'];?></td>
                            <td class = "table_cell"><?php echo '(' . $row['order_id'] . ')';?></td>
                            <td class = "table_cell"><button id="statusBtn" onclick="myFunction()" value="test">In Progress</button></td>
                            <!-- TODO:change button color and text with js -->
                        </tr>
            <?php
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