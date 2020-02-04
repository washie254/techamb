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
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$fname = mysqli_real_escape_string($db, $_POST['fname']);
		$lname = mysqli_real_escape_string($db, $_POST['lname']);
		$phone = mysqli_real_escape_string($db, $_POST['tel']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		function validate_phone_number($phone)
		{
			// Allow +, - and . in phone number
			$filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
			// Remove "-" from number
			$phone_to_check = str_replace("-", "", $filtered_phone_number);
			// Check the lenght of number
			// This can be customized if you want phone number from a specific country
			if (strlen($phone_to_check) < 9 || strlen($phone_to_check) > 14) {
			return false;
			} else {
			return true;
			}
		}

		//VALIDATE PHONE NUMBER 
		if (validate_phone_number($phone) !=true) { array_push($errors, "Invalid phone number"); }
		if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match"); }

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO users (username, fname, lname, email, password, telno) 
					  VALUES('$username', '$fname', '$lname', '$email', '$password', '$phone')";
			mysqli_query($db, $query);

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: home.php');
		}

	}

	// LOGIN ADMINISTRATOR
	if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($password)) { array_push($errors, "Password is required"); }

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
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

	//REPORT SNAKE BITE
	if (isset($_POST['reportinc'])) {

        $image = $_FILES['image']['name']; //receive image from a form
		$title = mysqli_real_escape_string($db, $_POST['title']);
		$wdescription = mysqli_real_escape_string($db, $_POST['wdescription']);
		$sdescription = mysqli_real_escape_string($db, $_POST['sdescription']);
		$town = mysqli_real_escape_string($db, $_POST['town']);
		$lat = mysqli_real_escape_string($db, $_POST['lat']);
		$lng = mysqli_real_escape_string($db, $_POST['lng']);
		$status = 'PENDING';
		$user = mysqli_real_escape_string($db, $_POST['user']);

		$latlng = $lat.", ".$lng;

		if (empty($image)) { array_push($errors, "Image required"); }
	   
		$target = "evidence/".basename($image); // name of the folder where the images will be saved

        if (count($errors) == 0) {
			$sql = "INSERT INTO incidents (user, image, title, wdescription, sdescription, town, lat, lng, latlng, status ) 
								VALUES ('$user', '$image', '$title', '$wdescription', '$sdescription', '$town', '$lat', '$lng', '$latlng', '$status')";
			if(mysqli_query($db, $sql)){
			    header('location: incidents.php');
			}
			if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
			    $msg = "Image uploaded successfully";
			}else{
			    $msg = "Failed to upload image"; //or just push it as an error
			}
		}
    }

	
?>