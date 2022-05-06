<?php
ob_start();
//session_start();
include "header.php";
include "connection.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function getName($n) {
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

function email($x,$y,$z)
{
	/* Exception class. */
	require 'C:\PHPMailer\src\Exception.php';

	/* The main PHPMailer class. */
	require 'C:\PHPMailer\src\PHPMailer.php';

	/* SMTP class, needed if you want to use SMTP. */
	require 'C:\PHPMailer\src\SMTP.php';

	$mail = new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host = $_SESSION['emailHost'];
	$mail->SMTPAuth = true;
	// //paste one generated by Mailtrap
	// //paste one generated by Mailtrap
	$mail->Username =$_SESSION['emailUserID'];
	$mail->Password =$_SESSION['emailPassword'];
	$mail->SMTPSecure = 'tls';
	$mail->Port = $_SESSION['emailPort'];
	//$mail->Port = 465;
	//From email address and name
	$mail->From = $_SESSION['emailUserID'];
	$mail->FromName = "Fotopia";

	//To address and name
	// ;
	// // //Recipient name is optional
	// //;
	// ;
	$mail->addAddress($y);


	//Address to which recipient will reply
	$mail->addReplyTo($_SESSION['emailUserID'], "Reply");

	//CC and BCC
	//$mail->addCC("cc@example.com");
	//$mail->addBCC("bcc@example.com");

	//Send HTML or Plain Text email
	$mail->isHTML(true);

	$mail->Subject = "Link to reset your Fotopia Password";
	$mail->Body = "<html><head><style>.titleCss {font-family: \"Roboto\",Helvetica,Arial,sans-serif;font-weight:600;font-size:18px;color:#0275D8 }.emailCss { width:100%;border:solid 1px #DDD;font-family: \"Roboto\",Helvetica,Arial,sans-serif; } </style></head><table cellpadding=\"5\" class=\"emailCss\"><tr><td align=\"left\"><img src=\"".$_SESSION['project_url']."logo.png\" /></td><td align=\"center\" class=\"titleCss\">LINK TO RESET PASSWORD</td><td align=\"right\">".$_SESSION['support_team_email']."<br>".$_SESSION['support_team_phone']."</td></tr><tr><td colspan=\"2\"><br><br>";
	//$mail->AltBody = "This is the plain text version of the email content";



	$mail->Body.="Dear {{Registrered_User_Name}},<br><br>

Your Secret Code is : {{secret_code}}<br><br>
<a href='{{project_url}}/resetPassword.php?email={{user_email}}' target='_blank'>
Click here</a> to reset your password

<br><br><span style=\"font-size:10px;font-weight:bold;\">*This is an auto generated email notification from Fotopia. Please do not reply back to this email. For any support please write to support@fotopia.no</span><br><br>
Thanks,<br>
Fotopia Team.";
  $mail->Body=str_replace('{{secret_code}}', $x , $mail->Body);
	$mail->Body=str_replace('{{project_url}}', $_SESSION['project_url'] , $mail->Body);
  $mail->Body=str_replace('{{user_email}}', $y , $mail->Body);
	$mail->Body=str_replace('{{Registrered_User_Name}}',$z, $mail->Body);
	$mail->Body.="<br><br></td></tr></table></html>";
	// echo $mail->Body;exit;



	try {
	    $mail->send();
	    echo "Message has been sent successfully";
	} catch (Exception $e) {
		echo $e->getMessage();
	    echo "Mailer Error: " . $mail->ErrorInfo;
	}
}

if(isset($_REQUEST['confirmbtn']))
{
$email=$_REQUEST['email'];
//echo "select * from user_login where email='$email'";
$res=mysqli_query($con,"select * from user_login where email='$email'");
$get_user=mysqli_fetch_assoc($res);
$exist=mysqli_num_rows($res);
$approved=$get_user['email_verified'];
if($exist==0)
	{
	header("location:forgotPassword.php?notexist=1");
	}
else if($exist!=0 && $approved==0)
{
header("location:forgotPassword.php?notapp=1");
}
else
{
$email_verification_code=getName(10);
mysqli_query($con,"update user_login set email_verification_code='$email_verification_code' where email='$email'");
email($email_verification_code,$email,$get_user['first_name']);
//echo "update user_login set email_verification_code='$email_verification_code' where email='$email'";exit;

header("location:forgotPassword.php?codesent=1");
}


}


 

//$code=$_REQUEST['code'];
//$res=mysqli_query($con,"select * from user_login where email_verification_code='$code'");
//$exist=mysqli_num_rows($res);
/*
if($exist!=0)
	{

	mysqli_query($con,"update user_login set email_verified=1 where email_verification_code='$code'");


 ?>
<div class="container content box-middle-container full-screen-size" data-sub-height="238">
            <div class="row">
                <div class="col-md-12 text-center box-middle">
                    <div>

                        <hr class="space m">
                        <h1 style="font-size:80px"><i class="fa fa-check" style="color:green"></i></h1>
                        <h1>Account activated!</h1>
                        <h5>
                            Your account has been activated. Please click the login button to proceed.</a>
                        </h5>
                        <hr class="space m">
                        <a class="anima-button btn-ms btn circle-button" href="login.php"><i class="fa fa-long-arrow-left"></i>Login</a>
                    </div>
                </div>
            </div>
        </div>
		<?php  }
		 */ ?>

		 <?php if(isset($_REQUEST['codesent']))
		 { ?>
		<div class="container content box-middle-container full-screen-size" data-sub-height="238">
            <div class="row">
                <div class="col-md-12 text-center box-middle">
                    <div>

                        <hr class="space m">
                        <h1 style="font-size:80px"><i class="fa fa-key" style="color:green"></i></h1>
                        <h1 id="label_password_reset_sent" adr_trans="label_password_reset_sent">Password reset code sent!</h1>
                        <h5>
                            <span id="label_reset_code" adr_trans="label_reset_code">Code to reset your password has been sent to your email. </span><br />
                            <span id="label_please_follow" adr_trans="label_please_follow">Please follow the email instrcution to continue reset your password.</span></a>
                        </h5>
                        <hr class="space m">
                        <a class="anima-button btn-ms btn circle-button adr-cancel" id="label_go_back_home" adr_trans="label_go_back_home" href="index.php"><i class="fa fa-long-arrow-left"></i>Go back to Home</a>
                    </div>
                </div>
            </div>
        </div>
		<?php }  ?>

		<?php if(!isset($_REQUEST['codesent']))
		{ ?>
		<div class="container content box-middle-container full-screen-size" data-sub-height="238">
            <div class="row">

			<div class="col-md-4"> &nbsp;</div>
                <div class="col-md-4 text-center box-middle">

                        <hr class="space m">
                        <h1 style="font-size:80px"><i class="fa fa-key fa-sm text-xl" style="color:green"></i></h1>
                        <h3 id="label_forgot_password" adr_trans="label_forgot_password">Forgot Password</h3>

						<?php if(isset($_REQUEST["notexist"])) { ?>
                        <div class="error-box"  style="display:block;">
                            <div class="alert alert-warning" id="label_email_not_exist"
                            adr_trans="label_email_not_exist">Email not exist. Please enter correct email and try again.</div>
                        </div>
						<?php } ?>

							<?php if(isset($_REQUEST["notapp"])) { ?>
                        <div class="error-box"  style="display:block;">
                            <div class="alert alert-warning" id="label_email_not_approved"
                            adr_trans="label_email_not_approved">Your registration is pending for Admin approval,<br /> So you will not use this facility now.</div>
                        </div>
						<?php } ?>

						<form name="reset" method="post" action="">
                        <h5>
                            <span  id="label_enter_email" adr_trans="label_enter_email">Enter your email :</span><br /><br />


					<input name="email" onblur="this.value=this.value.trim()"  type="email" placeholder="" autocomplete="off" class="form-control form-value" required="" size="40"  />

							<br /><br />
							 <button class="ActionBtn-sm AnimationBtn VerticalAlign-t" type="submit" name="confirmbtn" id="label_confirm" adr_trans="label_confirm"><i class="fa fa-sign-in"></i>Confirm</button>
                       &nbsp;&nbsp;<a class="CancelBtn-sm AnimationBtn" id="label_cancel"
                       adr_trans="label_cancel" href="login.php"><i class="fa fa-sign-in"></i>Cancel</a>
</center>

                        </h5>
                        </form>
                    </div>
					<div class="col-md-4 text-center box-middle"> &nbsp;</div>
                </div>

            </div>
        </div>

		<?php } ?>
		<?php include "footer.php";  ?>
