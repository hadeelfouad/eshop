<?php
		include("config.php");
        $sql_tb1 = "CREATE TABLE users (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    firstname VARCHAR(30) NOT NULL,
                    lastname VARCHAR(30) NOT NULL,
                    email VARCHAR(50) NOT NULL,
                    password VARCHAR(15) NOt NULL,
                    avatar VARCHAR(20)
                    )";
        mysql_query($sql_tb1);
        $sql_tb2 = "CREATE TABLE product (
                    productid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(30) NOT NULL,
                    quantity int(6) UNSIGNED DEFAULT 100,
                    price decimal(10,2) DEFAULT 100.0,
                    photo VARCHAR(20)
                    )";
        mysql_query($sql_tb2);
        $sql_tb3 = "CREATE TABLE history (
                    userid INT(6),
                    productname VARCHAR(20),
                    quantity int(11),
                    totalprice int(11),
                    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )";
        mysql_query($sql_tb3);
?>
<?php
        $sql_tb4 = "CREATE TABLE cart (
                    productid int(6),
                    userid INT(6)
                    )";
        mysql_query($sql_tb4);
        $sql_in1 = "INSERT INTO product(name,photo) VALUES ('desktop computer','p1.jpg')";
        mysql_query($sql_in1);
        $sql_in2 = "INSERT INTO product(name,photo) VALUES ('mouse','p2.jpg')";
        mysql_query($sql_in2);
        $sql_in3 = "INSERT INTO product(name,photo) VALUES ('laptop','p3.jpg')";
        mysql_query($sql_in3);
        //echo $_SESSION['userid'];
        header("location:/eshop/login.php");
        exit();
?>