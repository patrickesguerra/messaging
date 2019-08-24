<?php 
require('connection.php'); 

if(isset($_REQUEST['from_user'])){ 
$advance_time=time()+15; 
$user_id = $_REQUEST['from_user']; 
$query=mysqli_query($con,"SELECT * FROM status WHERE user_id='$user_id'"); 
if(mysqli_num_rows($query)>0){ 
mysqli_query($con,"UPDATE status SET status='$advance_time' WHERE user_id='$user_id'"); 
}else{ 
mysqli_query($con,"INSERT INTO status(user_id,status) VALUES ('$user_id','$advance_time')"); 
} 
?>