<?php

   date_default_timezone_set('Europe/London');

   //We have defined the four(4) parameters(host,username,password,database) needed to connect to the database in the constant.php and we imported it here.
   require_once("constants.php");

   // this is the code that connects PHP to the database(MySQL) and returns the $con handler for use in subsequent codes. Note: This particular file is include in all other files that need to connect to the database.
   $con=new mysqli(DB_HOST, DB_USER, DB_PASS,DB_NAME) or die($con->connect_error); 
   if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>