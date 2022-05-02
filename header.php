<?php
include "project-environment.php";

 $page="index.php";
 if(isset($_SESSION['loggedin_id']))
{
$type=$_SESSION['user_type'];

if($type=="Realtor")
{

$id=$_SESSION['loggedin_id'];
		$realtor_profile1=mysqli_query($con,"select * from realtor_profile where realtor_id='$id'");
		$realtor_profile=mysqli_fetch_array($realtor_profile1);
		$realtor_employer_id=$realtor_profile['realtor_employer_id'];
		$organization_name=$realtor_profile['organization_name'];
		if(($realtor_employer_id=='' && !@$_REQUEST['first']) || ($organization_name=='' && !@$_REQUEST['first']))
		{ header("location:edit_realtor_profile.php?first=1"); exit; }



 $page="csrRealtorDashboard.php";
}
if($type=="Photographer")
{
$id=$_SESSION['loggedin_id'];
	$photographer_profile1=mysqli_query($con,"select * from photographer_profile where photographer_id='$id'");
		$photographer_profile=mysqli_fetch_array($photographer_profile1);
		$about_me=$photographer_profile['about_me'];
		$skills=$photographer_profile['skills'];
		// if(($about_me=='' && !@$_REQUEST['first']) || ($skills=='' && !@$_REQUEST['first']))
		// { header("location:edit_photographer_profile.php?first=1"); exit; }

$page="photographerDashboard.php";
}

}

function unlinkr($dir, $pattern = "*") {
    // find all files and folders matching pattern
    $files = glob($dir . "/$pattern"); 

    //interate thorugh the files and folders
    foreach($files as $file){ 
    //if it is a directory then re-call unlinkr function to delete files inside this directory     
        if (is_dir($file) and !in_array($file, array('..', '.')))  {
            echo "<p>opening directory $file </p>";
            unlinkr($file, $pattern);
            //remove the directory itself
            echo "<p> deleting directory $file </p>";
            rmdir($file);
        } else if(is_file($file) and ($file != __FILE__)) {
            // make sure you don't delete the current script
            echo "<p>deleting file $file </p>";
            unlink($file); 
        }
    }
}
 ?>
<!DOCTYPE html>
<!--[if lt IE 10]> <html  lang="en" class="iex"> <![endif]-->
<!--[if (gt IE 10)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Photography App</title>
    <meta name="description" content="About page with company informations.">
    <script src="scripts/jquery.min.js"></script>
    <link rel="stylesheet" href="scripts/bootstrap/css/bootstrap.css">
    <script src="scripts/script.js"></script>
    <link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="scripts/flexslider/flexslider.css">
    <link rel="stylesheet" href="css/content-box.css">
	 <link rel="stylesheet" href="css/image-box.css">
	  <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href='scripts/magnific-popup.css'>
	 <link rel="stylesheet" href="scripts/jquery.flipster.min.css">
     



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>
<script>
function getClippedRegion(image, x, y, width, height) {
   var canvas = document.createElement("canvas"),
      ctx = canvas.getContext("2d");

   canvas.width = width;
   canvas.height = height;

   //                   source region         dest. region
   ctx.drawImage(image, x, y, width, height, 0, 0, width, height);

   return {
      // Those are some pdfMake params
      image: canvas.toDataURL(),
      width: 500
   };
}
var lang1="";
var loadfile="";
function changeLanguage(lang1)
{
//alert(lang);

setLanguage(lang1);

//var lang=lang1;
if(lang1=="en")
{
loadfile="en.json";
}
else
{
loadfile="no.json";
}
var data="";


$.ajax({
    type: "Get",
    url: loadfile,
    dataType: "json",
    success: function(data) {



      $("td[adr_trans],strong[adr_trans],th[adr_trans],b[adr_trans],div[adr_trans],p[adr_trans],span[adr_trans],adr_trans,button[adr_trans],a[adr_trans],h1[adr_trans],h2[adr_trans],h3[adr_trans],h4[adr_trans],h5[adr_trans]").each(function(){
      		// alert($(this).attr("id"));
      		// var idIs=$(this).attr("id");

         // $("#"+idIs).html(data[idIs]);

        var idIs=$(this).attr("adr_trans");
      //var idIs=$(this).attr("id");




var htmlIs=$('[adr_trans="'+idIs+'"]').html();

if(htmlIs.indexOf("fa fa")!=-1)
{
//alert("coming");
var splitIs=htmlIs.split("</i>");

var actualFA=splitIs[0]+"</i>";
//alert(actualFA);
$('[adr_trans="'+idIs+'"]').html(actualFA+data[idIs]);
}
else
{
$('[adr_trans="'+idIs+'"]').html(data[idIs]);
}


});

},
    error: function(){
        //alert("json not found");
    }
});





}

var langval="";
  function setLanguage(langval)
{
//alert(langval);
  var xhttp= new XMLHttpRequest();
  xhttp.onreadystatechange = function()
  {
    if(this.readyState == 4 && this.status == 200){

    }
  };
  xhttp.open("POST","set_language.php?lang="+langval,true);
  xhttp.send();
}

</script>

    <style>

	.adr-save,.adr-save:hover
	{
	background:#AAD1D6!important;
	border-color:#AAD1D6!important;
    color: #000 !important;
    border-radius: 5px !important;
	}
	.adr-cancel
	{
	/*background:#5cb85c!important;
	border-color:#5cb85c!important;*/
	background:#F2ADA8!important;
	border-color:#F2ADA8!important;
    color: #000 !important;
    border-radius: 5px !important;
     
	}
    .adr-success
	{
	/*background:#5cb85c!important;
	border-color:#5cb85c!important;*/
	background:#AAD1D6!important;
	border-color:#AAD1D6!important;
     color: #000 !important;
     border-radius: 5px !important;
	}
    .btn-default
    {

    border: none !important;
    padding-top:20px;
    background:#AAD1D6!important;
    color: #000 !important;
    border-radius: 5px !important;
    }
/*.navbar {
    -webkit-box-shadow: 0 8px 6px -6px #999;
    -moz-box-shadow: 0 8px 6px -6px #999;
    box-shadow: 0 8px 6px -6px #999;

      
}*/
.td,.th
{
width:fit-content;
max-width:150px;
word-break:break-all;
}

.fc-today-button,.fc-button
{
border-radius:0px!important;
color:#FFF;
}
.form-control
{
background: #FFF!important;
color:#000!important;
}
a.adr-save > i,button.adr-save > i,a.adr-cancel > i,button.adr-cancel > i,a.adr-save > span,a.btn-default > i,button.btn-default > i
{
  color: #000 !important;

} 
#MenuList .active
{
z-index:999;
opacity:1!important;
}
	</style>

    <style>

    .adr-save,.adr-save:hover
    {
    background:#AAD1D6!important;
    border-color:#AAD1D6!important;
    color: #000 !important;
    border-radius: 5px !important;
    }
    .adr-cancel
    {
    /*background:#5cb85c!important;
    border-color:#5cb85c!important;*/
    background:#F2ADA8!important;
    border-color:#F2ADA8!important;
    color: #000 !important;
    border-radius: 5px !important;
     
    }
    .adr-success
    {
    /*background:#5cb85c!important;
    border-color:#5cb85c!important;*/
    background:#AAD1D6!important;
    border-color:#AAD1D6!important;
     color: #000 !important;
     border-radius: 5px !important;
    }
    .btn-default
    {

    border: none !important;
    padding-top:20px;
    background:#AAD1D6!important;
    color: #000 !important;
    border-radius: 5px !important;
    }

    a.adr-save > i,button.adr-save > i,a.adr-cancel > i,button.adr-cancel > i,a.adr-save > span,a.btn-default > i,button.btn-default > i
{
  color: #000 !important;

} 

    .row
    {
    width:100%;
    }
    .fc-today-button,.fc-button
{
border-radius:25px!important;
}
#MenuList .active
{
z-index:999;
opacity:1!important;
}

</style>

<style type="text/css">

        

.PageHeading-sm
{
  font-size: 10px;
  font-family: verdana;
  color: #000; 
  padding: 0px;
}
.PageHeading-md
{
  font-family: verdana;
  color: #000; 
  font-size: 12px;
  padding: 0px;
}
.PageHeading-lg
{
  font-family: verdana;
  color: #000; 
  font-size: 13px;
  padding: 0px;
}

.FieldLabel
{
  font-family: verdana;
  color: #000; 
  font-size: 12px;
  text-transform: capitalize;
  text-align: left;
  padding: 0px;
}
.FieldData
{
  font-family: verdana;
  color: #000; 
  font-size: 10px;
  font-weight: 600;
  text-align: left;
  float: left;
  padding: 5px;
}

.HyperLink-sm
{
  font-family: verdana;
  color: blue; 
  font-size: 10px;
  text-align: left;
  text-decoration: underline;
}
.HyperLink-md
{
  font-family: verdana;
  color: blue; 
  font-size: 12px;
  text-align: left;
  text-decoration: underline;
}



.ActionBtn-sm
{
    font-family: verdana;
    color: #000;
    font-size: 10px;
    width: 108px;
    word-break: break-word;
    display: inline-block;
    border-radius: 5px;
    background: #aad1d6;
    border: 1px solid #aad1d6;
    padding: 0px 5px;
    text-align: center;
    font-weight: 600;
    line-height: 24px;

}
.ActionBtn-md
{
    font-family: verdana;
    color: #000;
    font-size: 12px;
    word-break: break-word;
    width: 150px;
    display: inline-block;
    border-radius: 5px;
    background: #aad1d6;
    border: 1px solid #aad1d6;
    padding: 0px 5px;
    text-align: center;
    font-weight: 600;
    line-height: 24px;
}
.ActionBtn-lg
{
    font-family: verdana;
    color: #000;
    font-size: 13px;
    word-break: break-word;
    width: 180px;
    display: inline-block;
    border-radius: 5px;
    background: #aad1d6;
    border: 1px solid #aad1d6;
    padding: 0px 5px;
    text-align: center;
    font-weight: 600;
    line-height: 24px;
}

.CancelBtn-sm
{
    font-family: verdana;
    color: #000;
    font-size: 10px;
    width: 108px;
    display: inline-block;
    word-break: break-word;
    border-radius: 5px;
    background: #F2ADA8;
    border: 1px solid #F2ADA8;
    padding: 0px 5px;
    text-align: center;
    font-weight: 600;
    line-height: 24px;
}
.CancelBtn-md
{
    font-family: verdana;
    color: #000;
    font-size: 12px;
    width: 150px;
    word-break: break-word;
    display: inline-block;
    border-radius: 5px;
    background: #F2ADA8;
    border: 1px solid #F2ADA8;
    padding: 0px 5px;
    text-align: center;
    font-weight: 600;
    line-height: 24px;
}
.CancelBtn-lg
{
    font-family: verdana;
    color: #000;
    font-size: 13px;
    width: 180px;
    word-break: break-word;
    display: inline-block;
    border-radius: 5px;
    background: #F2ADA8;
    border: 1px solid #F2ADA8;
    padding: 0px 5px;
    text-align: center;
    font-weight: 600;
    line-height: 24px;
}

/*animation btn start here*/
.AnimationBtn
{
  position: relative;
  overflow: hidden;
  display: inline-block;
  width: fit-content;
  padding: 0px 10px;
  transition: padding-left .3s;
}
.AnimationBtn:hover
{
  padding-left:  40px;
  transition: padding-left .3s;
}
.AnimationBtn:hover i
{
  margin-left: -25px;
  transition: all .3s;
}
.AnimationBtn i 
{
position: absolute;
top: 50%;
height: 20px;
line-height: 20px;
margin-top: -10px;
margin-left: -50%;
font-size: 100%;
}
/*animationbtn ends here*/
.TextCenter
{
    text-align: center;
}
.TextRight
{
    text-align: right;
}

.IconColor
{
    color: #aad1d6;
}

.SidebarActive
{
  background: #000;
  border-color: #000;
  border-radius: 5px;
  color: #000;
  height: 30px;
  width: 90px;
  font-family: verdana;
  padding-left: 5px;
  padding-right: 5px;
  padding-bottom: 5px;
  padding-top: 5px;
  font-weight: 600;
}
.SidebarInActive
{
  background: #000;
  border-color: #000;
  border-radius: 5px;
  color: #000;
  height: 30px;
  width: 90px;
  font-family: verdana;
  padding-left: 5px;
  padding-right: 5px;
  padding-bottom: 5px;
  padding-top: 5px;
  font-weight: 600;
}
.IconWithTitle
{
  color: #000;
  padding: 5px;
  border-radius: 5px;
  font-size: 10px;
}
.TabBtnActive
{
  background: #aad1d6;
  border: 1px solid #000; 
  border-radius: 5px;
  color: #000;
  height: 30px;
  width: 90px;
  font-family: verdana;
  font-size: 10px;
  margin-left: 5px;
  margin-right: 5px;
  margin-bottom: 5px;
  margin-top: 5px;
  padding: 5px;
  float: left;
}
.TabBtnInActive
{
  background: #fff;
  border: 1px solid #000;
  border-radius: 5px;
  color: #000;
  height: 30px;
  width: 90px;
  font-family: verdana;
  font-size: 10px;
  margin-left: 5px;
  margin-right: 5px;
  margin-bottom: 5px;
  margin-top: 5px;
  padding: 5px;
  float: left;
}
.NotificationTable,.ListTable,.ProfileTable
{
  color: #000;
  background: white;
  opacity:0.9;
  width:98%;
  padding-left:3px;
  border-radius: 5px;
}
.NotificationTable > tbody > .listPageTR > td:first-child,.NotificationTable > .TableHeading > tr > th:first-child
{
  padding-left: 20px !important;
  width: 100px !important;
}
.TableHeading
{
  font-family: verdana;
  font-size: 10px;
  color: #000;
  text-align: left;
  background: #aad1d6;
  font-weight: 600;
  vertical-align: ;
  padding: 12px;
  
}
.TableContent
{
  font-family: verdana !important;
  font-size: 10px;
  color: #000;
  text-align: left;
  padding: 5px;
}
.Table-Img
{
  height: 30px;
  width: 90px;
  border-radius: 5px;   
}
/*common table start here*/

/*profiletable code start here*/
.ProfileTable tr td:nth-child(1)
{
    width: 150px !important;
    float: right;
    text-align: right;
    font-family: verdana;

}
.ProfileTable tr td:nth-child(1) span
{
    font-size: 12px;
}
.ProfileTable tr td:nth-child(2)
{
    padding-left: 5px;
    padding-right: 15px;
    width: 30px!important;
    vertical-align: top;
}
.ProfileTable tr td:nth-child(3)
{
    text-align: left;
    font-size: 10px;
    font-family: verdana !important;
}
/*profiletable code end here*/
thead > tr:last-child
{
     border-top: solid 1px #aad1d6!important;
    border-bottom: solid 0.5px #aad1d6!important;
    border-left: solid 1px #aad1d6!important;
    border-right: solid 1.5px #aad1d6!important;
}
/*common table end here*/
//to be applied in body tag
.PageFont
{
  font-family: verdana !important;
}




.Status-Created
{

color: #000; 
font-weight: bold;
display: block; 
background:#86C4F0;
max-width: 200px;
padding: 5px;
text-align: center;


}

.Status-Wip
{


color: #000; 
font-weight: bold;
display: block; 
background:#FF8400;
max-width: 200px;
text-align: center;
padding: 5px;

}

.Status-Completed
{

color: #000; 
font-weight: bold;
display: block; 
background:#76EA97;
max-width: 200px;
text-align: center;
padding: 5px;

}

.Status-Rework
{

color: #000; 
font-weight: bold;
display: block; 
background:#F58883;
max-width: 200px;
text-align: center;
padding: 5px;

}

.Status-Cancelled
{

color: #000; 
font-weight: bold;
display: block; 
background:#F58883;
max-width: 200px;
text-align: center;
padding: 5px;



}

.Status-Wwc
{

font-weight: bold;
background: orange;
color: #000; 
display: block; 
max-width: 200px;
text-align: left;
padding: 5px;



}

.Status-Declined
{

color: #000; 
font-weight: bold;
display: block; 
background:#F58883; 
max-width: 200px;
text-align: center;
padding: 5px;


}

.Status-Reopen
{

color: #000; 
font-weight: bold;
display: block; 
background:#F58883;
max-width: 200px;
text-align: center;
padding: 5px;



}

.PaginationPrevNext
{

background: blue;  
color: #000; 
height: 10px; 
width: 10px;
font-size: 10px; 
padding: 2px;
border: 2px solid blue; 

}

.PaginationFirstLast
{

background: blue;  
color: #000; 
height: 10px; 
width: 10px;
font-size: 10px; 
padding: 2px;
border: 2px solid blue; 

}

.PaginationCurrentPage
{

background: blue;  
color: #000; 
height: 10px; 
width: 10px;
font-size: 10px; 
padding: 2px;
border: 2px solid blue; 

}

.BoxHeading
{

font-family: verdana;
color: #000;
font-size: 13px; 
font-weight: bold;
text-align: center;
background: #aad1d6;  
border-radius: 5px; 
padding: 2px ;
justify-content: center;
}

.PaginationEntries
{

font-family: verdana;
color: #000;
font-size: 10px;
padding: 5px;
word-spacing: 10px;
float: right;
margin-top: 10px;
margin-bottom: 10px;
}

.SocialIcon
{
font-size: 10px; 
padding: 10px;
color: #000;
background: #aad1d6; 
border-radius: 10px; 
margin: 2px;
}
.SocialIconWithTitle
{
    margin-left: 5px;
    padding: 4px;
    background: #aad1d6;
    color: #000;
    border-radius: 20px !important;
    font-size: 8px !important;
    padding-left: 4px !important;
    padding-right: 4px !important;
}
}
.form-control
{
    font-family: verdana;
    font-size: 12px;
    color: #000;
    height: 27px;
    margin-bottom: 5px;
}
::placeholder
{
    font-size: 12px; 
    font-family: verdana;
    text-transform: capitalize;
}

/*.InputText
{
    font-size: 10px; 
    color: red;
    font-family: verdana;
}
*/
.ImagePreviewIconEye
{

background: brown; 
border-radius: 0px 5px 5px 0px; 
color: #000; 
font-size: 10px; 
font-family: verdana; 
float: left; 
padding-top: 2px;
padding-bottom: 2px;
padding-right: 2px;
padding-left: 2px;
margin-left: 10px;
width: 40px;
height: 30px;
border: 2px solid brown; 
z-index: -1;
position: relative;
top: 10px;
display: none;

}

.ImageCheckboxIcon
{
background: brown; 
border-radius: 5px 0px 0px 5px; 
color: #000; 
font-size: 10px; 
font-family: verdana; 
float: right; 
padding-top: 2px;
padding-bottom: 2px;
padding-right: 2px;
padding-left: 2px;
margin-right: 10px;
width: 40px;
height: 30px;
border: 2px solid brown; 
z-index: -1;
position: relative;
top: 10px;
display: none;

}

.ImageInputField
{

color: #000; 
font-size: 10px; 
font-family: verdana; 
background: #fff; 
padding: 2px;
border-radius: 1px; 
border: 1px;
height: 10px; 
width: 10px;
display: none;

}

.ErrorInfoMsg
{

color: #000; 
font-size: 10px; 
font-family: verdana; 
background: lightred; 
border-radius: 1px; 
padding-top: 2px;
padding-bottom: 2px;
padding-right: 2px;
padding-left: 2px;
text-align: justify;
border: 1px solid lightred;
height: 30px; 
width: 100px;
opacity: 0.4;
font-style: italic;

}

.SuccessInfoMsg
{

color: #000; 
font-size: 10px; 
font-family: verdana; 
background: lightgreen; 
border-radius: 1px; 
padding-top: 2px;
padding-bottom: 2px;
padding-right: 2px;
padding-left: 2px;
text-align: justify;
border: 1px solid lightgreen;
height: 30px; 
width: 100px;
opacity: 0.4;
font-style: italic;

}

.ImageBox
{
border:solid 2px #aaa;
padding: 5px !important;
background: #ddd;
margin: 15px;
}
.ImageBox a
{
    visibility: hidden;
    background: #aad1d6 !important;
    
}
.ImageBox a i
{
    color: #000 !important;
}
.ImageBox img
{
    width: 240px !important;
    height: 180px !important;
    visibility: visible;
}
.ImageBox span
{
    font-family: verdana;
    font-size: 12px;
    color:  #000;
    font-weight: 600;
    visibility: visible;
}
.DropdownInput
{
font-size: 10px; 
font-family: verdana;    
height: 30px; 
width: 100px;

}

.ImageCircle
{
height: 10px; 
width: 10px;
border-radius: 10px;
}

.ChatUser
{
color: green; 
font-size: 11px; 
font-weight: bold;
padding-bottom: 2px;
font-family: verdana;  
}

.ChatDate
{
color: black; 
font-size: 10px;
padding-bottom: 2px; 
font-family: verdana;  
}

.ChatMsg
{
color: blue; 
font-size: 10px; 
font-family: verdana;  
text-align: justify;
line-height: 3px;
word-wrap:break-word;
padding-bottom: 5px; 
}

.ChatSender
{

background: lightgreen;
padding-right: 5px;
padding-left: 5px;
text-align: right;
float: right;
width: 100%;
border-bottom: solid 1px;
border-bottom-color: #fff;

}

.ChatReceiver
{

background: lightgrey;
padding-right: 5px;
padding-left: 5px;
text-align: left;
float: left;
width: 100%;
border-bottom: solid 1px;
border-bottom-color: #fff;

}

 


/* dashboard section-box start here */
.advs-box.boxed-inverse
 {
    font-family: verdana;
    padding: 15px;
    border-radius: 10px;
    text-align: center;
 }
.advs-box.boxed-inverse > h5 > span
{
    display: block;
    margin: 10px 0px;
}
 .advs-box.boxed-inverse > p.counter,.advs-box.boxed-inverse > p
{

   font-size: 25px;
   color: #000;
   font-weight: 600;
   display: inline-block;
   margin: 15px 0px;
}
.advs-box.boxed-inverse > h5 + span
{
    padding-right: 5px;
    font-size: 25px;
    color: #000;
}
.advs-box.boxed-inverse > a 
{
    margin: 0% auto;
    display: block;
}

/* dashboard section-box end here */

/*dashboard below section-box  css */
.LatestDelivered
{
  background: #fff;
  padding: 10px;
  padding-right: 0px !important;
  border-radius: 10px;
  height: 305px;
}
.LatestDelivered > div > a > img
{
    margin-bottom: 10px;
    width: 230px;
    height: 130px;
}
.LatestDelivered > div > a > span
{
   position:absolute;
   text-align:center;
   z-index:2;
   color:#000;
   background:#FFF!important;
   padding:3px;
   opacity:0.6;
   width:95%;
   float:left;
   left:-1px;
   font-weight:bold;
   font-size:12px;
}
.LatestDelivered + a ,.UpcomingCalender + a
{
    margin-top: 20px;
}

.UpcomingCalender
{
    border-radius: 5px;
    opacity: 0.8;
    height: 305px;
}
/*Wishlist card or rigth side card  code start here*/
.RightSideCard
{
    height: inherit;
    overflow: scroll;
    height: 600px;
    overflow-x: hidden;
    margin-top: 3px; 
    padding-right: 0px;
}
.cardTable
{
    background: #FFF;
    color: #000;
    font-weight: 600;
    opacity: 0.8;
    width: 100%;
    border-radius: 10px;
    width: 100%;
    font-size: 12px;
    font-family: verdana;
}
/*.cardTable > tbody > tr 
{

    /*float: left;*/
/*}*/

.cardTable > tbody > tr > td
{
    padding: 15px;
    border: none;
    border-top: none;
}
td > .img_wrp
{
    display: inline-block;
    position: relative;
}
.img_wrp > img
{
    visibility: hidden;
    max-width: 120px;
    width: 120px;
    height: 100px;
}
.img_wrp > i.fa-heart
{
    position: absolute;
    top: 80px;
    right: 1px;
    background: white;
    color: #aad1d6;
    font-weight: 700;
    padding: 2px;
}
.img_wrp > i.fa-heart-o
{
    position: absolute;
    bottom: 85px;
    right: 0px;
    background: white;
    color: #aad1d6;
    font-weight: 700;
    padding: 2px;
}

.CardLabel
{
    font-family: verdana;
    padding-top: 3px;
    width: 120px!important;
    word-break: break-word;
    font-size: 12px;
}
i.fa-star-o,i.fa-star
{
    padding: 1px;
    color: #aad1d6;
    font-size: 10px;
}

/*Common Textsize and color and family*/
.Text-sm
{
    font-family: verdana;
    font-size: 10px;
    color:  #000;
}
.W-100
{
    width: 100%;
}
.W-98
{
    width: 98%;
}
.W-96
{
    width: 96%;
}
.W-75
{
    width: 75%;
}
.W-50
{
    width: 50%;
}
.W-30
{
    width: 30%;
}
.W-20
{
    width: 20%;
}
.W-10
{
    width: 10%;
}
.Float-left
{
    float: left;
}
.Float-right
{
    float: right;
}
.Text-md
{
    font-family: verdana;
    font-size: 12px;
    color:  #000;
}
.Text-lg
{
    font-family: verdana;
    font-size: 13px;
    color:  #000;
}
/*Table scroll*/
.TableScroll
{
    width: 100%;
    scrollbar-width: none;
    overflow-x: scroll;
    overflow-y: hidden;
}

/*Product BreadCrum code start here*/
.ProductBreadCrumb
{
    /*border-radius: 5px 0px 0px 5px;*/
    border: solid 1px;
    background: #FFF;
    color: #000!important;
    font-weight: 600;
    padding: 10px;
}
.ProductBreadCrumb.Left
{
    border-radius: 5px 0px 0px 5px;
}
.ProductBreadCrumb.Right
{
    border-radius: 0px 5px 5px 0px;
}
.Active
{
    background: #aad1d6;
}
/*nav tab configrations starts here*/
.nav-tabs
{

  font-family: verdana;
}
.nav-tabs li a
{

  font-family: verdana;
  background: #fff!important;

}

.nav-tabs li.active,.nav-tabs li.active a
{

  font-family: verdana;
  background: #aad1d6!important;

}

/*nav tab configrations ends here*/

/*nav pills Start here*/
.nav-pills li a
{
  font-family: verdana;
  background: #fff!important; 
  border: none !important;
  color: #000 !important;
  padding: 5px;
  line-height: 24px;
  font-weight: 600;
  font-size: 12px;
}
.nav-pills li.active,.nav-pills li.active a
{
  font-family: verdana;
  background: #aad1d6!important;
}
/*nav pills end here*/

/*Calendar configs starts here*/

#calendar
{
background-color:#FFFFFF!important;
border-radius:10px!important;
}
table td[class*="col-"], table th[class*="col-"]
{
background:#EEE!important;
}
.fc-day-mon,.fc-day-tue,.fc-day-wed,.fc-day-thu,.fc-day-fri
{
background:#FFF!important;
border:solid 1px #EEE!important;
}
.fc-day-sat,.fc-day-sun
{
background:#EEEEEE!important;
}
.fc-daygrid-event
{
background:none!important;
}
.status1
{
background-color:#86C4F0!important;
color:#000!important;
}
.status4,.status5,.status6
{
background-color:#F58883!important;
color:#000!important;
}
.status3
{
color:#000!important;
background-color:#76EA97!important;
}
.status2,.status7 {
background-color:#FF8400!important;
color:#000!important;
}
.fc-day-mon,.fc-day-tue,.fc-day-wed,.fc-day-thu,.fc-day-fri
{
background:#FFF!important;
border:solid 1px #000!important;
}
.fc-day-sat,.fc-day-sun
{
border:solid 1px #000!important;
background: repeating-linear-gradient(
45deg,
transparent,
transparent 10px,
#ccc 2px,
#DDD 12px
),
 
linear-gradient(
    to bottom,
    #eee,
    #999
  )!important;
}
.fc-day-today
{
background: #FFF!important;
color:#000!important;
border:solid 1px #01A8F2!important;
}

h2.fc-toolbar-title
{
display:contents;
color:#000!important;
border:solid 1px #000!important;
padding:10px;
}
.fc .fc-toolbar.fc-header-toolbar
{
background:#FFF;
border-radius:25px;
}
.fc-scroller-harness,.fc-scroller-harness-liquid
{
border-radius:0px!important;
}
.fc-prev-button, .fc-next-button
{
background:#FFF!important;
color:#000!important;
margin:10px!important;

}
.fc-timegrid-event .fc-event-time
{
margin-bottom:0px!important;
}
.statusBUSY
{
 pointer-events: none;
    color:#000;
    padding-left:5px;
background: repeating-linear-gradient(
    45deg,
    transparent,
    transparent 10px,
    #ccc 2px,
    #DDD 12px
  ),
  /* on "bottom" */
  linear-gradient(
    to bottom,
    #eee,
    #999
  )!important;

}
.fc-button-primary
{
    background: #aad1d6!important;
    color: #000!important;
    font-family: verdana!important;
    font-size: 12px!important;
}
/*Calendar configs starts here*/
</style>

<script>
var calid;
function calDetails(calid)
{
$("#dayVal").val(calid);

}
</script>
     <link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
    <!-- Extra optional content header -->
</head>
<input type="hidden" name="dayVal" id="dayval" value="">
<body class="home">
    <div id="preloader"></div>
	<header data-menu-anima="fade-left" class=" hidden-xs hidden-sm">
        <div class="navbar navbar-default over wide-area" role="navigation">
            <div class="navbar navbar-main over">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle">
                            <i class="fa fa-bars"></i>
                        </button>
                <a class="navbar-brand" href="<?php echo $page; ?>" style="padding-left:30px;"><img src="images/Fotopia-New-Logo1.png" alt="logo" style="margin-top:-6px;width:65px;height:60px">
						       <span style="display:inline;font-size:13px;color:#000!important;font-weight:bold;margin-left:-4px"><span style="color:#aad1d6;font-size:18px;padding-left:13px">f</span>otopia</span></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav over mega-menu-fullwidth">
                          <?php

						  if(!isset($_SESSION['loggedin_id']))
							{

						  ?>

						    <li class="dropdown current-active">
                                <a href="index.php" class="dropdown-toggle" data-toggle="dropdown" role="button" adr_trans="label_home">Home <span class="caret"></span></a>
                               <!-- <ul class="dropdown-menu">
                                    <li><a href="<?php //echo $page; ?>" >Home</a></li>


                                </ul>-->
                            </li>


							 <li class="dropdown current-active">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" adr_trans="label_about_us">About Us <span class="caret"></span></a>

                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" adr_trans="label_overview">Overview <span class="caret"></span></a>
                                <!--<ul class="dropdown-menu">
                                    <li><a href="gallery-grid.html">overview 1</a></li>

                                </ul>-->
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" adr_trans="label_key_features">Key Features <span class="caret"></span></a>
                                <!--<div class="mega-menu dropdown-menu multi-level row bg-menu" style="background-image:url(images/menu-bg.jpg);">
                                    <div class="col">
                                        <h5 adr_trans="label_portfolio">Portfolio 1</h5>
                                        <ul class="fa-ul text-s">
                                            <li><i class="fa-li fa fa-desktop"></i><a href="portfolio-1-gutted-boxed.html">Gutted boxed</a></li>
                                            <li><i class="fa-li fa fa-desktop"></i><a href="portfolio-1-gutted-full-width.html">Gutted full width</a></li>
                                        </ul>

                                    </div>

                                </div>-->
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" adr_trans="label_testimonial">Testimonial <span class="caret"></span></a>
                               <!-- <div class="mega-menu dropdown-menu multi-level row bg-menu" style="background-image:url(images/menu-bg.jpg)">
                                    <div class="col">
                                        <ul class="fa-ul text-s">
                                            <li><i class="fa-li fa fa-newspaper-o"></i><a href="blog-1.html">Blog 1</a></li>
                                            <li><i class="fa-li fa fa-newspaper-o"></i><a href="blog-2.html">Blog 2</a></li>

                                        </ul>
                                    </div>
                                </div>-->
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" adr_trans="label_contacts">Contacts <span class="caret"></span></a>
                               <!-- <ul class="dropdown-menu">
                                    <li><a href="contacts-1.html">Contacts 1</a></li>

                                </ul>-->
                            </li>
							<?php } ?>
                        </ul>
                       <div class="nav navbar-nav navbar-right">

                           <div class="collapse navbar-collapse">
								<?php



if(isset($_SESSION['loggedin_email']))
{
$detailsOdUser="";
$detailsOdUser1="";
$loggedINID=$_SESSION['loggedin_id'];
		$loggedin_name=$_SESSION['loggedin_name'];

		if($_SESSION['user_type']=='Realtor')
		{
		$detailsOdUser=mysqli_query($con,"select * from realtor_profile where realtor_id='$loggedINID'");
$detailsOdUser1=mysqli_fetch_array($detailsOdUser);
}
else
{
$detailsOdUser=mysqli_query($con,"select * from photographer_profile where photographer_id='$loggedINID'");
$detailsOdUser1=mysqli_fetch_array($detailsOdUser);
}
							?>


                        <ul class="nav navbar-nav over mega-menu-fullwidth" id="MenuList">
                            <li class="dropdown current-active" style="z-index:999">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" style="color:#000!important;"><span adr_trans="label_hi" style="text-transform:none!important;font-weight:bold;font-size:12px;">Hi,</span> <?php echo $loggedin_name; ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                  <li><a href="change_email_password.php"  adr_trans="label_my_account"><i class="fa fa-key" style="padding-right:10px;"></i>My Account</a></li>
				  <li><a href="cms.php?id=1"><i class="fa fa-camera-retro" style="padding-right:10px;"></i>About Fotopia</a></li>
				  <li><a href="cms.php?id=3"><i class="fa fa-question" style="padding-right:10px;"></i>FAQ</a></li>
				  <li><a href="cms.php?id=4"><i class="fa fa-envelope-o" style="padding-right:10px;"></i>Help & Support</a></li>
				  <li><a href="cms.php?id=2"><i class="fa fa-check-square-o" style="padding-right:10px;"></i>Terms & Conditions</a></li>
   <li><a href="logout.php" adr_trans="label_logout"><i class="fa fa-sign-out" style="padding-right:10px;" ></i>Logout</a></li>
                                </ul>
                            </li>

<img src="data:<?php echo @$detailsOdUser1['profile_pic_image_type']; ?>;base64,<?php echo base64_encode(@$detailsOdUser1['profile_pic']); ?>" width="50" height="60" style="border-radius:60px;margin-left:5px;margin-top:10px;" />

<?php } else { ?>
<div class="btn-group navbar-left navbar-social" style="padding-right:10px;">
                                <div class="btn-group social-group">
				<a href="login.php" adr_trans="label_login" style="font-weight:bold;vertical-align:middle;margin-top:10px;color:#000">Login
	 </a><p style="display: inline;position: relative;top: 6px;">&nbsp;&nbsp; | &nbsp;</p>
	<a target="" href="signup.php" adr_trans="label_signup" style="font-weight:bold;vertical-align:middle;margin-top:10px;color:#000">Signup</a>
	</div>
<?php } ?></div>

<div class="btn-group navbar-left navbar-social">
                                <div class="btn-group social-group">

<?php
if(isset($_SESSION['loggedin_id']))
{
$user_type=$_SESSION['user_type'];
$countIs=0;
$link="";
$loggedin_id=$_SESSION['loggedin_id'];
if($user_type=='Photographer')
{
 $photographer_count_query="select count(*) as total from user_actions where (action_done_by_id='$loggedin_id' or photographer_id='$loggedin_id') and (is_read=0 or photographer_read=0)";
 
 
                  $photographer_count_result=mysqli_query($con,$photographer_count_query);
				  $photographer_data=mysqli_fetch_assoc($photographer_count_result);
                  $countIs=$photographer_data['total'];
				  $link="./photographeractivity.php";
}
else
{
 $realtor_count_query="select count(*) as total from user_actions where (action_done_by_id='$loggedin_id' or realtor_id='$loggedin_id') and (is_read=0 or realtor_read=0)";
                  $realtor_count_result=mysqli_query($con,$realtor_count_query);
                  $realtor_data=mysqli_fetch_assoc($realtor_count_result);
                  $countIs=$realtor_data['total'];
				   $link="./realtor_activity.php";
}
?>
<a href="<?php echo $link; ?>" title="You have <?php echo $countIs; ?> unread notifications.Click here to view">
<?php /* ?><i class="fa fa-bell" style="width:fit-content"><?php if($countIs>0) { ?><?php echo $countIs; ?><?php } ?></i> <?php */ ?>

<div id="ex4">
<span class="p1 fa-stack fa-2x has-badge" data-count="<?php echo $countIs; ?>">

<i class="p3 fa fa-bell-o fa-stack-1x xfa-inverse" style="width:fit-content;color:#000!important" data-count="4b"></i>
</span>
</div>
<style>
#ex4 .p1[data-count]:after{
position:absolute;
right:25%;
top:8%;
content: attr(data-count);
font-size:35%;
padding:4%;
border-radius:50%;
line-height:100%;
color: white;
background:rgba(255,0,0,.85);
text-align:center;
min-width: 20%;
font-weight:bold;
}
</style>
</a>
<?php } ?>



                                </div>
                            </div>
<?php  //$sessval=$_SESSION['Selected_Language_Session']; ?>
			<select class="selectpicker sss" data-width="fit" onChange="changeLanguage(this.value)">
			 <option  data-content='<span class="flag-icon flag-icon-us"></span> US' value='en' <?php if(isset($_SESSION['Selected_Language_Session']) && $_SESSION['Selected_Language_Session']=='en') { echo "selected"; } ?>>English</option>
    <option data-content='<span class="flag-icon flag-icon-no"></span> NO' value='no' <?php if(isset($_SESSION['Selected_Language_Session']) && $_SESSION['Selected_Language_Session']=='no') { echo "selected"; } ?>>Norwegian</option>
</select>
<input type="hidden" name="Selected_Language" id="Selected_Language" value="en" />

<script>
$(function(){
  $('.selectpicker').selectpicker();
   $('.dropdown-toggle').removeClass("btn btn-default");
  $('.selectpicker.dropdown-toggle').attr("style","margin-top-20:0px;border-radius:8px;background:#FFF;color:#000;border:none;margin-right:20px;");


});
</script>
                        </div>
                    </div>





                </div>

            </div>
        </div>
		</header>
			<!-- mobile device starts -->
			<header data-menu-anima="fade-left" class=" hidden-md hidden-lg hidden-xl">



				 <div class="navbar navbar-default over wide-area" role="navigation">
            <div class="navbar navbar-main over">
                <div class="container">
                    <div class="navbar-header">
                       <?php if(!isset($_SESSION['loggedin_email']))
{
?> <button type="button" class="navbar-toggle">
                            <i class="fa fa-bars"></i>
                        </button> <?php } ?>
                <a class="navbar-brand" href="<?php echo $page; ?>" style="padding-left:30px;">
				
				<img src="images/Fotopia-New-Logo1.png" alt="logo" style="margin-top:-6px;width:65px;height:60px" class="hidden-sm hidden-xs">
				
				<img src="images/Fotopia-New-Logo1.png" alt="logo" style="margin-top:-6px;width:65px;height:40px" class="hidden-md hidden-lg hidden-xl">
				
				
						       <span style="display:inline;font-size:13px;color:#000!important;font-weight:bold;margin-left:-4px"><span style="color:#aad1d6;font-size:18px;padding-left:13px">f</span>otopia</span></a>



							   			<?php



if(isset($_SESSION['loggedin_email']))
{
		$loggedin_name=$_SESSION['loggedin_name'];
							?>


                        <ul class="nav navbar-nav" style="width:170px;float:left;margin-left:-30px;margin-top:0px;">
                            <li class="dropdown current-active" style="float:left;z-index:999">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" style="text-transform:none!important;">Hi, <?php echo substr($loggedin_name,0,3)."..."; ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu"  style="width:200px;position:absolute; background:#FFF;color:#000;">
                  <li><a href="change_email_password.php" adr_trans="label_my_account">My Account</a></li>
				    <li><a href="cms.php?id=1"><i class="fa fa-camera-retro" style="padding-right:10px;"></i>About Fotopia</a></li>
				  <li><a href="cms.php?id=3"><i class="fa fa-question" style="padding-right:10px;"></i>FAQ</a></li>
				  <li><a href="cms.php?id=4"><i class="fa fa-envelope-o" style="padding-right:10px;"></i>Help & Support</a></li>
				  <li><a href="cms.php?id=2"><i class="fa fa-check-square-o" style="padding-right:10px;"></i>Terms & Conditions</a></li>
   <li><a href="logout.php" adr_trans="label_logout">Logout</a></li>
                                </ul>
                            </li>
							<img src="data:<?php echo @$detailsOdUser1['profile_pic_image_type']; ?>;base64,<?php echo base64_encode(@$detailsOdUser1['profile_pic']); ?>" width="50" height="50" style="border-radius:60px;margin-left:0px;margin-top:20px;" />





</ul>

<?php } else { ?>
<div style="display:inline-block;margin-top:20px;">
				<a href="login.php" style="font-weight:bold;vertical-align:middle;margin-top:30px;color:#000">Login
	&nbsp;&nbsp; | &nbsp;&nbsp; </a>
	<a target="" href="signup.php" style="font-weight:bold;vertical-align:middle;margin-top:30px;color:#000">Signup</a>
</div>
<?php } ?>

		<div>


<?php  $sessval1=$_SESSION['Selected_Language_Session']; ?>

		<select class="selectpicker" data-width="fit" onChange="changeLanguage(this.value)" style="margin-top:10px;margin-left:5px;color:#000;background:#FFF;">
			 <option  data-content='<span class="flag-icon flag-icon-us"></span> US' value='en' <?php if(isset($_SESSION['Selected_Language_Session']) && $_SESSION['Selected_Language_Session']=='en') { echo "selected"; } ?>>English</option>
    <option data-content='<span class="flag-icon flag-icon-no"></span> NO' value='no' <?php if(isset($_SESSION['Selected_Language_Session']) && $_SESSION['Selected_Language_Session']=='no') { echo "selected"; } ?>>Norwegian</option>
</select>
<input type="hidden" name="Selected_Language" id="Selected_Language" value="en" />

<script>
$(function(){
  $('.selectpicker').selectpicker();

   $('.bootstrap-select').attr("style","margin-top:-10px;");
   $('.dropdown-toggle').removeClass("btn btn-default");
   $('.selectpicker.dropdown-toggle').attr("style","margin-top:30px;border-radius:8px;background:#FFF;color:#000;border:none;;margin-left:35px;");


});
</script>
<?php

 if(isset($_SESSION['user_type']) && $_SESSION['user_type']=="Photographer")
    {
?>
<ul class="nav navbar-nav" style="width:10px;float:left;display:inline-block;margin-top:0px;margin-left:-5px;">
                            <li class="dropdown current-active" style="float:left;display:inline-block;z-index:999">
   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" style="width:40px;float:right"><i class="fa fa-bars"></i></span></a>
                           <ul class="dropdown-menu" style="top:50px;position:absolute;background-color:#FFF;color:#000;display:">



<li><a href="photographerDashboard.php"><i class="fa fa-home" style="padding-right:10px;"></i><span adr_trans="label_home">Home</span></a></li>
<li><a href="photographerCalendar.php"><i class="fa fa-calendar" style="padding-right:10px;"></i><span adr_trans="label_calendar">Calendar</span></a></li>
<li><a href="photographerorder_list.php"><i class="fa fa-stack-exchange" style="padding-right:10px;"></i><span adr_trans="label_order">Orders</span></a></li>
<li><a href="photographeractivity.php"><i class="fa fa-bell-o" style="padding-right:10px;"></i><span adr_trans="label_notification">Notification</span></a></li>
<!-- <li><a href="editor_list.php"><i class="fa fa-users" style="padding-right:10px;" adr_trans="label_editors"></i>Editors</a></li> -->
<li><a href="products.php"><i class="fa fa-list" style="padding-right:10px;"></i><span adr_trans="label_products">Products</span></a></li>
<li><a href="photographer_profile.php"><i class="fa fa-user" style="padding-right:10px;"></i><span adr_trans="label_my_profile">My profile</span></a></li>


 </ul>
                                  </li>
								</ul>

<?php } ?>

<?php
 if(isset($_SESSION['user_type']) && $_SESSION['user_type']=="Realtor")
    {
?>
<ul class="nav navbar-nav" style="width:10px;float:left;display:inline-block;margin-top:0px;margin-left:-10px;">
                            <li class="dropdown current-active" style="float:left;display:inline-block;z-index:999">
   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" style="width:40px;float:right"><i class="fa fa-bars fa-2x"></i></span></a>
                           <ul class="dropdown-menu" style="top:50px;position:absolute;background-color:#000000;color:white;display:">

<li><a href="csrRealtorDashboard.php"><i class="fa fa-home" style="padding-right:10px;"></i><span adr_trans="label_home">Home</span></a></li>
<li><a href="csrRealtorCalendar.php"><i class="fa fa-calendar" style="padding-right:10px;"></i><span adr_trans="label_calendar">Calendar</span></a></li>
<li><a href="order_list.php"><i class="fa fa-stack-exchange" style="padding-right:10px;"></i><span adr_trans="label_order">Orders</span></a></li>
<li><a href="order_reports.php"><i class="fa fa-file" style="padding-right:10px;" ></i><span adr_trans="label_order_reports">Order reports</span></a></li>
<li><a href="realtor_activity.php"><i class="fa fa-bell-o" style="padding-right:10px;"></i><span adr_trans="label_notification">Notification</span></a></li>
<li><a href="realtor_profile.php"><i class="fa fa-user" style="padding-right:10px;"></i><span adr_trans="label_my_profile">My profile</span></a></li>




     </ul>
                                  </li>
								</ul>
								<?php } ?>
							<style>

@media only screen and (max-width: 800px) {

.bootstrap-select
{
width:50px;display:inline-block;margin-left:0px;
}
.selectpicker
{
margin-top:40px;border-radius:8px;background:#FFF;color:#000;border:none;margin-left:0px;
}
.dropdown-toggle
{
margin-top:20px!important;
}
}
</style>

	</div>

		</div>




                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav over mega-menu-fullwidth">
                          <?php

						  if(!isset($_SESSION['loggedin_id']))
							{

						  ?>

						    <li class="dropdown current-active">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" adr_trans="label_home">Home <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo $page; ?>">Home</a></li>


                                </ul>
                            </li>


							 <li class="dropdown current-active">
                                <a href="about.php" class="dropdown-toggle" data-toggle="dropdown" role="button" adr_trans="label_about_us">About Us <span class="caret"></span></a>

                            </li>

                            <li class="dropdown">
                                <a href="overview.php" class="dropdown-toggle" data-toggle="dropdown" role="button" adr_trans="label_overview">Overview <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="gallery-grid.html">overview 1</a></li>

                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="keyfeatures.php" adr_trans="label_key_features">Key Features <span class="caret"></span></a>
                                <div class="mega-menu dropdown-menu multi-level row bg-menu" style="background-image:url(images/menu-bg.jpg);">
                                    <div class="col">
                                        <h5 adr_trans="label_portfolio">Portfolio 1</h5>
                                        <ul class="fa-ul text-s">
                                            <li><i class="fa-li fa fa-desktop"></i><a href="portfolio-1-gutted-boxed.html">Gutted boxed</a></li>
                                            <li><i class="fa-li fa fa-desktop"></i><a href="portfolio-1-gutted-full-width.html">Gutted full width</a></li>
                                        </ul>

                                    </div>

                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="testimonial.php" adr_trans="label_testimonial">Testimonial <span class="caret"></span></a>
                                <div class="mega-menu dropdown-menu multi-level row bg-menu" style="background-image:url(images/menu-bg.jpg)">
                                    <div class="col">
                                        <ul class="fa-ul text-s">
                                            <li><i class="fa-li fa fa-newspaper-o"></i><a href="blog-1.html">Blog 1</a></li>
                                            <li><i class="fa-li fa fa-newspaper-o"></i><a href="blog-2.html">Blog 2</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" adr_trans="label_contacts">Contacts <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="contacts-1.html">Contacts 1</a></li>

                                </ul>
                            </li>
							<?php } ?>
                        </ul>
                      <div class="btn-group navbar-left navbar-social" style="padding-right:10px;display:inline-block;width:120px;">
                                <div class="btn-group social-group">

</div>

<div class="btn-group navbar-left navbar-social" style="width:200px;margin-left:20px;">
                                <div class="btn-group social-group" style="width:200px;display:inline-block;float-left">

<?php
if(isset($_SESSION['loggedin_id']))
{
$user_type=$_SESSION['user_type'];
$countIs=0;
$link="";
$loggedin_id=$_SESSION['loggedin_id'];
if($user_type=='Photographer')
{
 $photographer_count_query="select count(*) as total from user_actions where (action_done_by_id='$loggedin_id' or photographer_id='$loggedin_id') and is_read=0";
                  $photographer_count_result=mysqli_query($con,$photographer_count_query);
				  $photographer_data=mysqli_fetch_assoc($photographer_count_result);
                  $countIs=$photographer_data['total'];
				  $link="./photographeractivity.php";
}
else
{
 $realtor_count_query="select count(*) as total from user_actions where (action_done_by_id='$loggedin_id' or realtor_id='$loggedin_id') and is_read=0";
                  $realtor_count_result=mysqli_query($con,$realtor_count_query);
                  $realtor_data=mysqli_fetch_assoc($realtor_count_result);
                  $countIs=$realtor_data['total'];
				   $link="./realtor_activity.php";
}
?>
<a href="<?php echo $link; ?>"  title="You have <?php echo $countIs; ?> unread notifications.Click here to view">
<?php /* ?><i class="fa fa-bell" style="width:fit-content"><?php if($countIs>0) { ?><?php echo $countIs; ?><?php } ?></i> <?php */ ?>

<div id="ex4">
<span class="p1 fa-stack fa-2x has-badge" data-count="<?php echo $countIs; ?>">

<i class="p3 fa fa-bell-o fa-stack-1x xfa-inverse" style="width:fit-content;color:#000!important" data-count="4b"></i>
</span>
</div>
<style>
#ex4 .p1[data-count]:after{
position:absolute;
right:25%;
top:8%;
content: attr(data-count);
font-size:35%;
padding:4%;
border-radius:50%;
line-height:100%;
color: white;
background:rgba(255,0,0,.85);
text-align:center;
min-width: 20%;
font-weight:bold;
}
</style>
</a>
<?php } ?>



                                </div>


                            </div>




                        </div>

                    </div>





                </div>

            </div>
        </div>
					<!-- mobile device ends -->

    </header>
