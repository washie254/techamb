<?php 
	
	session_start(); 

	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['id']);
		header("location: login.php");
	}
?>
<!DOCTYPE >
<html><title>ADMIN</title>
<body>
<p>WELCOME <?php echo $_SESSION['username'];?></p>
<li><a href="index.php?logout='1'"></i> Logout </a></li>
<body>
</html>