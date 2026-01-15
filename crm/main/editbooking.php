<?php
session_start();

// Verify if the user is logged in, redirect if not
if (!isset($_SESSION['user_id'])) {
    header("Location: https://dreamtravels.great-site.net/crm/login.php"); // Redirect to login page if session is not set
    exit();
}

$servername = "sql307.infinityfree.com";
$username = "if0_40439465";
$password = "5lSouEF6Wds";
$dbname = "if0_40439465_dream";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['ID'])) {
    $booking_id = $_GET['ID'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_status = $_POST['status'];
        $new_price = $_POST['price'];

        // Update the booking details
        $update_sql = "UPDATE bookings SET status = ?, price = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sdi", $new_status, $new_price, $booking_id);

        if ($stmt->execute()) {
            echo "Booking updated successfully.";

            // Fetch the customer's email and booking details
            $email_stmt = $conn->prepare("SELECT email, booking_reference FROM bookings WHERE id = ?");
            $email_stmt->bind_param("i", $booking_id);
            $email_stmt->execute();
            $email_result = $email_stmt->get_result();
            $email_row = $email_result->fetch_assoc();
            $customer_email = $email_row['email'];
            $booking_reference = $email_row['booking_reference'];

            // Fetch the first adult passenger's name for this booking
            $passenger_stmt = $conn->prepare("SELECT name FROM passengers WHERE booking_reference = ? AND passenger_type = 'Adult' ORDER BY id ASC LIMIT 1");
            $passenger_stmt->bind_param("s", $booking_reference);
            $passenger_stmt->execute();
            $passenger_result = $passenger_stmt->get_result();
            $passenger_name = $passenger_result->fetch_assoc()['name'] ?? 'Valued Customer';

            // Prepare a professional email based on the booking status
            $subject = "Booking Update: Status - $new_status (Ref: $booking_reference)";
            $message = "<html>
                        <head>
                            <style>
                                body { font-family: Arial, sans-serif; line-height: 1.6; }
                                .container { max-width: 600px; margin: auto; background: #ffffff; padding: 20px; border-radius: 8px; }
                                .header { text-align: center; background-color: #004a87; color: #ffffff; padding: 10px; }
                                .footer { text-align: center; font-size: 12px; color: #666; margin-top: 20px; }
                            </style>
                        </head>
                        <body>
                            <div class='container'>
                                <div class='header'>
                                    <h2>Dream Travels</h2>
                                </div>
                                <p>Dear $passenger_name,</p>
                                <p>We hope this message finds you well. We are writing to inform you that the status of your booking (Reference: <strong>$booking_reference</strong>) has been updated to: <strong>$new_status</strong>.</p>";

            switch ($new_status) {
                case 'Pending':
                    $message .= "<p>Your booking is currently pending. We are processing your request and will update you once further information is available.</p>";
                    break;

                case 'Cancelled':
                    $message .= "<p>We regret to inform you that your booking has been cancelled. If you have any questions or need assistance, please contact our customer support team.</p>";
                    break;

                case 'Confirmed':
                    $message .= "<p>We are pleased to confirm your booking. One of our team members will be in touch with you shortly to assist with any remaining details and ensure a smooth experience.</p>";
                    break;

                case 'CVV Pending':
                    $message .= "<p>Your booking is pending because some documents are awaiting verification. Kindly submit the required documents as soon as possible to complete your booking.</p>";
                    break;

                case 'TKT':
                    $message .= "<p>Your booking is confirmed, and we will share your tickets shortly. We appreciate your patience and thank you for choosing Dream Travels.</p>";
                    break;

                default:
                    $message .= "<p>Please contact our customer support for further information regarding your booking.</p>";
                    break;
            }

            $message .= "<p>Thank you for choosing Dream Travels. We look forward to serving you on your upcoming journey.</p>
                         <p>Best Regards,<br>Dream Travels Team</p>
                         <div class='footer'>
                             <p>&copy; " . date('Y') . " Dream Travels. All rights reserved.</p>
                         </div>
                         </div>
                         </body>
                         </html>";

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: Dream Travels <support@dreamtravels.com>" . "\r\n";

            if (mail($customer_email, $subject, $message, $headers)) {
                echo "Email sent successfully to $customer_email.";
            } else {
                echo "Failed to send email to $customer_email.";
            }

            $email_stmt->close();
            $passenger_stmt->close();
        } else {
            echo "Error updating record: " . $conn->error;
        }
        $stmt->close();
    }

    $sql = "SELECT * FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking | Dream Travels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.2/css/boxicons.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('https://png.pngtree.com/thumb_back/fh260/background/20230805/pngtree-the-flight-path-on-both-sides-of-the-runway-image_12972429.jpg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        #pageLoader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 74, 135, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            color: #ffffff;
        }
        .airline-loader {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        .plane-icon {
            font-size: 60px;
            animation: fly 1.5s linear infinite;
        }
        @keyframes fly {
            0% { transform: translateX(-50px); }
            50% { transform: translateX(0px); }
            100% { transform: translateX(50px); }
        }
        .loader-text {
            font-size: 1.5rem;
            font-weight: 600;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 60px;
            max-width: 900px;
        }
        .card-header {
            background-color: #004a87;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }
        .btn-primary {
            background-color: #004a87;
            border-color: #004a87;
        }
        .btn-primary:hover {
            background-color: #003366;
            border-color: #003366;
        }
        .form-label {
            font-size: 1.1rem;
        }
        .alert {
            border-radius: 8px;
            margin-top: 15px;
        }
        .footer {
            background-color: #004a87;
            color: #ffffff;
            text-align: center;
            padding: 15px 0;
            margin-top: 30px;
        }
    </style>
    <script>
        window.onload = function() {
            document.getElementById('pageLoader').style.display = 'none';
        };
        document.addEventListener('DOMContentLoaded', function () {
            const loader = document.getElementById('loader');
            loader.style.display = 'none';

            document.querySelector('form').addEventListener('submit', function () {
                loader.style.display = 'flex';
            });
        });
    </script>
</head>
<body>
    <div id="pageLoader">
        <div class="airline-loader">
            <i class='bx bx-paper-plane plane-icon'></i>
            <div class="loader-text">Preparing Your Journey...</div>
        </div>
    </div>
    
    <!-- Loader -->
    <div id="loader">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Edit Booking Details</h4>
            </div>
            <div class="card-body">
                <a href="https://dreamtravels.great-site.net/crm/main/bookings.php" class="btn btn-secondary mb-3">Back to Bookings</a>
                <?php if ($booking): ?>
                    <div class="mb-3">
                        <p><strong>Booking Reference:</strong> <?php echo $booking['booking_reference']; ?></p>
                        <p><strong>From:</strong> <?php echo $booking['origin']; ?></p>
                        <p><strong>To:</strong> <?php echo $booking['to_location']; ?></p>
                        <p><strong>Price:</strong> $<?php echo $booking['price']; ?></p>
                        <p><strong>Booked On:</strong> <?php echo date("F j, Y", strtotime($booking['created_at'])); ?></p>
                        <p><strong>Email:</strong> <?php echo $booking['email']; ?></p>
                    </div>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status:</label>
                            <select class="form-select" name="status" id="status">
                                <option value="Pending" <?php if ($booking['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Confirmed" <?php if ($booking['status'] == 'Confirmed') echo 'selected'; ?>>Confirmed</option>
                                <option value="Cancelled" <?php if ($booking['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                <option value="CVV Pending" <?php if ($booking['status'] == 'CVV Pending') echo 'selected'; ?>>CVV Pending</option>
                                <option value="TKT" <?php if ($booking['status'] == 'TKT') echo 'selected'; ?>>TKT</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price:</label>
                            <input type="number" step="0.01" class="form-control" name="price" id="price" value="<?php echo $booking['price']; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Booking</button>
                    </form>
                <?php else: ?>
                    <p class="alert alert-danger">Booking not found. Please check the booking ID.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> Dream Travels. All rights reserved.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php $conn->close(); ?>
