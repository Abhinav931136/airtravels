<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="logo192.png"/><meta name="viewport" content="width=device-width,initial-scale=1"/><meta name="theme-color" content="#000000"/><meta name="description" content="Tours & Travels"/><link rel="apple-touch-icon" href="logo192.png"/>
<title>
Agent Section - Dream Travels CRM
</title>
   <!-- Favicons -->
  <link href="../img/LOGOF.png" rel="icon">
  <link href="../img/LOGOF.png" rel="apple-touch-icon">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
<link href="dashboard1.css" media="screen" rel="stylesheet" type="text/css" />
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
	require_once('auth1.php');
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
			<li class="active">
				<a href="index1.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
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

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
			</div>

			<ul class="box-info">
				
                
				<li><a href="bookings.php">
					<i class='bx bxs-receipt'></i>
					<span class="text">
						<h3>Manage Bookings</h3>
					</span></a>
				</li>
				<li><a href="http://mcrcedu.great-site.net/crm/">
					<i class='bx bx-power-off'></i>
					<span class="text">
						<h3>Log Out</h3>
					</span></a>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Bookings</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th style="font-size:12px">S. No.</th>
								<th style="font-size:12px">Reference No.</th>
								<th style="font-size:12px">&nbsp;&nbsp;&nbsp;From</th>
                                <th style="font-size:12px">&nbsp;&nbsp;&nbsp;To</th>
                                <th style="font-size:12px">&nbsp;&nbsp;&nbsp;Price</th>
                                <th style="font-size:12px">&nbsp;&nbsp;&nbsp;Booked On</th>
                                <th style="font-size:12px">&nbsp;&nbsp;&nbsp;Status</th>
							</tr>
						</thead>
<?php
$servername = "sql307.infinityfree.com";
$username = "if0_40439465";
$password = "5lSouEF6Wds";
$dbname = "if0_40439465_dream";   
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in user's name from the session
$user_name = $_SESSION['user_name'];

// Query to retrieve user_id from users table
$userQuery = "SELECT user_id FROM users WHERE name = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bind_param("s", $user_name);
$userStmt->execute();
$userResult = $userStmt->get_result();
$userData = $userResult->fetch_assoc();
$user_id = $userData['user_id'];
$userStmt->close();

// Check if the lock request was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lock_booking_id'])) {
    $bookingIdToLock = intval($_POST['lock_booking_id']);

    // Update the booking to lock it with the agent's user_id
    $lockQuery = "UPDATE bookings SET user_id = ? WHERE id = ? AND user_id = 'Available'";
    $lockStmt = $conn->prepare($lockQuery);
    $lockStmt->bind_param("si", $user_id, $bookingIdToLock);
    $lockStmt->execute();
    $lockStmt->close();
}

// Query to select only unlocked bookings (user_id = '0') or bookings locked by the current agent
$sql = "SELECT * FROM bookings WHERE user_id = 'Available' OR user_id = ? ORDER BY id DESC LIMIT 25";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Generate table rows
while ($row = $result->fetch_assoc()) {
    // Determine booking status
    $status = ($row['user_id'] == $user_id) ? "Locked by Me" : "Available";
				
			?>
						<tbody>
        <tr>
            <td style="font-size:11px"><?php echo $row['id']; ?></td>
            <td style="font-size:11px"><?php echo $row['booking_reference']; ?></td>
            <td style="font-size:11px">&nbsp;&nbsp;&nbsp;<?php echo $row['origin']; ?></td>
            <td style="font-size:11px">&nbsp;&nbsp;&nbsp;<?php echo $row['to_location']; ?></td>
            <td style="font-size:11px">&nbsp;&nbsp;&nbsp;<?php echo $row['price']; ?></td>
            <td style="font-size:11px">&nbsp;&nbsp;&nbsp;<?php echo $row['created_at']; ?></td>
            <td style="font-size:11px">
                <span class="status completed"><?php echo $status; ?></span>
                <?php if ($status === "Available") : ?>
    <!-- Lock button with improved styling -->
    <form method="post" style="display:inline;">
        <input type="hidden" name="lock_booking_id" value="<?php echo $row['id']; ?>">
        <button type="submit" 
                style="font-size:11px; 
                       color: #ffffff; 
                       background-color: #007bff; 
                       border: none; 
                       padding: 5px 10px; 
                       border-radius: 5px; 
                       cursor: pointer;
                       transition: background-color 0.3s ease;">
            Lock
        </button>
    </form>
<?php endif; ?>
            </td>
        </tr>
    </tbody>
                           <?php
}
$stmt->close();
$conn->close();
?>
					</table>
				</div>
			<!--	<div class="todo">
					<div class="head">
						<h3>Todos</h3>
						<i class='bx bx-plus' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<ul class="todo-list">
						<li class="completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
					</ul>
				</div>-->
			</div>
			
		</main>
		<!-- MAIN -->
	</section>

	<!-- CONTENT -->
	

	<script src="script.js"></script>

<?php
}
?>
</body>
<?php include('footer.php'); ?>
</html>