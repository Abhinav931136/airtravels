<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

include 'db_connection.php';

$query = "SELECT * FROM bookings";
$bookings = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
     <!-- Favicons -->
  <link href="../img/LOGOF.png" rel="icon">
  <link href="../img/LOGOF.png" rel="apple-touch-icon">
</head>
<body>

    <div class="navbar">
        <span>Welcome, <?php echo $_SESSION['user_name'];?></span>
        <div>
            <a href="manage_flights.php">Manage Flights</a>
            <a href="manage_agents.php">Manage Agents</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <h2>Bookings Overview</h2>
        <div class="booking-list">
            <table>
                <tr>
                    <th>PNR</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($bookings)) { ?>
                <tr>
                    <td><?php echo $row['booking_reference']; ?></td>
                    <td><?php echo $row['origin']; ?></td>
                    <td><?php echo $row['to_location']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td><a href="edit_booking.php?id=<?php echo $row['id']; ?>">Edit</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

</body>
</html>
