<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="logo192.png"/><meta name="viewport" content="width=device-width,initial-scale=1"/><meta name="theme-color" content="#000000"/><meta name="description" content="Tours & Travels"/><link rel="apple-touch-icon" href="logo192.png"/>
<title>
Agent Details - Dream CRM
</title>
   <!-- Favicons -->
  <link href="../img/LOGOF.png" rel="icon">
  <link href="../img/LOGOF.png" rel="apple-touch-icon">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
			&nbsp; &nbsp;<span class="text"><span style="color:skyblue">Dream</span><span style="color:black"> Travels</span>
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
				<a href="https://dreamtravels.com/crm/" class="logout">
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
							<a class="active" href="agents.php">Agents</a>
						</li>
					</ul>
                    <hr>
                    <h3> Add Agent</h3>
				</div>
			</div>
<form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3" enctype="multipart/form-data">
      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-7">
                <input type="text" name="name" placeholder="Enter agent name" required>
                
            </div>
</br>
            <label for="input2" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-7">
                <input type="email" name="email" placeholder="Enter agent email" required>
                
            </div>
</br>
            <label for="input3" class="col-sm-3 control-label">Contact</label>
            <div class="col-sm-7">
                <input type="tel" name="contact" placeholder="Enter contact no." required>
                
            </div>
</br>
            <label for="input4" class="col-sm-3 control-label">Date of Birth (DOB)</label>
            <div class="col-sm-7">
                <input type="date" name="dob" placeholder="Enter DOB" required>
                
            </div><br>
            <label for="input5" class="col-sm-3 control-label"> Username </label>
            <div class="col-sm-7">
                <input type="text" name="usa_name" placeholder="Enter USA Name" required>
                
            </div><br>
            <label for="input6" class="col-sm-3 control-label">Blood Group</label>
            <div class="col-sm-7">
                <input type="text" name="blood" placeholder="E.g.: O+" required>
                
            </div><br>
            <label for="input8" class="col-sm-3 control-label">Address</label>
            <div class="col-sm-7">
                <textarea name="address" placeholder="Enter address" rows="3" required></textarea>
                
            </div><br>
            <label for="input9" class="col-sm-6 control-label">Create Password</label>
            <div class="col-sm-7">
                <input type="password" name="password" placeholder="Enter password" required>
                
            </div><br>
            <label for="input10" class="col-sm-3 control-label">Profile Picture</label>
<div class="col-sm-7">
    <input type="file" name="profile_picture" accept="image/*" required>
</div>
<br>


      </div>
 
  </br>
      <input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Submit" name="submit" />
     
   </form>
   <hr>
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Agents List</h3>
					</div>					<table>
						<thead>
							<tr>
								<th style="font-size:12px">S. No.</th>
                                <th style="font-size:12px">&nbsp;&nbsp;&nbsp;Agent Id</th>
								<th style="font-size:12px">&nbsp;&nbsp;&nbsp;Name</th>
								<th style="font-size:12px">&nbsp;&nbsp;&nbsp;Email</th>
								<th style="font-size:12px">&nbsp;&nbsp;&nbsp;Profile</th>
                                <th style="font-size:12px">Actions</th>
							</tr>
						</thead>
                        <?php
			
				$servername = "sql307.infinityfree.com";
$username = "if0_40439465";
$password = "5lSouEF6Wds";
$dbname = "if0_40439465_dream";   
                $conn = new mysqli($servername, $username, $password, $dbname);
                $sl=0;

               if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $dob = $_POST['dob'];
    $usa_name = $_POST['usa_name'];
    $password = $_POST['password'];
    $blood = $_POST['blood'];
    $address = $_POST['address'];
    $role = "agent";

    // Profile picture upload
    $targetDir = "uploads/";
    $profilePictureName = basename($_FILES["profile_picture"]["name"]);
    $targetFilePath = $targetDir . $profilePictureName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow only image files
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath)) {
            // Generate unique User ID
            $prefix = "24SKYZN";
            $sql = "SELECT id FROM users WHERE role = 'agent' ORDER BY id DESC LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastId = (int)substr($row['id'], -4);
                $newId = str_pad($lastId + 1, 4, "0", STR_PAD_LEFT);
            } else {
                $newId = "0001";
            }
            $userId = $prefix . $newId;

            // Insert data into the database
            $sql = "INSERT INTO users (user_id, name, blood, address, email, dob, usa_name, contact, password, role, profile_picture) 
                    VALUES ('$userId', '$name', '$blood', '$address', '$email', '$dob', '$usa_name', '$contact', '$password', '$role', '$targetFilePath')";
            
            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>Agent added successfully! User ID: $userId</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Failed to upload profile picture.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Only JPG, JPEG, PNG, & GIF files are allowed.</div>";
    }
}

                
				$sql="SELECT * FROM users where role = 'agent'";
                  
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()){
                    $sl++;
				
			?>
						<tbody>
							<tr>
								<td style="font-size:11px">
									<?php echo $sl; ?>
								</td>
                                <td style="font-size:11px"><?php echo $row['user_id']; ?></td>
								<td style="font-size:11px"><?php echo $row['name']; ?></td>
                                <td style="font-size:11px">&nbsp;&nbsp;&nbsp;<?php echo $row['email']; ?></td>
                                <td style="font-size:11px">
    <img src="<?php echo $row['profile_picture']; ?>" width="50" height="50" alt="Profile Picture">
</td>

                                <td style="font-size:11px">&nbsp;&nbsp;&nbsp;<a class="status completed" href="viewagent.php?ID=<?php echo $row['id']; ?>">View </a>
			                       &nbsp;&nbsp;&nbsp; <a class="status process" href="editagent.php?ID=<?php echo $row['id']; ?>">Edit</a>
                                   &nbsp;&nbsp;&nbsp; <a class="status pending" href="deleteagent.php?ID=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this agent?');">Delete</a></td>
                            	</tr>
							
						</tbody>
                           <?php

              }
?>
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