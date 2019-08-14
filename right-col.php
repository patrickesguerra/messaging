<div id="right-col-container">
<div id="messages-container">

<?php 
$no_message=false;

if(isset($_GET['user'])){
	$_GET['user']=$_GET['user'];
}else{
	//user variable is not in the url bar
	//so select the last user, you have sent message
	$q='SELECT `sender_name`, `receiver_name` FROM `messages`
	WHERE `sender_name` ="'.$_SESSION['username'].'"
	or `receiver_name`="'.$_SESSION['username'].'"
	ORDER BY `date_time` DESC LIMIT 1';
    
$r=mysqli_query($con,$q);
if($r){
	if(mysqli_num_rows($r)>0){
		while($row=mysqli_fetch_assoc($r)){
			$sender_name=$row['sender_name'];
			$receiver_name=$row['receiver_name'];
			
			if($_SESSION['username']==$sender_name){
				$_GET['user']=$receiver_name;
			}
			else{
				$_GET['user']=$sender_name;
			}
		}
	}
	else{
		//this user havent sent any message
		echo 'no message from you';
		$no_message=true;
	}
}else{
	//query problem
	$q;
}
}
if($no_message==false){
$q='SELECT * FROM `messages` WHERE `sender_name`="'.$_SESSION['username'].'"
AND `receiver_name`="'.$_GET['user'].'"
OR
`sender_name`="'.$_GET['user'].'"
And `receiver_name`="'.$_SESSION['username'].'"';

$r=mysqli_query($con,$q);
if($r){
	//query successfull
	while($row=mysqli_fetch_assoc($r)){
		$sender_name=$row['sender_name'];
		$receiver_name=$row['receiver_name'];
		$message=$row['message_text'];
		
		//check who is the sender of the message
		if($sender_name== $_SESSION['username']){
			//show the message with grey back
			
			?>
			<div class="grey-message">
            <a href="#">Me</a> 
            <p><?php echo $message; ?></p>
            </div>
			<?php
			
		}
		else{
			//show the message with white back
			?>
			<div class="white-message">
            <a href="#"><?php echo $sender_name; ?></a>
            <p><?php echo $message ?></p>
            </div>

			<?php
		}
	}
}else{
	//query problem
	echo $q;
}
//end of no_message
}
?>



<!-- end of messages container -->
</div>
<form method="post" id="message-form">
<textarea class="textarea" id="message_text" placeholder="Write your message"></textarea>
</form>
<!--end of right-col-container -->
</div>
<script src="sub_file/jquery-3.3.1.min.js"></script>
<script>
$("document").ready(function(event){
	//now if the form is submitted
	$("#right-col-container").on('submit','#message-form',function(){
		//take the data from textarea
		var message_text=$("#message_text").val();
		//send the data to sending_process.php file
		$.post("sub_file/sending_process.php?user=<?php echo $_GET['user'];?>", 
		{
			text: message_text,
		},
		//in return we'll get
		function(data,status){
			
			//first remove the text from 
			//message_text so
			$("#message_text").val("");
			//now add the data inside the message container 
			document.getElementById("messages-container").innerHTML += data;
		}
		
		);
	});
//if any button is clicked inside
//right-col-container
$("#right-col-container").keypress(function(e){
	//as we will submit the form with enter button so 
	if(e.keyCode==13 && !e.shiftKey){
		//it means enter is clicked without shift key
		//so submit the form
		$("#message-form").submit();
	}
});
	
});
</script>