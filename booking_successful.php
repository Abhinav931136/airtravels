<?php
// booking_successful.php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "sql307.infinityfree.com";
$username = "if0_40439465";
$password = "5lSouEF6Wds";
$dbname = "if0_40439465_dream";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve booking reference from the URL
$bookingReference = $_GET['reference'] ?? null;

// Fetch booking details from the database
$bookingDetails = null;
if ($bookingReference) {
    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE booking_reference = ?");
    $stmt->bind_param("s", $bookingReference);
    
    // Execute the statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $bookingDetails = $result->fetch_assoc();
    } else {
        echo "Error executing query: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "No booking reference provided.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Successful!</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link href="img/LOGOF.webp" rel="icon">
    <style>
        /* Loader styles */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        #loader h2 {
            font-size: 24px;
            color: #007bff;
            margin-top: 20px;
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .spinner {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #007bff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fc; /* Light gray background */
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: white; /* White background for navbar */
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            display: flex;
            align-items: center;
        }
        .navbar img {
            height: 60px; /* Adjust logo size */
            margin-right: 20px; /* Space between logo and title */
        }
        .navbar h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: black; /* Black color for 'Zen' */
        }
        .navbar h1 span {
            color: skyblue; /* Skyblue color for 'Sky' */
        }
        .header {
            background-color: #007BFF; /* Calming blue */
            color: white;
            padding: 30px;
            text-align: center;
            border-bottom: 5px solid #0056b3; /* Deeper blue for contrast */
        }
        h2 {
            text-align: center;
            color: #333; /* Dark gray for text */
            font-size: 24px;
            margin-bottom: 20px;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: white; /* White background for contrast */
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            padding: 30px;
            transition: transform 0.2s;
        }
        .container:hover {
            transform: translateY(-5px);
        }
        .booking-info {
            margin: 20px 0;
            padding: 20px;
            background: #e2f7e2; /* Soft green background for booking info */
            border: 1px solid #b3e0b3; /* Light green border */
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .booking-info p {
            margin: 5px 0;
            font-size: 16px;
            color: #333; /* Dark gray text */
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #777; /* Soft gray for footer text */
        }
    </style>
    <script>
        // Display loader for 5 seconds, then show the content
        window.onload = function() {
            setTimeout(function() {
                document.getElementById('loader').style.display = 'none';
                document.body.style.overflow = 'visible'; // Enable scroll when the loader is hidden
            }, 5000); // 5 seconds
        };
    </script>
</head>
<body style="overflow: hidden;"> <!-- Prevent scrolling during loader display -->

<!-- Loader -->
<div id="loader">
    <div class="spinner"></div>
    <h2>Please wait while, we process your order....</h2>
</div>

<div class="navbar">&nbsp;&nbsp;&nbsp;&nbsp;
    <img src="../img/LOGO.webp" alt="Skyzen Logo" style="height: 60px; width: 220px"> <!-- Logo -->
</div>

<div class="container">
    <h2>Booking Successful!</h2>
    <?php if ($bookingDetails): ?>
        <div class="booking-info">
            <p><strong>Booking Reference:</strong> <?= htmlspecialchars($bookingDetails['booking_reference']) ?></p>
            <p><strong>Airline:</strong> <?= htmlspecialchars($bookingDetails['airline']) ?></p>
            <p><strong>From:</strong> <?= htmlspecialchars($bookingDetails['origin']) ?></p>
            <p><strong>To:</strong> <?= htmlspecialchars($bookingDetails['to_location']) ?></p>
            <p><strong>Departure:</strong> <?= htmlspecialchars($bookingDetails['departure_time']) ?></p>
            <p><strong>Arrival:</strong> <?= htmlspecialchars($bookingDetails['arrival_time']) ?></p>
            <p><strong>Return Departure:</strong> <?= htmlspecialchars($bookingDetails['return_departure_time']) ?></p>
            <p><strong>Return Arrival:</strong> <?= htmlspecialchars($bookingDetails['return_arrival_time']) ?></p>
            <p><strong>Travel Class:</strong> <?= htmlspecialchars($bookingDetails['travel_class']) ?></p>
            <p><strong>Adults:</strong> <?= htmlspecialchars($bookingDetails['adults']) ?></p>
            <p><strong>Children:</strong> <?= htmlspecialchars($bookingDetails['children']) ?></p>
            <p><strong>Infants:</strong> <?= htmlspecialchars($bookingDetails['infants']) ?></p>
            <p><strong>Total Price:</strong> $<?= htmlspecialchars($bookingDetails['price']) ?></p>
        </div>
        
        <p>Your Booking Details has been shared in your registered email address. Kindly check spam folder if the mail hasn't arrived.</p>
    <?php else: ?>
        <p>Booking details not found. Please contact support.</p>
    <?php endif; ?>
</div>

<div class="footer">
    <p>&copy; <?= date("Y"); ?> Dream Travels. All Rights Reserved.</p>
</div>

</body>
</html>
