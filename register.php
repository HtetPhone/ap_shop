<?php 
	session_start();

	require "config/config.php";
	require "config/common.php";

	$nameErr = $emailErr = $phNumErr = $addressErr = $passwordErr = "";
	if(isset($_POST['submit'])) {
		if(empty($_POST['name'])) {
			$nameErr = "<p class='text-danger'>Name is empty </p>";
		}else {
		$name = filter_input(INPUT_POST,'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
	  
		if(empty($_POST['email'])) {
			$emailErr = "<p class='text-danger'>email is empty </p>";
		}else {
			$email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
		}

		if(empty($_POST['phNum'])) {
			$phNumErr = "<p class='text-danger'>Ph no. is empty</p>";
		}else {
			$phNum = filter_input(INPUT_POST,'phNum', FILTER_SANITIZE_NUMBER_INT);
		}

		if(empty($_POST['address'])) {
			$addressErr = "<p class='text-danger'>Ph no. is empty</p>";
		}else {
			$address = filter_input(INPUT_POST,'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
	
		if(empty($_POST['password'])) {
			$passwordErr = "<p class='text-danger'>password is empty </p>";
		}elseif(strlen($_POST['password']) < 6){
			$passwordErr = "<p class='text-danger'>password has to be longer than 6 characters. </p>";
		}else {
			$password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$sPass = password_hash($password, PASSWORD_DEFAULT);
		}

		if(empty($nameErr) && empty($emailErr) && empty($phNumErr) && empty($addressErr) && empty($passwordErr)) {

			//checking if user exists
			$stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
			$stmt->execute([$email]);
			$user = $stmt->fetch();
			if($user) {
				echo "<script> alert('User exist!!');</script>";
			}else{
				$sql = "INSERT INTO users(name, email, phone ,password, address) VALUES (?,?,?,?,?)";
				$stmt = $pdo->prepare($sql);
				$result = $stmt->execute([$name,$email,$phNum,$sPass,$address]);
				if($result) {
					echo "<script> alert('Successfully added!');window.location.href='login.php';    </script>";
					}
			}

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
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>Make an account</h3>
						<form class="row login_form" action="" method="post" id="contactForm">
						<input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
							<input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control <?php echo $nameErr ? 'is-invalid' : null; ?>" id="name" name="name" placeholder="Username">
								<?php echo $nameErr; ?>
							</div>
							<div class="col-md-12 form-group">
								<input type="email" class="form-control <?php echo $emailErr ? 'is-invalid' : null; ?>" name="email" placeholder="Email" >
								<?php echo $emailErr; ?>
							</div>
							<div class="col-md-12 form-group">
								<input type="number" class="form-control <?php echo $phNumErr ? 'is-invalid' : null; ?>" name="phNum" placeholder="Phone No.">
								<?php echo $phNumErr; ?>
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control <?php echo $addressErr ? 'is-invalid' : null; ?>" name="address" placeholder="Address & Location">
								<?php echo $addressErr; ?>
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control <?php echo $passwordErr ? 'is-invalid' : null; ?>" name="password" placeholder="Password" >
								<?php echo $passwordErr; ?>
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" name="submit" class="primary-btn">Register</button>
							</div>
							<div class="col-md-12 form-group">
								<button class="primary-btn bg-primary"><a class="text-white mt-0" href="login.php">Log In</a></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>