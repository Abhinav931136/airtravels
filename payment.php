<?php
// Database connection
$servername = "sql307.infinityfree.com";
$username = "if0_40439465";
$password = "5lSouEF6Wds";
$dbname = "if0_40439465_dream";

// Disable error reporting for security (enable during development)
error_reporting(0);
ini_set('display_errors', 0);

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: Please try again later.");
}

// Retrieve data from URL parameters and sanitize
$airlineName = urldecode(htmlspecialchars($_GET['airline'] ?? '', ENT_QUOTES));
$price = htmlspecialchars($_GET['price'] ?? '', ENT_QUOTES);
$flight_id = htmlspecialchars($_GET['flight_id'] ?? '', ENT_QUOTES);
$departureTime = urldecode(htmlspecialchars($_GET['departure_time'] ?? '', ENT_QUOTES));
$arrivalTime = urldecode(htmlspecialchars($_GET['arrival_time'] ?? '', ENT_QUOTES));
$from = htmlspecialchars($_GET['from'] ?? '', ENT_QUOTES);
$to = htmlspecialchars($_GET['to'] ?? '', ENT_QUOTES);
$travelClass = urldecode(htmlspecialchars($_GET['travel_class'] ?? '', ENT_QUOTES));
$adults = intval($_GET['adults'] ?? 0);
$children = intval($_GET['children'] ?? 0);
$infants = intval($_GET['infants'] ?? 0);
$return_departure_time = urldecode(htmlspecialchars($_GET['return_departure_time'] ?? '', ENT_QUOTES));
$return_arrival_time = urldecode(htmlspecialchars($_GET['return_arrival_time'] ?? '', ENT_QUOTES));
$return_departure_timezone = urldecode(htmlspecialchars($_GET['return_departure_timezone'] ?? '', ENT_QUOTES));
$return_arrival_timezone = urldecode(htmlspecialchars($_GET['return_arrival_timezone'] ?? '', ENT_QUOTES));

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generate booking reference number
    $bookingReference = generateBookingReference();

    // Retrieve and sanitize form data
    $contact = trim(htmlspecialchars($_POST['contact'] ?? '', ENT_QUOTES));
    $email = trim(htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES));
    $cardNumber = trim(htmlspecialchars($_POST['card-number'] ?? '', ENT_QUOTES));
    $cardHolder = trim(htmlspecialchars($_POST['card-holder'] ?? '', ENT_QUOTES));
    $expiryDate = trim(htmlspecialchars($_POST['expiry-date'] ?? '', ENT_QUOTES));
    $cvv = trim(htmlspecialchars($_POST['cvv'] ?? '', ENT_QUOTES));
    $code = trim(htmlspecialchars($_POST['country-code'] ?? '', ENT_QUOTES));

    // Initialize an array to store passenger details
    $passengerDetails = [];

    // Retrieve adult passenger details
    for ($i = 1; $i <= $adults; $i++) {
        $passengerDetails[] = [
            'type' => 'Adult',
            'name' => htmlspecialchars($_POST['adult_name_' . $i] ?? '', ENT_QUOTES)
        ];
    }

    // Retrieve child passenger details
    for ($i = 1; $i <= $children; $i++) {
        $passengerDetails[] = [
            'type' => 'Child',
            'name' => htmlspecialchars($_POST['child_name_' . $i] ?? '', ENT_QUOTES)
        ];
    }

    // Retrieve infant passenger details
    for ($i = 1; $i <= $infants; $i++) {
        $passengerDetails[] = [
            'type' => 'Infant',
            'name' => htmlspecialchars($_POST['infant_name_' . $i] ?? '', ENT_QUOTES)
        ];
    }

    // Insert booking details into the database
    $sql = "INSERT INTO bookings (booking_reference, contact, airline, email, code, flight_id, price, adults, children, infants, origin, to_location, travel_class, departure_time, arrival_time, return_departure_time, return_arrival_time, card_number, card_holder, expiry_date, cvv) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssssssssssssssssssss", $bookingReference, $contact, $airlineName, $email, $code, $flight_id, $price, $adults, $children, $infants, $from, $to, $travelClass, $departureTime, $arrivalTime, $return_departure_time, $return_arrival_time, $cardNumber, $cardHolder, $expiryDate, $cvv);

        if ($stmt->execute()) {
            // Insert passenger details
            $passengerSql = "INSERT INTO passengers (booking_reference, passenger_type, name) VALUES (?, ?, ?)";
            $passengerStmt = $conn->prepare($passengerSql);

            if ($passengerStmt) {
                foreach ($passengerDetails as $passenger) {
                    $passengerStmt->bind_param("sss", $bookingReference, $passenger['type'], $passenger['name']);
                    if (!$passengerStmt->execute()) {
                        echo "Error saving passenger: " . $passenger['name'];
                    }
                }
                $passengerStmt->close();
            } else {
                echo "Error: Could not prepare passenger insertion statement.";
            }

            // Send confirmation email
            $subject = "Booking Confirmation - Dream Travels";
            $message = "
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            padding: 10px;
            background-color: #4a90e2;
            color: #fff;
        }
        .header h1 {
            margin: 0;
        }
        .content {
            margin: 20px 0;
        }
        .content h2 {
            color: #4a90e2;
        }
        .booking-details, .passenger-details {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        .booking-details th, .booking-details td,
        .passenger-details th, .passenger-details td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .footer {
            text-align: center;
            padding: 10px;
            color: #777;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class='email-container'>
        <div class='header'>
            <h1>Dream Travels</h1>
            <p>Your Journey Begins Here</p>
        </div>
        <div class='content'>
            <h2>Booking Confirmation</h2>
            <p>Dear {$cardHolder},</p>
            <p>Thank you for booking with Dream Travels! Here are your booking details:</p>
            
            <table class='booking-details'>
                <tr><th>Booking Reference</th><td>{$bookingReference}</td></tr>
                <tr><th>Airline</th><td>{$airlineName}</td></tr>
                <tr><th>Flight Route</th><td>{$from} to {$to}</td></tr>
                <tr><th>Departure</th><td>{$departureTime}</td></tr>
                <tr><th>Arrival</th><td>{$arrivalTime}</td></tr>";

if (!empty($return_departure_time)) {
    $message .= "
                <tr><th>Return Departure</th><td>{$return_departure_time} {$return_departure_timezone}</td></tr>
                <tr><th>Return Arrival</th><td>{$return_arrival_time} {$return_arrival_timezone}</td></tr>";
}

$message .= "
                <tr><th>Travel Class</th><td>{$travelClass}</td></tr>
                <tr><th>Total Price</th><td>$$price</td></tr>
            </table>

            <h3>Passenger Details</h3>
            <table class='passenger-details'>
                <tr><th>Type</th><th>Name</th></tr>";

foreach ($passengerDetails as $passenger) {
    $message .= "
                <tr>
                    <td>{$passenger['type']}</td>
                    <td>{$passenger['name']}</td>
                </tr>";
}

$message .= "
            </table>

            <p>We are looking forward to providing you with an exceptional travel experience. For any assistance, feel free to reach out to our support team at <a href='mailto:support@dreamtravels.com'>support@dreamtravels.com</a>.</p>
            <p>Safe travels!</p>
        </div>
        <div class='footer'>
            &copy; Dream Travels, All rights reserved.<br>
        </div>
    </div>
</body>
</html>";

$headers = "From: Dream Travels <support@dreamtravels.com>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            if (mail($email, $subject, $message, $headers)) {
                echo "Confirmation email sent.";
            } else {
                echo "Error sending confirmation email.";
            }

            // Redirect to success page with booking reference
            header("Location: booking_successful.php?reference=$bookingReference");
            exit;
        } else {
            echo "Error: Could not complete your booking. Please try again.";
        }
        $stmt->close();
    } else {
        echo "Error: Unable to prepare booking insertion statement.";
    }
}

$conn->close();

// Function to generate booking reference
function generateBookingReference($length = 12) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flaticon/1.0.0/flaticon.css">
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
    color: black;
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

.dot-loader {
    display: flex;
    gap: 8px;
}

.dot {
    width: 15px;
    height: 15px;
    background-color: #777777;
    border-radius: 50%;
    animation: dot-flash 1.5s infinite;
}

.dot:nth-child(1) {
    animation-delay: 0s;
}

.dot:nth-child(2) {
    animation-delay: 0.3s;
}

.dot:nth-child(3) {
    animation-delay: 0.6s;
}

@keyframes dot-flash {
    0%, 80%, 100% {
        opacity: 0.3;
        transform: scale(0.8);
    }
    40% {
        opacity: 1;
        transform: scale(1.2);
    }
}

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f4f8; /* Light background for a soft look */
            margin: 0;
            padding: 0;
        }

        .header {
    background-color: white; /* Changed to white background */
    color: black; /* Black text */
    padding: 20px;
    text-align: center;
    display:flex;
    align-items: center;
    justify-content:space-between;
    border-bottom: 4px solid #0056b3;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}


        .header img {
            max-width: 250px; /* Adjust the logo size as necessary */
            margin-bottom: 10px;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            padding: 20px;
            box-sizing: border-box;
            transition: transform 0.2s; /* Slight lift effect */
        }

        .container:hover {
            transform: translateY(-5px); /* Lift effect on hover */
        }

        h2 {
            text-align: center;
            margin: 20px 0;
            color: #333;
            border-bottom: 2px solid #007bff; /* Match header color */
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }
        label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  color: #0b0a0a;
  font-size: 18px;
}

input[type="text"],
input[type="date"],
select {
  width: 100%;
  padding: 12px;
  border: 2px solid #26e8b1;
  border-radius: 4px;
  box-sizing: border-box;
  font-size: 16px;
}

input:focus {
  color: black;
  background-color: white;
  outline-color: rgb(0, 255, 255);
  box-shadow: 0 0 10px rgb(0, 255, 255);
}
        label {
            font-weight: 500;
            color: #555;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 5px 0 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border 0.3s, box-shadow 0.3s;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border: 1px solid #007bff; /* Border color on focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Placeholder hover effect */
        input[type="text"]::placeholder,
        input[type="email"]::placeholder {
            color: #bbb; /* Default placeholder color */
            transition: color 0.3s; /* Transition effect */
        }

        input[type="text"]:hover::placeholder,
        input[type="email"]:hover::placeholder {
            color: #007bff; /* Change placeholder color on hover */
        }
        .button {
            background-color: #28a745; /* Green button */
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Shadow effect */
        }

        .button:hover {
            background-color: #218838; /* Darker green on hover */
            transform: translateY(-2px); /* Lift effect on hover */
            box-shadow: 0 0 10px rgba(40, 167, 69, 0.7); /* Glowing effect */
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }

        .booking-details {
            padding: 20px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                padding: 10px;
            }
            .header {
                font-size: 16px;
            }
            h2 {
                font-size: 20px;
            }
            .button {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
    <script>
        function validateForm() {
            // Validate card number (16 digits)
            const cardNumber = document.getElementById('card-number').value;
            if (!/^\d{16}$/.test(cardNumber)) {
                alert('Card number must be exactly 16 digits.');
                return false;
            }

            // Validate contact number with country code
            const contact = document.getElementById('contact').value;
            if (!/^\d{10,15}$/.test(contact)) {
                alert('Contact number must be 10-15 digits long.');
                return false;
            }

            // Validate expiry date (MM/YY)
            const expiryDate = document.getElementById('expiry-date').value;
            if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiryDate)) {
                alert('Expiry date must be in the format MM/YY.');
                return false;
            } else {
                const currentYear = new Date().getFullYear() % 100;  // Get last two digits of the current year
                const currentMonth = new Date().getMonth() + 1;      // Months are 0-indexed in JavaScript
                const [expMonth, expYear] = expiryDate.split('/').map(Number);

                if (expYear < currentYear || (expYear === currentYear && expMonth < currentMonth)) {
                    alert('Expiry date must be in the future.');
                    return false;
                }
            }

            // Validate CVV (3 digits)
            const cvv = document.getElementById('cvv').value;
            if (!/^\d{3}$/.test(cvv)) {
                alert('CVV must be exactly 3 digits.');
                return false;
            }

            return true;
        }
    </script>
    <script>
    // Display loader for 3 seconds, then show the content
    window.onload = function() {
        setTimeout(function() {
            document.getElementById('loader').style.display = 'none';
            document.body.style.overflow = 'visible'; // Enable scroll when the loader is hidden
        }, 3000); // 3 seconds
    };
</script>

<body style="overflow: hidden;"> <!-- Prevent scrolling during loader display -->
    <!-- Loader -->
    <div id="loader">
        <div class="dot-loader">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
        <h2>Please wait, we are processing your request...</h2>
    </div>
</body>


<div class="header">
    <a href="index.html"><img src="img/LOGO.webp" alt="Dream Logo" style="height: 60px; width: 220px"></a> <!-- Add logo -->
    <div class="brand">
        <h1 style="display: inline;"><span style="color:rgb(21, 166, 244);" >Sky</span><span style="color:black;">zen</span> Payment Gateway
    </h1>
    </div>
</div>


<div class="container">
    <div class="booking-details">
        <h2>Flight Booking Details</h2>
        <p><strong>Airline:</strong> <?= htmlspecialchars($airlineName) ?></p>
        <p><strong>From:</strong> <?= htmlspecialchars($from) ?></p>
        <p><strong>To:</strong> <?= htmlspecialchars($to) ?></p>
        <p><strong>Departure:</strong> <?= htmlspecialchars($departureTime) ?></p>
        <p><strong>Arrival:</strong> <?= htmlspecialchars($arrivalTime) ?></p>
<!-- Display Return Flight Details if available -->
    <?php if (!empty($return_departure_time)): ?>
        <h1 style="font-size:1rem">Return Flight Details:</h1>
        <p><strong>Return Departure:</strong> <?= htmlspecialchars($return_departure_time) ?> <?= htmlspecialchars($return_departure_timezone) ?></p>
        <p><strong>Return Arrival:</strong> <?= htmlspecialchars($return_arrival_time) ?> <?= htmlspecialchars($return_arrival_timezone) ?></p>
    <?php endif; ?>
        <p><strong>Travel Class:</strong> <?= htmlspecialchars($travelClass) ?></p>
        <p><strong>Price:</strong> $<?= htmlspecialchars($price) ?></p>
        <p><strong>Adults:</strong> <?= htmlspecialchars($adults) ?></p>
        <p><strong>Children:</strong> <?= htmlspecialchars($children) ?></p>
        <p><strong>Infants:</strong> <?= htmlspecialchars($infants) ?></p>
    </div>

    <form method="POST" action="" onsubmit="return validateForm();">
    <h2>Passenger & Payment Information</h2>
    <!-- Dynamically generate name fields based on the number of adults, children, and infants -->
    <div class="form-group">
        <?php
        // Dynamically create name input fields for adults
        for ($i = 1; $i <= $adults; $i++) {
            echo '
            <div class="passenger">
                <label for="adult_name_'.$i.'">Adult Passenger '.$i.':</label>
                <div class="input-icon">
                    <i class="flaticon-user"></i>
                    <input type="text" id="adult_name_'.$i.'" name="adult_name_'.$i.'" required>
                </div>
            </div>';
        }

        // Dynamically create name input fields for children
        for ($i = 1; $i <= $children; $i++) {
            echo '
            <div class="passenger">
                <label for="child_name_'.$i.'">Child Passenger '.$i.':</label>
                <div class="input-icon">
                    <i class="flaticon-user"></i>
                    <input type="text" id="child_name_'.$i.'" name="child_name_'.$i.'" required>
                </div>
            </div>';
        }

        // Dynamically create name input fields for infants
        for ($i = 1; $i <= $infants; $i++) {
            echo '
            <div class="passenger">
                <label for="infant_name_'.$i.'">Infant Passenger '.$i.':</label>
                <div class="input-icon">
                    <i class="flaticon-user"></i>
                    <input type="text" id="infant_name_'.$i.'" name="infant_name_'.$i.'" required>
                </div>
            </div>';
        }
        ?>
    </div>

    <div class="form-group">
    <label for="contact">Contact Number (With Country Code):</label>
    <div class="input-icon">
        <i class="flaticon-phone"></i>
        <div class="input-group">
            <select id="country-code" name="country-code" class="form-control">
                <!-- Option values will be populated dynamically -->
            </select>
            <input type="text" id="contact" name="contact" class="form-control" placeholder="Enter your number" required>
        </div>
    </div>
</div>

    <div class="form-group">
        <label for="email">Email Address:</label>
        <div class="input-icon">
            <i class="flaticon-email"></i>
            <input type="email" id="email" name="email" required>
        </div>
    </div>
   <div class="form-group">
    <label for="card-number">Card Number:</label>
    <div class="input-icon">
        <i class="flaticon-credit-card"></i>
        <input type="text" id="card-number" name="card-number" maxlength="16" required>
    </div>
</div>

    <div class="form-group">
        <label for="card-holder">Card Holder Name:</label>
        <div class="input-icon">
            <i class="flaticon-user"></i>
            <input type="text" id="card-holder" name="card-holder" required>
        </div>
    </div>
    <div class="form-group">
        <label for="expiry-date">Expiry Date (MM/YY):</label>
        <div class="input-icon">
            <i class="flaticon-calendar"></i>
            <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY" required>
        </div>
    </div>
    <div class="form-group">
        <label for="cvv">CVV:</label>
        <div class="input-icon">
            <i class="flaticon-lock"></i>
            <input type="text" id="cvv" name="cvv" maxlength="4" required>
        </div>
    </div>
    <button type="submit" class="button">Complete Payment</button>
</form>
<div class="container">
    <!-- Existing content (booking details and form) -->
    
    <!-- Visa card image section at the bottom -->
    <div class="payment-methods" style="text-align: center; margin-top: 30px; padding: 20px; background-color: #f0f4f8; border-radius: 10px;">
        <p style="font-size: 18px; color: #333; margin-bottom: 10px;">We accept the following payment methods:</p>
        <img src="img/mastercard.webp" alt="MasterCard" style="height: 50px; margin: 0 15px;">
        <img src="img/amex.webp" alt="American Express" style="height: 50px; margin: 0 15px;">
    </div>

<div class="footer">
    &copy; 2025 Dream Travels. All Rights Reserved.
</div>
<script>
    const countryCodes = [
        { code: '+1', country: 'United States' },
        { code: '+44', country: 'United Kingdom' },
        { code: '+91', country: 'India' },
        { code: '+61', country: 'Australia' },
        { code: '+81', country: 'Japan' },
        { code: '+49', country: 'Germany' },
        { code: '+33', country: 'France' },
        { code: '+39', country: 'Italy' },
        { code: '+86', country: 'China' },
        { code: '+7', country: 'Russia' },
        { code: '+55', country: 'Brazil' },
        { code: '+27', country: 'South Africa' },
        { code: '+34', country: 'Spain' },
        { code: '+52', country: 'Mexico' },
        { code: '+20', country: 'Egypt' },
        { code: '+966', country: 'Saudi Arabia' },
        { code: '+971', country: 'United Arab Emirates' },
        { code: '+94', country: 'Sri Lanka' },
        { code: '+63', country: 'Philippines' },
        { code: '+62', country: 'Indonesia' },
        { code: '+64', country: 'New Zealand' },
        { code: '+98', country: 'Iran' },
        { code: '+92', country: 'Pakistan' },
        { code: '+234', country: 'Nigeria' },
        { code: '+880', country: 'Bangladesh' },
        { code: '+90', country: 'Turkey' },
        { code: '+82', country: 'South Korea' },
        { code: '+354', country: 'Iceland' },
        { code: '+46', country: 'Sweden' },
        { code: '+358', country: 'Finland' },
        { code: '+31', country: 'Netherlands' },
        { code: '+48', country: 'Poland' },
        { code: '+372', country: 'Estonia' },
        { code: '+47', country: 'Norway' },
        { code: '+30', country: 'Greece' },
        { code: '+351', country: 'Portugal' },
        { code: '+45', country: 'Denmark' },
        { code: '+36', country: 'Hungary' },
        { code: '+420', country: 'Czech Republic' },
        { code: '+372', country: 'Estonia' },
        { code: '+32', country: 'Belgium' }
    ];

    const countryCodeSelect = document.getElementById('country-code');

    // Populate the country code dropdown
    countryCodes.forEach(function (item) {
        const option = document.createElement('option');
        option.value = item.code;
        option.textContent = `${item.country} (${item.code})`;
        countryCodeSelect.appendChild(option);
    });
</script>
</body>
</html>
