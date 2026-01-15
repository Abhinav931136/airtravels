<?php
session_start();
include 'db_connection.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Plain-text password

    // Query to check if the email and plain-text password match
    $query = "SELECT * FROM users WHERE email='$email' or user_id='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Fetch user data
        $user = mysqli_fetch_assoc($result);

        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on user role (admin or agent)
        if ($user['role'] == 'admin') {
            header("Location: main/index.php");
        } else {
            header("Location: main/index1.php");
        }
    } else {
        // Invalid email or password
        echo "<div class='error-msg'>Invalid email or password!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CRM System</title>
      <!-- Favicons -->
  <link href="../img/LOGOF.png" rel="icon">
  <link href="../img/LOGOF.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap" rel="stylesheet">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style1.css">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8299232384245649"
     crossorigin="anonymous"></script>
</head>
<body>

<?php
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
	foreach($_SESSION['ERRMSG_ARR'] as $msg) {
		echo '<div style="color: red; text-align: center;">',$msg,'</div><br>'; 
	}
	unset($_SESSION['ERRMSG_ARR']);
}
?>
<section class="form-section">
    <div class="form-wrapper">
      <form action="" method="post" style="margin: 20px 0;
  background-color: white;
  padding: 50px 100px;
  border-radius: 35px;
  -webkit-box-shadow: 0px 0px 57px -37px rgba(104,94,253,1);
  -moz-box-shadow: 0px 0px 57px -37px rgba(104,94,253,1);
  box-shadow: 0px 0px 57px -37px rgba(104,94,253,1);">
        <div>
        <center>
          <img src="../img/LOGO.png" alt="Dream Travels" height="90px"></center>
          <div class="photo-info">
          <h3>Login To CRM</h3></div>
        </div>
        <div class="input-block email">
          <input 
            id="login-email"
            type="text"
            name="email"
            placeholder="Email/ Agent Id"
          />
        </div>
        <div class="input-block password">
          <input
            type="password"
            id="login-email"
            name="password"
            placeholder="Password"
          />
        </div>
        <button type="submit" name="submit" class="btn-login">Login</button>
      </form>
    </div>
  </section>

  
</body>
</html>