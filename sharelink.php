<?php
include "connection.php";

$secret=@$_REQUEST["secret_code"];

$get_raw_images=mysqli_query($con,"select * from raw_images where security_code='$secret'");
$raw_images=mysqli_fetch_assoc($get_raw_images);

?>
<?php


  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  if(isset($_REQUEST['link1']))
  {
  	/* Exception class. */
    include "project-environment.php";
  	require 'C:\PHPMailer\src\Exception.php';

  	/* The main PHPMailer class. */
  	require 'C:\PHPMailer\src\PHPMailer.php';

  	/* SMTP class, needed if you want to use SMTP. */
  	require 'C:\PHPMailer\src\SMTP.php';

  	$mail = new PHPMailer(true);
  	$mail->isSMTP();
  	$mail->Host = $emailHost;
  	$mail->SMTPAuth = true;
  	// //paste one generated by Mailtrap
  	// //paste one generated by Mailtrap
  	$mail->Username =$emailUserID;
  	$mail->Password =$emailPassword;
  	$mail->SMTPSecure = 'tls';
  	$mail->Port = $_SESSION['emailPort'];
  	//$mail->Port = 465;
  	//From email address and name
  	$mail->From = $emailUserID;
  	$mail->FromName = "Fotopia";

  	//To address and name
  	// ;
  	// // //Recipient name is optional
  	// //;
  	// ;
  	 $mail->addAddress($_REQUEST['email']);


  	//Address to which recipient will reply
  	$mail->addReplyTo($_SESSION['emailUserID'], "Reply");

  	//CC and BCC
  	//$mail->addCC("cc@example.com");
  	//$mail->addBCC("bcc@example.com");

  	//Send HTML or Plain Text email
  	$mail->isHTML(true);

  	$mail->Subject = "Image Link shared with you through Fotopia";
  	$mail->Body = "<html><head><style>.titleCss {font-family: \"Roboto\",Helvetica,Arial,sans-serif;font-weight:600;font-size:18px;color:#0275D8 }.emailCss { width:100%;border:solid 1px #DDD;font-family: \"Roboto\",Helvetica,Arial,sans-serif; } </style></head><table cellpadding=\"5\" class=\"emailCss\"><tr><td align=\"left\"><img src=\"".$_SESSION['project_url']."logo.png\" /></td><td align=\"center\" class=\"titleCss\">SHARED IMAGES LINK</td><td align=\"right\">".$_SESSION['support_team_email']."<br>".$_SESSION['support_team_phone']."</td></tr><tr><td colspan=\"2\"><br><br>";
  	//$mail->AltBody = "This is the plain text version of the email content";
  	$mail->Body.="Hi,<br>

   The pictures are completed and can be access via our Fotopia app
  <a href='{{link}}'
  target='_blank'>Click here</a><br>
  Thank you for choosing Fotopia! 

  <br><br><span style=\"font-size:10px;font-weight:bold;\">*This is an auto generated email notification from Fotopia. Please do not reply back to this email. For any support please write to support@fotopia.no</span><br><br>
Thanks,<br>
Fotopia Team.
  ";
    // $mail->Body=str_replace('{{secret_code}}', $v , $mail->Body);
    $link=$_REQUEST['link1'];
    $link1=$_SESSION['project_url']."sharelink.php?".$link;
  	$mail->Body=str_replace('{{link}}', $link1 , $mail->Body);
    // $mail->Body=str_replace('{{Photographer_Name}}', $x , $mail->Body);
  	// $mail->Body=str_replace('F{{orderId}}',$z, $mail->Body);
    	$mail->Body=str_replace('{{Editor_email}}',$_REQUEST['email'], $mail->Body);
      // $mail->Body=str_replace('{{you}}',$_REQUEST['sharename'], $mail->Body);
  	$mail->Body.="<br><br></td></tr></table></html>";
   // echo $mail->Body;
    // exit;
  	try {
  	    $mail->send();
  	    //echo "Message has been sent successfully";
  	} catch (Exception $e) {
  		echo $e->getMessage();
  	    echo "Mailer Error: " . $mail->ErrorInfo;
  	}

header("location:sharelink.php?secret_code=".$secret."&shar=".$_REQUEST['email']);


  }




function copy_folder($src, $dst) {

    // open the source directory
    $dir = opendir($src);

    // Make the destination directory if not exist
    @mkdir($dst);

    // Loop through the files in source directory
    while( $file = readdir($dir) ) {

        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) )
            {

                // Recursively calling custom copy function
                // for sub directory
                copy_folder($src . '/' . $file, $dst . '/' . $file);

            }
            else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }

    closedir($dir);
}
function getFileCount($path) {
        $size = 0;
        $ignore = array('.','..','cgi-bin','.DS_Store');
        $files = scandir($path);
        foreach($files as $t) {
            if(in_array($t, $ignore)) continue;
            if (is_dir(rtrim($path, '/') . '/' . $t)) {
                $size += getFileCount(rtrim($path, '/') . '/' . $t);
            } else {
                $size++;
            }
        }
        return $size;
    }


if(isset($_POST['ZIP']))
{
$id_url=$_REQUEST['Order_ID'];
$OrderCityState=mysqli_query($con,"select * from orders where id='$id_url'");
$OrderCityState1=mysqli_fetch_array($OrderCityState);
$property_city=$OrderCityState1['property_city'];
$property_state=$OrderCityState1['property_state'];
$timeRandom=rand(1000000000,9999999999);
mkdir("./temp/$timeRandom");

  $dir = $_POST['folderToZip'];

copy_folder($dir,"./temp/$timeRandom");
// Get real path for our folder
$rootPath = realpath("./temp/$timeRandom");
 $zip_file = "Fotopia_".$property_city."_".$property_state."_Order_".$id_url."_".$timeRandom.".zip";

// Initialize archive object
$zip = new ZipArchive();
$zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);
$totalNumberOdFiles=getFileCount("./temp/$timeRandom");
foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);
$x=1;
		$extn=$file->getExtension();
		$ParsedFileNameIS=explode("_",$relativePath);


		for($i=0;$i<$totalNumberOdFiles;$i++)
		{
	$ParsedFileName=$ParsedFileNameIS[0]."-".$x.".".$file->getExtension();
	$ParsedFileNameWithoutExtension=$ParsedFileNameIS[0]."-".$x;
		if (file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".jpg") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".png") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".jpeg") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".JPEG") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".PNG") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".gif") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".GIF") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".DNG") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".dng") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".CR2") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".cr2") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".NEF") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".nef") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".ARW") || file_exists("./temp/$timeRandom/".$ParsedFileNameWithoutExtension.".arw")) {
		$x++;
		}
		else
		{

		rename("./temp/$timeRandom/".$relativePath,"./temp/$timeRandom/".$ParsedFileName);

		break 1;
		}
    }
	$zip->addFile("./temp/$timeRandom/".$ParsedFileName, $ParsedFileName);
        // Add current file to archive

    }
}

// Zip archive will be created only after closing object
$zip->close();


header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($zip_file));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($zip_file));
readfile($zip_file);
unlink($zip_file);
unlinkr("./temp/$timeRandom");
rmdir("./temp/$timeRandom");
}


function delete_files($dir) {

foreach(glob($dir . '/*') as $file) {
  if(is_dir($file)) delete_files($file); else unlink($file);

} ;


}


 ?>


<html lang="en">
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
    <link rel="stylesheet" href="scripts/magnific-popup.css">
	 <link rel="stylesheet" href="scripts/jquery.flipster.min.css">

    <style>
	.adr-save
	{
	background:#aad1d6!important;
	border-color:#aad1d6!important;
    color: #000 !important;
	}
	.adr-cancel
	{
	/*background:#5cb85c!important;
	border-color:#5cb85c!important;*/
	background:#f0ad4e!important;
	border-color:#f0ad4e!important;
	}
  .adr-success
	{
	/*background:#5cb85c!important;
	border-color:#5cb85c!important;*/
	background:#6cc070!important;
	border-color:#6cc070!important;
	}
  .tab-black
  {
    background-color: white;
    color: black;
  }
  .tab-box > .panel, .tab-box > .panel-box > .panel{
    border-color: #585858;
  }
  .mfp-container

{

background:#000 !important;
opacity:1!important;

}
.nav-tabs.nav-justified > .active > a, .nav-tabs.nav-justified > .active > a:hover, .nav-tabs.nav-justified > .active > a:focus
{
border:none!important;
}
	</style>

<script>
var calid;
function calDetails(calid)
{
$("#dayVal").val(calid);

}
</script>
<script src="dropzone/dropzone.js"></script>
<script src="dropzone/validate.js"></script>
<script>

</script>
<link rel="stylesheet" href="dropzone/dropzone.css">
     <link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
    <!-- Extra optional content header -->
</head>
<body class="home device-l"><input type="hidden" name="dayVal" id="dayval" value="">

    <div id="preloader" style="display: none;"></div>
    <header data-menu-anima="fade-left">
        <div class="navbar navbar-default over wide-area" role="navigation">
            <div class="navbar navbar-main over">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle">
                            <i class="fa fa-bars"></i>
                        </button>
                        <a class="navbar-brand" href="index.php" style="padding-left:30px;"><img src="images/Fotopia-New-Logo1.png" alt="logo" style="margin-top:-6px;width:65px;height:60px">
						<span style="display:inline;font-size:13px;color:#000;margin-left:-4px"><span style="color:#aad1d6;font-size:18px;padding-left:13px">f</span>otopia</span></a>

                    </div>
                    <?php
                     $editor_email=@$raw_images["editor_email"];
                     $editor_name_split=explode("@",$editor_email);
                     $editor_name=@$editor_name_split[0];
                      ?>
                      <p align="center" style="font-size: large;color: #000;margin-top: 10px;"> Shared Pictures</p>

                    </div>
                </div>
            </div>

    </header>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.5.0/jszip.min.js" integrity="sha512-y3o0Z5TJF1UsKjs/jS2CDkeHN538bWsftxO9nctODL5W40nyXIbs0Pgyu7//icrQY9m6475gLaVr39i/uh/nLA==" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.js" integrity="sha512-UNbeFrHORGTzMn3HTt00fvdojBYHLPxJbLChmtoyDwB6P9hX5mah3kMKm0HHNx/EvSPJt14b+SlD8xhuZ4w9Lg==" crossorigin="anonymous"></script>

 <div class="section-empty">
   
        <div class="container-fluid" style="margin-left:0px;height:inherit;">
            <div class="row">
              <div class="col-md-12"><center style="color:black;font-size:20px"></center></div>
			<hr class="space xs">

      <div class="col-md-1">
      </div>
      <?php
         $id_url=@$raw_images["order_id"];
      $get_order_query1=mysqli_query($con,"SELECT * FROM orders where id='$id_url'");
      $get_order1=mysqli_fetch_array($get_order_query1);

      ?>
      <?php
      if(mysqli_num_rows($get_raw_images))
      {

         if($raw_images["service_name"]==1)
         {
           $service="standard_photos";
         }
         elseif($raw_images["service_name"]==2)
         {
            $service="floor_plans";
         }
         elseif($raw_images["service_name"]==3) {
             $service="Drone_photos";
         }
         else{
            $service="HDR_photos";
         }
      }
      else{
         $id_url="";
         $service="";
       }
       ?>

<?php 

if (@$_REQUEST['shar']) {
?>

<p align="center" style="color:green;font-style: italic;margin-bottom:-10px ;">

<?php echo "Pictures shared successfully to ".$_REQUEST['shar']; ?>

</p>
 
<?php } ?>

                <div class="col-md-8">

<div class="tab-box"  data-tab-anima="show-scale" style="width:100%;padding-left: 20px;">

<ul class="nav nav-tabs nav-justified" style="">
<li class=" active "><a href="#" class="">Shared Images</a>

    <?php if(@$_REQUEST['d']!=1){?>
  </li>
<?php } ?>

</ul>
<hr class="space xs">


<div class="panel active" style="border: 1px solid black;border-radius: 5px;">
    <button href="#tnc" class="btn ActionBtn-sm lightbox link"  name="send2" id="send2" adr_trans="label_share" style="float: right;position:relative;top: -55px;right: -15px;border-radius: 5px;"> share
</button>

	
  <div class="maso-list gallery" style="overflow:scroll;height: 550px;width: 100% !important;>
  
    <div class="maso-box row no-margins" data-options="anima:fade-in" style="position:relative;margin-left: 7%;">

      <?php
      $imagesDirectory = "./finished_images/order_".$id_url."/".$service;

      if (is_dir($imagesDirectory))
      {
       $opendirectory = opendir($imagesDirectory);
          while (($image = readdir($opendirectory)) !== false)
       {
         if(($image == '.') || ($image == '..'))
         {
           continue;
         }
         $imgFileType = pathinfo($image,PATHINFO_EXTENSION);
         if(($imgFileType == 'jpg') || ($imgFileType == 'png') || ($imgFileType == 'DNG') || ($imgFileType == 'CR2') || ($imgFileType == 'NEF') || ($imgFileType == 'ARW'))
         {
          ?>
                  <div data-sort="1" class=" col-md-3 cat1" style="visibility: visible;margin-top:5px;border:solid 2px #aaa;padding:5px;background:#ddd;margin:15px;">
                    <?php
                    $get_comment_querry=mysqli_query($con,"SELECT * FROM `image_naming` WHERE order_id=$id_url and image_name='$image'");
                    $get_comment=mysqli_fetch_assoc($get_comment_querry);
                    $checknaming=mysqli_query($con,"select * from image_naming where order_id=$id_url and image_name='$image'");
                    $checknaming1=mysqli_fetch_assoc($checknaming);
                    if($checknaming1['description']=="")
                    {
                    $image_namecond=explode("-",$image);
                    $image_namecond1=strtoupper($image_namecond[2])."-".$image_namecond[3]."-".@$image_namecond[4]."-".@$image_namecond[5];
                    $image_namecond1=rtrim($image_namecond1,"-");
                    $picture_name=mysqli_query($con,"select * from image_naming where order_id=$id_url and image_name='$image_namecond1'");
                    }
                    else{
                      $picture_name=mysqli_query($con,"select * from image_naming where order_id=$id_url and image_name='$image'");
                    }
                    $picture_name1=mysqli_fetch_assoc($picture_name);
                    ?>
                    <!-- <p><span style="color:red;">*</span><?php //echo $get_comment['description']; ?></p> -->

                      <a class="img-box i-center" href="<?php echo "finished_images/order_".$id_url."/".$service."/".$image; ?>" title="<?php echo $picture_name1['description']; ?>" data-anima="show-scale" data-trigger="hover" data-anima-out="hide" style="opacity: 1;">
                          <i class="fa fa-photo anima" aid="0.22880302434786803" style="transition-duration: 500ms; animation-duration: 500ms; transition-timing-function: ease; transition-delay: 0ms; opacity: 0;"></i>

                          <img alt="" src="<?php echo "finished_images/order_".$id_url."/".$service."/".$image; ?>" width="240" height="180"/>
                      </a>
                      <?php
                      $get_comment_querry=mysqli_query($con,"select * from img_upload where order_id=$id_url and img='$image'");
                      $get_comment=mysqli_fetch_assoc($get_comment_querry);
                      ?>
                    <!-- //  <p><span style="color:red;"></span><?php //echo $get_comment['comments'];?> </p> -->
                    <center><span style="text-align:center"><?php echo @$checknaming1['description']."<br>".date("d-m-Y h:i a",strtotime($checknaming1["created_on"]));?></span></center>
                  </div>
          <?php
         }
        }

          closedir($opendirectory);

      }

      ?>

    <?php
    if(!is_dir($imagesDirectory)) {
     echo  "<p align='center' style='' ><b> No Images <b></p>";
     }
    ?>
   </div>
   </div>

   </div>
   <form action="#" method="post">
   <input type="hidden" name="folderToZip" value="<?php echo "./finished_images/order_".$id_url."/".$service; ?>">
   <input type="hidden" name="Order_ID" value="<?php echo $id_url; ?>">

     <?php if(@$_REQUEST['d']==1){?>
     <input type="submit" class="btn ActionBtn-sm done" name="ZIP" value="Download" style="margin-top:10px;" >
   <?php } ?>
 </form>

 </div>
</div>
      <div class="col-md-1">
      </div>

   	</div>
	</div>
</div>

<div id="tnc" class="box-lightbox white" style="padding:25px;border-radius:25px 25px 25px 25px;width:300px;height:200px;">
   <div class="subtitle g" style="color:#333333">
     <h5 style="color:#333333" align="center" adr_trans="label_enter_the_email">Enter the Email</h5>
        <hr>
        <center><span class="sub" id="error" style="color:green;"></span></center>
        <form   method="post" name="stdform" action="" onSubmit="">
        <input id="email1" name="email" placeholder="Email" type="email" autocomplete="off"  onblur="this.value=this.value.trim()" class="form-control form-value" required>
        <input type="hidden" name="link1" id="link" value="<?php echo "secret_code=".$secret?>">
        <!-- <input type="hidden" name="sharename" value="<?php //echo $loggedin_name;?>"  /> -->
        <hr class="space s">
        <center><button class="btn ActionBtn-sm" style="color:#000" name="link" id="send" ><span adr_trans="label_send">Send</span></button></center>
        </form>
        <hr class="space l">




        </div>
               </div>




 <?php include "footer.php";
