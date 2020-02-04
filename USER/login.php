<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>User login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="header">
		<h2>User Login</h2>
	</div>
	
	<form method="post" action="login.php">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" required>
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password" required>
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="login_user">Login</button>
		</div>
		<p>
			don't have an account ? <a href="register.php">Sign up</a>
		</p>
	</form>


</body>
</html>