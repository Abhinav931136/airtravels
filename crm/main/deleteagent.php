<?php
// Database connection details
$servername = "sql307.infinityfree.com";
$username = "if0_40439465";
$password = "5lSouEF6Wds";
$dbname = "if0_40439465_dream";  

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided in the URL
if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

    $sql = "DELETE FROM users WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Agent deleted successfully!</div>";
    } else {

        echo "<div class='alert alert-danger'>Error deleting agent: " . $conn->error . "</div>";
    }

    header("Location: agents.php"); 
    exit();
} else {
    echo "<div class='alert alert-danger'>No agent ID specified.</div>";
}

// Close the database connection
$conn->close();
?>
