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


function email($y,$z,$type_of_user)
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

	$mail->Subject = $type_of_user." Registration Approved";
	$mail->Body = "<html><head><style>.titleCss {font-family: \"Roboto\",Helvetica,Arial,sans-serif;font-weight:600;font-size:18px;color:#0275D8 }.emailCss { width:100%;border:solid 1px #DDD;font-family: \"Roboto\",Helvetica,Arial,sans-serif; } </style></head><table cellpadding=\"5\" class=\"emailCss\"><tr><td align=\"left\"><img src=\"".$_SESSION['project_url']."logo.png\" /></td><td align=\"center\" class=\"titleCss\">".strtoupper($type_of_user)." REGISTRATION APPROVED SUCCESSFUL!</td><td align=\"right\">".$_SESSION['support_team_email']."<br>".$_SESSION['support_team_phone']."</td></tr><tr><td colspan=\"2\"><br><br>";
	//$mail->AltBody = "This is the plain text version of the email content";



	$mail->Body.="Dear {{Registrered_User_Name}},<br><br>

Your account has been approved by our Fotopia Admin team.<br>
<a href='{{project_url}}' target='_blank'>click here</a> to login to your Fotopia account.<br>
Thank you for choosing Fotopia! We look forward to saving you time by simplifying your real-estate photography experience.<br>
Know someone else that might benefit from using Fotopia? login to invite other real-estate agents or PhotoCompany into our community.<br>

Your account has been approved by Fotopia Admin Team.<br>{{Instructions}}

<br>
Thanks,<br>
Fotopia Team.";
if($type_of_user=="Realtor")
{
$mail->Body=str_replace('{{Instructions}}', "" , $mail->Body);
	$mail->Body=str_replace('{{project_url}}', $_SESSION['project_url']."login.php" , $mail->Body);
}
else{
$Instructions="<br>As a Photo Company, Kindly do all the below steps to continue using Fotopia.<br><br>
		1.	Fill out the Company profile<br>
		2.	Set up products for your Photo company<br>
		
<b>Note :</b> At your first Login, We will redirect you to Step #1 & step #2. You will not have access to anything until you complete these two steps.<br><br>
";
/*
3.	Set custom price for realtors (discount)<br>
4.	Create a CSR <br>
		5.	Create a Photographer<br>
		6.	Set custom price for photographers (Commissions)<br>
		7.	Create an Editor <br><br>
*/
$mail->Body=str_replace('{{Instructions}}', @$Instructions , $mail->Body);
	$mail->Body=str_replace('{{project_url}}', $_SESSION['project_url']."admin/index.php" , $mail->Body);
}

	$mail->Body=str_replace('{{Registrered_User_Name}}',$y, $mail->Body);
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



if(isset($_REQUEST['approve']))
{
	if(@$_REQUEST['id'])
	{
		$id=$_REQUEST['id'];
	$get_user_detail=mysqli_query($con,"SELECT * FROM `user_login` WHERE id=$id");
}
else
{
		$id1=$_REQUEST['id1'];
	$get_user_detail=mysqli_query($con,"SELECT * FROM `admin_users` WHERE id=$id1");
	}

	$get_user=mysqli_fetch_assoc($get_user_detail);
	email($get_user['first_name'],$get_user['email'],$get_user['type_of_user']);
	if(@$get_user['type_of_user']!='PCAdmin')
	{
		mysqli_query($con,"update user_login set email_verified=1 where id='$id'");
		header("location:userDetails.php?val=2&success=1&id=$id");
	}
	else{
	mysqli_query($con,"update admin_users set is_approved=1 where id='$id1'");
	header("location:userDetails.php?val=2&success=1&id1=$id1");
}
}
elseif(isset($_REQUEST['block']))
{
	if(@$_REQUEST['id'])
	{
	$id=$_REQUEST['id'];
	mysqli_query($con,"update user_login set email_verified=2 where id='$id'");
		header("location:userDetails.php?val=2&declined=1&id=$id");
  }
	else{
		$id1=$_REQUEST['id1'];
		mysqli_query($con,"update admin_users set is_approved=2 where id='$id1'");
			header("location:userDetails.php?val=2&declined=1&id1=$id1");
	}


}
?>



<?php include "header.php";  ?>
	<style>

	</style>
<div class="section-empty bgimage7">
	<hr class="space xs">
            <div class="row">

               
			<div class="col-md-2" style="padding-left:15px;">
				<hr class="space xs">
				<script>
				   $(".hidden-xs").css("margin-right":"46px");
				</script>

	<?php
	if($_SESSION["admin_loggedin_type"] == "FotopiaAdmin"){
		include "sidebar.php";
	}
	else{
		include "sidebar.php";
	}
	 ?>


			</div>
                <div class="col-md-8"  style="padding-top:10px;">
                    

					<?php if(@isset($_REQUEST["success"])) { ?>
                        <div class="success-box" style="display:block;padding-left: 20%">
												<div class="alert alert-success" adr_trans="label_approved_selected">Your have approved the selected user successfully.</div>
                        </div>
						<?php } ?>


<?php

if(isset($_REQUEST['id']))
{
	$id=@$_REQUEST['id'];
				$res=mysqli_query($con,"select * from user_login where id='$id'");
			}
			else {
				$id1=@$_REQUEST['id1'];
				$res=mysqli_query($con,"select * from admin_users where id='$id1'");
			}

				$res1=mysqli_fetch_array($res);

				?>
				<h5><span adr_trans="label_user_details" style="color:#000;margin-left: 3px;">User details</span></h5>  
					<table class="table-stripped" aria-busy="false" style="color: #000;background: #fff;opacity:0.8;width:90%;border-radius:5px!important;margin-top: 3px;">

					<tbody>
	   <tr><td  style="float:right;"><img src="data:<?php echo $res1['profile_pic_image_type']; ?>;base64,<?php echo base64_encode($res1['profile_pic']); ?>" width="50" height="50" style="border-radius: 35px;" /></td><td style="padding:0px 0px;vertical-align:top;"> </td><td><?php echo $res1['first_name']. $res1['last_name']; ?><hr class="space xs"></td></tr>
	    <tr><td colspan="3"><hr class="space xs" /></td></tr>
	    
		  <tr><td style="float:right"><span adr_trans="label_organization">Organization</span></td><td style="padding:0px 0px;vertical-align:top;">:</td><td><b><?php echo $res1['organization_name']; ?></b></td></tr>
		   <tr><td style="float:right"><span adr_trans="label_type_user">Type Of User</span></td><td style="padding:0px 0px;vertical-align:top;">:</td><td><?php echo $res1['type_of_user']; ?></td></tr>
		    <tr><td colspan="3"><hr class="space xs" /></td></tr>
		    <tr><td style="float:right"><span adr_trans="label_email">Email</span></td><td style="padding:0px 0px;vertical-align:top;">:</td><td><?php echo $res1['email']; ?></td></tr>
			 <tr><td style="float:right"><span adr_trans="label_contact_no">contact Number</span></td><td style="padding:0px 0px;vertical-align:top;">:</td><td><?php echo $res1['contact_number']; ?></td></tr>
			  <tr><td colspan="3"><hr class="space xs" /></td></tr>
			  <tr><td style="float:right"><span adr_trans="label_address">Address</span></td><td style="padding:0px 0px;vertical-align:top;">:</td><td><?php echo $res1['address_line1']." ".$res1['address_line2']; ?></td></tr>
			   <tr><td style="float:right"><span adr_trans="label_city">City</span></td><td style="padding:0px 0px;vertical-align:top;">:</td><td><?php echo $res1['city']; ?></td></tr>
			    <tr><td style="float:right"><span adr_trans="label_state">State</span></td><td style="padding:0px 0px;vertical-align:top;">:</td><td><?php echo $res1['state']; ?></td></tr>
				 <tr><td style="float:right"><span adr_trans="label_zip_code">Postal Code</span></td><td style="padding:0px 0px;vertical-align:top;">:</td><td><?php echo $res1['postal_code']; ?></td></tr>
				  <tr><td style="float:right"><span adr_trans="label_country">Country</span></td><td style="padding:0px 0px;vertical-align:top;">:</td><td><?php echo $res1['country']; ?></td></tr>
				   <tr><td colspan="3"><hr class="space xs" /></td></tr>
				 
				    <tr><td style="float:right"><span adr_trans="label_last_login">Last Login</span></td><td style="padding:0px 0px;vertical-align:top;">:</td><td><?php echo $res1['last_login']; ?></td></tr>
					<tr><td style="float:right"><span adr_trans="label_last_login_ip">Last Login IP Address</span></td><td style="padding:0px 0px;vertical-align:top;">:</td><td><?php echo $res1['last_login_ip']; ?></td></tr>
					<tr><td style="float:right"><span adr_trans="label_registration_date">Registration Date</span></td><td style="padding:0px 0px;vertical-align:top;">:</td><td><?php echo $res1['registered_on']; ?></td></tr>


                <tr><td style="float:right"><span adr_trans="label_status">Status</span></td><td style="padding:0px 0px;vertical-align:top;">:</td><td><?php if($res1['type_of_user']!='PCAdmin'){$approved=$res1['email_verified']; }else{$approved=$res1['is_approved'];}if($approved==0) { echo "<span style='color: #000; font-weight: bold;display: block; background:#F58883;padding-top: 3px;height:30px; max-width: 80px;padding-bottom: 5px;text-align: center;' adr_trans='label_pending'>Pending</span>"; } elseif($approved==2) { echo "<span style='color: #000; font-weight: bold;display: block; background:#F58883;padding-top: 3px;height:30px;max-width: 80px;padding-bottom: 5px;text-align: center;' adr_trans='label_blocked'>Blocked</span>"; } else { echo "<span style='color: #000; font-weight: bold;display: block; background:#76EA97;padding-top: 3px;height:30px; max-width: 80px;padding-bottom: 5px;text-align: center;' adr_trans='label_approved'>Approved</span>"; } ?></td></tr>
                 <tr><td colspan="3"><hr class="space xs" /></td></tr>

				</tbody>
				  </table>
         <p align="right" style="margin-top:10px;margin-right: 82px;">
				<?php if($res1['type_of_user']!='PCAdmin'){ if($res1['email_verified']==2) { ?>
				<a class="AnimationBtn ActionBtn-sm" href="userDetails.php?val=2&approve=1&id=<?php echo $res1['id']; ?>"><i class="fa fa-check"></i><span adr_trans="label_approve">Approve</span></a> <?php }


				elseif($res1['email_verified']==1) { ?>

								<a class="AnimationBtn CancelBtn-sm btn" href="userDetails.php?val=2&block=1&id=<?php echo $res1['id']; ?>"><i class="fa fa-ban"></i><span adr_trans="label_block">Block</span></a><?php }

								else{ ?>
<a class="AnimationBtn ActionBtn-sm btn" href="userDetails.php?val=2&approve=1&id=<?php echo $res1['id']; ?>"><i class="fa fa-check"></i><span adr_trans="label_approve">Approve</span></a>

<a class="AnimationBtn CancelBtn-sm btn" href="userDetails.php?val=2&block=1&id=<?php echo $res1['id']; ?>"><i class="fa fa-ban"></i><span adr_trans="label_block">Block</span></a>
<?php } }
else{
?>
<?php
if($res1['is_approved']==2) { ?>
<a class="AnimationBtn ActionBtn-sm btn" href="userDetails.php?val=2&approve=1&id1=<?php echo $res1['id']; ?>"><i class="fa fa-check"></i><span adr_trans="label_approve">Approve</span></a> <?php }


elseif($res1['is_approved']==1) { ?>

				<a class="AnimationBtn CancelBtn-sm btn" href="userDetails.php?val=2&block=1&id1=<?php echo $res1['id']; ?>"><i class="fa fa-ban"></i><span adr_trans="label_block">Block</span></a><?php }

				else{ ?>
<a class="AnimationBtn ActionBtn-sm btn" href="userDetails.php?val=2&approve=1&id1=<?php echo $res1['id']; ?>"><i class="fa fa-check"></i><span adr_trans="label_approve">Approve</span></a>

<a class="AnimationBtn CancelBtn-sm btn" href="userDetails.php?val=2&block=1&id1=<?php echo $res1['id']; ?>"><i class="fa fa-ban"></i><span adr_trans="label_block">Block</span></a>
<?php
}
}?>
								<?php

								if(@$_REQUEST['val'] == 0) {

									if($approved==0) {
										
										?>

<a class="AnimationBtn ActionBtn-sm" href="users.php?page1=1"><i class="fa fa-sign-in"></i><span adr_trans="label_back_users_list">Back to users list</span></a>

										<?php
									}

									elseif($approved == 2){
								?>

		<a class="AnimationBtn ActionBtn-sm" href="users.php?page2=1"><i class="fa fa-sign-in"></i><span adr_trans="label_back_users_list">Back to users list</span></a>

							<?php } 

							else{
								?>

									<a class="AnimationBtn ActionBtn-sm" href="users.php"><i class="fa fa-sign-in"></i><span adr_trans="label_back_users_list">Back to users list</span></a>
								<?php 
							}
						}

								elseif (@$_REQUEST['val'] == 1) {
									?>
									<a class="AnimationBtn ActionBtn-sm" href="csr_list.php"><i class="fa fa-sign-in"></i><span adr_trans="label_back_users_list">Back to users list</span></a>

								<?php }

								elseif (@$_REQUEST['val'] == 2 ) {

									if(@$_SESSION["admin_loggedin_type"] == "PCAdmin"){
										
										?>

							<a class="AnimationBtn ActionBtn-sm" href="csr_list1.php?fp=1"><i class="fa fa-sign-in"></i><span adr_trans="label_back_users_list">Back to users list</span></a>

								<?php } 
								else{
									?>
									<a class="AnimationBtn ActionBtn-sm" href="users.php"><i class="fa fa-sign-in"></i><span adr_trans="label_back_users_list">Back to users list</span></a>

								<?php }}  ?>



 </div>


            </div>


		<?php include "footer.php";  ?>
