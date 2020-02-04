<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Register</h2>
	</div>
	
	<form method="post" action="register.php">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<!-- <label>Username</label> -->
			<input type="text" name="username" placeholder="username" required>
		</div>
		<div class="input-group">
			<!-- <label>Username</label> -->
			<input type="text" name="fname" placeholder="First Name" required>
		</div>
		<div class="input-group">
			<!-- <label>Username</label> -->
			<input type="text" name="lname" placeholder="Last Name" required>
		</div>
		<div class="input-group">
			<!-- <label>Username</label> -->
			<input type="text" name="tel" placeholder="Tel No." required>
		</div>
		
		<div class="input-group">
			<!-- <label>Email</label> -->
			<input type="email" name="email"  placeholder="Email "required>
		</div>
		<div class="input-group">
			<!-- <label>Password</label> -->
			<input type="password" name="password_1" placeholder="password" required>
		</div>
		<div class="input-group">
			<!-- <label>Confirm password</label> -->
			<input type="password" name="password_2" placeholder="confirm password" required>
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="reg_user">Register</button>
		</div>
		<p>
			Already a member ? <a href="login.php">Sign in</a>
		</p>
	</form>
</body>
</html>