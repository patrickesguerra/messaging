<?php 
session_start();
require_once("connection.php"); ?>
<!doctype html>
<html>
<style>
*{margin:0px; padding:0px;}
#container{border:1px; solid black; text-align:center;}

</style>
<body>
<h1 align="center"> Login Form </h1>
<div id="container">
<form method="post">
<input type="text" class="input" placeholder="user_name" name="user_name"/> <br> <br>
<input type="password" class="input" placeholder="password" name="password"/> <br> <br>
<input type="submit" value="login" name="login"/>
<a href="register.php"> Register here </a>
</form>
</div>

<?php
if(isset($_SESSION['user_id'])){
	header("LOCATION: index.php");
}
if(isset($_POST['login'])){
	$user_name=$_POST['user_name'];
	$password=$_POST['password'];
	
	$q='SELECT * FROM `users` WHERE `user_name`="'.$user_name. '" AND `password`="'.$password.'"';
	$r=mysqli_query($con,$q);
	if($r){
		if(mysqli_num_rows($r)>0){
			while($row=mysqli_fetch_array($r)){
				$user_id=$row[0];
			}
			$_SESSION['username']=$user_name;
			$_SESSION['user_id']=$user_id;
			header("location:index.php");
		}
		else{
			echo 'Your password and user name did not match';
		}
	}
	else{
		echo $q;
	}
}
?>
</body>
</html>