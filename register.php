<?php require_once("connection.php");?>
<!doctype html>
<html>
<style>
*{margin:0px; padding:0px;}
#container{border:1px; solid black; text-align:center;}

</style>
<body>
<h1 align="center"> Registration Form </h1>
<br>
<br>
<div id="container">
<form method="post">
<input type="text" placeholder="user name" id="user_name" onkeyup="check_user()" name="user_name" class="input" required/>
<div id="checking">Checking</div>
<br>
<input type="password" placeholder="Password" name="password" class="input" required/><br><br>
<input type="submit" id="register" name="register" value="register" />
<a href="login.php"> Login here </a>

</div>
<?php 
if(isset($_POST['register'])){
$user_name=$_POST['user_name'];
$password=$_POST['password'];
$q="INSERT INTO `users`(`id`,`user_name`,`password`)VALUES('','".$user_name."','".$password."')";
$r=mysqli_query($con,$q);
if($r){
	header("location:login.php");
}else {
	echo $q;
}



}

?>
<script src="sub_file/jquery-3.3.1.min.js"></script>
<script> 

document.getElementById("register").disabled=true;
function check_user(){
	var user_name = document.getElementById("user_name").value;
	 
	 $.post("sub_file/user_check.php",
	 {
		 user: user_name
	 },
	 function(data,status){
		 if(data=='<p style="color:red">User already registered</p>'){
			 document.getElementById("register").disabled=true;
		 }
		 else{
			 document.getElementById("register").disabled=false;
		 }
		 document.getElementById("checking").innerHTML=data; 	
	 }
	 
	 );
	 
}
</script>

</body>
</html>