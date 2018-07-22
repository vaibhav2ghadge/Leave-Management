<?php
include('session.php');
include('funtion.php');

date_default_timezone_set('Asia/Kolkata');
//$date = date('m/d/Y h:i:s a', time());
//echo date_default_timezone_get();
//echo "<br> time zone ".$date;
	$username=$_SESSION['username'];
	$get_user_id = mysqli_query($connection,"SELECT id FROM sign_in WHERE username ='$username'") or die ("query not executed");
	$get_user_idr = mysqli_fetch_array($get_user_id);

	$usrid = strip_tags($get_user_idr['id']);
if(isset($_POST) & !empty($_POST))
{
	$timestamp = strtotime($_POST['startdate']);
		$timestamp1 = strtotime($_POST['enddate']);
		
		$interval = $timestamp1-$timestamp;
		$interval = ($interval/(60*60*24));
		//Calculating Academic year casual leave not greater than 15


$time= date('d/m/Y', time());//date('14/05/2017');
$d = date_parse_from_format("d-m-Y", $time);
//echo "<br>".$_SESSION['username'];
//echo $d['day']; 
$syear=null;
$eyear=null;
$datewhere=null;
$count1=0;
if($d['month']<6)
{
	 $syear=$d['year']-1;
	 $eyear=$d['year'];
	 $xty=$syear."-6-15";
	 $xty1=$eyear."-6-14";
//	 echo "<br>".$xty1."<br>";
	 $datewhere="SELECT COUNT(*) FROM leave_request WHERE id='$usrid' AND leavetype ='Casual' AND lstatus='Approved' AND lstart BETWEEN '$xty' AND '$xty1'";
	 
	
}
else if(($d['month']==6) && ($d['day']<=14))
{
	$syear=$d['year']-1;
	 $eyear=$d['year'];
	 $xty=$syear."-6-15";
	 $xty1=$eyear."-6-14";
//	 echo "<br>".$xty1."<br>";
	 $datewhere="SELECT COUNT(*) FROM leave_request WHERE id='$usrid' AND leavetype ='Casual' AND lstatus='Approved' AND lstart BETWEEN '$xty' AND '$xty1'";
	
}
else if(($d['month']==6) && ($d['day']>14))
{
	$syear=$d['year'];
	 $eyear=$d['year']+1;
	  $xty=$syear."-6-15";
	 $xty1=$eyear."-6-14";
//	 echo "<br>".$xty1."<br>";
	 $datewhere="SELECT COUNT(*) FROM leave_request WHERE id='$usrid' AND leavetype ='Casual' AND lstatus='Approved' AND lstart BETWEEN '$xty' AND '$xty1'";
	
}
else if(($d['month']>6))
{
	$syear=$d['year'];
	 $eyear=$d['year']+1;
	  $xty=$syear."-6-15";
	 $xty1=$eyear."-6-14";
//	 echo "<br>".$xty1."<br>";
	 $datewhere="SELECT COUNT(*) FROM leave_request WHERE id='$usrid' AND leavetype ='Casual' AND lstatus='Approved' AND lstart BETWEEN '$xty' AND '$xty1'";
	
}
//echo $datewhere;
$mm = mysqli_query($connection,$datewhere) or die ("query not executed");
$m=mysqli_fetch_array($mm);







	if($m[0]<=14)//casual leave conditon 15
	{
		if($interval<=3 && $interval>0 )
		{

		$username=$_SESSION['username'];
		$check_user_details = mysqli_query($connection,"SELECT * FROM sign_in WHERE username ='$username'") or die ("query not executed");

		//Get the logged in user info from the database
		while($get_user_details = mysqli_fetch_assoc($check_user_details))
		{
		//Pass all the logged in user info to variables to easily display them when needed
		//print_r($get_user_details);
			$user_id = $get_user_details['id'];

		}
		
		$leavetype = $_POST['leavetype'];
		$startdate = $_POST['startdate'];
		$enddate = $_POST['enddate'];
		$lreason = $_POST['lreason'];
		$noday=$_POST['noofday'];
		$m=0;
		//calculating day difference between two days
		//var_dump($startdate);
		

		/////////////////////////
		//dynamic added field value in array
		$bx_name = $_POST['BX_NAME'];
		$bx_date = $_POST['BX_DATE'];
		$bx_class = $_POST['BX_CLASS'];
		$bx_time = $_POST['BX_TIME'];
		$bx_rno = $_POST['BX_RNO'];
		$bx_lid;
		$uid1;
		mysqli_query($connection,"INSERT INTO leave_request VALUES('','$leavetype','$noday','$startdate','$enddate','$lreason',CURRENT_TIMESTAMP,'pending','$user_id')") or die("leave request not inserted");

		$res = mysqli_query($connection,"SELECT lid FROM leave_request WHERE id='$user_id' ORDER BY lid DESC LIMIT 1") or die ("id query not");
		while($ress=mysqli_fetch_array($res))
		 {
		 	$bx_lid = $ress[0];
		 }
		for($i=0;$i<sizeof($bx_rno);$i++)
		{
			$name=explode(' ',$bx_name[$i]);
			
			$res21 = mysqli_query($connection,"SELECT id FROM sign_in WHERE name='$name[0]' AND sname='$name[1]'	 ") or die("user id not found");
			while($res1231=mysqli_fetch_array($res21))
		 	{
		 		$uid1 = $res1231[0];
		 	}
			mysqli_query($connection,"INSERT INTO leave_grant VALUES('','$bx_lid','$uid1','$bx_class[$i]','$bx_rno[$i]','$bx_date[$i]','$bx_time[$i]','pending')");
		}
			$smsg="Your Leave successfully Submited";
			 $_REQUEST = $_POST = $_GET = NULL;
	 	}
	 	//error message if leave negative or greater than 3
	 	else
	 	{
	 		$fmsg ="Leave Must Be In Between 1 And 3 Days";
	 		 $_REQUEST = $_POST = $_GET = NULL;
	 	}
	 }//if end of causal leave
	 	else
	 	{
	 		$fmsg ="Your Causal Leave Quota For This Academic Year is Full";	
	 		 $_REQUEST = $_POST = $_GET = NULL;
	 	}
	 }
?>
 <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
              <?php if(isset($fmsg)){ ?><div class="alert alert-danger alrt" role="alert"><center> <?php echo $fmsg; ?> </center></div><?php } ?>

  <?php include("./inc/header.inc.php"); ?>
  <body>
 		<?php include("./inc/nav.inc.php"); ?>
		<div class="container">
		
		<form class="form well well-lg rounded-circle" id= "rendered-form" method="POST">

		<div class="form-group">
		<label class="col-sm-2 control-label">Date</label>
		<?php echo date('d/m/Y H:i:s'); ?>
		</div>
		<br>
		<div class="form-group">
		    <label class="col-sm-2 control-label " for="select-1479462616214" >Select Leave<span class="required">*</span> </label>
			<select type="select"  class="form-control" name="leavetype" id="select-1479462616214" aria-required="true">
				<option value="Casual" selected="true">Casual leave</option>
				<option value="Duty">Duty Leave</option>
			</select>
		</div>

		<div class="form-group">
		    <label class="col-sm-2 control-label " for="select-147946261621432" >Days<span class="required">*</span> </label>
			<select type="select"  class="form-control" name="noofday" id="select-147946261621432" aria-required="true">
				<option value="1" selected="true">ONE</option>
				<option value="2">TWO</option>
				<option value="3">THREE</option>
			</select>
		</div>





	<div class="form-group">
		<label for="date-1479462740507" class="col-sm-2 control-label">Start From <span class="required">*</span> </label> 
		<input type="date" class="calendar form-control" name="startdate" id="date-1479462740507" aria-required="true">
	</div>

	<div class="form-group">
		<label for="date-1479462821485" class="col-sm-2 control-label">End To <span class="required">*</span> </label> 
		<input type="date" class="calendar form-control" name="enddate" id="date-1479462821485" required>
	</div>
	<div class="clear"></div>
	<!--************************ Dynamic field for add teacher *************************************-->
		
    <fieldset >
	<legend class="control-label">Lecture Details</legend>
	<p> 
		<input type="button" class="btn btn-success	"value="Add Lecture" onClick="addRow('dataTable')" /> 
		<input type="button" class="btn btn-danger" value="Remove Lecture" onClick="deleteRow('dataTable')"  /> 
					
	</p>
    <table id="dataTable" class="table table-responsive " border="1">
    <tbody>
    	<tr>
            <p>
				<td><input type="checkbox" required="required" name="chk[]" checked="checked" /></td>
				<td>
					<label>Date</label>
					<input type="date" class="calendar form-control1" required="required" name="BX_DATE[]">
				</td>
				<td>
					<label for="BX_TIME">Time</label>
					<input type="text" required="required" class="small form-control1" placeholder="1.14PM "  name="BX_TIME[]">
				</td>

				<td>
					<label for="BX_CLASS">Class</label>
					<input type="text" required="required" class="small form-control1"  placeholder="TY BCS" name="BX_CLASS[]">
				</td>

				<td>
					<label for="BX_RNO">Room No</label>
					<input type="text" required="required" class="small form-control1" placeholder="J2" name="BX_RNO[]">
				</td>
				<td>

						 		
					<label for="BX_NAME">Teacher Name</label>
					<select class="form-control1" name="BX_NAME[]" >
						<?php //for($i=0;$i<$res[0];$i++)
											//{
												//echo " <option>vaibhav</option> ";
											//}
							while($ress1=mysqli_fetch_array($result1))
							{
								$mx=$ress1[0];
								$mx.=" $ress1[1]";

								echo "<option value='$mx'> ".$ress1[0]." ".$ress1[1]."</option>";
							}
						?>
					</select>

				</td>
			</p>
        </tr>

    </tbody>
	</table>
	<div class="clear"></div>
    </fieldset>


	<!-- End of Dynamic field -->
	<br/>

	<div class="form-group ">
	
	<label for="textarea-1479462871206" class="col-sm-2 control-label">Leave Reason <span >*</span> </label>
	
	<textarea type="textarea"  rows="3" class="form-control inputsm form-control3" name="lreason" maxlength="250" id="textarea-1479462871206" aria-required="true" placeholder="Your Leave Reason UPTO 250 character"></textarea>
	</div>
	
	<div class="form-group">
    <div class=" col-sm-10">
    <br>
    <br>
	<button class="btn-primary btn btn-success btn-s" name="button-1479462977067" style="success" id="button-1479462977067" type="Submit">Submit Leave</button>
	</div>
	</div>
	
	</form>
	</div>

  </body>
</html>