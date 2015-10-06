<?php 
session_start();
include('config.php');
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
 $userid =  $_SESSION['userid'];
}
else {
   header("location:/eshop/login.php");
   exit();
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
      <a href='#' onclick='overlay();'>EditProfile<span class="glyphicon glyphicon-edit"></a>
      <a href='cart.php'>Mycart<span class="glyphicon glyphicon-shopping-cart"></a>
      <a href ='product.php?logout'>Logout<span class="glyphicon glyphicon-off"></a>
      <a href='history.php'>History<span class="glyphicon glyphicon-open"></a>
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
  </div>
    </div>
<div class ="main">
<table id="products" class="table-striped">
  <tr>
<?php 
$query_1 = "SELECT * FROM history WHERE userid='$userid' ";
$result_1 = mysql_query($query_1);
$count_1 = mysql_num_rows($result_1);
// $products = mysql_fetch_row($result);
//$counter = 0;
if ($count_1==0) {
  echo "<script>
alert('No History! Start Shopping Now!');
window.location.href='http://localhost/eshop/product.php';
</script>";
}
else {

while($products_1 = mysql_fetch_row($result_1))
{
  echo "<td> Productname : ".$products_1[1]."</br></td>";
  echo "<td> Quantity : ".$products_1[2]."</br></td>";
  echo "<td> TotalPrice: $".$products_1[3]."</br></td>";
  echo "<td> Date : ".$products_1[4]."</br></td></tr>";
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
              window.location.href='http://localhost/eshop/history.php';
              </script>";
        }
        else {
        if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
              move_uploaded_file($_FILES['avatar']['tmp_name'],"C:/xampp/htdocs/eshop/pictures/".$_FILES['avatar']['name']);
              $sql1 = "UPDATE users SET firstname = '".$firstname."', lastname ='".$lastname."', email ='".$email."', password='".$password."', avatar='".$_FILES['avatar']['name']."' WHERE id ='".$_SESSION['userid']."'";
            mysql_query($sql1,$mysqlConnection);
              echo "<script>
              alert('updated!');
              window.location.href='http://localhost/eshop/history.php';
              </script>";
              }

        else{
               $sql1 = "UPDATE users SET firstname = '".$firstname."', lastname ='".$lastname."', email ='".$email."', password='".$password."' WHERE id ='".$_SESSION['userid']."'";
            mysql_query($sql1,$mysqlConnection);
              echo "<script>
              alert('updated!');
              window.location.href='http://localhost/eshop/history.php';
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