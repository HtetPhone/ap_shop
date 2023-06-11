			
<?php
$link = $_SERVER['PHP_SELF'];
$link_array = explode('/', $link);
$page = end($link_array);
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
	<title>Ap Shop</title>

	<!--
            CSS
            ============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
	<style>
		button:hover .ti-bag {
			background-color: orangered;
		}
		
	</style>
</head>

<body id="category">

	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container" style="height: 70px!important">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.php"><h4>AP Shopping<h4></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<!-- for cart-item count  -->
						<?php
						 	$item= 0;
							if(isset($_SESSION['cart'])) {
								foreach($_SESSION['cart'] as $key => $val) {
									$item += $val;
								}
							}
						?>
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item"><a href="cart.php" class="cart"><span class="ti-bag"></span><?php echo $item ? $item : null ?></a></li>
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
				<form method="post" class="d-flex justify-content-between">
					<input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
					<input type="text" name="search" class="form-control" id="search_input" placeholder="Search Here">
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div>
	</header>
	<!-- End Header Area -->

	
	<?php if($page != 'product_detail.php' && $page != 'cart.php'): ?>
		<!-- Start Banner Area -->
		<section class="banner-area organic-breadcrumb">
			<div class="container">
				<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
					<div class="col-first">
						<h1>Welcome</h1>
					</div>
				</div>
			</div>
		</section>
		<!-- End Banner Area -->
		
		<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Browse Categories</div>
					<ul class="main-categories">
						<li class="main-nav-list">
							<?php 
								$stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
								$stmt->execute();
								$cats = $stmt->fetchAll();
							?>
							<?php foreach($cats as $cat): ?>
								<a class="cursor-pointer" href="index.php?cat_id=<?php echo escape($cat['id']) ?>"><?php echo escape($cat['name'])?></a>
							<?php endforeach; ?>
						</li>
					</ul>
				</div>
			</div>

			<div class="col-xl-9 col-lg-8 col-md-7">
			<!-- Start Filter Bar -->
			<div class="filter-bar d-flex flex-wrap align-items-center">
			<div class="pagination">
				<a class="" href="?pageno=1">First</a>
				<a href="<?php if($pageNo <= 1) { echo "#";} else { echo "?pageno=".($pageNo - 1);} ?>" class="prev-arrow" style="pointer-events:<?php if($pageNo <=1){ echo "none";} ?>">
					<i class="fa fa-long-arrow-left" aria-hidden="true"></i>
				</a>
				<a href="#" class="active"><?php echo $pageNo; ?></a>
				<a href="<?php if($pageNo >= $totalPage) { echo "#";} else { echo "?pageno=".($pageNo + 1);} ?>" class="next-arrow" style="pointer-events: <?php if($pageNo >= $totalPage) { echo "none";}?>;"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
				<a class="" href="?pageno=<?php echo $totalPage?>">Last</a>
			</div>
<?php endif; ?>
				</div>
