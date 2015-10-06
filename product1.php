<html lang="en">
  <head>
  <link rel="stylesheet" type="text/css" href="css/bootstarp.css">
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
    <link href="css/signin.css" rel="stylesheet">
    <style type="text/css">
    #products td {
    	width: 40vw;
    	height: 10vh;
    }

    </style>
  </head>


  <body>

<?php 
session_start();
include('config.php');
$userid =  $_SESSION['userid'];
//echo $userid . "<br>";


$query = "SELECT * FROM product ";
$result = mysql_query($query);
$count = mysql_num_rows($result);
// $products = mysql_fetch_row($result);
//$counter = 0;
?>
<div >
<table id="products" class="table-striped">

<?php 
while($products = mysql_fetch_row($result))
{
	?>
	<tr >
		<td>
			<img src="/products<?php echo ""; ?>">
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
		<a class="btn btn-primary" href="product.php?pid=<?php echo $products[0]; ?>">Add to cart <span class="glyphicon glyphicon-shopping-cart"></span</a>
		
	</td>
	</tr>
	<?php
	
	
}

?>
</table>
</div>
</body>
</html>

<?php
if(isset($_GET["pid"])){
	$query= "INSERT INTO cart (productid, userid) VALUES (".$_GET["pid"] ."," . $_SESSION['userid']. ")";
	
	if(mysql_query($query)){
		echo "successfully added to cart";
		header('location: product.php');
	}
	$js = <<<EOT

EOT;
}
?>