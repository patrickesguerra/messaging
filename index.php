<?php
session_start();
if(isset($_SESSION['username'])){
//echo 'how are you '.$_SESSION['username']." ";

?>
<!doctype html>
<html>
<style>
<?php require_once("style.php");?>

</style>
<body>
<?php require_once("new-message.php");?>
<div id="container">
<div id="menu">
<?php 

echo $_SESSION['username'];
echo '<a style="float:right;color:white;" href="logout.php">Log out</a>';
?>
</div>
<div id="left-col">
<?php require_once("left-col.php");?>

<!-- end of left column-->
</div>
<div id="right-col"> 
<?php require_once("right-col.php");?>

<!-- end of right-col -->
</div>
</div>

</body>
</html>

<?php
}else{
	header("location:login.php");
}

?>