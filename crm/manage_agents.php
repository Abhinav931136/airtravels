<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'db_connection.php'; // Database connection

// Example of displaying a list of users
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="style.css">
      <!-- Favicons -->
  <link href="../img/logo.jpg" rel="icon">
  <link href="../img/logo.jpg" rel="apple-touch-icon">
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

<h2>Manage Users</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['role']; ?></td>
            <td>
                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                <a href="delete_user.php?id=<?php echo $user['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>
