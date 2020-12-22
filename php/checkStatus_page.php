<?php 
include "connect.php";
$query = "SELECT Last_Name from customer";
$result = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fatima's Pizzeria - transitional page</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat&display=swap" rel="stylesheet">
    <link rel = "stylesheet" href = "../css/checkStatusPage_styles.css"> <!-- the ../ moves up a folder, then finds the css-->
    <script src = "script.js" defer></script>  <!--deferring means that JS will be downloaded, but it will not be executed until all the HTML and CSS have been loaded -->

</head>

<body>
<!--TODO:Format this table to pull last name from customer table and order id from pizza_order table-->

    <table style="width:600px; margin: auto auto; border: 1px; line-height:40px;">
        <tr>
            <th colspan="6"><h2>Pizza Record</h2></th>
        </tr>
        <tr>
            <th>order_id</th>
            <th>customer_id</th>
            <th>pizza_id</th>
            <th>order_date</th>
            <th>order_type</th>
            <th>quantity</th>
        </tr>
     <?php
        while($rows=mysqli_fetch_assoc($result))
        {
    ?>
        <tr>
            <td><?php echo $rows['Last_Name']; ?></td>
        </tr>  
    <?php       
        }   
        ?>

    </table>

    <section class = "orderStatus">
        <!--header thingy on the page-->
        <h1 class = "title">Order Status</h1>

        <!--fields on the page-->
        <p class = "lastNameOrderID">LastName (OrderID)</p>
        <button>In Progress</button>                          <!--TODO:Add Javascript to turn this button green and say "completed" when clicked-->
        <br>
        <p class = "lastNameOrderID">LastName (OrderID)</p>
        <button>In Progress</button>
        <br>
        <p class = "lastNameOrderID">LastName (OrderID)</p>
        <button>In Progress</button>
        <br>
        <p class = "lastNameOrderID">LastName (OrderID)</p>
        <button>In Progress</button>
        <br>
        <p class = "lastNameOrderID">LastName (OrderID)</p>
        <button>In Progress</button>
        <br>
        <p class = "lastNameOrderID">LastName (OrderID)</p>
        <button>In Progress</button>
        <br>  
        <p class = "lastNameOrderID">LastName (OrderID)</p>
        <button>In Progress</button>
        <br>
        <p class = "lastNameOrderID">LastName (OrderID)</p>
        <button>In Progress</button>
        <br>
    </section>


     <!--access this page with http://localhost/Pizza%20Website/php/checkStatus_page.php -->


    <a href = "transitional_page.html" class = "home_btn"> 
        <img src = "../css/images/homeBtn.svg" alt = "home button">
    </a>
   
</body> 

</html>