<?php 
        session_start();
        include("config.php");
        $_SESSION['loggedin'] = false;
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

    <title>Eshop</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <script type="text/javascript">
      function overlay() {
      el = document.getElementById("overlay");
      el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
}
</script>
  </head>

  <body>
    <div class = "header">
      <a href="login.php"><img src="pictures/cart-logo.gif"//></a>
    </div>
<div class="container">
      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Login</h2>
        <input name = "email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <input name = "password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="signin" alt="Signin" value=""/>Sign in</button>
        <div class="member">
        <p>New member? Signup now!</p>
      </div>
        <button class="btn btn-lg btn-primary btn-block" onclick="overlay()">Signup</button>
      <?php
        if(isset($_POST['signin'])) 
        {
        //email and password sent from form 
        //echo 'k1';
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT id FROM users WHERE email='$email' and password = '$password'";
        $result = mysql_query($sql);
        $count = mysql_num_rows($result);
        $row = mysql_fetch_row($result);
        //echo $count;
        //echo 'row';
        //echo $row[0];
        if($count == 1) {
        $_SESSION['userid'] = $row[0];
        $_SESSION['loggedin'] = true;
        //echo 'lolo';
        //echo $_SESSION['userid'];
        header("location:/eshop/product.php");
        exit();
        }
        else {
        echo' <p>
        Incorrect email or password!
          </p>';
        //echo 'incorrect email or password';
        }

        }
      ?>
      </form>
    </div> <!-- /container -->
    <!--/signup form -->
    <div id="overlay">
        <div id = "signup">
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
        <p></p>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="save" alt="Save" value=""/>Done</button>
        </form>
        <p></p>
        <button onclick="overlay()" class="btn btn-lg btn-primary btn-block">back</button>
          <?php
          //session_start();
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
    exit();
    }
    //echo 'no recorders';
  $sql1 = "INSERT INTO users (firstname,lastname,email,password,avatar) VALUES('$firstname','$lastname','$email','$password','nopp.gif')";
    mysql_query($sql1,$mysqlConnection);
    header("location:/eshop/login.php");
    exit();
  }
  else {
    echo '<p>you are arleady registered!</p>';
  }
}
}
?>
          
      </div>
    </div>
    <div class ="footer">Website created @2015</div>
  </body>
</html>
