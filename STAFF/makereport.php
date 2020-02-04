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
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <!-- Required meta tags -->
  
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="megakit,business,company,agency,multipurpose,modern,bootstrap4">
  
  <meta name="author" content="themefisher.com">

  <title>Kentour Staff</title>
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
		  	Ken<span>Tour.</span>
		  </a>

		  <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
			<span class="fa fa-bars"></span>
		  </button>
	  
		  <div class="collapse navbar-collapse text-center" id="navbarsExample09">
			<ul class="navbar-nav ml-auto">
			<li class="nav-item"><a class="nav-link" href="index.php"> <== BACK </a></li>
			  <li class="nav-item active">
				<a class="nav-link" href="#"> :::::: <span class="sr-only">(current)</span></a>
			  </li>
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
		<h3>Staff guidelines</h3> 
		<p> provide some directives for your staff</p>  
        <?php
            include('connect-db.php');
           // include('server.php');
           $db = mysqli_connect('localhost', 'root', '', 'dkut_ambulance');
            if (isset($_GET['id']) && is_numeric($_GET['id']))
            {
                $taskid = $_GET['id'];
                $incid = $_GET['memb'];
                // $stat ="ATTENDED";

                $sql = "SELECT * FROM task WHERE id='$taskid'";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                    // $i =$row[0];
                    $victim =$row[2];
                    $directives = $row[4];
                    $datetim = $row[5];
                }
            }
        ?>
        <p> <b>Task  ID: </b><?php echo $taskid;?>
        <p> <b>VICTIM :</b> <?php echo $victim;?>
            <br>
            <b><u>Directives:</u></b> <?=$directives?>

            <br>
        </p>
        <br>


        <div class="container">

            <form method="post" action="makereport.php">
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
                    <textarea type="text" class="form-control" name="remarks" placeholder="Write a brief remark about the situation for admin to review"></textarea>
                </div>

                <input type="text" style="opacity:0;" name="taskid" value="<?=$taskid?>" readonly>

                <button type="submit" class="btn btn-success" name="makereport" style="width:100%;"><b>PROVIDE INCIDENT REMARKS</b></button>
                </a>

            </form>
        </div>
    </div>
</div>
</section>


<!-- Section Intro END -->
<!-- Section About Start -->


<!-- Section About End -->

<

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
						<li><a href="index.php">Staff</a></li>
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