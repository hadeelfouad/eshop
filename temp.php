
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
      <a href='#' onclick='overlay();'>EditProfile</a>
      <a href='chart.php'>Mychart<span class="glyphicon glyphicon-shopping-cart"></a>
  </div>
    </div>
<?php 
session_start();
include('config.php');
if(isset($_SESSION["loggedin"])) {
 $userid =  $_SESSION['userid'];
}
else {
   header("location:/eshop/login.php");
}


$query = "SELECT * FROM product ";
$result = mysql_query($query);
$count = mysql_num_rows($result);
// $products = mysql_fetch_row($result);
//$counter = 0;
?>
<div class ="main">
<table id="products" class="table-striped">

<?php 
while($products = mysql_fetch_row($result))
{
	?>
	<tr >
		<td>
			<img img width = '50' height='50' src='pictures/<?php echo "".$products[4].""; ?>'>
		</td>
		<td>
	<?php 

	echo "name: ".$products[1]."<br>";
	?></td>
	<td>
	<?php
	if ($products[2] != 0)
	{
		echo "quantity: ".$products[2]."<br>";
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
//	echo $products[0]."<br>";
//	print_r($products);
//	echo "<br>";
	?>
	</td>
	<td>
  <a class="btn btn-primary" href="product.php?pid=<?php echo $products[0]; ?>">Add to cart <span class="glyphicon glyphicon-shopping-cart"></span</a>";
	</td>
	</tr>
	 <?php
		if(isset($_GET["pid"])){
        if ($products[2] != 0)
  {$sql1 = "SELECT quantity FROM cart WHERE productid='".$_GET["pid"] ."'";
        $result1 = mysql_query($sql);
        $row1 = mysql_fetch_row($result);
        $quantity1= $row[0] +1;
		$query= "INSERT INTO cart (productid, userid,quantity) VALUES (".$_GET["pid"] ."," . $_SESSION['userid']. ",".$quantity1.")";
     $sql = "SELECT quantity FROM product WHERE productid='".$_GET["pid"] ."'";
        $result = mysql_query($sql);
        $row = mysql_fetch_row($result);
        $quantity= $row[0] -1;
        echo $quantity;
		$sql1 = "UPDATE product SET quantity = '$quantity' WHERE productid =".$_GET["pid"] ."";
		mysql_query($sql1);
		if(mysql_query($query)){
		echo "successfully added to cart";
		header('location: product.php');
			}
		$js = <<<EOT

EOT;
}
}	
}

?>
</table>
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
   				echo' <p>
      			password mismatch!
      			</p>';
				}
				else {
				if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
      		    move_uploaded_file($_FILES['avatar']['tmp_name'],"C:/xampp/htdocs/eshop/pictures/".$_FILES['avatar']['name']);
      		    $sql1 = "UPDATE users SET firstname = '".$firstname."', lastname ='".$lastname."', email ='".$email."', password='".$password."', avatar='".$_FILES['avatar']['name']."' WHERE id ='".$_SESSION['userid']."'";
    		    mysql_query($sql1,$mysqlConnection);
    		    echo' <p>
      			updated!
      			</p>';
    		      }

    		else{
               $sql1 = "UPDATE users SET firstname = '".$firstname."', lastname ='".$lastname."', email ='".$email."', password='".$password."' WHERE id ='".$_SESSION['userid']."'";
    		    mysql_query($sql1,$mysqlConnection);
    		    echo' <p>
      			updated!!
      			</p>';
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