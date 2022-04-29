<?php
ob_start();

include "connection1.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Login Check
if(isset($_REQUEST['loginbtn']))
{
	header("location:index.php?failed=1");
}


function email($y,$z)
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
	 $mail->addAddress($z);


	//Address to which recipient will reply
	$mail->addReplyTo($_SESSION['emailUserID'], "Reply");

	//CC and BCC
	//$mail->addCC("cc@example.com");
	//$mail->addBCC("bcc@example.com");

	//Send HTML or Plain Text email
	$mail->isHTML(true);

	$mail->Subject = "Approved successfully";
	$mail->Body = "<html><head><style>.titleCss {font-family: \"Roboto\",Helvetica,Arial,sans-serif;font-weight:600;font-size:18px;color:#0275D8 }.emailCss { width:100%;border:solid 1px #DDD;font-family: \"Roboto\",Helvetica,Arial,sans-serif; } </style></head><table cellpadding=\"5\" class=\"emailCss\"><tr><td align=\"left\"><img src=\"".$_SESSION['project_url']."logo.png\" /></td><td align=\"center\" class=\"titleCss\">ADMIN APPROVED SUCCESSFUL</td><td align=\"right\">".$_SESSION['support_team_email']."<br>".$_SESSION['support_team_phone']."</td></tr><tr><td colspan=\"2\"><br><br>";
	//$mail->AltBody = "This is the plain text version of the email content";



	$mail->Body.="Dear {{Registrered_User_Name}},<br><br>

Welcome to Fotopia!<br><br>

Your account has been approved by Fotopia Admin Team.<br>
<a href='{{project_url}}/login.php' target='_blank'>click here</a>
to login in to your Fotopia account.
<br><br><span style=\"font-size:10px;font-weight:bold;\">*This is an auto generated email notification from Fotopia. Please do not reply back to this email. For any support please write to support@fotopia.no</span><br><br>
Thanks,<br>
Fotopia Team.";
	$mail->Body=str_replace('{{project_url}}', $_SESSION['project_url'] , $mail->Body);
	$mail->Body=str_replace('{{Registrered_User_Name}}',$y, $mail->Body);
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

?>



<?php include "header.php";  ?>


<style>

@media only screen and (max-width: 600px) {
		#table2{

      width: 130px!important;
    /*margin-left: -85px!important;*/
}
}

	#table2{

      width: 390px;
   }

</style>
		
<div class="section-empty bgimage7">
            <div class="row">
<hr class="space s">

			<div class="col-md-2">
				<script>
				   $(".hidden-xs").css("margin-right":"46px");
				</script>

	<?php

		include "sidebar.php";

	 ?>


			</div>
                <div class="col-md-8"  style="padding-top:0px;">
                <hr class="space s" />  


<?php

$loggedin_id=$_SESSION["loggedin_id"];
				$res=mysqli_query($con,"select * from realtor_profile where realtor_id='$loggedin_id'");
				$res1=mysqli_fetch_array($res);

				?>

				<?php if(@isset($_REQUEST["u"])) { ?>
                        <div class="success-box" style="display:block;margin-left:330px;">
                            <div class="text-success" adr_trans="label_profile_update_msg">Profile information updated successfully</div>
                        </div>
						<?php }  ?>

					<table class="ProfileTable W-100"   cellpadding="10" cellspacing="10">

					<tbody class="TableContent">
						<tr><td colspan="3"><hr class="space xs" /></td></tr>
            <tr><td align="center" colspan="3" ><span></span></td></tr>
	  <?php

	  $userExist=mysqli_num_rows($res);

	  if ($userExist == 0) { ?>

	  	<tr><td   ><span adr_trans="label_no_profile">No profile information</span></td></tr>

	 <?php  }
	 else{ 

	   ?>
<tr><td colspan="3"><hr class="space xs" /></td></tr>
	    <tr><td id="table2"><img src="data:<?php echo @$res1['logo_image_type']; ?>;base64,<?php echo base64_encode(@$res1['logo']); ?>" width="60" height="60" /></td><td>&nbsp;</td><td class="Text-lg fa-2x"><?php echo @$res1['organization_name']; ?>
		 </td></tr>
		 <tr><td colspan="3"><hr class="space xs" /></td></tr>
		 <tr><td   ><span adr_trans="label_org_branch">Organization branch</span></td><td >:</td><td ><?php echo @$res1['organization_branch']; ?></td></tr>
		  <tr><td   ><span>Company ID</span></td><td >:</td><td ><?php echo @$res1['realtor_employer_id']; ?>
		  
		  </td></tr>
<tr><td   ><span adr_trans="label_portfolio_website">Portfolio/Website</span></td><td >:</td><td ><?php echo @$res1['portfolio']; ?></td></tr><tr><td colspan="3"><hr class="space xs" /></td></tr>
		  <tr><td   ><span adr_trans="label_org_contact_no">Organization contact number</span></td><td >:</td><td ><b><?php echo @$res1['organization_contact_number']; ?></b></td></tr>
		   <tr><td   ><span adr_trans="label_org_email">Organization Email</span></td><td >:</td><td ><?php echo @$res1['organization_email']; ?></td></tr>
			<tr><td colspan="3"><hr class="space xs" /></td></tr>
			   
					<tr><td ><span adr_trans="label_fb_id">Facebook ID</span><span class="fa fa-facebook SocialIconWithTitle"></span></td><td >:</td><td ><?php echo @$res1['facebook_id']; ?></td></tr>
					<tr><td><span adr_trans="label_insta_id">Instagram ID</span><span class="fa fa-instagram SocialIconWithTitle"></span></td><td >:</td><td ><?php echo @$res1['instagram_id']; ?></td></tr>
					<tr><td   ><span adr_trans="label_twitter_id">Twitter ID</span><span class="fa fa-twitter SocialIconWithTitle"></span></td><td >:</td><td ><?php echo @$res1['twitter_id']; ?></td></tr>
					
					<tr><td   ><span adr_trans="label_youtube_id">Youtube ID</span><span class="fa fa-youtube SocialIconWithTitle" ></span></td><td >:</td><td ><?php echo @$res1['youtube_id']; ?></td></tr>
					<tr><td   ><span adr_trans="label_linkedin_id">LinkedIN ID </span><span class="fa fa-linkedin SocialIconWithTitle"></span></td><td >:</td><td ><?php echo @$res1['linkedin_id']; ?></td></tr>
					
					
					<tr><td colspan="3"><hr class="space xs" /></td></tr>
					
					<tr><td   ><span adr_trans="label_first_name">First name</span></td><td >:</td><td ><?php echo @$res1['first_name']; ?></td></tr>
					<tr><td   ><span adr_trans="label_last_name">Last name</span></td><td >:</td><td ><?php echo @$res1['last_name']; ?></td></tr>  
					<tr><td   ><span adr_trans="label_contact_no">Contact number</span></td><td >:</td><td ><b><?php echo @$res1['contact_number']; ?></b></td></tr>
					<tr><td   ><span adr_trans="label_profile_picture">Profile picture</span></td><td >:</td><td ><img src="data:<?php echo @$res1['profile_pic_image_type']; ?>;base64,<?php echo base64_encode(@$res1['profile_pic']); ?>" width="50" height="50" /></td></tr>
			  
			   
			   <tr><td colspan="3"><hr class="space xs" /></td></tr>
		  <!--  <tr><td   >Email</td><td >:</td><td ><?php echo @$res1['email']; ?></td></tr> -->
			  <tr><td   ><span adr_trans="label_address">Address</span></td><td >:</td><td ><?php echo @$res1['address_line1'].", ".@$res1['address_line2']; ?></td></tr>
			   <tr><td   ><span adr_trans="label_city">City</span></td><td >:</td><td ><?php echo @$res1['city']; ?></td></tr>
			    <tr><td   ><span adr_trans="label_state">State</span></td><td >:</td><td ><?php echo @$res1['state']; ?></td></tr>
				 <tr><td   ><span adr_trans="label_zip_code">Zip Code</span></td><td >:</td><td ><?php echo @$res1['postal_code']; ?></td></tr>
				  <tr><td   ><span adr_trans="label_country">Country</span></td><td >:</td><td ><?php echo @$res1['country']; ?></td></tr>
				




<?php } ?>

		<tr><td colspan="3"><hr class="space xs" /></td></tr>
				</tbody>
				  </table>
				  <br />
				  <a class="AnimationBtn ActionBtn-sm " style="float: right;" href="edit_realtor_profile.php" adr_trans="label_add_profile"><i class="fa fa-pencil"></i>Add / Edit profile</a>



 </div>





<?php

if(isset($_REQUEST['updatebtn']))
{

$email_template_title=$_REQUEST['email_template_title'];
$email_template_content=$_REQUEST['email_template_content'];

$email_template=mysqli_query($con,"select * from email_template where pc_admin_id='$loggedin_id' and template_title= '$email_template_title' ");


$template_exist=mysqli_num_rows($email_template);


if($template_exist==0)
{

mysqli_query($con,"insert into email_template(template_title,template_body_text,created_on,last_updated_on,last_updated_by,created_by,pc_admin_id)values('$email_template_title','$email_template_content',now(),now(),'$loggedin_id','$loggedin_id','$loggedin_id')");

}

else
{

	$get_email_template=mysqli_fetch_array($email_template);
	$template_id = $get_email_template['id'];

	mysqli_query($con,"update email_template set template_body_text='$email_template_content',last_updated_on= now(),last_updated_by='$loggedin_id' where id='$template_id'");
}

//$insert_action=mysqli_query($con,"INSERT INTO `user_actions`( `module`, `action`, `action_done_by_name`, `action_done_by_id`, `photographer_id`,`action_date`) VALUES ('Profile','Updated','$loggedin_name',$loggedin_id,$loggedin_id,now())");


header("location:company_profile.php?r=1");
}


 ?>


            </div>


		<?php include "footer.php";  ?>
