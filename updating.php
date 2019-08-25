<?php 
require('connection.php'); 
session_start(); 

$user_name = $_SESSION['username']; 
$user_id = $_SESSION['user_id']; 
if(isset($_REQUEST['from_user'])){ 
$advance_time=time()+15; 
$user_id = $_REQUEST['from_user']; 
$query=mysqli_query($con,"SELECT * FROM status WHERE user_id='$user_id'"); 
if(mysqli_num_rows($query)>0){ 
mysqli_query($con,"UPDATE status SET status='$advance_time' WHERE user_id='$user_id'"); 
} 
}else{ 
mysqli_query($con,"INSERT INTO status(user_id,status) VALUES ('$user_id','$advance_time')"); 
} 

$html_left_div = ''; 
$html_left_div .='<div id="left-col-container"> 
<div style="cursor:pointer" onclick="document.getElementById(\'new-message\').style.display=\'block\'" class="white-back"> 
<p align="center">New Message </p> 
</div>'; 

$q = 'SELECT DISTINCT `receiver_name`,`sender_name`,`date_time` 
FROM `messages` WHERE 
`sender_name`="' . $_SESSION['username'] . '" OR 
`receiver_name`="' . $_SESSION['username'] . '" 
ORDER BY `date_time` DESC'; 
$e = 'SELECT * from messages'; 
$r = mysqli_query($con, $q); 
// echo $q; 
if ($r) { 
if (mysqli_num_rows($r) > 0) { 
$counter = 0; 
$added_user = array(); 
while ($row = mysqli_fetch_assoc($r)) { 
$sender_name = $row['sender_name']; 
$receiver_name = $row['receiver_name']; 
$timestamp = $row['date_time']; 
if ($_SESSION['username'] == $sender_name) { 
//add the receiver_name but only once 
//so to do that check the user in array 
if (in_array($receiver_name, $added_user)) { 
//dont add receiver_name because 
//he is already added 
} else { 
//add the receiver_name 

$html_left_div .='<div class="grey-back"> 
<img src="s.jpg" class="image"/> 
<a href="?user=' . $receiver_name . '">' . $receiver_name . '</a>'; 
$fetch_content = mysqli_query($con, "SELECT * FROM users JOIN status ON `users`.`id`=`status`.`user_id`"); 
while ($row_fetch = mysqli_fetch_array($fetch_content)) { 
$time = $row_fetch[5]; 
if ($time <= time()) { 
$html_left_div .='<img src=\'r.png\' height=\'10\' width=\'10\' style=\'float:right\'>'; 
} else { 
$html_left_div .='<img src=\'a.png\' height=\'10\' width=\'10\' style=\'float:right\'>'; 
} 
} 

$html_left_div .='</div>'; 

//as receiver_name added so 
///add it to the array as well 
$added_user = array($counter => $receiver_name); 
//increment the counter 
$counter++; 
} 
} elseif ($_SESSION['username'] == $receiver_name) { 
//add the sender_name but only once 
//so to do that check the user in array 
if (in_array($sender_name, $added_user)) { 
//dont add sender_name because 
//he is already added 
} else { 
//add the sender_name 
$html_left_div .='<div class="grey-back"> 
<img src="s.jpg" class="image"/> 
<a href="?user=' . $sender_name . '">' . $sender_name . '</a>'; 
$fetch_content = mysqli_query($con, "SELECT * FROM users JOIN status ON `users`.`id`=`status`.`user_id`"); 
while ($row_fetch = mysqli_fetch_array($fetch_content)) { 
$time = $row_fetch[5]; 
if ($time <= time()) { 
$html_left_div .='<img src=\'r.png\' height=\'10\' width=\'10\' style=\'float:right\'>'; 
} else { 
$html_left_div .='<img src=\'a.png\' height=\'10\' width=\'10\' style=\'float:right\'>'; 
} 
} 

$html_left_div .='</div>'; 
//as sender_name added so 
///add it to the array as well 
$added_user = array($counter => $sender_name); 
//increment the counter 
$counter++; 
} 
} 
} 
} else { 
//no message sent 
echo 'no user'; 
} 
} else { 
//query problem 
echo $q; 
} 

$html_left_div .='</div>'; 
echo $html_left_div;