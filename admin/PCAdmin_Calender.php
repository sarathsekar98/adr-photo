<?php
ob_start();

include "connection1.php";

if(@$_REQUEST['busy'])
{

$fromDatetime=$_REQUEST['fromDatetime'];
$toDatetime=$_REQUEST['toDatetime'];
$Photographer_id=$_REQUEST['Photographer_id'];
$Photographer_name=$_REQUEST['ph_name'];
$dateTemp=explode("T",$fromDatetime);
$busyDate=$dateTemp[0];

mysqli_query($con,"INSERT INTO `appointments` (`order_id`, `created_by_id`, `photographer_id`, `home_seller_id`, `from_datetime`, `to_datetime`, `status`, `active`) VALUES ('0', '0', '$Photographer_id', '0', '$fromDatetime', '$toDatetime', '0', '1')");
header("location:PCAdmin_Calender.php?ph_id=$Photographer_id&ph_name=$Photographer_name&busydate=$busyDate");
}

 if(!empty(@$_REQUEST['ph_name']) && empty(@$_REQUEST['ph_id']) && empty(@$_REQUEST['busy'])  && empty(@$_REQUEST['deleteBusy']))
 {
 header("location:PCAdmin_Calender.php?notexist=1");
}

if(@$_REQUEST['deleteBusy'])
{
$busyid=$_REQUEST['busyid'];
$ph_id=$_REQUEST['ph_id'];
$ph_name=$_REQUEST['ph_name'];

$getDate=mysqli_query($con,"select * from appointments where id='$busyid'");
$getDate1=mysqli_fetch_array($getDate);

$from_datetime1=$getDate1['from_datetime'];

$dateTemp=explode("T",$from_datetime1);
$busyDate=$dateTemp[0];

mysqli_query($con,"delete from `appointments` where id='$busyid'");

header("location:PCAdmin_Calender.php?ph_id=$ph_id&ph_name=$ph_name&busydate=$busyDate");
}



?>
<?php include "header.php";  ?>
 <div class="section-empty bgimage3">
        <div class="container" style="margin-left:0px;height:inherit;width:100%">
            <div class="row">
			<hr class="space s">
                <div class="col-md-2">
	<?php include "sidebar.php"; ?>


			</div>
			<script>
			var busyDate=0;
			function fillPhId()
			{
		  var value= $('#ph_name').val();

  var photographer_id=$('#phList [value="' + value + '"]').data('value');
			//alert(photographer_id);
			$("#ph_id").val(photographer_id);
			$("#filterForm").submit();
			}



			var urlNew="";
			</script>

                <div class="col-md-8" style="margin-top:-6px;">

<div class="row">
<div class="col-md-12" style="padding-left:20px;">
				<div class="col-md-12">
				<h5 class="PageHeading-md"><span class="text-center" id="label_pca_calendar" adr_trans="label_pca_calendar"> Photo Company Admin Calendar</span> - <?php echo strtoupper($_SESSION['admin_loggedin_org']); ?></h5>

				 </div></div>
				</div>
<div class="row" style="margin-left:10px;">
<div class="col-md-12">
<div class="col-md-6"><?php if(@$_REQUEST['ph_name']) { echo strtoupper($_REQUEST['ph_name'])." (Photographer's) Calendar."; } if(@$_REQUEST['notexist']==1) { echo "<span style='color:red;font-weight:400'>Please type and select the Photographer <br>&nbsp;&nbsp;from the dropdown suggestion list.</span>"; } ?> </div>

				<div class="col-md-3" style=""><form name="" method="post" action="PCAdmin_Calender.php" id="filterForm">
<input type="text" name="ph_name"  id="ph_name" list="phList" onchange="fillPhId();" value="<?php echo @$_REQUEST['ph_name']; ?>" placeholder="Select a photographer"  autocomplete="off"  class="form-control W-100" style=""/>

 <datalist id="phList">
 	 <option value="" id="label_select_photographer" adr_trans="label_select_photographer">Select a Photographer</option>
       <?php
	   $photographers="select * from user_login where type_of_user='Photographer' and pc_admin_id='$_SESSION[admin_loggedin_id]' order by first_name";

         $Photographers_list=mysqli_query($con,$photographers);
         while($Photographers_list1=mysqli_fetch_assoc($Photographers_list))
        {?>
                    <option data-value="<?php echo $Photographers_list1["id"]; ?>" value="<?php echo $Photographers_list1['first_name']." ".$Photographers_list1['last_name']; ?>"></option>
                  <?php } ?>

                  </datalist>
				  <input type="hidden" name="ph_id" id="ph_id" value="<?php echo @$_REQUEST['ph_id']; ?>" />
				  </form>
				</div>  
				  <div class="col-md-3">
               <a href="photographerCalendar1.php?pc_admin_id=<?php echo $_SESSION['admin_loggedin_id'];?>" id="" class="ActionBtn-md AnimationBtn Float-right"><i class="fa fa-calendar"></i><span adr_trans="label_create_new_order"> Create New Order</span></a>
                </div>
				  </div></div>



<link href='../lib/main.css' rel='stylesheet' />
				<style>

.today_appointment
{
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 2px;
    padding-bottom: 2px;
}

@media only screen and (max-width: 600px) {
  .fc-prev-button, .fc-next-button, .fc-button
{
background:#000!important;
color:#FFF!important;
margin:3px!important;
font-size: 5px!important;
}
.fc .fc-toolbar-title
{
font-size:7px!important;

}
.forMobile
{
height:fit-content!important;
}
.fc-col-header-cell-cushion
{
font-size:10px!important;
}
#label_create_new_order
{
float:right!important;
margin-right:-70px!important;
font-size:10px!important;
margin-top:15px;
}
.fc .fc-button-primary
{
    color: #000 !important;
    background-color: #aad1d6 !important;
}
#label_create_new_order
{
    left: 53px;
    top: -15px;
}
}


				</style>
				<script src='../lib/main.js'></script>
				<?php
			if(@$_REQUEST['busydate'])
{
		?><script>
				busyDate=1;
				</script>
			<?php }
			if(@$_REQUEST['ph_id'])
{
		?>
			<script>

			var busyDateIs="<?php echo @$_REQUEST['busydate']; ?>";
		var urlNew="../photographer_events.php?photographer_id=<?php echo $_REQUEST['ph_id']; ?>";
		var urlNew1="photographer_busy.php?csr_id=0&photographer_id=<?php echo @$_REQUEST['ph_id']; ?>&pc_admin_id=<?php echo $_SESSION['admin_loggedin_id']; ?>";
			</script>

			<?php } else {  ?>
			<script>

				var urlNew="super_event.php?super_csr_id=<?php echo $_SESSION['admin_loggedin_id']; ?>";
var urlNew1="";
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
      initialView: 'timeGridWeek',
	  contentHeight: 540,
	   fixedWeekCount: false,
      nowIndicator: true,
     headerToolbar: {
        left: 'today',
        center: 'prev,title,next',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
 businessHours: // specify an array instead
  {
    dow: [ 1, 2, 3,4,5 ], // Monday, Tuesday, Wednesday, Thursday, Friday
    start: '08:00', // 8am
    end: '17:00' // 6pm
  },


      navLinks: true, // can click day/week names to navigate views
      editable: true,
      selectable: true,
      selectMirror: true,
      dayMaxEvents: true,
	  displayEventTime:true,// allow "more" link when too many events
      // events: response,
	  eventSources: [
    urlNew,
  urlNew1
  ],
  select: function(info) {
       // alert('selected ' + info.startStr + ' to ' + info.endStr);
	   if(info.view.type=="timeGridDay" || info.view.type=="timeGridWeek")
	  {
		createEventDateTimeNew(info.startStr,info.endStr);
		}
      },
	   eventDrop: function(info) {
   //alert(info.event.title + " was dropped on " + info.event.start.toISOString());

	if(info.event.extendedProps.status=='BUSY')
	{
	 info.revert();
	}

	},
	  selectOverlap: function(event) {
    return event.rendering === 'background';
  },
	    eventClick: function(info) {
		if(info.event.extendedProps.status!='BUSY')
		{
		var even=info.event;
   window.location.href = "superOrder_detail.php?id="+even.extendedProps.orderId;
   }
   if(info.event.extendedProps.status=='BUSY' && info.event.extendedProps.gmailEvent!=1)
   {
   var ph_name='<?php echo strtoupper(@$_REQUEST['ph_name']);?>';
    var ph_id='<?php echo @$_REQUEST['ph_id'];?>';
   if(confirm("Are you sure want to remove the selected BUSY event of Mr."+ph_name+"?")) {
   // alert(info.event.extendedProps.orderId);
  window.location.href = "PCAdmin_Calender.php?deleteBusy=1&busyid="+info.event.extendedProps.orderId+"&ph_id="+ph_id+"&ph_name="+ph_name;
   }
   }
  }
    });

    calendar.render();
if(busyDate==1)calendar.gotoDate(busyDateIs);

	}
	});


  });

</script>

	<div id='calendar' style="border-radius:5px"></div>

    </div>
	<div class="col-md-2" style="margin-top:17px;padding-right:0px;height:auto">
	<div class="BoxHeading"><p align="center" id="label_today_appointment" adr_trans="label_today_appointment">Today's Appointment<br /><br /> <?php echo date("d-M-Y"); ?></p></div>

	<?php
	$appointments="";
	if(@$_REQUEST['ph_id']) {
	$appointments=mysqli_query($con,"select * from appointments where photographer_id!=0 and photographer_id='$_REQUEST[ph_id]' and date(from_datetime)=CURRENT_DATE and status!=0 order by from_datetime");
	}
	else
	{
	$appointments=mysqli_query($con,"select * from appointments where photographer_id!=0 and photographer_id in(select id from user_login where type_of_user='Photographer' and pc_admin_id='$_SESSION[admin_loggedin_id]') and date(from_datetime)=CURRENT_DATE and status!=0 order by from_datetime");
	}?>
    <hr class="space xs">

    <?php
	while($appointments1=mysqli_fetch_array($appointments))
	{
	$orderid=$appointments1['order_id'];
	$photographer_id=$appointments1['photographer_id'];

	$order_info1=mysqli_query($con,"select * from orders where id='$orderid'");
	$order_info=mysqli_fetch_array($order_info1);

	$userInfo1=mysqli_query($con,"select * from user_login where id='$photographer_id'");
	$userInfo=mysqli_fetch_array($userInfo1);
	 ?>
	      <table style="background-color: white;font-size:11px;font-weight:600;margin-left:5px;border-radius: 5px;width:200px;">
        <tr><td class="today_appointment"><?php echo $userInfo['first_name']." ".$userInfo['last_name']; ?></td><td class="today_appointment" style="text-align: end;text-decoration: underline;"><?php echo "Order#".$orderid; ?></td></tr>
        <tr><td class="" colspan="2" style="word-break: break-all;padding-left: 5px;"><p><?php echo $order_info['property_address'];?></p><p style="margin-top: -7px;"><?php echo @$order_info['property_state']." , ".@$order_info['property_city'];?></p></td></tr>
        <tr><td class="today_appointment"><?php echo date("H:i a",strtotime(@$appointments1['from_datetime']))."-".date("H:i a",strtotime(@$appointments1['to_datetime']))?></td><td class="today_appointment"><a href="superOrder_detail.php?id=<?php echo $orderid;?>" style="float: right;font-size: 8px;" class="btn btn-xs ActionBtn-sm">See order</a></td></tr>
    </table><hr class="space xs">
	 <?php } ?>

	</div>
	</div>



	</div>




   <script>


    $( document ).on( "click", "td.fc-day", function() {
    var dateIs=$(this).attr("data-date");
    var createEventis=$(this).find("a#createEvent").text();
    if(createEventis=="Create event")
    {
    }
    else
    {

  var FcTop=$(this).find("div.fc-daygrid-day-top");
  var existing=FcTop.html();
  FcTop.html(existing+"<a href='./create_order.php?date="+dateIs+"' class='fc-daygrid-day-number' id='createEvent' style='float:left;padding-right:20px;text-decoration:underline;color:blue'>Create event</a>");
  //console.log(FcTop);
    }
    });


function createEventDateTimeNew(fromDatetime,toDatetime)
    {

var phNameIs='<?php echo strtoupper(@$_REQUEST['ph_name']);?>';
if(phNameIs!='')
{
var fromDate = new Date(fromDatetime);
	var toDate=new Date(toDatetime);
//alert(dateFormat(date1, "dddd, mmmm dS, yyyy, h:MM:ss TT"));
    if(confirm("Are you sure want to mark  Mr."+phNameIs+" (Photographer) with BUSY status for "+fromDate.toDateString()+" "+fromDate.toLocaleTimeString()+" TO "+toDate.toLocaleTimeString()+"?"))
    {

	// var even=info.event;
 var dateMovedTo=fromDatetime;
 var dateIS=dateMovedTo.split("T");
 //alert(dateIS[0]);

 var todayDate1=new Date().toISOString();
 var todayDate=todayDate1.split("T");

 if(todayDate[0]>dateIS[0])
 {
 alert("BUSY status cannot be marked to past date");
  info.revert();

 }
 else
 {
	var phId1='<?php echo @$_REQUEST['ph_id']; ?>';
	var phname1='<?php echo @$_REQUEST['ph_name']; ?>';
   window.location.href="./PCAdmin_Calender.php?busy=1&fromDatetime="+fromDatetime+"&toDatetime="+toDatetime+"&Photographer_id="+phId1+"&ph_name="+phname1.trim();
   }
    }

    }
   }

    </script>
		<?php include "footer.php";  ?>
