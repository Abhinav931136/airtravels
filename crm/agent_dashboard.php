<?php
session_start();
if ($_SESSION['role'] != 'agent') {
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
    <title>Agent Dashboard</title>
    <link rel="stylesheet" href="style.css">
     <!-- Favicons -->
  <link href="../img/logo.jpg" rel="icon">
  <link href="../img/logo.jpg" rel="apple-touch-icon">
  <style>
            /* Search Form styles */
        .search-form-container {
            display: flex;
            justify-content: center; /* Center the form container */
            margin-bottom: 20px;
        }

        .search-form {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            padding: 20px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
            transition: box-shadow 0.3s ease;
            width: 80%; /* Set a fixed width for the form */
            max-width: 600px; /* Max width for larger screens */
        }

        .search-form:hover {
            box-shadow: 0 0 20px rgba(0, 123, 255, 1); /* Glowing effect on hover */
        }

        .search-form input[type="text"],
        .search-form input[type="date"],
        .search-form select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .search-form input:focus,
        .search-form select:focus {
            border-color: #007BFF;
            outline: none;
        }

        .search-form button {
            padding: 10px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.2s;
            grid-column: span 3; /* Full width */
        }

        .search-form button:hover {
            background-color: #0056b3;
            transform: scale(1.05); /* Slightly enlarge button on hover */
        }
  </style>
</head>
<body>

    <div class="navbar">
        <span>Welcome, <?php echo $_SESSION['user_name'];?></span>
        <div>
            <a href="manage_flights.php">Manage Flights</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <!-- Search Form -->
        <div class="search-form-container">
            <form action="bookings.php" method="GET" class="search-form">
                <input type="text" name="pnr" placeholder="Booking Ref" required>
                <button type="submit" name="search">Search</button>
            </form>
        </div>

    <div class="container">
        <h2>Bookings Overview</h2>
        <div class="booking-list">
            <table>
                <tr>
                    <th>PNR</th>
                    <th>Customer</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($bookings)) { ?>
                <tr>
                    <td><?php echo $row['booking_reference']; ?></td>
                    <td><?php echo $row['name']; ?></td>
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
