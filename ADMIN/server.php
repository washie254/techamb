<?php 
	session_start();
	// variable declaration
	$username = "";
	$email    = "";
	$errors = array(); 
	$_SESSION['success'] = "";

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'dkut_ambulance');


	// REGISTER USER
	if (isset($_POST['reg_admin'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO admin (username, email, password) 
					  VALUES('$username', '$email', '$password')";
			mysqli_query($db, $query);

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: home.php');
		}

	}

	// ... 

	// LOGIN ADMINISTRATOR
	if (isset($_POST['login_admin'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($password)) { array_push($errors, "Password is required"); }

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
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

	// ADD STAFF
	if (isset($_POST['add_staff'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
		$cdate = date("Y-m-d");
		$status = "ACTIVE";
		$ostatus = "AVAILABLE";

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO staff (username, email, password, dateadded, status, operationalstatus) 
					  VALUES('$username', '$email', '$password', '$cdate','$status','$ostatus')";
			mysqli_query($db, $query);

			// $_SESSION['username'] = $username;
			// $_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		}

	}

	//ALOCATE STAFF 
	
	if (isset($_POST['allocatestaff'])) {
		$staff = mysqli_real_escape_string($db, $_POST['staff']);
		$user = mysqli_real_escape_string($db, $_POST['user']);
		$incid = mysqli_real_escape_string($db, $_POST['incid']);
		$directives = mysqli_real_escape_string($db, $_POST['directives']);
		$status = 'PENDING';

		if (empty($incid)) { array_push($errors, "could not resolve incident"); }
		if (empty($user)) { array_push($errors, "could not resolve user"); }
		if (empty($directives)) { array_push($errors, "Kindly provide directives"); }
		if (empty($staff)) { array_push($errors, "Could Not resolve staff"); }

	
		if (count($errors) == 0) {
			$query = "INSERT INTO task (incid, user, staffid, directives, status) 
					  VALUES('$incid', '$user', '$staff', '$directives', '$status')";
			
			if(mysqli_query($db, $query)){

				$sql="UPDATE staff 
					SET operationalstatus='OCCUPIED'
						WHERE id='$staff' ";
				mysqli_query($db, $sql);

				$sql2="UPDATE incidents
					SET status='ONGOING'
						WHERE id='$incid' ";
				mysqli_query($db, $sql2);

				header('location: incidents.php');

			}
		}

	}

	if (isset($_POST['markcomplete'])) {
		$patremark= mysqli_real_escape_string($db, $_POST['patremark']);
		$incid= mysqli_real_escape_string($db, $_POST['incid']);
		$taskid= mysqli_real_escape_string($db, $_POST['taskid']);
		$stafid= mysqli_real_escape_string($db, $_POST['stafid']);
		$status = 'COMPLETED';

		if (empty($patremark)) { array_push($errors, "Add some patient remarks"); }
		if (empty($incid)) { array_push($errors, "could not resolve incident id"); }
		if (empty($taskid)) { array_push($errors, "could not resolve task id"); }

	
		if (count($errors) == 0) {
			$query = "UPDATE task SET status='$status' WHERE id='$taskid'";
			if(mysqli_query($db, $query)){

				$sql="UPDATE incidents 
					SET status='$status', adminadvice='$patremark'
						WHERE id='$incid' ";
				mysqli_query($db, $sql);

				$sql2="UPDATE staff
					SET operationalstatus='AVAILABLE'
						WHERE id='$stafid' ";
				mysqli_query($db, $sql2);

				header('location: incidents.php');

			}
		}

	}



?>