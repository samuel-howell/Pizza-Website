<?php
    //connect to the db
    include "connect.php";

    if(isset($_GET['id']))      //  gets the order_id (that is sent through the href) on the checkStatus_page  
    {
        $order_id = $_GET['id'];
        echo $order_id;

        $sql = "UPDATE pizza_order SET fulfilled='1' WHERE order_id='$order_id'";
        if(mysqli_query($conn, $sql))
        {
            header('Refresh: .1; URL=http://localhost/Pizza%20Website/php/checkStatus_page.php'); //  redirects back to checkStatus page 
        }
        else
        {
            echo "<script type = 'text/javascript'>alert('the fulfilled value wasnot changed'); </script>"; // display alert message over page
            header('Refresh: .1; URL=http://localhost/Pizza%20Website/php/checkStatus_page.php'); //  redirects to the same  page to try again after .1 second(so it can show the failure message)    
            die();
        }
    } 
    else 
    {
        echo "failed isset";
        header('Refresh: .1; URL=http://localhost/Pizza%20Website/php/checkStatus_page.php'); //  redirects to the same  page to try again after .1 second(so it can show the failure message)    
            die();
    }
   

?>