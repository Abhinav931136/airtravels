<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="logo192.png"/><meta name="viewport" content="width=device-width,initial-scale=1"/><meta name="theme-color" content="#000000"/><meta name="description" content="Tours & Travels"/><link rel="apple-touch-icon" href="logo192.png"/>
<title>
Booking Details - Dream CRM
</title>
   <!-- Favicons -->
  <link href="../img/LOGOF.png" rel="icon">
  <link href="../img/LOGOF.png" rel="apple-touch-icon">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
<link href="dashboard.css" media="screen" rel="stylesheet" type="text/css" />
<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('a[rel*=facebox]').facebox({
      loadingImage : 'src/loading.gif',
      closeImage   : 'src/closelabel.png'
    })
  })
</script>
<style>
    td{
        font-size: 12px;
    }
    th{
        font-size: 12px;
    }
</style>


<?php
	require_once('auth.php');
?>
 <script language="javascript" type="text/javascript">
/* Visit http://www.yaldex.com/ for full source code
and get more free JavaScript, CSS and DHTML scripts! */
<!-- Begin
var timerID = null;
var timerRunning = false;
function stopclock (){
if(timerRunning)
clearTimeout(timerID);
timerRunning = false;
}
function showtime () {
var now = new Date();
var hours = now.getHours();
var minutes = now.getMinutes();
var seconds = now.getSeconds()
var timeValue = "" + ((hours >12) ? hours -12 :hours)
if (timeValue == "0") timeValue = 12;
timeValue += ((minutes < 10) ? ":0" : ":") + minutes
timeValue += ((seconds < 10) ? ":0" : ":") + seconds
timeValue += (hours >= 12) ? " P.M." : " A.M."
document.clock.face.value = timeValue;
timerID = setTimeout("showtime()",1000);
timerRunning = true;
}
function startclock() {
stopclock();
showtime();
}
window.onload=startclock;
// End -->
</SCRIPT>	
</head>
<body>
<?php
$position=$_SESSION['role'];
if($position=='agent') {
?>
<section id="sidebar">
		<a href="#" class="brand">
			&nbsp; &nbsp;<span class="text"><span style="color:skyblue">Sky</span><span style="color:black">zen Travels</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="index1.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="active">
				<a href="bookings.php">
					<i class='bx bxs-receipt'></i>
					<span class="text">Manage Bookings</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="https://dreamtravels.great-site.net/crm/" class="logout">
					<i class='bx bx-power-off'></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
            <p><b>Welcome!</b> <?php echo $_SESSION['user_name'];?> </p>
            
		</nav>
		<!-- NAVBAR -->
        <main>
		<!-- MAIN -->
		<div class="head-title">
				<div class="left">
					<h1>Booking Details</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="bookingsdetail.php">Booking Information</a>
						</li>
					</ul>
				</div>
			</div>
<div class="container-fluid">
      <div class="row-fluid">


<?php
$servername = "sql307.infinityfree.com";
$username = "if0_40439465";
$password = "5lSouEF6Wds";
$dbname = "if0_40439465_dream";  
$conn = new mysqli($servername, $username, $password, $dbname);

// Get the booking ID from the URL
$id = $_GET['ID'];

// Fetch the booking details from the bookings table
$sql = "SELECT * FROM bookings WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$booking_reference = ""; // Initialize booking reference

if ($row = $result->fetch_assoc()) {
    $booking_reference = $row['booking_reference'];
    $agent_user_id = $row['user_id']; // Get the agent_user_id for later use
?>
<br>
<center><h4><i class="icon-edit icon-large"></i> Booking Information</h4></center>
<hr>
<br><br>

<table>
    <tbody>
        <tr>
            <td> Booking Reference No. :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['booking_reference']; ?> 
            </td>
        </tr>
        <tr>
            <td> Email :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['email']; ?>
            </td>
        </tr>
        <tr>
            <td> Contact No. :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['code'];?><?php echo $row['contact']; ?> 
            </td>
        </tr>
        <tr>
            <td> Price :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                $<?php echo $row['price']; ?> 
            </td>
        </tr>
        <tr>
            <td> From :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['origin']; ?> 
            </td>
        </tr>
        <tr>
            <td> To :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['to_location']; ?> 
            </td>
        </tr>
        <tr>
            <td> Departure :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['departure_time']; ?> 
            </td>
        </tr>
        <tr>
            <td> Arrival :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['arrival_time']; ?> 
            </td>
        </tr>
        <tr>
            <td> Return Departure :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['return_departure_time']; ?> 
            </td>
        </tr>
        <tr>
            <td> Return Arrival :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['return_arrival_time']; ?> 
            </td>
        </tr>
        <tr>
            <td> Travel Class :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['travel_class']; ?> 
            </td>
        </tr>
        <tr>
            <td> Status :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['Status']; ?> 
            </td>
        </tr>
        <tr>
            <td> Card Holder :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['card_holder']; ?> 
            </td>
        </tr>
        <tr>
            <td> Card Number :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['card_number']; ?> 
            </td>
        </tr>
        <tr>
            <td> Expiry Date :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['expiry_date']; ?> 
            </td>
        </tr>
        <tr>
            <td> CVV :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['cvv']; ?> 
            </td>
        </tr>
        <tr>
            <td> Adults :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['adults']; ?> 
            </td>
        </tr>
        <tr>
            <td> Children :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['children']; ?> 
            </td>
        </tr>
        <tr>
            <td> Infants :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php echo $row['infants']; ?> 
            </td>
        </tr>
        <tr>
            <td> Agent Name :  </td>
            <td style="padding: 10px; border-top: 1px solid #fafafa; background-color: #f4f4f4; text-align: left; color: #7d7d7d;"> 
                <?php
                // Fetch agent's name from users table using agent_user_id
                if ($agent_user_id) {
                    $agent_sql = "SELECT name FROM users WHERE user_id = ?";
                    $agent_stmt = $conn->prepare($agent_sql);
                    $agent_stmt->bind_param("s", $agent_user_id);
                    $agent_stmt->execute();
                    $agent_result = $agent_stmt->get_result();

                    if ($agent_row = $agent_result->fetch_assoc()) {
                        echo $agent_row['name'];
                    } else {
                        echo 'Not Assigned';
                    }

                    $agent_stmt->close();
                } else {
                    echo 'Not Assigned';
                }
                ?>
            </td>
        </tr>
    </tbody>

</table>
<br>
			
</center>

</div>
<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Passenger Details</h3>
					</div>					<table>
						<thead>
							<tr>
								<th style="font-size:12px">S. No.</th>
								<th style="font-size:12px">&nbsp;&nbsp;&nbsp;Name</th>
								<th style="font-size:12px">&nbsp;&nbsp;&nbsp;Type</th>
							</tr>
						</thead>
                        
						<tbody><?php
                // Fetch passengers for this booking
                $passenger_sql = "SELECT * FROM passengers WHERE booking_reference = ?";
                $passenger_stmt = $conn->prepare($passenger_sql);
                $passenger_stmt->bind_param("s", $booking_reference);
                $passenger_stmt->execute();
                $passenger_result = $passenger_stmt->get_result();
                $counter = 1;

                while ($passenger_row = $passenger_result->fetch_assoc()) {
                ?>
                    <tr>
                        <td style="font-size:11px"><?php echo $counter++; ?></td>
                        <td style="font-size:11px"><?php echo $passenger_row['name']; ?></td>
                        <td style="font-size:11px"><?php echo $passenger_row['passenger_type']; ?></td>
                    </tr>
                <?php
                }
                ?>
						</tbody>
                           
					</table>
				</div>
			</div>
<?php
}
?>
<?php
}
?>
</>
<script src="script.js"></script>
</body>

</html>
			