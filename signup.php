<?php
session_start();
include("config.php");
if($_SERVER["REQUEST_METHOD"] == "POST") 
 {
$email = $_POST['email'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$password = $_POST['password'];
$confirmpassword = $_POST['confirmpassword'];

if($password != $confirmpassword) {
   echo' <p style="color: red; text-align: center">
      password mismatch!
      </p>';
}
else {
  //echo $email;
  $sql = "SELECT id FROM users WHERE email='$email'";
  $result = mysql_query($sql);
  //echo 'done';
  //$count = mysql_num_rows($result);
  //echo $count;
  if(mysql_num_rows($result) == 0) {
     if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
      //echo getcwd();
      move_uploaded_file($_FILES['avatar']['tmp_name'],"C:/xampp/htdocs/eshop/pictures/".$_FILES['avatar']['name']);
      $sql1 = "INSERT INTO users (firstname,lastname,email,password,avatar) VALUES('$firstname','$lastname','$email','$password','".$_FILES[avatar][name]."')";
    mysql_query($sql1,$mysqlConnection);
    header("location:/eshop/login.php");
    }
    //echo 'no recorders';
  $sql1 = "INSERT INTO users (firstname,lastname,email,password,avatar) VALUES('$firstname','$lastname','$email','$password','nopp.gif')";
    mysql_query($sql1,$mysqlConnection);
    header("location:/eshop/login.php");
  }
  else {
    echo '<p style="color: red; text-align: center">you are arleady registered!</p>';
  }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Signup
	</title>
	<link href="css/main.css" rel="stylesheet">
	<link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class ="header">
  	<a href="login.php"><img src="pictures/cart-logo.gif"//></a>
  </div>
  <div class = "container">
   <form class="form-signup" method ="post" enctype="multipart/form-data">
        <h2>Sign Up</h2>
        <input name = "email" type="email" id="inputEmail" maxlength="30" class="form-control" placeholder="Email address" required autofocus></br>
        <p></p>
        <input name = "firstname" type="text" id="inputFirstname" maxlength="15"  class="form-control" placeholder="First Name" required autofocus></br>
        <p></p>
        <input name = "lastname" type="text" id="inputLastname" maxlength="15" class="form-control" placeholder="Last Name" required autofocus></br>
        <p></p>
        <input name = "password" type="password" id="inputPassword" maxlength="15" minlength="6" class="form-control" placeholder="Password" required>
    	<p></p>
        <input name = "confirmpassword" type="password" id="confirmPassword" maxlength="15" minlength="6" class="form-control" placeholder="Confirm Password" required>
    	<p></p>
      <label for="avatar" class="sr-only" style="color: blue">Choose a profile picture</label>
      <input type="file" name="avatar" accept="image/*">
    </p></p>
    	<button class="btn btn-lg btn-primary btn-block" type="submit">Done</button>
      </form>
    </div> <!-- /container -->
  <div class= "footer">
  	<p>Website created @2015</p>
  </div>
</body>
</html>