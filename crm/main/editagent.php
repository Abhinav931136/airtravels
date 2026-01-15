<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="logo192.png"/><meta name="viewport" content="width=device-width,initial-scale=1"/><meta name="theme-color" content="#000000"/><meta name="description" content="Tours & Travels"/><link rel="apple-touch-icon" href="logo192.png"/>
<title>
Update Agent Details - Dream Travels CRM
</title>
   <!-- Favicons -->
  <link href="../img/logo.jpg" rel="icon">
  <link href="../img/logo.jpg" rel="apple-touch-icon">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
<link href="dashboard.css" media="screen" rel="stylesheet" type="text/css" />
<link href="edit.css" media="screen" rel="stylesheet" type="text/css" />
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
			&nbsp; &nbsp;<span class="text"><span style="color:blue">Sky</span><span style="color:black">Zen</span> Tour & Travels</span>
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
			<li >
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
							<a class="active" href="editagent.php">Update/Edit Agent Details</a>
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
$result = mysqli_query($conn,"SELECT * FROM users WHERE id='" . $_GET['ID'] . "'");
$row= mysqli_fetch_array($result);
?>
<?php
$servername = "sql307.infinityfree.com";
$username = "if0_40439465";
$password = "5lSouEF6Wds";
$dbname = "if0_40439465_dream";    
                $conn = new mysqli($servername, $username, $password, $dbname);
//getting id from url
$ID = $_GET['ID'];

//selecting data associated with this particular id
$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$ID");

while($res = mysqli_fetch_array($result))
{
    $user_id = $res['user_id'];
	$name = $res['name'];
	$email = $res['email'];
    $contact = $res['contact'];
    $dob = $res['dob'];
    $usa_name = $res['usa_name'];
    $blood = $res['blood'];
    $address = $res['address'];
    $password = $res['password'];
}

?>
	<center>

<form action="saveeditagent.php?ID=<?php echo $ID?>" method="post" enctype="multipart/form-data">
<center><h4><i class="icon-edit icon-large"></i> Edit Agent</h4></center>
<div id="ac">
<span>Agent Id : </span><input type="text" style="width:265px; height:30px;"  name="user_id" value="<?php echo $user_id; ?>" /><br>
<span>Name : </span><input type="text" style="width:265px; height:30px;"  name="name" value="<?php echo $name; ?>" /><br>
<span>Email : </span><input type="email" style="width:265px; height:30px;"  name="email" value="<?php echo $email; ?>" /><br>
<span>Contact : </span><input type="text" style="width:265px; height:30px;"  name="contact" value="<?php echo $contact; ?>" /><br>
<span>DOB : </span><input type="date" style="width:265px; height:30px;"  name="DOB" value="<?php echo $dob; ?>" /><br>
<span>USA Name : </span><input type="text" style="width:265px; height:30px;"  name="usa_name" value="<?php echo $usa_name; ?>" /><br>
<span>Blood Group : </span><input type="text" style="width:265px; height:30px;"  name="blood" value="<?php echo $blood; ?>" /><br>
<span>Address : </span><input type="text" style="width:265px; height:30px;"  name="address" value="<?php echo $address; ?>" ><br>
<span>Password : </span><input type="text" style="width:265px; height:30px;"  name="password" value="<?php echo $password; ?>" /><br><br>

<div >
<input type="submit" value="Save Changes" name="submit" id="submit">
</div>
</div>
</form>
</center>
</div>
</div>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
    <?php
}
?>
	<!-- CONTENT -->
	
<script src="script.js"></script>
</body>

</html>