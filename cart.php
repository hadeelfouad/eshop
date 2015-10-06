<?php
session_start();
include('config.php');
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
 $userid =  $_SESSION['userid'];
}
else {
   header("location:/eshop/login.php");
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>Eshop</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="css/product.css" rel="stylesheet">

        <script type="text/javascript">
       function overlay() {
       el = document.getElementById("overlay");
       el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
    } 
    </script>
  </head>


  <body>
     <div class = "header">
      <a href="product.php"><img src="pictures/cart-logo.gif"//></a>
      <div class = "right">
      <a href='#' onclick='overlay();'>EditProfile<span class="glyphicon glyphicon-edit"></span></a>
      <a href='cart.php'>Mycart<span class="glyphicon glyphicon-shopping-cart"></a>
      <a href ='cart.php?logout'/>Logout<span class="glyphicon glyphicon-off"></a>
      <a href='history.php'>History<span class="glyphicon glyphicon-open"></a>
  </div>
    </div>
<?php 
$query = "SELECT p.productid, p.name,p.quantity,p.price,COUNT(*),SUM(p.price) FROM product p, cart c WHERE c.userid='$userid'and p.productid=c.productid GROUP BY c.productid ";
$result = mysql_query($query);
$count = mysql_num_rows($result);
// $products = mysql_fetch_row($result);
//$counter = 0;
?>
<?php
  if(isset($_GET['logout'])) {
  $sql44 = "SELECT COUNT(*),productid FROM cart WHERE userid='$userid' GROUP BY productid";
  $result44 = mysql_query($sql44);
  $count44 = mysql_num_rows($result44); 
  while($rows = mysql_fetch_row($result44)) {
  $pid = $rows[1];
  $sql_22 = "SELECT quantity FROM product WHERE productid='$pid'";
  $result_22 = mysql_query($sql_22);
  $row_22 = mysql_fetch_row($result_22);
  $quantity= $row_22[0] + $rows[0];
  $sql_11 = "UPDATE product SET quantity = '$quantity' WHERE productid ='$pid'";
  mysql_query($sql_11);
  }
  $sql5 ="DELETE FROM cart WHERE userid='$userid'";
  mysql_query($sql5);
  $_SESSION = array();
  session_unset();
  session_destroy();
  setcookie(session_name(), false, time() - 3600); 
  header("location:/eshop/product.php");
  exit();
  }
?>
<div class ="main">
  <div  style="position:relative;top: 80%;">
    <p><?php 
    $query32 = "SELECT SUM(total) FROM (SELECT c.productid,SUM(p.price)as total FROM product p, cart c WHERE c.userid='$userid'and p.productid=c.productid GROUP BY c.productid)as a ";
    $result32 = mysql_query($query32);
    $count32 = mysql_num_rows($result32); 
    $row32 = mysql_fetch_row($result32);
    $totalprice = $row32[0];
    echo "Total amount: $".$row32[0]."<br>";
?>
  </p>
  <p><form action="" method="POST"><button class="btn btn-primary" onclick="confirm()" type="submit" name="confirm" alt="Confirm" value=""/>Confirm</button></form></p>
</div>
<?php 
if(isset($_POST['confirm'])) {
        $sql__ = "SELECT productid FROM cart WHERE userid='$userid'";
        $result__ = mysql_query($sql__);
        $count__ = mysql_num_rows($result__);
        $row__ = mysql_fetch_row($result__);
//$sql_check = "SELECT productid FROM cart where userid='$userid'";
//mysql_query($sql_check);
//$count_check = mysql_num_rows($sql_check);
if($count__== 0) {
 header("location:/eshop/product.php");
 exit();
}
else {
            $sql4 = "INSERT INTO history (userid,productname,quantity,totalprice)
            SELECT c.userid, p.name,COUNT(*),SUM(p.price) 
            FROM product p, cart c 
            WHERE c.userid='$userid' and p.productid=c.productid 
            GROUP BY c.productid"; 
  mysql_query($sql4);
  $sql5 ="DELETE FROM cart WHERE userid='$userid'";
  mysql_query($sql5);
  echo "<script>
alert('Items are bought');
window.location.href='http://localhost/eshop/product.php';
</script>";
}
}
?>
<table id="products" class="table-striped">

<?php 
while($products = mysql_fetch_row($result))
{
  ?>
   <tr>
    <td>
  <?php 

  echo "name: ".$products[1]."<br>";
  ?></td>
  <td>
  <?php

  if ($products[2] != 0)
  {
    echo "quantity available: ".$products[2]."<br>";
    }
  else
  {
    echo "item out of stock <br>";
  }
  ?> 
  </td>
  <td>
    <?php
  echo "price: ".$products[3]."<br>";
//  echo $products[0]."<br>";
//  print_r($products);
//  echo "<br>";
  
  ?>
  </td>
  <td>
    <?php 

  echo "#ItemsBought: ".$products[4]."<br>";
  ?>
  
  </td>
    <td>
    <?php 

  echo "ItemsTotal: $".$products[5]."<br>";
  ?>
  </td>
  <td>
   <a class="btn btn-primary" href="cart.php?apid=<?php echo $products[0]; ?>"><span class="glyphicon glyphicon-plus" style="vertical-align:middle font-size:30px"></span</a>";
  </td>
    <td>
  <a class="btn btn-primary" href="cart.php?rpid=<?php echo $products[0]; ?>"><span class="glyphicon glyphicon-remove" style="vertical-align:middle font-size:30px"></span</a>";
  </td>
   </tr>
   <?php
    if(isset($_GET["apid"])){
            $sql_q = "SELECT quantity FROM product WHERE productid='$pid'";
            $result_q = mysql_query($sql_q);
            $row_q = mysql_fetch_row($result_q);
            $quantityr= $row_q[0];
            if($quantityr> 0) 
  {
        $query= "INSERT INTO cart (productid, userid) VALUES (".$_GET["apid"] ."," . $_SESSION['userid']. ")";
        mysql_query($query);
        $sql = "SELECT quantity FROM product WHERE productid='".$_GET["apid"] ."'";
        $result = mysql_query($sql);
        $row = mysql_fetch_row($result);
        $quantity= $row[0] -1;
        //echo $quantity;
        $sql1 = "UPDATE product SET quantity = '$quantity' WHERE productid =".$_GET["apid"] ."";
        mysql_query($sql1);
        
        //if(mysql_query($query)){
        //echo "successfully added to cart";
        //header('location: product.php');
      //}
    $js = <<<EOT

EOT;
}
header('location: cart.php');
} 
}
?>
   <?php
    if(isset($_GET["rpid"])){
        $userid = $_SESSION["userid"];
        $productid = $_GET["rpid"];
        $query= "DELETE FROM cart WHERE userid='$userid' and productid='$productid' LIMIT 1";
        if (mysql_query($query)){
        $sql = "SELECT quantity FROM product WHERE productid='".$_GET["rpid"] ."'";
        $result = mysql_query($sql);
        $row = mysql_fetch_row($result);
        $quantity= $row[0] +1;
        //echo $quantity;
        $sql1 = "UPDATE product SET quantity = '$quantity' WHERE productid =".$_GET["rpid"] ."";
        mysql_query($sql1);
        header('location: cart.php');
        //if(mysql_query($query)){
        //echo "successfully added to cart";
        //header('location: product.php');
      //}
    $js = <<<EOT

EOT;
}
} 
?>

</table>
</div>
<div id="overlay">
        <div id = "signup">
          <table>
        <h2>Edit Profile</h2>
          <?php 
          //session_start();
      include('config.php');
      $userid = $_SESSION['userid'];
      $sql = "SELECT * FROM users WHERE id='$userid'";
      $result = mysql_query($sql);
          while($row = mysql_fetch_row($result)) {
            echo "<td><img width = '100' height='100' src='pictures/". $row[5] ."'></br> ". $row[1] . " ". $row[2] . "</br>  " . $row[3] . "</br>";
         }
          ?>
        <td>
        <form class="form-signup" method ="post" enctype="multipart/form-data">
        <input name = "email" type="email" id="inputEmail" maxlength="30" class="form-control" placeholder="new email*" autofocus required></br>
        <p></p>
        <input name = "firstname" type="text" id="inputFirstname" maxlength="15"  class="form-control" placeholder="new firstname*"  autofocus required></br>
        <p></p>
        <input name = "lastname" type="text" id="inputLastname" maxlength="15" class="form-control" placeholder="new lastame*" autofocus required></br>
        <p></p>
        <input name = "password" type="password" id="inputPassword" maxlength="15" minlength="6" class="form-control" placeholder="new password*" required>
        <p></p>
        <input name = "confirmpassword" type="password" id="confirmPassword" maxlength="15" minlength="6" class="form-control" placeholder="Confirm Password*" required>
        <p></p>
        <label for="avatar" class="sr-only" style="color: blue">Choose a profile picture</label>
        <input type="file" name="avatar" accept="image/*">
        <p></p>
        <button type="submit" name="save" alt="Save" value=""/>Done</button>
        </form>
        <p></p>
        <?php
            include("config.php");
            if(isset($_POST['save'])) 
            { echo '     
                <script type="text/javascript">
            el = document.getElementById("overlay");
            el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
              </script>';
              $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];
        if($password != $confirmpassword) {
              echo "<script>
              alert('Password mismatch!');
              window.location.href='http://localhost/eshop/cart.php';
              </script>";
        }
        else {
        if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
              move_uploaded_file($_FILES['avatar']['tmp_name'],"C:/xampp/htdocs/eshop/pictures/".$_FILES['avatar']['name']);
              $sql1 = "UPDATE users SET firstname = '".$firstname."', lastname ='".$lastname."', email ='".$email."', password='".$password."', avatar='".$_FILES['avatar']['name']."' WHERE id ='".$_SESSION['userid']."'";
            mysql_query($sql1,$mysqlConnection);
              echo "<script>
              alert('Updated!');
              window.location.href='http://localhost/eshop/cart.php';
              </script>";
              }

        else{
               $sql1 = "UPDATE users SET firstname = '".$firstname."', lastname ='".$lastname."', email ='".$email."', password='".$password."' WHERE id ='".$_SESSION['userid']."'";
            mysql_query($sql1,$mysqlConnection);
              echo "<script>
              alert('Updated!');
              window.location.href='http://localhost/eshop/cart.php';
              </script>";
                  }
            }
        }         
    ?>
    </td>
    </table>
    <button onclick="overlay()" class="btn btn-lg btn-primary btn-block">back</button>
    </div>
    </div>

<div class ="footer">Website created @2015</div>
</body>
</html>
