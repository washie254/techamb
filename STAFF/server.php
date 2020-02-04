<?php 
	session_start();
	// variable declaration
	$username = "";
	$email    = "";
	$errors = array(); 
	$_SESSION['success'] = "";

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'dkut_ambulance');


	// LOGIN STAF
	if (isset($_POST['login_staff'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($password)) { array_push($errors, "Password is required"); }

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM staff WHERE username='$username' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: home.php');
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

	//STAFF MAKING A REPORTING 
	if (isset($_POST['makereport'])) {
		$taskid = mysqli_real_escape_string($db, $_POST['taskid']);
		$remarks = mysqli_real_escape_string($db, $_POST['remarks']);
		$status = 'AWAITING APPROVAL';
		if (empty($remarks)) { array_push($errors, "Kindly provide some remarks"); }
		if (empty($taskid)) { array_push($errors, "Could Not resolve your Task ID"); }

		if (count($errors) == 0) {
			
			$query = "UPDATE task 
						SET
					    status='$status',
						staffremarks='$remarks' 
						WHERE id='$taskid' ";
			if(mysqli_query($db, $query)){
				header('location: incidents.php');
			}

			
		}
	}

?>