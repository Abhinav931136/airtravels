<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="logo192.png"/><meta name="viewport" content="width=device-width,initial-scale=1"/><meta name="theme-color" content="#000000"/><meta name="description" content="Tours & Travels"/><link rel="apple-touch-icon" href="logo192.png"/>
<title>
Agent Details - Dream Travels CRM
</title>
   <!-- Favicons -->
  <link href="../img/LOGO.png" rel="icon">
  <link href="../img/LOGO.png" rel="apple-touch-icon">
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
if($position=='admin') {
?>
<section id="sidebar">
		<a href="#" class="brand">
			&nbsp; &nbsp;<span class="text"><span style="color:skyblue">Sky</span><span style="color:black">zen Travels</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="active">
				<a href="agents.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Manage Agents</span>
				</a>
			</li>
            <li>
				<a href="AddTransaction.php">
					<i class='bx bxs-receipt' ></i>
					<span class="text">Add Transaction Record</span>
				</a>
			</li>
			<li>
				<a href="transaction.php">
					<i class='bx bxs-receipt'></i>
					<span class="text">Manage Bookings</span>
				</a>
			</li>
			<li>
				<a href="messages.php">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Message</span>
				</a>
			</li>
            <li>
                <a href="payment.php">
                 <i class='bx bx-rupee'> </i>

                   <span class="text">Payment Record</span>
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
					<h1>Agent Details</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="viewagent.php">Agent Information</a>
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
	$id=$_GET['ID'];
	$sql="SELECT * FROM users WHERE id= $id";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
<br>
<center><h4><i class="icon-edit icon-large"></i> Agent Information</h4></center>
<hr>
<br><br>

<table>
<tbody>
<tr>
<td> Profile Picture:  </td>
<td style="padding: 10px;
				border-top: 1px solid #fafafa;
				background-color: #f4f4f4;
				text-align: left;
				color: #7d7d7d;">
    <?php if (!empty($row['profile_picture'])) { ?>
        <img src="<?php echo $row['profile_picture']; ?>" alt="Profile Picture" width="100" height="100">
    <?php } else { ?>
        <p>No profile picture uploaded.</p>
    <?php } ?>
</td>
</tr>
<tr>
<td> Agent Id :  </td>
<td style="padding: 10px;
				border-top: 1px solid #fafafa;
				background-color: #f4f4f4;
				text-align: left;
				color: #7d7d7d;"> <?php echo $row['user_id']; ?> </td>
</tr>
<tr>
<td> Agent Name :  </td>
<td style="padding: 10px;
				border-top: 1px solid #fafafa;
				background-color: #f4f4f4;
				text-align: left;
				color: #7d7d7d;"> <?php echo $row['name']; ?> </td>
</tr>
<tr>
<td> Email :  </td>
<td style="padding: 10px;
				border-top: 1px solid #fafafa;
				background-color: #f4f4f4;
				text-align: left;
				color: #7d7d7d;"> <?php echo $row['email']; ?></td>
</tr>
<tr>
<td> Contact No. :  </td>
<td style="padding: 10px;
				border-top: 1px solid #fafafa;
				background-color: #f4f4f4;
				text-align: left;
				color: #7d7d7d;"> <?php echo $row['contact']; ?> </td>
</tr>
<tr>
<td> Date of Birth (DOB) :  </td>
<td style="padding: 10px;
				border-top: 1px solid #fafafa;
				background-color: #f4f4f4;
				text-align: left;
				color: #7d7d7d;"> <?php echo $row['dob']; ?> </td>
</tr>
<tr>
<td> USA Name :  </td>
<td style="padding: 10px;
				border-top: 1px solid #fafafa;
				background-color: #f4f4f4;
				text-align: left;
				color: #7d7d7d;"> <?php echo $row['usa_name']; ?> </td>
</tr>
<tr>
<td> Blood Group :  </td>
<td style="padding: 10px;
				border-top: 1px solid #fafafa;
				background-color: #f4f4f4;
				text-align: left;
				color: #7d7d7d;"> <?php echo $row['blood']; ?> </td>
</tr>
<tr>
<td> Address :  </td>
<td style="padding: 10px;
				border-top: 1px solid #fafafa;
				background-color: #f4f4f4;
				text-align: left;
				color: #7d7d7d;"> <?php echo $row['address']; ?> </td>
</tr>
<tr>
<td> Password :  </td>
<td style="padding: 10px;
				border-top: 1px solid #fafafa;
				background-color: #f4f4f4;
				text-align: left;
				color: #7d7d7d;"> <?php echo $row['password']; ?> </td>
</tr>
</tbody>

</table>
<br>
			
</center>

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
			