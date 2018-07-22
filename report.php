<?php
include('session.php');
include("./inc/header.inc.php"); ?>
  <body>
 		<?php include("./inc/nav.inc.php"); ?>

<div class="container">
	
		<form class="form  well well-lg rounded-circle" action="" method="POST">
			<label class="col-sm-2 control-label">Date:</label>
			<input type="date" required="required" class="small form-control1"   name="from">
			<input type="date" required="required" class="small form-control1"   name="to">

			<button class="btn-primary btn btn-success btn-sm" name=""  type="Submit">Submit</button>
			</form>
			<br> <br>
			
			<?php
				$time= date('d/m/Y', time());//date('14/05/2017');
				$d = date_parse_from_format("d-m-Y", $time);	
				

				if(isset($_POST) & !empty($_POST))
				{
					
					$from2 = $_POST['from'];
					$to2 = $_POST['to'];
					//$from2 = $from1."-6-15";
					//$to2 = $to1."-6-14";
					
				
			?>




			<?php
			$username=$_SESSION['username'];
			$res = MYSQLI_QUERY($connection,"SELECT id,name,sname,department,designation FROM sign_in WHERE username='$username' ") OR DIE("NOT GETTING USER DETTAILS");
			$res1 = MYSQLI_FETCH_ASSOC($res);
			$userid = $res1['id'];
			//print_r($res1);
			//calculating casual leave
			$ress = MYSQLI_QUERY($connection,"SELECT count(id) FROM leave_request WHERE id='$userid' AND lstatus='Approved' AND leavetype='Casual' AND lstime BETWEEN '$from2' AND '$to2' ");
			$res11 = MYSQLI_FETCH_ARRAY($ress);
			//calculating duty leave
			$resss = MYSQLI_QUERY($connection,"SELECT count(id) FROM leave_request WHERE id='$userid' AND lstatus='Approved' AND leavetype='Duty' AND lstime BETWEEN '$from2' AND '$to2' ");
			$res111 = MYSQLI_FETCH_ARRAY($resss);
			//print_r($res111);

			?>
			<div class=" well well-lg rounded-circle">
			<label>Id :</label> <span class="report1"><?php echo $res1['id'];  ?></span>
			<label class="reportright ">Staff Type:</label> <label class="reportright1 report1"><?php echo   $res1['designation'] ;  ?></label>


			<br>
			<label class="topbuff">Employee Name:</label><span class="report1"> <?php echo $res1['name']." ".$res1['sname'];  ?></span>
			<label class="reportrightt ">Department:</label><label class="reportright1 report1"> <?php echo $res1['department'];?></label>
			
			
			<br>
			<label class="topbuff">Total CL:</label> <label class="report1"><?php echo $res11[0];  ?></label>
			<label class="mn">Academic Year :</label> <label class="report1"><?php echo $from2." TO ".$to2 ;?> </label>
			<label class="reportrighttt">Total DL:</label><label class="report1"> <?php echo $res111[0];?></label>





					<table class="table table-bordered">
			<tr>
			<th>Appli.Date </th>	
			<th>From </th>
			<th>To </th>
			<th>Day Count </th>
			<th>Remark </th>
			<th>Reason </th>
			</tr>
			<tr>
			<td colspan="6" align="center">Casual Leave</td>

			</tr>

			<?php 

				$ressss = MYSQLI_QUERY($connection,"SELECT * FROM leave_request WHERE id='$userid' AND leavetype='Casual' AND lstime BETWEEN '$from2' AND '$to2' ") OR DIE("PROBLEM TO GETTING CASUAL LEAVE");
	
				while($res1111 = MYSQLI_FETCH_ASSOC($ressss))
				{




			?>
			
			<tr>
			<td> <?php echo $res1111['lstime']; ?> </td>
			<td> <?php echo $res1111['lstart']; ?>  </td>
			<td> <?php echo $res1111['lend']; ?>  </td>
			<td> <?php echo $res1111['noday']; ?>  </td>
			<td> <?php echo $res1111['lstatus']; ?>  </td>
			<td> <?php echo $res1111['lreason']; ?>  </td>
			</tr>
			<?php   }    ?>
			<tr>
			<td colspan="6" align="center">Duty Leave</td>

			</tr>

			<?php 

				$resssss = MYSQLI_QUERY($connection,"SELECT * FROM leave_request WHERE id='$userid' AND leavetype='Duty' AND lstime BETWEEN '$from2' AND '$to2' ") OR DIE("PROBLEM TO GETTING CASUAL LEAVE");
	
				while($res11111 = MYSQLI_FETCH_ASSOC($resssss))
				{




			?>
			
			<tr>
			<td> <?php echo $res11111['lstime']; ?> </td>
			<td> <?php echo $res11111['lstart']; ?>  </td>
			<td> <?php echo $res11111['lend']; ?>  </td>
			<td> <?php echo $res11111['noday']; ?>  </td>
			<td> <?php echo $res11111['lstatus']; ?>  </td>
			<td> <?php echo $res11111['lreason']; ?>  </td>
			</tr>
			<?php   }   }//end of $_post
			 ?>

			</table>
		</div>
		</div>
		</div>
</div>
</body>