<?php 
require('connection.php');
$user_name=$_SESSION['username'];
$user_id=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
	header("LOCATION: index.php");
}else{
	$advance_time=time()+15;
	$query=mysqli_query($con,"SELECT * FROM status WHERE user_id='$user_id'");
	if(mysqli_num_rows($query)>0){
		mysqli_query($con,"UPDATE status SET status='$advance_time' WHERE user_id='$user_id'");
	}else{
		mysqli_query($con,"INSERT INTO status(user_id,status) VALUES ('$user_id','$advance_time')");
	}
}
?>
<div id="left-col-container">
<div style="cursor:pointer" onclick="document.getElementById('new-message').style.display='block'" class="white-back">
<p align="center">New Message </p>
</div>

<?php 

$q='SELECT DISTINCT `receiver_name`,`sender_name`,`date_time`
FROM `messages` WHERE 
`sender_name`="'.$_SESSION['username'].'" OR
`receiver_name`="'.$_SESSION['username'].'"
ORDER BY `date_time` DESC';
$e='SELECT * from messages';
$r=mysqli_query($con,$q);


if($r){
	if(mysqli_num_rows($r)>0){
		$counter=0;
		$added_user=array();
		while($row=mysqli_fetch_assoc($r)){
			$sender_name=$row['sender_name'];
			$receiver_name=$row['receiver_name'];
			$timestamp=$row['date_time'];
			if($_SESSION['username']==$sender_name){
				//add the receiver_name but only once
				//so to do that check the user in array
				if(in_array($receiver_name,$added_user)){
					//dont add receiver_name because
					//he is already added
				}else{
					//add the receiver_name
					?>
					<div class="grey-back">
                    <img src="images/s.jpg" class="image"/>
                    <?php 
					echo '<a href="?user='.$receiver_name.'">'.$receiver_name.'</a>';
                   $fetch_content=mysqli_query($con,"SELECT * FROM users JOIN status ON `users`.`id`=`status`.`user_id`");
					while($row_fetch=mysqli_fetch_array($fetch_content)){
						$time=$row_fetch[5];
						if($time<= time()){
							$status = "<img src='images/r.png' height='10' width='10' style='float:right'>";
						}else{
							$status= "<img src='images/a.png' height='10' width='10' style='float:right'>";
						}
					}
				     echo $status;
					?>
                    </div>
					<?php
					//as receiver_name added so
					///add it to the array as well
					$added_user=array($counter=>$receiver_name);
					//increment the counter
					$counter++;
				}
			}elseif($_SESSION['username']==$receiver_name){
				//add the sender_name but only once
				//so to do that check the user in array
				if(in_array($sender_name,$added_user)){
					//dont add sender_name because
					//he is already added
				}else{
					//add the sender_name
					?>
					<div class="grey-back">
                    <img src="images/s.jpg" class="image"/>
                    <?php echo '<a href="?user='.$sender_name.'">'.$sender_name.'</a>';
                      $fetch_content=mysqli_query($con,"SELECT * FROM users JOIN status ON `users`.`id`=`status`.`user_id`");
					while($row_fetch=mysqli_fetch_array($fetch_content)){
						$time=$row_fetch[5];
						if($time<= time()){
							$status = "<img src='images/r.png' height='10' width='10' style='float:right'>";
						}else{
							$status= "<img src='images/a.png' height='10' width='10' style='float:right'>";
						}
					}
				     echo $status;
					?>
                    </div>
					<?php
					//as sender_name added so
					///add it to the array as well
					$added_user=array($counter=>$sender_name);
					//increment the counter
					$counter++;
				}
			}
			}
		}
		else{
		//no message sent
		echo 'no user';
	    }
	}else{
	//query problem
	echo $q;
}
?>



<!-- end of left-col-container -->
</div>
<input type="hidden" value="<?php echo $user_id; ?>" id="from_user_id">
<script type="text/javascript">
setInterval(function(){updating_status()},5000);
function updating_status(){
	let this_user = $('#from_user_id').val(); 
	$.ajax({
		method: "POST",
		url: "updating.php",
		data: {from_user:this_user},
	success: function(response){
		$('#content').html(response);
	}
	});
}
</script>