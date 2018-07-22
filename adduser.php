<?php
include('session.php');   //include('funtion.php');
      

                  $username=$_SESSION['username'];
            $ur = MYSQLI_QUERY($connection,"SELECT designation FROM sign_in WHERE username='$username' ") OR DIE("PROBLEM TO GETTING designation");
$ur1 = MYSQLI_FETCH_ASSOC($ur);
$des = $ur1['designation'];

if($des=="hod") { 
include('funtion.php');
include("./inc/header.inc.php"); ?>
  <body>

		<?php
				if(isset($_POST) && !empty($_POST))
				{
					$name = $_POST['Name'];
					$sname = $_POST['Surname'];
					$username = $_POST['Username'];
					$email = $_POST['Email'];
					$pass = $_POST['Password'];
					$pass1 = $_POST['Password1'];
					$dep = $_POST['Department'];
					$des = $_POST['Designation'];
		//			print_r($_POST);
					$ckuname = MYSQLI_QUERY($connection,"SELECT username FROM sign_in WHERE username='$username' ") OR DIE("PROBLEM TO FETCH USERNAME");
					if($pass==$pass1 && strlen($pass)>5)
					{
					if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false)
					{
					 $count=mysqli_num_rows($ckuname);
					 if($count==0)
					 {
					 	
					 
						 $ckuemail = MYSQLI_QUERY($connection,"SELECT email FROM sign_in WHERE email='$email' ") OR DIE("PROBLEM TO FETCH email");
						 $count1=mysqli_num_rows($ckuemail);
						 if($count1==0)
						 {
							 	
							 
							 MYSQLI_QUERY($connection,"INSERT INTO sign_in VALUES('','$name','$sname','$username','$email','$pass','$dep','$des') ") OR DIE("INFORMATION CANOT BE INSERTED IN DB");
							$smsg = "User Info Inserted successfully";
						}
						else
						{
								$fmsg = "UserName Already Exits";
						}
					}
					else
					{
						$fmsg = "Email Already Exits";
					}
				}
				else
				{
					$fmsg = "Enter Valid Email";
				}
			}
			else
			{
				$fmsg ="Password Not Match OR Must Be Greater Than 5";
			}
			}


		?>

		 <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
              <?php if(isset($fmsg)){ ?><div class="alert alert-danger alrt" role="alert"><center> <?php echo $fmsg; ?> </center></div><?php } ?>

 		<?php include("./inc/nav.inc.php"); ?>
		<div class="container">
		<div class="row">
		<div class="col-md-9 xp">
		<form class="form well well-lg rounded-circle" id= "rendered-form" method="POST">
			<div class="form-group">
		<label for="Name" class="col-sm-2 control-label xp">Name</label>
					<input type="text" required="required" class="small form-control"  placeholder="Ethan" name="Name">
					</div>
					<div class="form-group">
	<label for="Name" class="col-sm-2 control-label xp" >Surname</label>
					<input type="text" required="required" class="small form-control"  placeholder="Hunt" name="Surname">
					</div>
<div class="form-group">
		<label for="Username" class="col-sm-2 control-label xp">Username</label>
					<input type="text" required="required" class="small form-control"  placeholder="Joker324" name="Username">
					</div>
					<div class="form-group">
	<label for="Email" class="col-sm-2 control-label xp">Email</label>
					<input type="text" required="required" class="small form-control"  placeholder="Ethanhunt@mi.com" name="Email">
					</div>
<div class="form-group">
		<label for="Password" class="col-sm-2 control-label xp">Password</label>
					<input type="Password" required="required" class="small form-control"  placeholder="Eth******Hun" name="Password">
					</div>
<div class="form-group">
		<label for="Password1" class="col-sm-2 control-label xp">Conform Password</label>
					<input type="Password" required="required" class="small form-control"  placeholder="Eth******Hun" name="Password1">
					</div>
<?php
			$username=$_SESSION['username'];
			$res = MYSQLI_QUERY($connection,"SELECT id,name,sname,department,designation FROM sign_in WHERE username='$username' ") OR DIE("NOT GETTING USER DETTAILS");
			$res1 = MYSQLI_FETCH_ASSOC($res);
			$dep = $res1['department']; ?>




					<div class="form-group">
	<label for="Department" class="col-sm-2 control-label xp">Department</label>
					<select type="select"  class="form-control xp" name="Department" id="select-1479462616214" aria-required="true">
				<option value="<?php  echo $dep;  ?>" selected="true"><?php  echo $dep;  ?></option>
				
			</select>
			</div>
			<div class="form-group">
	<label for="Designation" class="col-sm-2 control-label xp">Designation</label>
					<select type="select"  class="form-control xp" name="Designation" id="Designation" aria-required="true">
				<option value="hod" >Head Of Department</option>
				<option value="teacher" selected="true">Teacher</option>
				<option value="lab assistance">Lab Assistance</option>
			</select>
			</div>

			
			
    </div>
    </div>
    <div class="form-group">
    
    <div class="row">
		<div class="col-md-9 xp" >
	<button class="btn-primary btn btn-success pp" name="button-1479462977067" style="success" id="button-1479462977067" type="Submit">Submit User Details</button>
	
	<button class="btn-primary btn btn-danger pull-right pp" name="button-1479462977067" style="success" id="button-1479462977067" type="reset">Clear User Details</button>
	
	</div>
	</div>
	

</div>




		</form>
		</div>
		</div>
		</div>
		</body>
<?php
}
else
{

	header('Location: index.php'); // Redirecting To Home Page

}
?>