<?php 
session_start();
//$userid =  $_SESSION['userid'];
//echo $userid;
if(isset($_SESSION["loggedin"])) {
 $userid =  $_SESSION['userid'];
}
else {
   header("location:/eshop/login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <title>Our Products</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Custom styles for this template -->
    <link href="css/main.css" rel="stylesheet">

    <body>
     <div class = "header">
        <a href="login.php"><img src="pictures/cart-logo.gif"//></a>
     </div>
     <div class = "container">
        <table>
            <?php
            include("config.php");
             $sql = "SELECT * FROM product";
             $result = mysql_query($sql);
                while($row = mysql_fetch_array($result)){   
                echo "<tr><td><img width = '50' height='50' src='pictures/". $row['photo'] ."'></br> ". $row['name'] . "</br>  $" . $row['price'] . "</br>"; 
                if($row['quantity'] > 0) {
                    echo  "<input type='submit' name='buy' value='" . $row['productid'] . "'></td></tr>";
                }
                else {
                        echo "<label>Sold out</label></tb></tr>";
                }
                }
            ?>
        </table>
     </div>
     <div class ="footer">Website created @2015
     </div>
    </body>
</html>