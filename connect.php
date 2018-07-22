<?php
$connection=mysqli_connect("localhost","root","") or die (" Problem to connect database");
mysqli_select_db($connection,"log_in") or die ("Faild to select database"); 
 
?>