<?php include('server.php');?>
<?php 
	//session_start(); 

	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: login.php");
	}

?>
<!doctype html>
<html lang="en">
  <head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="megakit,business,company,agency,multipurpose,modern,bootstrap4">
  
  <meta name="author" content="themefisher.com">

  <title>Fortune Admin</title>
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  <!-- Icon Font Css -->
  <link rel="stylesheet" href="plugins/themify/css/themify-icons.css">
  <link rel="stylesheet" href="plugins/fontawesome/css/all.css">
  <link rel="stylesheet" href="plugins/magnific-popup/dist/magnific-popup.css">
  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="plugins/slick-carousel/slick/slick.css">
  <link rel="stylesheet" href="plugins/slick-carousel/slick/slick-theme.css">
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="css/style.css">
</head>

<body>


<!-- Header Start --> 
<header class="navigation">
	<div class="header-top ">
		<div class="container">
			<div class="row justify-content-between align-items-center">
				<div class="col-lg-2 col-md-4">
					<div class="header-top-socials text-center text-lg-left text-md-left">
						<a href="#"><i class="ti-github"></i></a>
						<a href="#" style="color:Yellow"> <b>	
							<?php  if (isset($_SESSION['username'])):?>
							<?php echo $_SESSION['username']; ?> </b>
						</a>
						<a href="index.php?logout='1'" style="color: red;">logout</a>
						<?php endif ?>
					</div>
				</div>
				<div class="col-lg-10 col-md-8 text-center text-lg-right text-md-right">
					<div class="header-top-info">
						<a href="tel:+254720870388">Call Us : <span>+254-790-108689</span></a>
						<a href="mailto:Fortune Health@mail.com" ><i class="fa fa-envelope mr-2"></i><span>FortuneHealth@mail.com</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<nav class="navbar navbar-expand-lg  py-4" id="navbar">
		<div class="container">
		  <a class="navbar-brand" href="#">
		  	Fortune<span>Health.</span>
		  </a>

		  <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
			<span class="fa fa-bars"></span>
		  </button>
	  
		  <div class="collapse navbar-collapse text-center" id="navbarsExample09">
			<ul class="navbar-nav ml-auto">
			  	<li class="nav-item active">
					<a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
			  	</li>
			  	<li class="nav-item"><a class="nav-link" href="index.php">Report</a></li>
			  	<li class="nav-item"><a class="nav-link" href="incidents.php">Incidents</a></li>
			   	<li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
			</ul>
		  </div>
		</div>
	</nav>
</header>

<!-- Header Close --> 

<div class="main-wrapper ">

<section class="section intro">

<div class="container">
	<div style="padding: 6px 12px; border: 1px solid #ccc;">
		<p>Here is your profile and stats</p> 
		 
		</p>  
	</div>
</div>
<br>
<div class="container" id="activestaff">
    <div style="padding: 6px 12px; border: 1px solid #ccc;height:auto; verflow: auto;">
        <h3>User Information</h3> 
		<p> The following is your current account information</p> 
		
		<table class="table table-stripped">
                    <thead>
                        <tr>
                            <th sope="col">Avatar</th>
                            <th scope="col">Personal</th>
                            <th scope="col">About Salon</th>
                        </tr>
                    </thead>
                    <?php
                        $user = $_SESSION['username'];
    ;                   $query2 = "SELECT * FROM users WHERE username='$user'";
                        $result2 = mysqli_query($db, $query2);
                        while($row = mysqli_fetch_array($result2, MYSQLI_NUM)){
                            $uid = $row[0];
                            $names = $row[2]." ".$row[3];
                            $datecreated =$row[7];
                            $phone = $row[6];
                            $email = $row[4];

                        }
                    
                    ?>
                    <tr> <td>::<b style="color: #58BA2B;"> PROFILE INFORMATION</b></td> </tr>
                    <tr>
                        <td>
                            <?php 
                             echo '<img src="images/avatar.png" style="width:150px; height:150px;">';
                            ?>

                        </td>
                        <td>
                            <label class="label">User Id:</label><?php echo $uid; ?><br>
                            <label class="label">Username :</label> <?php echo $user; ?><br>
                            <label class="label">Other Names:</label> <?php echo $names; ?><br>
                        </td>
                        <td>
                            <label class="label">TelNo.:</label><?php echo $phone; ?><br>
                            <label class="label">Email:</label><?php echo $email; ?><br>
                            <label class="label">Date Created:</label><?php echo $datecreated; ?><br>
                        
                        </td>
                    </tr>
                </table>
    </div>
</div>

<br>
<div class="container" id="inactivestaff">
    <div style="padding: 6px 12px; border: 1px solid #ccc;height:auto; verflow: auto;">
        <h3>Statistics</h3> 
		<p> the following are some of your activities statistics log: The following are all 
		the incidents you have reported </p> 
		<?php
			$sql0 = "SELECT * FROM incidents WHERE user='$user'";
			$result0 = mysqli_query($db, $sql0);
			$count=0;
			$solved=0;
			$pending=0;
			$ongoing=0;
			while($rows = mysqli_fetch_array($result0, MYSQLI_NUM))
			{	$status = $rows[11];
				$count++;
				if($status=='COMPLETED'){
					$solved++;
				}elseif($status=='PENDING'){
					$pending++;
				}elseif($status=='ONGOING'){
					$ongoing++;
				}
			}	
		?>
		<P>
		<div class="alert alert-success" role="alert">
			<b><u>Total Incidents</u></b> : <?=$count?> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
			<b><u>Total Pending</u></b> : <?=$pending?> &nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
			<b><u>Total Solved</u></b> : <?=$solved?> &nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
			<b><u>Total Ongoing</u></b> : <?=$ongoing?><br>
		</div>
		 
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
				<th scope="col">Id</th>
				<th scope="col">Description</th>
				<th scope="col">Snake Desciption</th>
				<th scope="col">Location</th>
				<th scope="col">Status</th>
				<th scope="col">Date Time</th>
				</tr>
			</thead>
			<tbody>
				<!-- [ LOOP THE REGISTERED AGENTS ] -->
				<?php
				 require('connect-db.php');
                $user = $_SESSION["username"];
				$sql = "SELECT * FROM incidents WHERE user='$user'";
				$result = mysqli_query($conn, $sql);
				while($row = mysqli_fetch_array($result, MYSQLI_NUM))
				{	
					
                    echo '<tr>';
                        //Id	Image	Description	Snake Desciption	Location	Status	Date Time
						echo '<td>'.$row[0].'</td> '; //TASK ID //USERNAME
						echo '<td>'.$row[3].'<br>'.$row[4].'</td> '; //EMAIL
						echo '<td>'.$row[5].'</td> '; //DATEADDED
						echo '<td>'.$row[6].'<br>'.$row[9].'</td> '; //STATUSD
						echo '<td>'.$row[11].'</td> '; //STATUSD
						echo '<td>'.$row[10].'</td> '; //STATUSD
						
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
    </div>
</div>

<br>
  <!-- <div class="container">
    <div style="padding: 6px 12px; border: 1px solid #ccc;" id="addstaff">
        <h3>Assign a New Staff Member</h3> 
		<p> signup a new staff Member</p>   
		
		<form method="post" action="index.php">
		<style>
			.error {
				width: 98%; 
				margin: 0px auto; 
				padding: 10px; 
				border: 1px solid #a94442; 
				color: #a94442; 
				background: #f2dede; 
				border-radius: 5px; 
				text-align: left;
			}
		</style>
          <?php include('errors.php'); ?>
       
		  <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input type="text" class="form-control" name="username" placeholder="Enter username" ></textarea>
		  </div>
		  <div class="form-group">
              <label for="exampleInputEmail1">Email</label>
              <input type="email" class="form-control" name="email" placeholder="Enter Email" ></textarea>
		  </div>
		  <div class="form-group">
              <label for="exampleInputEmail1">password</label>
              <input type="password" class="form-control" name="password_1" placeholder="Enter password" ></textarea>
		  </div>
		  <div class="form-group">
              <label for="exampleInputEmail1">confirm password</label>
              <input type="password" class="form-control" name="password_2" placeholder="confirm password" ></textarea>
		  </div>
		  <button type="submit" class="btn btn-success" name="add_staff" style="width:100%;"><b>ADD STAFF</b></button>

		</form>

      </div>
  </div> -->
</section>

<!-- footer Start -->
<footer class="footer section">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="widget">
					<h4 class="text-capitalize mb-4">Fortune Health Company</h4>

					<ul class="list-unstyled footer-menu lh-35">
						<li><a href="#">Terms & Conditions</a></li>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Support</a></li>
						<li><a href="#">FAQ</a></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-2 col-md-6 col-sm-6">
				<div class="widget">
					<h4 class="text-capitalize mb-4">Quick Links</h4>

					<ul class="list-unstyled footer-menu lh-35">
						<li><a href="index.php">Home</a></li>
						<li><a href="staff.php">Staff</a></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="widget">
					<h4 class="text-capitalize mb-4">Subscribe Us</h4>
					<p>Subscribe to the Fortune Health  </p>

					<form action="#" class="sub-form">
						<input type="text" class="form-control mb-3" placeholder="Subscribe Now ...">
						<a href="#" class="btn btn-main btn-small">subscribe</a>
					</form>
				</div>
			</div>

			<div class="col-lg-3 ml-auto col-sm-6">
				<div class="widget">
					<div class="logo mb-4">
						<h3>Ken<span>Tour.</span></h3>
					</div>
					<h6><a href="tel:+254-790-108689" >+254-790-108689</a></h6>
					<a href="mailto:Fortune Health@yahoo.com"><span class="text-color h4">Fortunehealth@yahoo.com</span></a>
				</div>
			</div>
		</div>
		
		<div class="footer-btm pt-4">
			<div class="row">
				<div class="col-lg-6">
					<div class="copyright">
						&copy; Copyright Reserved to <span class="text-color">Fortune Health.</span> by <a href="#">Fortune</a>
					</div>
				</div>
				<div class="col-lg-6 text-left text-lg-right">
					<ul class="list-inline footer-socials">
						<li class="list-inline-item"><a href="#"><i class="ti-facebook mr-2"></i>Facebook</a></li>
						<li class="list-inline-item"><a href="#"><i class="ti-twitter mr-2"></i>Twitter</a></li>
						<li class="list-inline-item"><a href="#"><i class="ti-linkedin mr-2 "></i>Linkedin</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>
   
    </div>

    <!-- 
    Essential Scripts
    =====================================-->

    
    <!-- Main jQuery -->
    <script src="plugins/jquery/jquery.js"></script>
    <script src="js/contact.js"></script>
    <!-- Bootstrap 4.3.1 -->
    <script src="plugins/bootstrap/js/popper.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
   <!--  Magnific Popup-->
    <script src="plugins/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <!-- Slick Slider -->
    <script src="plugins/slick-carousel/slick/slick.min.js"></script>
    <!-- Counterup -->
    <script src="plugins/counterup/jquery.waypoints.min.js"></script>
    <script src="plugins/counterup/jquery.counterup.min.js"></script>

    <!-- Google Map -->
    <script src="plugins/google-map/map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeLMlsiwzp6b3Gnaxd86lvakimwGA6UA&callback=initMap"></script>    
    
    <script src="js/script.js"></script>

  </body>
  </html>
   