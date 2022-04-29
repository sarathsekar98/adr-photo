<?php
ob_start();

include "connection1.php";

//Login Check
if(isset($_REQUEST['loginbtn']))
{
	header("location:index.php?failed=1");
}
$superCsr=$_SESSION['admin_loggedin_id'];
$loggedin_id=$_SESSION['admin_loggedin_id'];

?>
<?php include "header.php";  ?>
 <div class="section-empty bgimage4">
        <div class="container-fluid" style="margin-left:0px;height:inherit">
            <div class="row">
			<hr class="space xs">
                <div class="col-md-2">
				<hr class="space s">
	<?php include "sidebar.php"; ?>
		<script>
		var id=null;
		var title=null;
		function GetDetails(id,title)
		{

		 var xhttp= new XMLHttpRequest();
  xhttp.onreadystatechange = function()
  {
    if(this.readyState == 4 && this.status == 200){

	 $("#resultDiv").html(this.responseText)


    }
  };
  xhttp.open("GET","Get_Details.php?id="+id,true);
  xhttp.send();
		}





		var id1=null;
		var org=null;
		function GetCompanyDetails(supercsr,id1,org)
		{
		$("#companyName").html(org);
		 var xhttp= new XMLHttpRequest();
  xhttp.onreadystatechange = function()
  {
    if(this.readyState == 4 && this.status == 200){
	 $("#resultDiv1").html(this.responseText);

    }
  };
  xhttp.open("GET","Get_Company_Details.php?super_csr_id="+supercsr+"&id="+id1,true);
  xhttp.send();
		}

	var id_to_show_hide;
	function show(id_to_show_hide)
	{
	$("#show"+id_to_show_hide).show();

	}
	function hide(id_to_show_hide)
	{
	$("#show"+id_to_show_hide).hide();

	}

var tog="";
function togglePH(tog)
{
if(tog=='photographers')
{
$("#photo_company").hide();
$("#photographers").show();
}
else
{
$("#photographers").hide();
$("#photo_company").show();
}

}
		</script>
<style>
 
.mobileLinks
{
width:75px!important;
display:inline-block!important;
color:#000000!important;
font-weight:600!important;
}

.mobileLinks a
{
color:#000000!important;
font-weight:600!important;
}

#label_view12 i
{
    color: #7c6f6f!important;
	}


	@media only screen and (max-width: 600px) {
  .fc-prev-button, .fc-next-button, .fc-button
{
/*background:#000!important;
color:#FFF!important;*/
margin:2px!important;
font-size: 7px!important;
}
.fc .fc-toolbar-title
{
font-size:7px!important;
}

.forMobile
{
height:fit-content!important;
}
}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .active
{
opacity:1!important;
border:none;
}
/*new code */
.RadionBTn-group
{
	font-size: 12px;
	font-family: verdana;
	font-weight: 600;
	padding-left: 10px;
}
.RadionBTn-group tbody > tr > td > input,.RadionBTn-group > tbody > tr > td:nth-child(2) > span,.RadionBTn-group tbody > tr > td > span
{
	color: #000!important;
	position: relative;
	top: 0px;
}
</style>
			</div>
                <div class="col-md-8">
<?php if(@isset($_REQUEST["na"])) { ?>

                            <p class="text-error" align="center" style="font-style:italic;color:red"><br />You are not Authorized to view the details of the requested Order.<br /></p>

						<?php }  ?>
						<div class="row">
						<!--<p align="left"><span style="padding-left:5px;color:#000;">PC Admin Dashboard</span>-->	
						<a href="quick_create_order.php?u=0&pc_admin_id=<?php echo $_SESSION['admin_loggedin_id']; ?>" class="ActionBtn-sm">Quick Order</a>
						<hr class="space s"> 
					<div class="row" style="margin-left:0px;"></p></div>

               
								<div class="row" style="margin-left:0px;">

											<div class="col-md-3">
													 <div class="advs-box boxed-inverse">

													
															
																	<h5><i class="fa fa-arrow-circle-right fa-lg IconColor"></i><span>New / Ongoing </span></h5>
																		<?php
																		$get_ongoing_query=mysqli_query($con,"select count(*) as ongoing_no from orders where status_id in(1,2,4,7,8) and pc_admin_id=$superCsr");
																		if($get_ongoing=mysqli_fetch_assoc($get_ongoing_query))
																		{
																		?>
																	<p class="counter" data-speed="1000" data-to=" <?php echo $get_ongoing["ongoing_no"];?>"> <?php echo $get_ongoing["ongoing_no"]; }?></p>

																	
							 <a class="ActionBtn-sm" adr_trans="label_view" href="superorder_list1.php?o=1" >View </a>


															
													</div>
											</div>
											 <div class="col-md-3">
                     <div class="advs-box boxed-inverse">

												
														<h5><i class="fa fa-check-circle fa-lg IconColor"></i><span id="label_completed" adr_trans="label_completed">Completed</span></h5>
												
															<?php
															$get_order_query=mysqli_query($con,"select count(*) as completed_no from orders where status_id=3 and pc_admin_id=$superCsr");
															if($get_order=mysqli_fetch_assoc($get_order_query))
															{
															?>
                            <p class="counter" data-speed="1000" data-to=" <?php echo $get_order["completed_no"];?>">

			 <?php echo $get_order["completed_no"]; }?>
		 </p>

		
							 <a class="ActionBtn-sm" adr_trans="label_view" href="superorder_list1.php?c=1">View </a>

		  
													
                    </div>
                </div>
                <div class="col-md-3">
                     <div class="advs-box boxed-inverse">

													
                              <h5><i class="fa fa-users circle-right fa-lg IconColor"></i><span id="label_users" adr_trans="label_users">Users</span></h5>
                              
															<?php
															$get_user_query=mysqli_query($con,"select count(*) as user_no from user_login where type_of_user='Photographer' and pc_admin_id=$superCsr");

															$get_user_query1=mysqli_query($con,"select count(*) as user_no1 from admin_users where type_of_user='CSR' and pc_admin_id=$superCsr");

															$get_user_query2=mysqli_query($con,"select count(*) as user_no2 from photo_company_admin where pc_admin_id=$superCsr");

															$get_user=mysqli_fetch_assoc($get_user_query);
															$get_user1=mysqli_fetch_assoc($get_user_query1);
															$get_user2=mysqli_fetch_assoc($get_user_query2);
															  ?>
														<p class="counter" data-speed="1000" data-to="<?php echo $get_user["user_no"]+$get_user1["user_no1"]+$get_user2["user_no2"];?>">

		<?php echo $get_user["user_no"]+$get_user1["user_no1"]+$get_user2["user_no2"]; ?>
		 </p>
							 <a class="ActionBtn-sm" adr_trans="label_view" href="csr_list1.php?p=1">View </a>

		     
												
                    </div>
                </div>
                <div class="col-md-3">
                   <div class=" advs-box boxed-inverse">

                         
														<h5><i class="fa fa-sliders fa-lg IconColor"></i><span>Revenue this Month</span></h5>

															<?php

													$total1=0;
													// echo "SELECT id FROM orders where status_id=3 and pc_admin_id=$superCsr";
													$get_invoiced_name_query=mysqli_query($con,"SELECT id FROM orders where month(session_from_datetime)=month(now()) and status_id=3 and pc_admin_id=$superCsr");
													while(@$get_name=mysqli_fetch_assoc(@$get_invoiced_name_query))
													{
														$order_id=$get_name['id'];
														//echo "SELECT sum(total_price*quantity) as totalPrice from order_products WHERE order_id='$order_id'";
														  $total_cost=mysqli_query($con,"SELECT sum(price*quantity) as totalPrice from order_products WHERE order_id='$order_id'");
																	if($get_product=mysqli_fetch_array($total_cost))
                                   {
													     	   @$total1 +=@$get_product['totalPrice'];
													       }
                          }
												?>
											   <span>$</span><p class="" data-speed="1000" data-to="<?php echo $total1;?>"><?php echo $total1; ?></p>
											 
											   
							 <a class="ActionBtn-sm" adr_trans="label_view" href="payment_reports.php">View </a>

												

                    </div>
                </div>
            </div>






<hr class="space l">

<!--  calendar starts -->


<link href='../lib/main.css' rel='stylesheet' />
				<style>

				#calendar
				{
				background-color:#FFFFFF;
				}

				table td[class*="col-"], table th[class*="col-"]
				{
				background:#EEE;

				}
        .fc-day-mon,.fc-day-tue,.fc-day-wed,.fc-day-thu,.fc-day-fri
        {
        background:#DAE7BD!important;
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
        

        

		.fc-day-mon,.fc-day-tue,.fc-day-wed,.fc-day-thu,.fc-day-fri
{
background:#FFF!important;
border:solid 1px #01A8F2!important;
}
.fc-day-sat,.fc-day-sun
{
background:#EEEEEE!important;
border:solid 1px #01A8F2!important;
}
				</style>
				<script src='../lib/main.js'></script>
			<?php
			if(@$_REQUEST['ph_id'])
{
		?>
			<script>
		var urlNew="../photographer_events.php?photographer_id=<?php echo $_REQUEST['ph_id']; ?>";
			</script>

			<?php } else {  ?>
			<script>
				var urlNew="super_event.php?super_csr_id=<?php echo $_SESSION['admin_loggedin_id']; ?>";

			</script>
			<?php }   ?>

<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
let today = new Date().toISOString().slice(0, 10)


$.ajax({
      url: urlNew,
      modal: true,
	   dataType: 'JSON',
	  success: function(response){
	 // eventData=JSON.stringify(response);
	//alert(eventData);

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialDate: today,
      initialView: 'timeGridDay',
	  contentHeight: 320,
	   fixedWeekCount: false,
      nowIndicator: true,
      headerToolbar: {
        left: 'today',
        center: 'prev,title,next',
        right: 'timeGridWeek,timeGridDay'
      },



      navLinks: true, // can click day/week names to navigate views
      editable: true,
      selectable: true,
      selectMirror: true,
      dayMaxEvents: true,
	  displayEventTime:true,// allow "more" link when too many events
      events: response,
	    eventClick: function(info) {
		var even=info.event;
   window.location.href = "superOrder_detail.php?id="+even.extendedProps.orderId;
  }
    });

    calendar.render();



	}
	});


  });

</script>
<div class="col-md-6 TextCenter">


             <h5 class="PageHeading-md TextCenter" adr_trans="label_upcoming_events">Upcoming Events</h5>
 <div id='calendar' class="UpcomingCalender"></div>
  
                
                <a href="PCAdmin_calender.php" class="ActionBtn-md AnimationBtn" adr_trans="label_view_my_calender"><i class="fa fa-calendar"></i>View My Calender</a>  
    </div>

<!-- calendar ends -->


<div class="col-md-6 TextCenter">

               <h5 class="PageHeading-md TextCenter" id="label_latest_delivered" adr_trans="label_latest_delivered">Latest Delivered Orders</h5>
<div class="advs-box boxed-inverse forMobile LatestDelivered">
 <?php

		$get_latest_delivered_query=mysqli_query($con,"SELECT * FROM `img_upload` where finished_images=1 and order_id in(select id from orders where pc_admin_id=$_SESSION[admin_loggedin_id]) order by rand() limit 4");
		while($get_latest_delivered=mysqli_fetch_array($get_latest_delivered_query))
		{
		  $orderIDIs=$get_latest_delivered['order_id'];
		$get_address1=mysqli_query($con,"SELECT * FROM orders where id='$orderIDIs'");
		$get_address=mysqli_fetch_array($get_address1);
			?>

			<div class="col-md-6">
				<a href="superOrder_detail.php?id=<?php echo $get_latest_delivered['order_id']; ?>&finished_image=1">
				<img src="../finished_images/order_<?php echo $get_latest_delivered['order_id']; ?>/<?php if($get_latest_delivered['service_id']==1){ echo "standard_photos" ;}elseif($get_latest_delivered['service_id']==2){ echo "floor_plans";}elseif($get_latest_delivered['service_id']==3){echo "Drone_photos";}else{ echo "Hdr_photos";}?>/<?php echo $get_latest_delivered['img']?>"/>
				 <span ><?php echo $get_address['property_address']; ?></span>
			</a>
			</div>
<?php		}
	?>

</div>
  

 <a class="ActionBtn-md AnimationBtn" href="superorder_list1.php?c=1" adr_trans="label_view_order"><i class="fa fa-long-arrow-right"></i>View My Orders </a>
 
</div>




 







                </div>
								</div>



<div class="col-md-2">


<table class="table-responsive RadionBTn-group"><tr><td>
	<input type="radio" name="toglePH"  value="photographers" checked="checked" onchange="togglePH(this.value)" />&nbsp;&nbsp;<span id="label_photographers" adr_trans="label_photographers">&nbsp;Photographers<br /></span></td>
	<td>&nbsp;&nbsp;<input type="radio"  name="toglePH"  value="photo_company"  onchange="togglePH(this.value)"/>&nbsp;&nbsp;<span id="label_csr" adr_trans="label_csr">CSR</span></td>
	</tr>
	</table>

<div class="RightSideCard">
				<div id="photographers">

				<!-- <h5 class="text-left" style="margin-left:20px;display:none" id="label_photographers" adr_trans="label_photographers">Photographers</h5> -->
				<p style="padding-left:3px;">
				<form name="searchByLocation" method="post" action="" style="margin-left:5px;">

		<?php 	/*	 <input type="text" list="Suggestions" multiple="multiple" class="form-control form-value" name="location" value="" style="display:inline;font-size:12px;"  placeholder="Choose city" />

</form>
<datalist id="Suggestions">
 <?php
							$city1=mysqli_query($con,"select cities from norway_states_cities");
							while($city=mysqli_fetch_array($city1))
							{
							?>
							<option value="<?php echo $city['cities']; ?>"><?php echo $city['cities']; ?></option>
							<?php } ?>
</datalist>
				</p>
<br />
				<?php

$whereIs="";
$knowMore="";
				if(@$_REQUEST['location'])
				{
				$searchByLocation=$_REQUEST['location'];
				$whereIs=" and location like '%$searchByLocation%'";
			} */?>

<input type="text" list="Suggestions" multiple="multiple" class="form-control form-value" name="photographersearch" value="<?php echo @$_REQUEST['photographersearch'];?>"  placeholder="Search Photographer" />

</form>

				</p>
<br />
				<?php

$whereIs="";
$knowMore="";
				if(@$_REQUEST['photographersearch'])
				{
				$searchByphotographer=$_REQUEST['photographersearch'];
				$whereIs=" and first_name like '%$searchByphotographer%'";
				}


				$photo=mysqli_query($con,"select * from user_login where email_verified=1 and type_of_user='Photographer' and pc_admin_id=$superCsr $whereIs order by id desc");
				while($photo1=mysqli_fetch_array($photo))
				{

				?>
				<table cellspacing="0" border="0" align="center"  cellpadding="0" class="table table-responsive cardTable">
				<tr><td rowspan="0" align="center">

				 <?php
                if ($ph=mysqli_query($con,"select * from user_login where type_of_user='Photographer' and pc_admin_id=$superCsr $whereIs order by id desc")) {

                  ?>
<div ng-repeat="file in imagefinaldata" class="img_wrp">

				<img   href="#aboutMe" class="lightbox link" data-lightbox-anima="show-scale" onclick="GetDetails(<?php echo $photo1['id']; ?>)" src="data:<?php echo $photo1['profile_pic_image_type']; ?>;base64,<?php echo base64_encode($photo1['profile_pic']); ?>"/>

				   <?php

				   $knowMore="<a href='#aboutMe'  class='lightbox link' data-lightbox-anima='show-scale' onclick='GetDetails(".$photo1['id'].")'><span class='Text-md' adr_trans='label_view1'>View</span></a>";
                }
               ?>

				<p  class="CardLabel TextCenter"><?php echo strtoupper($photo1['first_name']); ?> </p>
        

<?php
$phidIs=$photo1['id'];
//echo "select ROUND(avg(rating)) as avgRating,photographer_id from photographer_rating group by realtor_id having photographer_id='$phidIs'";
$rating=mysqli_query($con,"select ROUND(avg(rating)) as avgRating,photographer_id from photographer_rating group by realtor_id,photographer_id having photographer_id='$phidIs'");
$ratingIs=0;
if($rating1=mysqli_fetch_array($rating))
{
$ratingIs= $rating1['avgRating'];
}



for($i=1;$i<=5;$i++)
{
if($i<=$ratingIs)
{
?>
<i class="fa fa-star" ></i>
<?php } else { ?>
<i class="fa fa-star-o"></i>
<?php } } ?>

    <br />    
<span class="Text-md"><?php echo $knowMore; ?></span>
				</td>
				</tr>

				<tr class="fade-top" style="transition-duration: 300ms; animation-duration: 300ms; transition-timing-function: ease; transition-delay: 0ms;display:none;" id="show<?php echo $photo1['id']; ?>">
				<td>

				<a href="#aboutMe" class="lightbox link" data-lightbox-anima="show-scale" style="color:blue;text-decoration:none;color:#333333;padding-left:10px;" id="label_about_me" adr_trans="label_about_me" onclick="GetDetails(<?php echo $photo1['id']; ?>)">About Me</a>&nbsp;&nbsp;&nbsp;&nbsp;<br>
				<a href="#aboutMe" class="lightbox link" data-lightbox-anima="show-scale" style="color:blue;text-decoration:none;color:#333333;padding-left:10px;" id="label_my_skills" adr_trans="label_my_skills" onclick="GetDetails(<?php echo $photo1['id']; ?>)">My Skills</a>&nbsp;&nbsp;&nbsp;&nbsp;<br>
				<a href="#aboutMe" class="lightbox link" data-lightbox-anima="show-scale" style="color:blue;text-decoration:none;color:#333333;padding-left:10px;" id="label_portfolio" adr_trans="label_portfolio" onclick="GetDetails(<?php echo $photo1['id']; ?>)">Portfolio</a>&nbsp;&nbsp;&nbsp;&nbsp;<br>
				<a href="#aboutMe" class="lightbox link" data-lightbox-anima="show-scale" style="color:blue;text-decoration:none;color:#333333;padding-left:10px;" id="label_contact" adr_trans="label_contact" onclick="GetDetails(<?php echo $photo1['id']; ?>)">Contact</a><br>
        	<a href="#aboutMe" class="lightbox link" data-lightbox-anima="show-scale" style="color:blue;text-decoration:none;color:#333333;padding-left:10px;" id="label_products" adr_trans="label_products" onclick="GetDetails(<?php echo $photo1['id']; ?>)">Products</a><br>


				</td></tr>


				</table>
	<?php } ?>

</div>





<div id="photo_company" style="display:none;">


<h5 class="text-left" style="display:none" id="label_photo_companies" adr_trans="label_photo_companies">Photo companies</h5>


<form name="searchByLocation" method="post" >

				 <input type="text"  class="form-control form-value" name="companySearch" value="<?php echo @$_REQUEST['companySearch']; ?>" placeholder="Search CSR" />
				 </form>
				 <br>

				<?php


$where="";

if(isset($_REQUEST['companySearch']))
{
$companySearch=$_REQUEST['companySearch'];
$where="and first_name like '$companySearch%'";
}

				$photo=mysqli_query($con,"select * from admin_users where is_approved=1 and type_of_user='CSR' and pc_admin_id='$superCsr' $where order by id desc");
				while($photo1=mysqli_fetch_array($photo))
				{
		 $knowMore="<a href='#photoCompany'  class='lightbox link' data-lightbox-anima='show-scale' onclick='GetCompanyDetails(".$photo1['pc_admin_id'].",".$photo1['id'].",\"".$photo1['organization_name']."\")'><span adr_trans='label_view1'>View</span></a>";

				?>
				<table cellspacing="0" border="0" align="center"  cellpadding="0" class="table table-responsive cardTable">
				<tr><td rowspan="0" align="center">

				 <?php
                if ($ph=mysqli_query($con,"select * from admin_users where type_of_user='CSR' and pc_admin_id='$superCsr' $where  order by id desc")) {

                  ?>
<div ng-repeat="file in imagefinaldata" class="img_wrp" style="display: inline-block;position: relative;">
				<img   href="#photoCompany" class="lightbox link" data-lightbox-anima="show-scale" onclick="GetCompanyDetails(<?php echo $photo1['pc_admin_id']; ?>,<?php echo $photo1['id']; ?>,'<?php echo $photo1['organization_name']; ?>')" src="data:<?php echo $photo1['profile_pic_image_type']; ?>;base64,<?php echo base64_encode($photo1['profile_pic']); ?>" />

				   <?php


                }
               ?>

				<p align="center" class="CardLabel"><?php echo strtoupper($photo1['first_name']); ?></p>
         

<?php
$phidIs=$photo1['id'];
//echo "select ROUND(avg(rating)) as avgRating,super_csr_id from photographer_rating group by realtor_id having super_csr_id='$phidIs'";
$rating=mysqli_query($con,"select ROUND(avg(rating)) as avgRating,super_csr_id from photographer_rating group by realtor_id,super_csr_id having super_csr_id='$phidIs'");
$ratingIs=0;
if($rating1=mysqli_fetch_array($rating))
{
$ratingIs= $rating1['avgRating'];
}



for($i=1;$i<=5;$i++)
{
if($i<=$ratingIs)
{
?>
<i class="fa fa-star"></i>
<?php } else { ?>
<i class="fa fa-star-o"></i>
<?php } } ?>
               </p>
<span><?php echo $knowMore; ?></span>

				</td>
				</tr>

				 <tr class="fade-top" style="transition-duration: 300ms; animation-duration: 300ms; transition-timing-function: ease; transition-delay: 0ms;display:none;color:#333333" id="show<?php echo $photo1['id']; ?>1">
        <td style="padding-left:10px;">

        <a href="#photoCompany" class="lightbox link" data-lightbox-anima="show-scale" style="color:blue;text-decoration:none;color:#333333;padding-left:10px;" id="label_about_us" adr_trans="label_about_us" onclick="GetCompanyDetails(<?php echo $photo1['pc_admin_id']; ?>,<?php echo $photo1['id']; ?>,'<?php echo $photo1['organization_name']; ?>')">About us</a>&nbsp;&nbsp;&nbsp;&nbsp;<br>
        <a href="#photoCompany" class="lightbox link" data-lightbox-anima="show-scale" style="color:blue;text-decoration:none;color:#333333;padding-left:10px;" id="label_photographers" adr_trans="label_photographers" onclick="GetCompanyDetails(<?php echo $photo1['pc_admin_id']; ?>,<?php echo $photo1['id']; ?>,'<?php echo $photo1['organization_name']; ?>')">Photographers</a>&nbsp;&nbsp;&nbsp;&nbsp;<br>

          <a href="#photoCompany" class="lightbox link" data-lightbox-anima="show-scale" style="color:blue;text-decoration:none;color:#333333;padding-left:10px;" id="label_products" adr_trans="label_products" onclick="GetCompanyDetails(<?php echo $photo1['pc_admin_id']; ?>,<?php echo $photo1['id']; ?>,'<?php echo $photo1['organization_name']; ?>')">Products</a><br>
        <a href="#photoCompany" class="lightbox link" data-lightbox-anima="show-scale" style="color:blue;text-decoration:none;color:#333333;padding-left:10px;" id="label_contact" adr_trans="label_contact" onclick="GetCompanyDetails(<?php echo $photo1['pc_admin_id']; ?>,<?php echo $photo1['id']; ?>,'<?php echo $photo1['organization_name']; ?>')">Contact</a><br>


        </td></tr>


				</table>
					<?php } ?>

</div>

</div>

</div>

<script>


function addToWishList(supercsr,photographers)
{
var Super_CSR__id= supercsr;
var P_id= photographers;
var typeofuser="<?php echo $_SESSION['admin_loggedin_type']; ?>";
var xhttp= new XMLHttpRequest();
  xhttp.onreadystatechange = function()
  {
    if(this.readyState == 4 && this.status == 200){


    }
    };

  xhttp.open("GET","wishlist.php?Super_CSR_id="+Super_CSR__id+"&P_id="+P_id+"&type="+typeofuser,true);
  xhttp.send();
window.location.href = "./csr_dashboard.php?wl=1";

 }


 function addToWishList1(supercsrid,subcsrid)
{
var super_csr_id= supercsrid;
var sub_csr_id= subcsrid;

var xhttp= new XMLHttpRequest();
  xhttp.onreadystatechange = function()
  {
    if(this.readyState == 4 && this.status == 200){


    }
    };
  xhttp.open("GET","wishlist1.php?super_csr_id="+super_csr_id+"&sub_csr_id="+sub_csr_id,true);
  xhttp.send();
window.location.href = "./csr_dashboard.php?wl=1&cw=1";

 }


 function removeFromWishList(supercsr,photographers)
{
var Super_CSR__id= supercsr;
var P_id= photographers;
var typeofuser="<?php echo $_SESSION['admin_loggedin_type']; ?>";
var xhttp= new XMLHttpRequest();
  xhttp.onreadystatechange = function()
  {
    if(this.readyState == 4 && this.status == 200){


    }
    };
  xhttp.open("GET","removeFromWishlist.php?Super_CSR_id="+Super_CSR__id+"&P_id="+P_id+"&type="+typeofuser,true);
  xhttp.send();
window.location.href = "./csr_dashboard.php?rwl=1";

 }




 function removeFromWishList1(supercsrid,subcsrid)
{
var super_csr_id= supercsrid;
var sub_csr_id= subcsrid;

var xhttp= new XMLHttpRequest();
  xhttp.onreadystatechange = function()
  {
    if(this.readyState == 4 && this.status == 200){


    }
    };
  xhttp.open("GET","removeFromWishlist1.php?super_csr_id="+super_csr_id+"&sub_csr_id="+sub_csr_id,true);
  xhttp.send();
window.location.href = "./csr_dashboard.php?rwl=1&cw=1";

 }

// $wish=mysqli_query($con,"INSERT INTO `wishlist` (`realtor_id`, `photographer_id`) VALUES ('$loggedin_id',
//   '$photo1['id']')");
</script>


			<div id="aboutMe" class="box-lightbox" style="background: #F1F3F4;padding:25px;height:350px;border-radius:10px;">
                        <div class="subtitle g" style="color:#333333">

                            <h5 style="color:#333333" align="center" id="label_photographer_details" adr_trans="label_photographer_details" >PHOTOGRAPHER DETAILS</h5>
                            <hr class="space s">

							<div class="tab-box right" data-tab-anima="fade-left">
							<div class="hidden-md hidden-lg hidden-xl">
							<ul class="nav nav-tabs col-md-4 col-sm-4" style="height: 200px;">
          <li class="active mobileLinks" id="about" style="border-bottom:solid 1px #DDD;" ><a href="#" id="label_about_me" adr_trans="label_about_me" >About me</a></li>
			        <li id="skills" style="border-bottom:solid 1px #DDD;" class="mobileLinks"><a href="#" id="label_skills" adr_trans="label_skills" > Skills</a></li>
              <li id="portfolio" style="border-bottom:solid 1px #DDD;" class="mobileLinks"><a href="#" id="label_portfolio" adr_trans="label_portfolio" > Portfolio</a></li>
               <li id="contact" style="border-bottom:solid 1px #DDD;" class="mobileLinks"><a href="#" id="label_contact" adr_trans="label_contact" > Contact</a></li>
               <li id="products" style="border-bottom:solid 1px #DDD;" class="mobileLinks"><a href="#" id="label_products" adr_trans="label_products" >Products</a></li>

                      </ul>
							</div>
                        <div class="panel-box col-md-8 col-sm-8" id="resultDiv" style="height:200px;overflow-y:scroll;">

                        </div>
                        <ul class="nav nav-tabs col-md-4 col-sm-4 hidden-sm hidden-xs" style="height: 145.333px;">
              <li class="active" id="about" style="border-bottom:solid 1px #DDD;width:96%" ><a href="#"><i class="fa fa-user" style="color:#333333"></i><span adr_trans="label_about_me">About Me</span></a></li>
			        <li id="skills" style="border-bottom:solid 1px #DDD;width:96%"><a href="#"><i class="fa fa-certificate" style="color:#333333"></i><span adr_trans="label_skills"> Skills</span></a></li>
              <li id="portfolio" style="border-bottom:solid 1px #DDD;width:96%"><a href="#"><i class="fa fa-list" style="color:#333333"></i><span adr_trans="label_portfolio"> Portfolio</span></a></li>
               <li id="contact" style="border-bottom:solid 1px #DDD;width:96%"><a href="#"><i class="fa fa-tablet" style="color:#333333"></i><span adr_trans="label_contact"> Contact</span></a></li>
               <li id="products" style="border-bottom:solid 1px #DDD;width:96%"><a href="#"><i class="fa fa-database	" style="color:#333333"></i><span adr_trans="label_products"> Products</span></a></li>

                      </ul>
                    </div>

							</div>

</div></div>












			<div id="photoCompany" class="box-lightbox  col-md-6" style="background: #F1F3F4;padding:25px;height:450px;border-radius:10px;">
                        <div class="subtitle g" style="color:#333333">
                            <h5 style="color:#333333" align="center" id="label_photocompany_details" adr_trans="label_photocompany_details">
							<span id="companyName" style="text-transform:uppercase"></span></h5>
                            <hr class="space s">

							<div class="tab-box right" data-tab-anima="fade-left">
							<div class="hidden-md hidden-lg hidden-xl">
							<ul class="nav nav-tabs col-md-4 col-sm-4" style="height: 200px;">
         <li class="active mobileLinks" id="about" style="border-bottom:solid 1px #DDD;"><a href="#" id="label_about_me" adr_trans="label_about_me" >About us</a></li>
			        <li id="skills" style="border-bottom:solid 1px #DDD;width:150px!important;" class="mobileLinks"><a href="#" id="label_photographers" adr_trans="label_photographers" >Photographers</a></li>
             <li id="products" style="border-bottom:solid 1px #DDD;" class="mobileLinks"><a href="#" id="label_products" adr_trans="label_products" >Products</a></li>
               <li id="contact" style="border-bottom:solid 1px #DDD;" class="mobileLinks"><a href="#" id="label_contact" adr_trans="label_contact" > Contact</a></li>
                      </ul>
							</div>
                        <div class="panel-box  col-md-8 col-sm-8" id="resultDiv1" style="height:330px;overflow-y:scroll;">

                        </div>
                        <ul class="nav nav-tabs col-md-4 hidden-sm hidden-xs" style="height: 145.333px;">
              <li class="active" id="about" style="border-bottom:solid 1px #DDD;width:96%" ><a href="#"><i class="fa fa-user" style="color:#333333"></i><span adr_trans="label_about_us"> About Us</span></a></li>
			        <li id="skills" style="border-bottom:solid 1px #DDD;width:96%"><a href="#"><i class="fa fa-camera" style="color:#333333"></i><span adr_trans="label_photographers"> Photographers</span></a></li>
             <li id="products" style="border-bottom:solid 1px #DDD;width:96%"><a href="#"><i class="fa fa-database" style="color:#333333"></i><span adr_trans="label_products"> Products</span></a></li>
               <li id="contact" style="border-bottom:solid 1px #DDD;width:96%"><a href="#"><i class="fa fa-tablet" style="color:#333333"></i><span adr_trans="label_contact"> Contact</span></a></li>


                        </ul>
                    </div>

							</div>
            </div>


            </div>



<?php if(isset($_REQUEST['companySearch']) || @$_REQUEST['cw']) { ?>
<script>
$("#photographers").hide();
$("#photo_company").show();
var value="photo_company";
  $("input[name=toglePH][value=" + value + "]").prop('checked', true);
</script>
<?php } ?>
		<?php include "footer.php";  ?>
