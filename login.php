<?php 
	 session_start();

	 require "config/config.php";
	 require "config/common.php";
	 if(isset($_POST['submit'])) {

		$email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
		$password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	
		$stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email");
		$stmt->bindValue(':email', $email);
		$stmt->execute();
		$user = $stmt->fetch();
		if($user) {
		  $hashedPw = $user['password'];
		  if(password_verify($password, $hashedPw)) {
			$_SESSION['user'] = $user;
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['logged_in'] = time();
	  
			header('Location: index.php');
		  }
		}else {
		  echo "<script> alert('Incorrect Credentials') </script>";
		}
	
	  }
?>



<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>AP Shop</title>

	<!--
		CSS
		============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>

<body>

	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h"><img src="img/logo.png" alt=""></a>
				</div>
			</nav>
		</div>
		
	</header>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Login/Register</h1>
					<nav class="d-flex align-items-center">
						<a href="">Sign into your account and start purchasing!</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="login_box_img">
						<img class="img-fluid" src="img/login.jpg" alt="">
						<div class="hover">
							<h4>New to our website?</h4>
							<p>There are advances being made in science and technology everyday, and a good example of this is the</p>
							<a class="primary-btn" href="register.php">Create an Account</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>Log in to enter</h3>
						<form class="row login_form" action="" method="post" id="contactForm" novalidate="novalidate">
							<input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" name="email" placeholder="Email" required>
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" name="password" placeholder="Password" required>
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" name="submit" class="primary-btn">Log In</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->

	<!-- start footer Area -->
	<?php include "footer.php"; 