<?php
ob_start();
// session_start();
include "connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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

$mail->Subject = "User Registration ";
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
.titleCss {font-family: \"Roboto\",Helvetica,Arial,sans-serif;font-weight:600;font-size:18px;color:#0275D8 }.emailCss { width:100%;border:solid 1px #DDD;font-family: \"Roboto\",Helvetica,Arial,sans-serif; } </style></head><table cellpadding=\"5\" class=\"emailCss\"><tr><td align=\"left\"><img src=\"".$_SESSION['project_url']."logo.png\" /></td><td align=\"center\" class=\"titleCss\">USER REGISTRATION SUCCESSFUL</td><td align=\"right\">".$_SESSION['support_team_email']."<br>".$_SESSION['support_team_phone']."</td></tr><tr><td colspan=\"2\"><br><br>";
//$mail->AltBody = "This is the plain text version of the email content";




$mail->Body.="<b>Dear {{Registrered_User_Name}},</b><br><br>

Fotopia has created you as a {{Type_of_user}} in our fotopia application.<br>
To complete the registration,please follow the options below. <br />
<br><br>
<a href='{{project_url}}admin/organization.php?id={{id}}&profile_id={{profile_id}}&user_type={{Type_of_user}}&approve=1' class='button' style='background:#5cb85c !important' >Proceed</a>&nbsp;&nbsp;<a href='{{project_url}}admin/organization.php?id={{id}}&profile_id={{profile_id}}&approve=0' class='button' style='background:#d9534f !important'>Decline</a>
<br><br><span style=\"font-size:10px;font-weight:bold;\">*This is an auto generated email notification from Fotopia. Please do not reply back to this email. For any support please write to support@fotopia.no</span><br><br>
Thanks,<br>
Fotopia Team.";

$mail->Body.="<br><br></td></tr></table></html>";

if($type_of_user=="Photo Company")
{
	$type_of_user="Photo Company Admin";
}
$mail->Body=str_replace('{{Type_of_user}}',$type_of_user, $mail->Body);
$mail->Body=str_replace('{{project_url}}',$_SESSION['project_url'], $mail->Body);
$mail->Body=str_replace('{{Organisation_Name}}','Fotopia', $mail->Body);
$mail->Body=str_replace('{{id}}',$id, $mail->Body);
$mail->Body=str_replace('{{profile_id}}',$profile_id, $mail->Body);
$mail->Body=str_replace('{{Registrered_User_Name}}',$first_name, $mail->Body);
//echo $mail->Body;exit;



try {
    $mail->send();
    //echo "Message has been sent successfully";
} catch (Exception $e) {
	echo $e->getMessage();
    echo "Mailer Error: " . $mail->ErrorInfo;
}
}

function getName($n) {
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}
//Login Check
if(isset($_REQUEST['signupbtn']))
{
	$fname=$_REQUEST['fname'];
	$lname=$_REQUEST['lname'];
	// $org=$_REQUEST['org'];
	// $typeofuser=$_REQUEST['typeofuser'];
	$email=$_REQUEST['email'];
	$password=$_REQUEST['password'];
	$contactno=$_REQUEST['contactno'];

$org_name=$_REQUEST['org_name'];
$org_branch=$_REQUEST['org_branch'];
$org_email=$_REQUEST['org_email'];
$org_no=$_REQUEST['org_no'];


	$addressline1=$_REQUEST['addressline1'];
	$addressline2=$_REQUEST['addressline2'];
	$city=$_REQUEST['city'];
	$state=$_REQUEST['state'];
	$zip=$_REQUEST['zip'];
	$country=$_REQUEST['country'];

$for_whom = $_REQUEST["for_whom"];

	$email_verification_code=getName(10);

	$imgData="";
	$imageProperties="";
	$imageType="";
	if (count($_FILES) > 0) {
    if (is_uploaded_file($_FILES['profilepic']['tmp_name'])) {
        //echo "coming";
        $imgData = addslashes(file_get_contents($_FILES['profilepic']['tmp_name']));
      //  $imageProperties = getimageSize($_FILES['profilepic']['tmp_name']);
        $imageType = $_FILES['profilepic']['type'];
      /*  $sql = "INSERT INTO output_images(imageType ,imageData)
	VALUES('{$imageProperties['mime']}', '{$imgData}')";
        $current_id = mysqli_query($conn, $sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_error($conn));
        if (isset($current_id)) {
            header("Location: listImages.php");
        } */
    }
}

		//echo "insert into user_login (first_name,last_name,organization,type_of_user,email,password,contact_number,address,city,state,postal_code,country,email_verified,profile_pic,profile_pic_image_type,registered_on)values('$fname','$lname','$org','$typeofuser','$email','$password','$contactno','$address','$city','$state','$zip','$country',1,'$imgData','$imageType',now())";exit;
if($for_whom=="realtor"){

$typeofuser = "Realtor";

   mysqli_query($con,"insert into user_login_temp (type_of_user,organization_name,organization_branch,organization_contact_number,organization_email,first_name,last_name,email,password,contact_number,address_line1,address_line2,city,state,postal_code,country,email_verification_code,email_verified,profile_pic,profile_pic_image_type,registered_on)values('$typeofuser','$org_name','$org_branch','$org_no','$org_email','$fname','$lname','$email','$password','$contactno','$addressline1','$addressline2','$city','$state','$zip','$country','$email_verification_code',0,'$imgData','$imageType',now())");
$inserted_id=mysqli_insert_id($con);
if($inserted_id!=0)
{
mysqli_query($con,"insert into realtor_profile (organization_name,organization_branch,organization_contact_number,organization_email,first_name,last_name,email,password,contact_number,address_line1,address_line2,city,state,postal_code,country,profile_pic,profile_pic_image_type,realtor_id)values('$org_name','$org_branch','$org_no','$org_email','$fname','$lname','$email','$password','$contactno','$addressline1','$addressline2','$city','$state','$zip','$country','$imgData','$imageType','$inserted_id')");
$profile_id=mysqli_insert_id($con);
email($email,$typeofuser,$fname,$inserted_id,$profile_id);
}
header("location:users.php");

}

else{


$typeofuser = "Photo Company";

$user = "PCAdmin";

mysqli_query($con,"insert into admin_users_temp (type_of_user,organization_name,organization_branch,organization_contact_number,organization_email,first_name,last_name,email,password,contact_number,address_line1,address_line2,city,state,postal_code,country,profile_pic,profile_pic_image_type,registered_on)values('$user','$org_name','$org_branch','$org_no','$org_email','$fname','$lname','$email','$password','$contactno','$addressline1','$addressline2','$city','$state','$zip','$country','$imgData','$imageType',now())");
$inserted_id=mysqli_insert_id($con);
if($inserted_id!=0)
{
mysqli_query($con,"insert into photo_company_profile (organization_name,organization_branch,email,contact_number,address_line1,address_line2,city,state,postal_code,country,pc_admin_id)values('$org_name','$org_branch','$email','$contactno','$addressline1','$addressline2','$city','$state','$zip','$country','$inserted_id')");
$profile_id=mysqli_insert_id($con);
email($email,$typeofuser,$fname,$inserted_id,$profile_id);
}
header("location:users.php");


}



	//echo "select * from user_login where email='$email' and password='$pass'";





}
?>
<?php include "header.php";  ?>
<hr class="space s">
     <div class="col-md-2" style="">
	<?php include "sidebar.php"; ?>


			</div>
	<style>
	.container.content
	{
		padding-top:20px;
		padding-bottom:20px;
	}
	p{
		font-weight:bold;
		padding-bottom:0px;
	}
input
{
box-shadow:5px 5px 5px 5px #DDD;
}
	</style>
	<script>
function get_states(cityIs)
{
  if(cityIs!="")
  {
  $("#validation_message").css("display","none");
  $("#validation_message").html("");

  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
  var split=this.responseText.split("zipcode");
    document.getElementById("state").innerHTML = split[0];
    // document.getElementById("zip").value= split[1];
  
    }
  xhttp.open("GET", "../getState.php?city="+cityIs, true);
  xhttp.send();
   }
   else{
   	$("#validation_message").css("display","block");
    $("#validation_message").html("(Please select your city!.)");
   }
} 

	function validate_email(val)
{
// alert(type);
var email=$("#email").val(); 
if(email==""){

	// alert("Please enter an email");
	return false;
}
else{

	val=email;
}
var type= $("input[name='for_whom']:checked").val();


if(val!="" && typeof type !== 'undefined')
{
	// alert(type); 
  var xhttp= new XMLHttpRequest();
  xhttp.onreadystatechange = function()
  {
    if(this.readyState == 4 && this.status == 200){
     if(this.responseText == "true")
     {

        var langIs='<?php echo $_SESSION['Selected_Language_Session']; ?>';
		var alertmsg='';
		if(langIs=='no')
		{
	$("#Email_exist_error").html("E-posten er allerede i bruk, vennligst velg en annen e-post og fortsett");
		}
		else
		{
		$("#Email_exist_error").html("Email already in use, please choose different email and continue");
		}
	   $("#Email_exist_error").show();
	   $("#email").val("");
	    $("#email").focus();
     }
     else
     {
      $("#Email_exist_error").html();
	  $("#Email_exist_error").hide();
     }
    }
  };
  xhttp.open("GET","validate_email_signup.php?id="+val+"&type="+type,true);
  xhttp.send();
  }
  else{
  
  $("#Email_exist_error").html("Please select the user type!");
	   $("#Email_exist_error").show();
	   $("#email").val("");
	    $("#email").focus();
  }
}



function showPassword() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }

 var y = document.getElementById("confirmpassword");
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }

}


function showStep2() {

var fname =  $("#fname").val();
var lname =  $("#lname").val();
var email =  $("#email").val();
var contactno =  $("#contactno").val();
var password =  $("#password").val();
var confirmpassword =  $("#confirmpassword").val();

var pattern = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;

var emailpattern = /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

var contactpattern= /[0-9+.\(\)\-\s+]*/;




if(fname=='')
{
$("#fname").css("border","solid 1px red");
}
else
{
$("#fname").css("border","solid 1px grey");
}
if(lname=='')
{
$("#lname").css("border","solid 1px red");
}
else
{
$("#lname").css("border","solid 1px grey");
}
if(email=='')
{
$("#email").css("border","solid 1px red");
}
else
{
$("#email").css("border","solid 1px grey");
}
if(contactno=='')
{
$("#contactno").css("border","solid 1px red");
}
else
{
$("#contactno").css("border","solid 1px grey");
}
if(password=='')
{
$("#password").css("border","solid 1px red");
}
else
{
$("#password").css("border","solid 1px grey");
}
if(confirmpassword=='')
{
$("#confirmpassword").css("border","solid 1px red");
}
else
{
$("#confirmpassword").css("border","solid 1px grey");
}





if (fname==""){
var langIs='<?php echo $_SESSION['Selected_Language_Session']; ?>';
		var alertmsg='';
		if(langIs=='no')
		{
		 $("#validation_message").html("Vennligst skriv inn ditt fornavn!");
		}
		else
		{
	  $("#validation_message").html("Please enter the first name!");
		}
   $("#validation_message").css("display","block");
  $("#fname").focus();
  return false;
}

else{
  $("#validation_message").css("display","none");
}

if (lname==""){
var langIs='<?php echo $_SESSION['Selected_Language_Session']; ?>';
		var alertmsg='';
		if(langIs=='no')
		{
		  $("#validation_message").html("Vennligst skriv inn ditt etternavn!");
		}
		else
		{
	 $("#validation_message").html("Please enter the last name!");
		}

  $("#validation_message").css("display","block");
  $("#lname").focus();
  return false;
}

else{

  $("#validation_message").css("display","none");
}

if (email==""){
var langIs='<?php echo $_SESSION['Selected_Language_Session']; ?>';
		var alertmsg='';
		if(langIs=='no')
		{
		  $("#validation_message").html("Vennligst skriv inn e-post ID!");
		}
		else
		{
	   $("#validation_message").html("Please enter the Email ID!");
		}

  $("#validation_message").css("display","block");
  $("#email").focus();
  return false;
}

else{

  $("#validation_message").css("display","none");
}

if(email.match(emailpattern) == null)
{
var langIs='<?php echo $_SESSION['Selected_Language_Session']; ?>';
		var alertmsg='';
		if(langIs=='no')
		{
		 $("#validation_message").html("Vennligst skriv inn din e-post i riktig fomat!");
		}
		else
		{
	 $("#validation_message").html("Please enter email in the correct format!");
		}

  $("#validation_message").css("display","block");
  $("#email").focus();
  return false;

}

else{
$("#validation_message").css("display","none");

}


if (contactno==""){

var langIs='<?php echo $_SESSION['Selected_Language_Session']; ?>';
		var alertmsg='';
		if(langIs=='no')
		{
		$("#validation_message").html("Vennligst skriv inn kontaktnummeret!");
		}
		else
		{
	 $("#validation_message").html("Please enter the contact number!");
		}
  $("#validation_message").html("Please enter the contact number!");
  $("#validation_message").css("display","block");
  $("#contactno").focus();
  return false;
}
else
{
  $("#validation_message").css("display","none");
}


if(contactno.match(contactpattern) == '')
{
var langIs='<?php echo $_SESSION['Selected_Language_Session']; ?>';
		var alertmsg='';
		if(langIs=='no')
		{
		$("#validation_message").html("Vennligst skriv inn kontaktnummeret!");
		}
		else
		{
	 $("#validation_message").html("please enter the correct contact number");
		}
  $("#validation_message").html("Please enter the correct contact number!");
  $("#validation_message").css("display","block");
  $("#contactno").focus();
  return false;
}





if (password==""){
var langIs='<?php echo $_SESSION['Selected_Language_Session']; ?>';
		var alertmsg='';
		if(langIs=='no')
		{
		$("#validation_message").html("Vennligst skriv passordet!");
		}
		else
		{
	$("#validation_message").html("Please enter the password!");
		}


  $("#validation_message").css("display","block");
  $("#password").focus();
  return false;
}

else{

  $("#validation_message").css("display","none");
}


if (confirmpassword==""){
var langIs='<?php echo $_SESSION['Selected_Language_Session']; ?>';
		var alertmsg='';
		if(langIs=='no')
		{
		$("#validation_message").html("Vennligst bekreft passordet!");
		}
		else
		{
	$("#validation_message").html("Please enter the confirm password! ");
		}

  $("#validation_message").css("display","block");
  $("#confirmpassword").focus();
  return false;
}

else{

  $("#validation_message").css("display","none");
}

if (confirmpassword!=password){
var langIs='<?php echo $_SESSION['Selected_Language_Session']; ?>';
		var alertmsg='';
		if(langIs=='no')
		{
		 $("#validation_message").html("Passordet og det bekreftede passordet m� v�re det samme!");
		}
		else
		{
	 $("#validation_message").html("The password and confirm password should be same!");
		}


  $("#validation_message").css("display","block");
  $("#confirmpassword").focus();
  return false;
}

else{

  $("#validation_message").css("display","none");
}




if(password.match(pattern) == null)
{
var langIs='<?php echo $_SESSION['Selected_Language_Session']; ?>';
		var alertmsg='';
		if(langIs=='no')
		{
		 $("#validation_message").html("Vennligst skriv inn passord i riktig format!");
		}
		else
		{
	 $("#validation_message").html("Please enter password in the correct format!");
		}


  $("#validation_message").css("display","block");
  $("#password").focus();
  return false;

}

else{
$("#validation_message").css("display","none");

}


if($('input:radio[name=for_whom]').is(':checked')){

 $("#validation_message").css("display","none");
}

else{
var langIs='<?php echo $_SESSION['Selected_Language_Session']; ?>';
		var alertmsg='';
		if(langIs=='no')
		{
		$("#validation_message").html("Vennligst velg brukertype!");
		}
		else
		{
	 $("#validation_message").html("Please select the user type!");
		}

  $("#validation_message").css("display","block");
  $("#for_whom").focus();
  return false;
}





   document.getElementById('step1').style.display = "none";
   document.getElementById('step2').style.display = "block";

}

function showStep1() {

   document.getElementById('step2').style.display = "none";
   document.getElementById('step1').style.display = "block";

}



function step2Validation()
{

var org_name =  $("#org_name").val();
if(org_name=='')
{
$("#org_name").css("border","solid 1px red");
}
else
{
$("#org_name").css("border","solid 1px grey");
}


var org_branch =  $("#org_branch").val();
if(org_branch=='')
{
$("#org_branch").css("border","solid 1px red");
}
else
{
$("#org_branch").css("border","solid 1px grey");
}

var org_email =  $("#org_email").val();
if(org_email=='')
{
$("#org_email").css("border","solid 1px red");
}
else
{
$("#org_email").css("border","solid 1px grey");
}


var org_no =  $("#org_no").val();
if(org_no=='')
{
$("#org_no").css("border","solid 1px red");
}
else
{
$("#org_no").css("border","solid 1px grey");
}

var addressline1 =  $("#addressline1").val();
if(addressline1=='')
{
$("#addressline1").css("border","solid 1px red");
}
else
{
$("#addressline1").css("border","solid 1px grey");
}




var city =  $("#city").val();
if(city=='')
{
$("#city").css("border","solid 1px red");
}
else
{
$("#city").css("border","solid 1px grey");
}

var state =  $("#state").val();
if(state=='')
{
$("#state").css("border","solid 1px red");
}
else
{
$("#state").css("border","solid 1px grey");
}

var zip =  $("#zip").val();
if(zip=='')
{
$("#zip").css("border","solid 1px red");
}
else
{
$("#zip").css("border","solid 1px grey");
}

var country =  $("#country").val();
if(country=='')
{
$("#country").css("border","solid 1px red");
}
else
{
$("#country").css("border","solid 1px grey");
}

}
	</script>


	<script src='https://www.google.com/recaptcha/api.js'></script>



<div class="container content">

            <div class="row">
            	
			  <form action="" class="form-box form-ajax" method="post"  enctype="multipart/form-data"  onSubmit="return validateData()">




                <div class="col-md-8" style="color: #000;background: #fff;padding-left:30px;border-radius:5px;margin-top: 3px;">

                      		<br>
						<?php if(@isset($_REQUEST["success"])) { ?>
                        <div class="success-box" style="display:block;">
                            <div class="text-success" id="label_msg_sent" adr_trans="label_msg_sent">Congratulations. Your message has been sent successfully</div>
                        </div>
						<?php } elseif(isset($_REQUEST["failed"])) { ?>
                        <div class="error-box"  style="display:block;">
                            <div class="text-warning" id="label_invalid_loggin" adr_trans="label_invalid_loggin">Invalid login  credentials. Please try again.</div>
                        </div>
						<?php }  elseif(isset($_REQUEST["sessexp"])) { ?>
                        <div class="error-box"  style="display:block;">
                            <div class="text-warning" id="label_session_expired" adr_trans="label_session_expired">Your session expired. Please login again.</div>
                        </div>
						<?php } else { ?>
				<div class="error-box"  style="display:none;">
                            
                        </div>
						<?php } ?>

 

                       <div class="col-md-12"><h3 align="center" > Create User</h3></div>

                       <br><i class="col-md-12" style="word-wrap:break-word;padding-left:0px;text-align:center"><span style="">Please pick your option as Realtor or Photo Company</span></i><br><br>

                       <div class="error-box" id="validation_message" style="margin-left:20px;color:red;display:none;font-style:italic;" align="center">
                            <div class="text-warning" ></div>
                        </div>
			<span style="margin-left:250px;color:red;display:none;font-style:italic;" id="Email_exist_error" class=""></span>

          <div id="step1" name="step1">

             <div class="col-md-6">
    <center><label for="from_homeseller">
          <input type="radio" name="for_whom" value="realtor" onchange="validate_email('aa')" required />&nbsp;&nbsp;<span adr_trans="label_realtor">Realtor </span>
        </label>
      </center>
      </div>

      <div class="col-md-6">
        <center><label for="from_realtor">
          <input type="radio" name="for_whom" value="photo_company" onchange="validate_email('aa')" />&nbsp;&nbsp;<span adr_trans="label_photo_company"> Photo company</span>
        </label>
        </center>
        <br>
      </div>
						<div class="col-md-6">
                                <p><span id="label_first_name" adr_trans="label_first_name">First Name</span></p>
                                <input id="fname" name="fname" placeholder="First name" type="text" autocomplete="off" minlength="1" maxlength="20" class="form-control form-value" required="" >
                            </div>

							<div class="col-md-6">
                                <p id="label_last_name" adr_trans="label_last_name">Last Name</p>
                                <input id="lname" name="lname" placeholder="Last name" type="text" autocomplete="off" minlength="1" maxlength="20" class="form-control form-value" required="">
                            </div>

							<!-- <div class="col-md-6">
                                <p id="label_organization" adr_trans="label_organization">Organization</p>
                                <input id="org" name="org" placeholder="Organization" type="text" autocomplete="off" class="form-control form-value" required="">
                            </div> -->

							<!-- <div class="col-md-6">
							 <p id="label_type_user" adr_trans="label_type_user">Type of user</p>
							<select name="typeofuser" class="form-control form-value" required="">
							<option value="Realtor" id="label_realtor" adr_trans="label_realtor">Realtor
                            </option>
							<option value="Photographer" id="label_photographer" adr_trans="label_photographer" >Photographer</option>
							</select>
							</div> -->

                            <div class="col-md-6">
                                <p id="label_email" adr_trans="label_email">Email</p>
                                <input id="email" name="email" placeholder="Email" type="email"    autocomplete="off" class="form-control form-value" required="" onblur="this.value=this.value.trim();validate_email(this.value)">
                            </div>


							 <div class="col-md-6">
                                <p id="label_contact_no" adr_trans="label_contact_no">Contact Number</p>
           <input id="contactno" name="contactno" placeholder="Contact number" type="tel" pattern="[0-9+.\(\)\-\s+]*" min="1" autocomplete="off" class="form-control form-value" required="">
                            </div>


                            <div class="col-md-6">
                                <p id="label_password" adr_trans="label_password"><i class="fa fa-info-circle" style="float:right;padding-top:4px;" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"></i></p>

                               <input id="password" name="password" placeholder="password" type="password" autocomplete="off" class="form-control form-value" required="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"  style="display:inline" />

                            </div>

							<div class="col-md-6">
                                <p id="label_confirm_password" adr_trans="label_confirm_password">Confirm Password</p>
                                <input id="confirmpassword" name="confirmpassword" placeholder="Confirm password" type="password" autocomplete="off" class="form-control form-value" required="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">


                            </div>

                            <br>

                            <div class="col-md-6">

                                <input type="checkbox" onclick="showPassword()"> Show Password


                            </div>


                            <div class="col-md-12" align="right">
                              <hr class="space s">
                            <a class="AnimationBtn ActionBtn-sm" onclick="return showStep2()" id="next" name="next" adr_trans="label_next" ><i class="fa fa-chevron-circle-right"></i>Next</a>&nbsp;&nbsp;<a class="AnimationBtn CancelBtn-sm" href="users.php" id="label_cancel" adr_trans="label_cancel"><i class="fa fa-times"></i>Cancel</a>

                            <hr class="space xs">


                            </div>

                            </div>



<div id="step2" name="step2" style="display:none" >


    <div class="col-md-6">
                                <p adr_trans="label_org_name">Organization name</p>
                                <input id="org_name" name="org_name" placeholder="Organization name" type="text" autocomplete="off" class="form-control form-value" required="" >
                            </div>

                            <div class="col-md-6">
                                <p adr_trans="label_org_branch">Organization branch</p>
                                <input id="org_branch" name="org_branch" placeholder="Organization name" type="text" autocomplete="off" class="form-control form-value" required="">
                            </div>

                            <div class="col-md-6">
                                <p adr_trans="label_org_email">Organization Email</p>

                                <input id="org_email" name="org_email" placeholder="Organization Email" type="email" autocomplete="off" class="form-control form-value" required="" onblur="this.value=this.value.trim();">
                            </div>


                             <div class="col-md-6">
                                <p adr_trans="label_org_contact_no">Organization contact number</p>
           <input id="org_no" name="org_no" placeholder="Organization contact number" type="tel" pattern="[0-9+.\(\)\-\s+]*" min="1" autocomplete="off" class="form-control form-value" required="">
                            </div>

						 <div class="col-md-6">
						  <p id="label_address_line1" adr_trans="label_address_line1">Address Line 1</p>
						   <input id="addressline1" name="addressline1" placeholder="Address line 1" type="text" autocomplete="off" class="form-control form-value" required="">
						 </div>

							 <div class="col-md-6">
						  <p id="label_address_line2" adr_trans="label_address_line2">Address Line 2</p>
						   <input id="addressline2" name="addressline2" placeholder="Address line 2" type="text" autocomplete="off" class="form-control form-value" >
						 </div>

						<div class="col-md-6">
							 <p id="label_city" adr_trans="label_city">City</p>
							<select name="city" onchange="get_states(this.value)" id="city" class="form-control form-value" required="">
								<option value="">select city</option>
							<?php
							$city1=mysqli_query($con,"select cities from norway_states_cities order by cities asc");
							while($city=mysqli_fetch_array($city1))
							{
							?>
							<option value="<?php echo $city['cities']; ?>"><?php echo $city['cities']; ?></option>
							<?php } ?>
							</select>
							</div>

							<div class="col-md-6">
							 <p id="label_state" adr_trans="label_state">State</p>
							<select name="state" id="state" class="form-control form-value" required="">
						
							</select>
							</div>
						 <div class="col-md-6">
                                <p id="label_zip_code" adr_trans="label_zip_code">Zip Code</p>
                                <input name="zip" id="zip" placeholder="Zip code" type="number" min="1" autocomplete="off" class="form-control form-value" required="">
                            </div>


						<div class="col-md-6">
							 <p id="label_country" adr_trans="label_country">Country</p>
							<select name="country" id="country" class="form-control form-value" required="">
							<?php
							//$country1=mysqli_query($con,"select * from countries");
							//while($country=mysqli_fetch_array($country1))
							//{
							?>
							<option value="Norway"><?php //echo $country['countryName']; ?>Norway</option>
							<option value="US"><?php //echo $country['countryName']; ?>US</option>
							<?php //} ?>
							</select>
							</div>
						<div class="col-md-6">
                                <p id="label_profile_pic" adr_trans="label_profile_pic">Profile Pic</p>
           <input id="profilepic" name="profilepic" placeholder="Profile pic" type="file" autocomplete="off" class="form-control form-value"  accept="image/*">
                            </div>


							<div class="col-md-6" style="display:none">
                               <br>
                                <input id="terms" name="terms" type="checkbox" class=" form-value" checked="checked"/>&nbsp;&nbsp;<span id="label_accept" adr_trans="label_accept">Accept our</span>
                                <a href="#tnc" class="lightbox link" data-lightbox-anima="show-scale" style="color:blue;text-decoration:underline" id="label_terms" adr_trans="label_terms">Terms & Conditions</a><br />
                            </div>


							<div class="col-md-6">
                                <p id="label_confirm_captcha" adr_trans="label_confirm_captcha">Confirm Captcha</p>
                               <span class="g-recaptcha" data-sitekey="6LfcQV0aAAAAALoVQq1XWMiLQDmIOadNhXqLStI_"></span>
        <span id="error"></span>
                            </div>




						 <div class="row">
                            <div class="col-md-12"><center><hr class="space s">

							<div class="error-box"  style="display:none;">
                            <div class="alert alert-warning" id="error-msg">&nbsp;</div>
                        </div>

						  <a class="AnimationBtn CancelBtn-sm" onclick="showStep1()" id="next" name="next" ><i class="fa fa-chevron-circle-left"></i>Back</a>&nbsp;&nbsp;<button class="AnimationBtn ActionBtn-sm" type="submit" name="signupbtn" id="label_signup" adr_trans="label_signup" onclick="return step2Validation()"><i class="fa fa-sign-in"></i>Signup</button>

						  <hr class="space xs">

</center>
					   </div>
                        </div>
</div>

                </div> </form>


            </div>
        </div>
		 <div id="tnc" class="box-lightbox white" style="padding:25px">
                        <div class="subtitle g" style="color:#333333">
                            <h5 style="color:#333333" align="center" id="label_terms" adr_trans="label_terms">Terms and Conditions</h5>
                            <hr>
                            <span class="sub" style="color:#333333">Read and accept our terms and conditions.<br /><br /></span>

                            <?php
                						$cmsPage=mysqli_query($con,"select * from cms_pages where id=2");
                						$cmsPage1=mysqli_fetch_array($cmsPage);
                						echo $cmsPage1['page_content'];
                						?>
						 </div>
                    </div>
                </div>
		 <script>


    function validateData() {

	$('.error-box').hide();
	$('#error-msg').html('');

	var pass=document.getElementById('password').value;
	var cpass=document.getElementById('confirmpassword').value;
	if(pass!=cpass)
	{
	//alert("Password and Confirm password must be same.");
	$('#error-msg').html('Password and Confirm password must be same.');
	$('.error-box').show();
	return false;
	}




        var response = grecaptcha.getResponse();
        if(response.length == 0) {
		$('#error-msg').html('Please Confirm with captcha');
	$('.error-box').show();
            //document.getElementById('error').innerHTML = '<span style="color:red;margin-left:20px;">  This field is required.</span>';
            return false;
        }
        return true;
    }

 $("#profilepic").change(function () {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            var langIs='<?php echo $_SESSION['Selected_Language_Session']; ?>';
		var profile_pic_alert='';
		if(langIs=='no')
		{
		profile_pic_alert="Profilbilde skal bare v�re i det gitte formatet";
		}
		else
		{
		profile_pic_alert="Profile Pic should be only in the given format";
		}
            alert(profile_pic_alert+": "+fileExtension.join(', '));
			$("#profilepic").val("");
        }
    });
    </script>
		<?php include "footer.php";  ?>
