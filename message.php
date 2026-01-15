<?php
$servername = "sql307.infinityfree.com";
$username = "if0_40439465";
$password = "5lSouEF6Wds";
$dbname = "if0_40439465_dream";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO messages (name, email, subject, message, created_at) VALUES ('$name', '$email', '$subject', '$message', NOW())";


    if ($conn->query($sql) === TRUE) {
    echo "
    <div style='
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 50px;
        margin: 20px auto;
        max-width: 600px;
        border-radius: 10px;
        background-color: #f1f1f1;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        font-family: Arial, sans-serif;
    '>
        <i class='fas fa-check-circle' style='
            font-size: 50px;
            color: #004a87;
            margin-bottom: 20px;
        '></i>
        <h2 style='
            color: #004a87;
            font-size: 24px;
            margin-bottom: 10px;
        '>Thanks for Contacting Us!</h2>
        <p style='
            color: #333;
            font-size: 18px;
        '>Your message has been successfully received. Our team will get back to you as soon as possible.</p>
    </div>
    ";
} else {
    echo "
    <div style='
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 50px;
        margin: 20px auto;
        max-width: 600px;
        border-radius: 10px;
        background-color: #f8d7da;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        font-family: Arial, sans-serif;
    '>
        <i class='fas fa-exclamation-triangle' style='
            font-size: 50px;
            color: #d9534f;
            margin-bottom: 20px;
        '></i>
        <h2 style='
            color: #d9534f;
            font-size: 24px;
            margin-bottom: 10px;
        '>Submission Failed</h2>
        <p style='
            color: #333;
            font-size: 18px;
        '>We encountered an error while saving your message. Please try again later.</p>
    </div>
    ";
}
}

$conn->close();
?>
