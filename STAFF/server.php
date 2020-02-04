<?php 
	session_start();
	// variable declaration
	$username = "";
	$email    = "";
	$errors = array(); 
	$_SESSION['success'] = "";

	// connect to database
$db = mysqli_connect('localhost', 'africand_muchemi', 'Muchemi254', 'africand_kentour');


	// STAFF
	if (isset($_POST['staff_login'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

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

	// If upload button is clicked ...
	if (isset($_POST['add_land'])) {

		$title = $_POST['title'];
		$size = $_POST['size'];
		$description = $_POST['description'];	
		$location = $_POST['location'];
		$cost = $_POST['cost'];
		$cdate = date("Y-m-d");
		$status = "AVAILABLE";
	

		$image = $_FILES['image']['name'];
		// Get text
		$image_text = mysqli_real_escape_string($db, $_POST['image_text']);
		// image file directory
		// Get image name
		$target = "lands/".basename($image);
		
		if (empty($title)) { array_push($errors, "insert title"); }
		if (empty($location)) { array_push($errors, "Add location"); }
		if (empty($description)) { array_push($errors, "Add a brief description"); }
		if (empty($cost)) { array_push($errors, "Insert price of the piece of land"); }
	
		if (count($errors) == 0) {
		  $sql = "INSERT INTO land (landtitle, location, cost, image, description, status, dateadded ) 
								VALUES ('$title','$location','$cost','$image','$description','$status','$cdate')";
		  // execute query
		  //mysqli_query($db, $sql);
		  //echo '<script> alert("Land added Successfully!"); </script>';
		  //header("refresh; url=index.php");
		  if(mysqli_query($db, $sql)){
			  echo '<script> alert("Land Successfuly Added !"); </script>';
			header("refresh; url=lands.php");
			echo '<script> alert("Land added Successfully!"); </script>';
			header("refresh; url=index.php");
		  }
		  if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
			$msg = "Image uploaded successfully";
		  }else{
			$msg = "Failed to upload image";
		  }
		}
	}

	if (isset($_POST['respondenq'])) {
		$enqid = $_POST['enqid'];
		$feedback = $_POST['feedback'];
		$stat ="ATTENDED";
		
		if (empty($feedback)) { array_push($errors, "Insert Feedback !"); }
	
		if (count($errors) == 0) {

			$sql ="UPDATE enquiries SET 
			    feedback ='$feedback',
			    status = '$stat'
			    
			    WHERE id='$enqid'";
			    
			mysqli_query($db, $sql);
			
			header('location: enquiries.php');
		}
	}


	// If upload button is clicked ...
	if (isset($_POST['rejectreason'])) {

		$reason = $_POST['reason'];
		$uid = $_POST['userID'];
		$uname = $_POST['username'];
		$cdate = date("y-m-d");
		$stat ="REJECTED";
		
		if (empty($reason)) { array_push($errors, "Kindly add a reason"); }
	
		if (count($errors) == 0) {

			$sql ="UPDATE members SET accountStatus='$stat' WHERE id='$uid'";
			mysqli_query($db, $sql);

            $sql0 =  "INSERT INTO rejectedaccounts (userid, username, reason, date) 
                                            VALUES ('$uid','$uname','$reason','$cdate')";
			mysqli_query($db, $sql0);
			
			header('location: accounts.php');
		}
	}

	if (isset($_POST['rejectloan'])) {

		$reason = $_POST['reason'];
		$mem = $_POST['memid'];
		$lid = $_POST['loanid'];
		$stat ="REJECTED";
		$cdate = date("y-m-d");
		
		if (empty($reason)) { array_push($errors, "Kindly add a reason"); }
	
		if (count($errors) == 0) {

			$sql ="UPDATE cashloans SET status='$stat' WHERE memberid='$mem' AND id='$lid' ";
			mysqli_query($db, $sql);

            $sql0 =  "INSERT INTO rejectedloanreasons (loanid, memid, reason, date) 
                                            VALUES ('$lid','$mem','$reason','$cdate')";
			mysqli_query($db, $sql0);
			
			header('location: index.php');
		}
	}

	if (isset($_POST['rejectlan'])) {
        $landid = $_POST['landid'];
		$reason = $_POST['reason'];
		$mem = $_POST['memid'];
		$lid = $_POST['loanid'];
		$stat ="REJECTED";
		$cdate = date("y-m-d");
		
		if (empty($reason)) { array_push($errors, "Kindly add a reason"); }
	
		if (count($errors) == 0) {

			$sql ="UPDATE landapplications SET status='$stat' WHERE memberid='$mem' AND id='$lid' ";
			mysqli_query($db, $sql);

            $sql0 =  "INSERT INTO rejectedlanreasons (appid, memid, reason, date) 
                                            VALUES ('$lid','$mem','$reason','$cdate')";
			mysqli_query($db, $sql0);
			
			$sql1 =  "UPDATE land SET status='AVAILABLE' WHERE lid='$landid'";
			mysqli_query($db, $sql1);
			
			header('location: landapps.php');
		}
	}
?>