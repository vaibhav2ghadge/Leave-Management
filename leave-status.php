<?php
include('session.php');
include("./inc/header.inc.php"); ?>
<?php
	$username=$_SESSION['username'];
	$check_user_details = mysqli_query($connection,"SELECT * FROM sign_in WHERE username ='$username'") or die ("query not executed");
	$get_user_details = mysqli_fetch_array($check_user_details);

	$id = strip_tags($get_user_details['id']);
	$desig = strip_tags($get_user_details['designation']);

//$get_leave_details = mysqli_fetch_array($check_leave_details);
//print_r($get_leave_details);

?>

<?php
	 if(isset($_POST['delete']) & !empty($_POST))
        {
        	
        	$lno=$_POST['lno'];
        	echo $lno;
        	mysqli_query($connection,"DELETE FROM leave_request WHERE lid='$lno' ") or die("not delted");
        	//refresh entire page
        	echo "<meta http-equiv='refresh' content='0'>";
        
        }
?>

  <body>
 	<?php include("./inc/nav.inc.php"); ?>
 	<!-- USERS LEAVE !-->
 	<div class="container">
 	<table class="table table-hover table-bordered">
 	<legend class="mp">Leave Status</legend>
 	<tr class="mlwe">
 		
 		<th> Leave Type </th>
 		<th>Leave Start Date </th>
 		<th> Leave Ends Date </th>
 		<th> Leave Reason </th>
 		<th> Leave Submitted </th>
 		<th> Status</th>
 		<th> Action</th>
 	</tr>
 	<?php
 	$lid1;
 	$check_leave_details = mysqli_query($connection,"SELECT * FROM leave_request WHERE id ='$id' ORDER BY lid DESC") or die ("query not executed");
 		$useridg = [];
 		$usersts=[];
 		$usernames=[];
 	while($res=mysqli_fetch_assoc($check_leave_details))
 	{
 		$id1=$id3=$res['lid'];
 		$mjgjt = MYSQLI_QUERY($connection,"SELECT leave_grant.uid,leave_grant.status FROM leave_grant,leave_request WHERE leave_grant.lid=leave_request.lid AND leave_grant.lid ='$id3'") OR DIE ("Problem To getting User Status");
 		while($dfr=MYSQLI_FETCH_ASSOC($mjgjt))
 		{
 				$useridg[]= $dfr['uid'];

 				$usersts[]= $dfr['status'];
 		}
 		for($i=0;$i<sizeof($useridg);$i++)
 		{
 			$xs = $useridg[$i];
 			
 			$asde = MYSQLI_QUERY($connection,"SELECT name,sname FROM sign_in WHERE id='$xs' ") or die("line 65 problem");
 				$jsh = MYSQLI_FETCH_ASSOC($asde);
 				$usernames[]=$jsh['name']." ".$jsh['sname'];		
 		}
 		
 		echo "<tr class=''>";
 		
 			echo "<td>".$res['leavetype']."</td>";
 			echo "<td>".$res['lstart']."</td>";
 			echo "<td>".$res['lend']."</td>";
 			echo "<td>".$res['lreason']."</td>";
 			echo "<td>".$res['lstime']."</td>";
 			echo "<td>";

 			if($res['lstatus']=="Approved")
 			{
 				echo "Principle"."<input type='button' class='btn btn-success btn-sm pull-right' value=".$res['lstatus'].">";
 			}
 			else if($res['lstatus']=="PriRejected")
 			{
 				echo "Principle"."<input type='button' class='btn btn-danger btn-sm pull-right' value="."Rejected".">";
 			}
 			else if($res['lstatus']=="HodApproved")
 			{
 				echo "Hod"."<input type='button' class='btn btn-warning btn-sm pull-right' value="."Approved".">";
 			}

 			else if($res['lstatus']=="HodRejected")
 			{
 				echo "Hod"."<input type='button' class='btn btn-danger btn-sm pull-right' value="."Rejected".">";
 			}
 			else
 			{
 			for($i=0;$i<sizeof($usernames);$i++)
 			{
 				echo $usernames[$i]."<input type='button' class='btn btn-warning btn-sm pull-right' value=".$usersts[$i].">";
 				echo "<br><br>";
 			}
 			}
 			echo "</td>";
 			$flg=0;
 			for($i=0;$i<sizeof($usersts);$i++)
 			{
 				if($usersts[$i]=="Approved")
 				{
 					$flg=1;
 				}
 				else
 				{
 					$flg=0;
 					break;
 				}
 			}
 		
 		?>
 		<td>  
 		<?php   if($flg==0)     {     ?>
 		<form method='POST' action='<?php $_SERVER['PHP_SELF'] ?>' > <input class='btn btn-danger   fer' type='submit' name='delete' value='Cancel Leave'>
      <input type='hidden' name='lno' value=' <?php echo $res['lid']; ?>'  >
      <?php } else {         ?>
       <input class='btn btn-danger fer'  type='submit' name='delete' value='Cancel Leave' disabled>
       <?php } ?>
 </form> 
 
 		</td></tr>
 		<?php
 		$useridg = [];
 		$usersts=[];
 		$usernames=[];
 	}
 	?>
 	<tr>
 	</tr>
 	</table>
 	<br>
<?php

	if($desig=="hod")
	{
		$query_hod="SELECT DISTINCT leave_request.lid,leave_request.leavetype,leave_request.lstart,leave_request.lend,leave_request.lreason,leave_request.lstime,leave_request.lstatus,leave_request.id  FROM leave_request,leave_grant WHERE leave_request.lid=leave_grant.lid AND  leave_grant.lid NOT IN(SELECT lid FROM leave_grant WHERE status='pending' OR status='Rejected') AND lstatus='pending' ";
		$ress=mysqli_query($connection,$query_hod) or die("hod query problem");
?>
		 	<table class="table table-hover">
		 	
	<legend class="mp">HOD Request</legend>
 	<tr class="mlwe">

 		
 		<th> Name </th>
 		<th> Leave Type </th>
 		<th>Leave Start Date </th>
 		<th> Leave Ends Date </th>
 		<th> Leave Reason </th>
 		<th> Status</th>
 	</tr>
 	<?php

 	while($res=mysqli_fetch_assoc($ress))
 	{
 		echo "<tr>";
 		
 		$id2 = $res['id'];
 		$res3 = MYSQLI_QUERY($connection,"SELECT name,sname FROM sign_in WHERE id='$id2'") OR DIE ("PROBLEM TO GETTING FNAME ND LNAME FRO HOD GRANR");	
 		$res4 = MYSQLI_FETCH_ASSOC($res3);
 		$name2 = $res4['name']." ".$res4['sname'];
 		echo "<td>".$name2."</td>";
 		echo "<td>".$res['leavetype']."</td>";
 		echo "<td>".$res['lstart']."</td>";
 		echo "<td>".$res['lend']."</td>";
 		echo "<td>".$res['lreason']."</td>";
 						
 	?>
 	<td>
 					<form method="POST" action=''>
        <input type='submit' name='action' value='Accept' class="btn btn-success"/>
        <input type='submit' name='action' value='Reject' class="btn btn-danger"/>
        <input type='hidden' name='id' value="<?php echo $res['lid']; ?>"/>
     
      </form>
      </td>
 			<?php	

 		 		}
 		echo "</tr>";
 	}
 
 	?>
 	<tr>
 	</tr>
 	</table>

<!-- HOD LOGIC FOR ACCEPT AND REJECT -->


<?php
if(isset($_POST))
{
	if(isset($_POST['action']) && $_POST['id'])
	 {
	 	if($_POST['action']=="Accept")
	 	{
	 		$a = "HodApproved";
	 		$id= $_POST['id'];
	 		$qry = "UPDATE leave_request SET lstatus='$a' where lid='$id'";
	 		$re = mysqli_query($connection,$qry) or die("Value not updated");
	 		//refresh entire page
        	echo "<meta http-equiv='refresh' content='0'>";

	 		
	 	}
	 	if($_POST['action']=="Reject")
	 	{
	 			$a = "HodRejected";
	 		$id= $_POST['id'];
	 		$qry = "UPDATE leave_request SET lstatus='$a' where lid='$id'";
	 		$re = mysqli_query($connection,$qry) or die("Value not updated");
	 		//refresh entire page
        	echo "<meta http-equiv='refresh' content='0'>";

	 	}
	 }
}
 ?>


<!-- Principle logic for accedpt only hod accepted request-->



<?php

	if($desig=="principal")
	{
		$query_pri="SELECT DISTINCT leave_request.lid,leave_request.leavetype,leave_request.lstart,leave_request.lend,leave_request.lreason,leave_request.lstime,leave_request.lstatus,leave_request.id  FROM leave_request WHERE lstatus='HodApproved' ";
		$po=mysqli_query($connection,$query_pri) or die("principle query problem");
?>
		 	<table class="table table-hover">
		 	
	<legend class="mp">Principal Request</legend>
 	<tr>

 		<th> lid</th>
 		<th> Name </th>
 		<th> Leave Type1 </th>
 		<th>Leave Start Date </th>
 		<th> Leave Ends Date </th>
 		<th> Leave Reason </th>
 		<th> Status</th>
 	</tr>
 	<?php

 	while($res=mysqli_fetch_assoc($po))
 	{
 		echo "<tr>";
 		echo "<td>".$res['lid']."</td>";
 		$id2 = $res['id'];
 		$res3 = MYSQLI_QUERY($connection,"SELECT name,sname FROM sign_in WHERE id='$id2'") OR DIE ("PROBLEM TO GETTING FNAME ND LNAME FRO HOD GRANR");	
 		$res4 = MYSQLI_FETCH_ASSOC($res3);
 		$name2 = $res4['name']." ".$res4['sname'];
 		echo "<td>".$name2."</td>";
 		echo "<td>".$res['leavetype']."</td>";
 		echo "<td>".$res['lstart']."</td>";
 		echo "<td>".$res['lend']."</td>";
 		echo "<td>".$res['lreason']."</td>";
 						
 	?>
 	<td>
 					<form method="POST" action=''>
        <input type='submit' name='actionpri' value='Accept' class="btn btn-success"/>
        <input type='submit' name='actionpri' value='Reject' class="btn btn-danger"/>
        <input type='hidden' name='id' value="<?php echo $res['lid']; ?>"/>
     
      </form>
      </td>
 			<?php	

 		 		}
 		echo "</tr>";
 	}
 
 	?>
 	<tr>
 	</tr>
 	</table>

<!-- pri LOGIC FOR ACCEPT AND REJECT -->


<?php
if(isset($_POST))
{
	if(isset($_POST['actionpri']) && $_POST['id'])
	 {
	 	if($_POST['actionpri']=="Accept")
	 	{
	 		$a = "Approved";
	 		$id= $_POST['id'];
	 		$qry = "UPDATE leave_request SET lstatus='$a' where lid='$id'";
	 		$re = mysqli_query($connection,$qry) or die("Value not updated");
	 		//echo "leave approved";
	 		//refresh entire page
        	echo "<meta http-equiv='refresh' content='0'>";

	 		
	 	}
	 	if($_POST['actionpri']=="Reject")
	 	{
	 			$a = "PriRejected";
	 		$id= $_POST['id'];
	 		$qry = "UPDATE leave_request SET lstatus='$a' where lid='$id'";
	 		$re = mysqli_query($connection,$qry) or die("Value not updated");
	 		//echo "leave rejected";
	 		//refresh entire page
        	echo "<meta http-equiv='refresh' content='0'>";
	 	}
	 }
}
 ?>
























 	<!-- FOR ACCEPT AND REJET OTHER USER REQUEST -->
<table class="table table-hover">
 	<legend class="mp">Other Request</legend>
 	<tr class="mlwe">
 		<th> Name </th>
 		
 		<th>Date </th>
 		<th> Class </th>
 		<th> Time </th>
 		<th> Room No </th>
 		<th> Action</th>
 	</tr>


<?php
 	$cdf = $_SESSION['username'];

 	$olrequest= MYSQLI_QUERY($connection,"SELECT * FROM leave_grant WHERE uid IN (SELECT id FROM sign_in WHERE username='$cdf') AND status='pending' ") or die ("PROBLEM TO ACCEPT AND REJET OTHER USER REQUEST");
 	
 	while($ress=mysqli_fetch_assoc($olrequest))
 	{
 		
 		$lid1 = $ress['lid'];
 		
 		$olname = MYSQLI_QUERY($connection,"SELECT id FROM leave_request WHERE lid='$lid1'");
 		while($resss=mysqli_fetch_assoc($olname))
 		{
 			
 			$uid1=$resss['id'];
 			
 			$olname1 = MYSQLI_QUERY($connection,"SELECT name,sname FROM sign_in WHERE id = '$uid1'");
 			while($ress1 = MYSQLI_FETCH_ASSOC($olname1))
 			{
 		
 				$name1 = $ress1['name']." ".$ress1['sname'];
 				//echo $name1;
 				echo "<tr> <td>".$name1."</td>";
 				echo "<td>".$ress['date']."</td>";
 				echo "<td>".$ress['class']."</td>";
 				echo "<td>".$ress['time']."</td>";
 				echo "<td>".$ress['rno']."</td>";
 			?>
 			<td><form method="POST" action=''>
        <input type='submit' name='action1' value='Accept' class="btn btn-success"/>
        <input type='submit' name='action1' value='Reject' class="btn btn-danger"/>
        <input type='hidden' name='id1' value="<?php echo $ress['lgid']; ?>"/>
   
      </form>
      </td>
      </tr>
 			<?php
 			}
 		}
 	}
?>

 	
 
 	<tr>
 	</tr>
 	</table>


<!-- OTHER USER LEAVE LOGIC FOR ACCEPT AND REJECT -->

<?php
if(isset($_POST))
{
	if(isset($_POST['action1']) && $_POST['id1'])
	 {
	 	if($_POST['action1']=="Accept")
	 	{
	 		$a = "Approved";
	 		$id= $_POST['id1'];
	 		$qry = "UPDATE leave_grant SET status='$a' where lgid='$id'";
	 		$re = mysqli_query($connection,$qry) or die("Value not updated");
	 		//refresh entire page
        	echo "<meta http-equiv='refresh' content='0'>";


	 		
	 	}
	 	if($_POST['action1']=="Reject")
	 	{
	 			$a = "Rejected";
	 		$id= $_POST['id1'];
	 		$qry = "UPDATE leave_grant SET status='$a' where lgid='$id'";
	 		$re = mysqli_query($connection,$qry) or die("Value not updated");
	 		//refresh entire page
        	echo "<meta http-equiv='refresh' content='0'>";


	 	}
	 }
}
 ?>

