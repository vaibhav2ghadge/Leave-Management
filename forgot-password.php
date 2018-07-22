<?php include("./inc/header.inc.php"); 
		require_once('connect.php');

?>


<?php
	if(!empty($_POST["forgot-password"])){
		
		$condition = "";
		if(!empty($_POST["user-email"])) {
			if(!empty($condition)) {
				
			}
			$condition = "email = '" . $_POST["user-email"] . "'";
		}
		
		if(!empty($condition)) {
			$condition = " where " . $condition;
		}

		$sql = "Select email,password from sign_in " . $condition;
		$result = mysqli_query($connection,$sql);
		$user = mysqli_fetch_array($result);
		
		if(!empty($user)) {
			
			if(!class_exists('PHPMailer')) 
			{
    			require('phpmailer/class.phpmailer.php');
				require('phpmailer/class.smtp.php');
			}

$mail = new PHPMailer();






$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port     = 587;  
$mail->Username = "tccollegeleave";
$mail->Password = "radarada";
$mail->Host     = "smtp.gmail.com";
$mail->Mailer   = "smtp";

$mail->SetFrom("tccollegeleave@gmail.com","Tc College");
$mail->AddReplyTo("tccollegeleave@gmail.com","Tc College");
//$mail->ReturnPath=SERDER_EMAIL;	
$mail->AddAddress("$user[0]");
$mail->Subject = "Forgot Password Recovery";		
$mail->WordWrap   = 80;
$content = "<b>your Password is $user[1].</b>"; $mail->MsgHTML($content);
$mail->IsHTML(true);

if(!$mail->Send()) {
	$fmsg = 'Problem in Sending Password Recovery Email';
} else {
	$smsg = 'Please check your email to get password!';
}






		} else {
			$fmsg = 'No Email Found';
		}
	}
?>
<?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
              <?php if(isset($fmsg)){ ?><div class="alert alert-danger alrt" role="alert"><center> <?php echo $fmsg; ?> </center></div><?php } ?>


<div class="col-sm-6 bn">

<h3 class="mh">Forgot Password</h3>
<form name="frmForgot" id="frmForgot" method="post" class="form well well-lg rounded-circle bn" onSubmit="return validate_forgot();">

	
	<div class="form-group">
		<label for="kl" class="col-sm-2 control-label ">Email</label>
		<div><input type="text" name="user-email" id="user-email" class="input-field form-control vg1" placeholder="eg:mi5@gmail.com"></div>
	</div>
	
	<div class="field-group">
		<button type="submit" name="forgot-password" id="forgot-password" value="Submit" class="btn-primary btn btn-success  vg3"> Reset Password</button>

		<a href="index.php" class="btn btn-warning">Go to Home</a>
	</div>	

</form>
