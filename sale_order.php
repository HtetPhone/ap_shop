<?php 
	session_start();
	include "config/config.php";
	include "config/common.php";

	if(isset($_SESSION['cart'])) {

		//preparing to submit to sale_orders tabale
		//need cusId , total_price
		$cusId = $_SESSION['user_id'];

		$total = 0;
		$cart_items = $_SESSION['cart'];
		foreach($cart_items as $key => $val) {
			$id= str_replace('id','',$key);
			$qty = $val;

			$stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
			$stmt->execute();
			$result= $stmt->fetch();
			$total += $result['price'] * $qty;
		}
		//inserting here
		$stmt = $pdo->prepare("INSERT INTO sale_orders (customer_id, total_price) VALUES(?,?)");
		$result = $stmt->execute([$cusId,$total]);

		if($result) {
			//preparing to submit to sale_order_detail table
			//needs sale_order_id, product_id, quantity
			$sale_order_id = $pdo->lastInsertId();
			foreach($cart_items as $key => $val) {
				$pId= str_replace('id','',$key);
				$qty = $val;

				//INSERTING HERE INTO SALE_ORDER_DETAIL
				$stmt = $pdo->prepare("INSERT INTO sale_order_detail (sale_order_id, product_id, quantity) VALUES(?,?,?) ");
				$result= $stmt->execute([$sale_order_id,$pId,$qty]);

				//taking out the bought product quantities
				$qtyStmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
				$qtyStmt->execute([$pId]);
				$qResult = $qtyStmt->fetch();

				$updateQty = $qResult['quantity'] - $qty;

				$updateStmt = $pdo->prepare("UPDATE products SET quantity=? WHERE id=?");
				$updateStmt->execute([$updateQty,$pId]);

				unset($_SESSION['cart']);
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

	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.html"><h4>AP Shopping<h4></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item"><a href="#" class="cart"><span class="ti-bag"></span></a></li>
							<li class="nav-item">
								<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="search_input" id="search_input_box">
			<div class="container">
				<form class="d-flex justify-content-between">
					<input type="text" class="form-control" id="search_input" placeholder="Search Here">
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div>
	</header>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Confirmation</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Order Details Area =================-->
	<section class="order_details section_gap">
		<div class="container">
			<h3 class="title_confirmation">Thank you. Your order has been received.</h3>
		</div>
	</section>
	<!--================End Order Details Area =================-->

	<?php include "footer.php" ?>
	