<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="logo192.png"/><meta name="viewport" content="width=device-width,initial-scale=1"/><meta name="theme-color" content="#000000"/><meta name="description" content="Tours & Travels"/><link rel="apple-touch-icon" href="logo192.png"/>
<title>
Bookings - Dream CRM
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
			<li  class="active">
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
							<a class="active" href="bookings.php">Bookings</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Booking List</h3>
						<form method="GET" action="">
                    <input type="text" name="search_booking" placeholder="Search by Booking Reference" required>
                    <button type="submit">Search</button>
                </form>
					</div>					<table>
						<thead>
							<tr>
								<th style="font-size:12px">S. No.</th>
								<th style="font-size:12px">&nbsp;&nbsp;&nbsp;Booking Id</th>
								<th style="font-size:12px">&nbsp;&nbsp;&nbsp;From</th>
                                <th style="font-size:12px">&nbsp;&nbsp;&nbsp;To</th>
                                <th style="font-size:12px">&nbsp;&nbsp;&nbsp;Price</th>
                                <th style="font-size:12px">&nbsp;&nbsp;&nbsp;Booked On</th>
                                <th style="font-size:12px">Actions</th>
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

                    // Get the agent's user_id using session user_name
                    $agent_username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';

                    $agent_user_id = 0; // Default to 0 if not found

                    // Fetch the agent's user_id from the users table based on username
                    if (!empty($agent_username)) {
                        $agent_sql = "SELECT user_id FROM users WHERE name = ?";
                        $agent_stmt = $conn->prepare($agent_sql);
                        $agent_stmt->bind_param("s", $agent_username);
                        $agent_stmt->execute();
                        $agent_result = $agent_stmt->get_result();

                        if ($agent_row = $agent_result->fetch_assoc()) {
                            $agent_user_id = $agent_row['user_id']; // Get the agent's user ID
                        }

                        $agent_stmt->close();
                    }

                    $sl = 0;
                    $search_booking = isset($_GET['search_booking']) ? $_GET['search_booking'] : '';

                    // SQL query to select bookings for the specific agent
                    if (!empty($search_booking)) {
                        $sql = "SELECT * FROM bookings WHERE user_id = ? AND booking_reference = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ss", $agent_user_id, $search_booking);
                    } else {
                        $sql = "SELECT * FROM bookings WHERE user_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $agent_user_id);
                    }

                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $sl++;
                    ?>
            <tr>
                    <td style="font-size:11px"><?php echo $sl; ?></td>
                    <td style="font-size:11px"><?php echo $row['booking_reference']; ?></td>
                    <td style="font-size:11px">&nbsp;&nbsp;&nbsp;<?php echo $row['origin']; ?></td>
                    <td style="font-size:11px">&nbsp;&nbsp;&nbsp;<?php echo $row['to_location']; ?></td>
                    <td style="font-size:11px">&nbsp;&nbsp;&nbsp;$<?php echo $row['price']; ?></td>
                    <td style="font-size:11px">&nbsp;&nbsp;&nbsp;<?php echo $row['created_at']; ?></td>
                    <td style="font-size:11px">
                        <a class="status completed" href="bookingsdetail.php?ID=<?php echo $row['id']; ?>">View</a>
                        &nbsp;&nbsp;&nbsp;
                        <a class="status pending" href="editbooking.php?ID=<?php echo $row['id']; ?>">Edit</a>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='7' style='font-size:11px'>No bookings found for this agent.</td></tr>";
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