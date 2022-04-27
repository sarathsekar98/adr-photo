<?php
   include "connection1.php";

   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
   function email($x,$y,$z,$v,$w)
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
   	 $mail->addAddress($w);


   	//Address to which recipient will reply
   	$mail->addReplyTo($_SESSION['emailUserID'], "Reply");

   	//CC and BCC
   	//$mail->addCC("cc@example.com");
   	//$mail->addBCC("bcc@example.com");

   	//Send HTML or Plain Text email
   	$mail->isHTML(true);

   	$mail->Subject = "Order Cost";
   	$mail->Body = "<html><head><style>.titleCss {font-family: \"Roboto\",Helvetica,Arial,sans-serif;font-weight:600;font-size:18px;color:#0275D8 }.emailCss { width:100%;border:solid 1px #DDD;font-family: \"Roboto\",Helvetica,Arial,sans-serif; } </style></head><table cellpadding=\"5\" class=\"emailCss\"><tr><td align=\"left\"><img src=\"".$_SESSION['project_url']."logo.png\" /></td><td align=\"center\" class=\"titleCss\">ORDER COST CREATED SUCCESSFULLY!</td><td align=\"right\">".$_SESSION['support_team_email']."<br>".$_SESSION['support_team_phone']."</td></tr><tr><td colspan=\"2\"><br><br>";
   	//$mail->AltBody = "This is the plain text version of the email content";
   	$mail->Body.="
    Hello {{Realtor_Name}},<br>

Order Cost has been generated by {{Photographer_Name}} for the order assignment
#F{{orderId}} dated {{DateAndTime}}.<br>

You may login to <a href=
'{{project_url}}' target='_blank'>Fotopia</a> to
review and approve the Order Cost.

<br><br><span style=\"font-size:10px;font-weight:bold;\">*This is an auto generated email notification from Fotopia. Please do not reply back to this email. For any support please write to support@fotopia.no</span><br><br>
Thanks,<br>
Fotopia Team.";

   	  $mail->Body=str_replace('{{project_url}}',$_SESSION['project_url'], $mail->Body);
      $mail->Body=str_replace('{{Photographer_Name}}', $x , $mail->Body);
   	  $mail->Body=str_replace('F{{orderId}}',$z, $mail->Body);
     	$mail->Body=str_replace('{{Realtor_Name}}',$y, $mail->Body);
      $mail->Body=str_replace('{{DateAndTime}}',$v, $mail->Body);
   	  $mail->Body.="<br><br></td></tr></table></html>";
   	 //echo $mail->Body;exit;
   	try {
   	    $mail->send();
   	    echo "Message has been sent successfully";
   	} catch (Exception $e) {
   		echo $e->getMessage();
   	    echo "Mailer Error: " . $mail->ErrorInfo;
   	}
   }
   $order_id=$_REQUEST['id'];
   mysqli_query($con,"UPDATE `invoice` SET `approved`=1 WHERE order_id=$order_id");
   $get_order_query=mysqli_query($con,"select * from orders where id=$order_id");
   $get_order=mysqli_fetch_assoc($get_order_query);
   $loggedin_name=$_SESSION['loggedin_name'];
   $loggedin_id=$get_order['created_by_id'];
   $get_photgrapher_name_query1=mysqli_query($con,"SELECT * FROM user_login where id='$loggedin_id'");
   $get_name1=mysqli_fetch_assoc($get_photgrapher_name_query1);
   $realtor=$get_name1["first_name"]." ".$get_name1["last_name"];
   $realtor_email=$get_name1['email'];
   $date = date('m/d/Y h:i:s a', time());
   email($loggedin_name,$realtor,$order_id,$date,$realtor_email);
   $insert_action=mysqli_query($con,"INSERT INTO `user_actions`( `module`, `action`, `action_done_by_name`, `action_done_by_id`,`action_done_by_type`, `photographer_id`, `action_date`) VALUES ('Invoice','Created','$loggedin_name',$loggedin_id,'Photographer',$loggedin_id,now())");
 ?>
