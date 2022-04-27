<?php
include "connection.php";
$realtor_name=$_REQUEST['realtor_name'];
$realtor_contactNo=$_REQUEST['realtor_contactNo'];
$realtor_email=$_REQUEST['realtor_email'];
$realtor_address=$_REQUEST['realtor_address'];
$realtor_employer_id=strtoupper($_REQUEST['realtor_employer_id']);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$checkRealtor=mysqli_query($con,"select * from user_login where email='$realtor_email' and type_of_user='Realtor'");
$realtorExist=mysqli_num_rows($checkRealtor);

$checkRealtorTemp=mysqli_query($con,"select * from user_login_temp where email='$realtor_email' and type_of_user='Realtor'");
$realtorExistTemp=mysqli_num_rows($checkRealtorTemp);

if($realtorExist>0 || $realtorExistTemp>0)
{
echo "There is another realtor registered already using the same email ID";
}
else
{

mysqli_query($con,"insert into user_login_temp(first_name,contact_number,email,type_of_user,address_line1,email_verified,registered_on)values('$realtor_name','$realtor_contactNo','$realtor_email','Realtor','$realtor_address',0,now())");
$realtor_id=mysqli_insert_id($con);

mysqli_query($con,"insert into realtor_profile(realtor_id,realtor_employer_id,first_name,contact_number,email,address_line1)values('$realtor_id','$realtor_employer_id','$realtor_name','$realtor_contactNo','$realtor_email','$realtor_address')");
$realtor_profile_id=mysqli_insert_id($con);


email($realtor_email,"Realtor",$realtor_name,$realtor_id,$realtor_profile_id);


echo "Realtor has been registered and Email sent to realtor for approval.";
}



function email($email,$type_of_user,$first_name,$id,$profile_id)
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

$mail->From = $_SESSION['emailUserID'];
$mail->FromName = "Fotopia";

$mail->addAddress($email);


//Address to which recipient will reply
$mail->addReplyTo($_SESSION['emailUserID'], "Reply");

//CC and BCC
//$mail->addCC("cc@example.com");
//$mail->addBCC("bcc@example.com");

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "Realtor Registration ";
$mail->Body = "<html><head><style>.button {
  background-color: black;
  border: none;
  color: white !important;
  padding: 3px 5px;
  text-align: center;
  border-radius:10px;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}
.titleCss {font-family: \"Roboto\",Helvetica,Arial,sans-serif;font-weight:600;font-size:18px;color:#0275D8 }.emailCss { width:100%;border:solid 1px #DDD;font-family: \"Roboto\",Helvetica,Arial,sans-serif; } </style></head><table cellpadding=\"5\" class=\"emailCss\"><tr><td align=\"left\"><img src=\"".$_SESSION['project_url']."logo.png\" /></td><td align=\"center\" class=\"titleCss\">REALTOR REGISTRATION SUCCESSFUL</td><td align=\"right\">".$_SESSION['support_team_email']."<br>".$_SESSION['support_team_phone']."</td></tr><tr><td colspan=\"2\"><br><br>";
//$mail->AltBody = "This is the plain text version of the email content";




$mail->Body.="<b>Dear {{Registrered_User_Name}},</b><br><br>

{{PC_Organisation_Name}} has created you as a {{Type_of_user}} in the Fotopia application .<br>
To register with Fotopia App please follow the options below, <br />
<br><br>
<a href='{{project_url}}admin/Realtor_approve.php?id={{id}}&profile_id={{profile_id}}&user_type={{Type_of_user}}&approve=1' class='button' style='background:#5cb85c !important;padding:5px;' >Proceed</a>&nbsp;&nbsp;<a href='{{project_url}}admin/Realtor_approve.php?id={{id}}&profile_id={{profile_id}}&approve=0' class='button' style='background:#d9534f !important;padding:5px'>Decline</a>
<br><br><span style=\"font-size:10px;font-weight:bold;\">*This is an auto generated email notification from Fotopia. Please do not reply back to this email. For any support please write to support@fotopia.no</span><br><br>
Thanks,<br>
Fotopia Team.";

$mail->Body.="<br><br></td></tr></table></html>";
$mail->Body=str_replace('{{Type_of_user}}',$type_of_user, $mail->Body);
$mail->Body=str_replace('{{project_url}}',$_SESSION['project_url'], $mail->Body);
$mail->Body=str_replace('{{PC_Organisation_Name}}',$_SESSION['admin_loggedin_org'], $mail->Body);
$mail->Body=str_replace('{{id}}',$id, $mail->Body);
$mail->Body=str_replace('{{profile_id}}',$profile_id, $mail->Body);
$mail->Body=str_replace('{{Registrered_User_Name}}',$first_name, $mail->Body);
// echo $mail->Body;exit;



try {
    $mail->send();
    //echo "Message has been sent successfully";
} catch (Exception $e) {
echo $e->getMessage();
    echo "Mailer Error: " . $mail->ErrorInfo;
}
}


 ?>
