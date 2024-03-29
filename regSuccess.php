
<?php include "header.php";  ?>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
// $mail->addAddress("sidambara.selvan@adrgrp.com","Sid");

$mail->addAddress($_REQUEST['email']);


//Address to which recipient will reply
$mail->addReplyTo($_SESSION['emailUserID'], "Reply");

//CC and BCC
//$mail->addCC("cc@example.com");
//$mail->addBCC("bcc@example.com");

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = @$_REQUEST['type']." Registration";
$mail->Body = "<html><head><style>.titleCss {font-family: \"Roboto\",Helvetica,Arial,sans-serif;font-weight:600;font-size:18px;color:#0275D8 }.emailCss { width:100%;border:solid 1px #DDD;font-family: \"Roboto\",Helvetica,Arial,sans-serif; } </style></head><table cellpadding=\"5\" class=\"emailCss\"><tr><td align=\"left\"><img src=\"".$_SESSION['project_url']."logo.png\" /></td><td align=\"center\" class=\"titleCss\"> ".strtoupper($_REQUEST['type'])." REGISTRATION SUCCESSFUL</td><td align=\"right\">".$_SESSION['support_team_email']."<br>".$_SESSION['support_team_phone']."</td></tr><tr><td colspan=\"2\"><br><br>";
//$mail->AltBody = "This is the plain text version of the email content";




$mail->Body.="<b>Dear {{Registrered_User_Name}},</b><br><br>

You are successfully registered as a {{Type_of_user}} in our Fotopia application.<br>
You will be notified via email once a Fotopia Admin approves your registration. (*Please note that you will not be able to login until approved).
<br><br><span style=\"font-size:10px;font-weight:bold;\">*This is an auto generated email notification from Fotopia. Please do not reply back to this email. For any support please write to support@fotopia.no</span><br><br>
Thanks,<br>
Fotopia Team.";

$mail->Body.="<br><br></td></tr></table></html>";
$mail->Body=str_replace('{{Type_of_user}}', $_REQUEST['type'], $mail->Body);
$mail->Body=str_replace('{{Registrered_User_Name}}',$_REQUEST['name']." ".$_REQUEST['lname'], $mail->Body);
//echo $mail->Body;exit;



try {
    $mail->send();
    //echo "Message has been sent successfully";
} catch (Exception $e) {
	echo $e->getMessage();
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
<div class="container content box-middle-container full-screen-size" data-sub-height="238">
            <div class="row">
                <div class="col-md-12 text-center box-middle">
                    <div>
                        <hr class="space m">
                        <h1 style="font-size:80px"><i class="fa fa-check" style="color:green"></i></h1>
                        <h1 id="label_registration_success" adr_trans="label_registration_success">Registration Successful!</h1>
                        <h5>
                        You are successfully registered as a <?php echo @$_REQUEST['type']; ?><br />
                        <span id="label_admin_approved_email" adr_trans="label_admin_approved_email">You will be notified in email when Admin approved.</span> <br />
                        <span id="label_admin_not_approved" adr_trans="label_admin_not_approved">You can login only after admin approved your account.</span>
                        </h5>
                        <hr class="space m">
                        <a class="AnimationBtn btn-ms CancelBtn-sm " id="label_go_back_home" adr_trans="label_go_back_home" href="index.php"><i class="fa fa-long-arrow-left"></i>Go back to home</a>
                    </div>
                </div>
            </div>
        </div>

		<?php include "footer.php";  ?>
