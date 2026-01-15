<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="logo192.png"/><meta name="viewport" content="width=device-width,initial-scale=1"/><meta name="theme-color" content="#000000"/><meta name="description" content="Tours & Travels"/><link rel="apple-touch-icon" href="logo192.png"/>
<title>
Messages - Dream Travels CRM
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
			<li>
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
			<li  class="active">
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
					<h1>Message Details</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="messages.php">Messages</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Messages Received</h3>
					</div>					<table>
						<thead>
							<tr>
								<th style="font-size:12px">S. No.</th>
								<th style="font-size:12px">&nbsp;&nbsp;&nbsp;Name</th>
								<th style="font-size:12px">&nbsp;&nbsp;&nbsp;Email</th>
                                <th style="font-size:12px">&nbsp;&nbsp;&nbsp;Subject</th>
                                <th style="font-size:12px">&nbsp;&nbsp;&nbsp;Message</th>
                                <th style="font-size:12px">&nbsp;&nbsp;&nbsp;Received On</th>
							</tr>
						</thead>
                        <?php
			
				$servername = "sql307.infinityfree.com";
$username = "if0_40439465";
$password = "5lSouEF6Wds";
$dbname = "if0_40439465_dream";    
                $conn = new mysqli($servername, $username, $password, $dbname);
                $sl=0;
                
				$sql="SELECT * FROM messages";
                  
				$result = $conn->query($sql);
				
			?>
						<tbody>
        <?php
        while ($row = $result->fetch_assoc()) {
            $sl++;
            $agent_name = 'Not Assigned'; // Default value for agent name

        ?>
            <tr>
                <td style="font-size:11px"><?php echo $sl; ?></td>
                <td style="font-size:11px"><?php echo $row['name']; ?></td>
                <td style="font-size:11px">&nbsp;&nbsp;&nbsp;<?php echo $row['email']; ?></td>
                <td style="font-size:11px">&nbsp;&nbsp;&nbsp;<?php echo $row['subject']; ?></td>
                <td style="font-size:11px">&nbsp;&nbsp;&nbsp;<?php echo $row['message']; ?></td>
                <td style="font-size:11px">&nbsp;&nbsp;&nbsp;<?php echo $row['created_at']; ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
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