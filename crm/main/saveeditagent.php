<?php
$servername = "sql307.infinityfree.com";
$username = "if0_40439465";
$password = "5lSouEF6Wds";
$dbname = "if0_40439465_dream";    
$conn = new mysqli($servername, $username, $password, $dbname);
if(isset($_POST['submit']))
{
$ID = $_GET['ID'];
$user_id = $_POST['user_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$dob = $_POST['dob'];
$usa_name = $_POST['usa_name'];
$blood = $_POST['blood'];
$address = $_POST['address'];
$password = $_POST['password'];

$update = mysqli_query($conn, "UPDATE users SET user_id='$user_id' ,name='$name' ,email='$email' ,contact='$contact' ,dob='$dob' ,usa_name='$usa_name' ,blood='$blood' ,address='$address' ,password='$password' WHERE id=$ID");
if($update){
echo "<script>alert('Details Updated Successfully!')</script>";

}
header("location: agents.php");
}
?>