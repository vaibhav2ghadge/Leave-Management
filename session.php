<?php
@session_start();
require_once('connect.php');

// SQL Query To Fetch Complete Information Of User
//$user_check=$_SESSION['username'];
/*
$ses_sql=mysqli_query("SELECT username FROM sign_in WHERE username='$user_check'", $connection);
$row = mysqli_fetch_assoc($ses_sql);
*/
//$login_session =$row['username'];
$login_session =$_SESSION['username'];

if(!isset($login_session)){
mysql_close($connection); // Closing Connection
header('Location: index.php'); // Redirecting To Home Page

}

?>