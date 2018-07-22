<?php

include('session.php');
require_once('connect.php');
////Calulating number of rows in user table
$sql = "SELECT count(*) FROM sign_in ";
$result = mysqli_query($connection,$sql) or die("faild to execute count from db");
while($ress=mysqli_fetch_array($result))
{
	$res=$ress[0];
}
///////////////////////////////////////
//Fetching user name and surname for other user leave
$sql1 = "SELECT name,sname FROM sign_in";

$result1 = mysqli_query($connection,$sql1);

?>