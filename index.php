<?php 
	session_start();

	require "config/config.php";
	require "config/common.php";

	// print_r($_SESSION['user']['role']);
	if(!isset($_SESSION['user'])) {
		echo "<script> alert('Please login first!');window.location.href='login.php'; </script>";
	}
	
	//search value
	if(isset($_POST['search'])){
		setcookie('search', $_POST['search'], time() + (86400 * 3), "/");
	}else {
		if(empty($_GET['pageno'])){
			unset($_COOKIE['search']); 
			setcookie('search', null, -1, '/'); 
		}
	}

	//cat cookie
	if(!empty($_GET['cat_id'])){
		setcookie('cat_id', $_GET['cat_id'], time() + (86400 * 3), "/");
	}else {
	if(empty($_GET['pageno'])){
		unset($_COOKIE['cat_id']); 
		setcookie('cat_id', null, -1, '/'); 
	}
	}


	//retrieving data 
	$stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
	$stmt->execute();
	$products = $stmt->fetchAll();

	//search
	if(empty($_POST['search']) && empty($_COOKIE['search'])) {
		// for pagination 
		if(!empty($_GET['pageno'])) {
			$pageNo = $_GET['pageno'];
		}else {
			$pageNo = 1;
		}
		$numberOfrecs = 5; //to show
		$offset = ($pageNo - 1) * $numberOfrecs;
		$totalPage = ceil(count($products) / $numberOfrecs);


		if(!empty($_GET['cat_id']) || !empty($_COOKIE['cat_id'])){
			$cat_id= !empty($_GET['cat_id']) ? $_GET['cat_id'] : $_COOKIE['cat_id'];
			$stmt= $pdo->prepare("SELECT * FROM products WHERE category_id =?");
			$stmt->execute([$cat_id]);
			$pages = $stmt->fetchAll();

			$numberOfrecs = 5; //to show
			$offset = ($pageNo - 1) * $numberOfrecs;
			$totalPage = ceil(count($pages) / $numberOfrecs); 

			$stmt= $pdo->prepare("SELECT * FROM products WHERE category_id =? LIMIT $offset, $numberOfrecs");
			$stmt->execute([$cat_id]);
			$pages = $stmt->fetchAll();
			
		}else {
			$stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT $offset, $numberOfrecs");
			$stmt->execute();
			$pages = $stmt->fetchAll();
		}
	}else {
		// for pagination 
		if(!empty($_GET['pageno'])) {
			$pageNo = $_GET['pageno'];
		}else {
			$pageNo = 1;
		}
		// when u search 
		$searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
		$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC");	
		$stmt->execute();
		$products = $stmt->fetchAll();

	
		$numberOfrecs = 5; //two show
		$offset = ($pageNo - 1) * $numberOfrecs;

		$totalPage = ceil(count($products) / $numberOfrecs); //chopping down the products into pages

		$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset, $numberOfrecs");           
		$stmt->execute();
		$pages = $stmt->fetchAll();
	}

?>



<?php include('header.php') ?>
	<!-- Start Best Seller -->
	<section class="lattest-product-area pb-40 category-list">
		<div class="row align-items-end">
			<!-- single product -->
			<?php foreach($pages as $key=>$value): ?>
			<div class="col-lg-4 col-md-6 mt-3">
				<div class="single-product p-2 shadow-sm" >
					<div class="d-flex justify-content-center align-items-center" >
						<a href="product_detail.php?id=<?php echo $value['id']?>">
							<img class="img-fluid" style="max-height: 150px!important;" src="admin/img/<?php echo escape($value['image']) ?>" alt="">
						</a>
					</div>
					<div class="product-details">
						<h6><?php echo escape($value['name']) ?></h6>
						<div class="price">
							<h6><?php echo escape($value['price']) ?> MMK</h6>
							<!-- <h6 class="l-through">$210.00</h6> -->
						</div>
						<div class="prd-bottom">
							<form action="addtocart.php" method="post">
								<input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
								<input type="hidden" name="id" value="<?php echo escape($value['id'])?>">
								<input type="hidden" name="qty" value="1">
								<div class="d-flex">
									<button type="submit" name="submit" style="display: contents;" class="social-info">
										<span class="ti-bag"></span>
									</button>
									<a href="product_detail.php?id<?php echo $value['id'] ?>" class="social-info ml-2">
										<span class="lnr lnr-move"></span>
										<p class="hover-text">view more</p>
									</a>
								</div>
							</form>
							
						</div>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</section>
	<!-- End Best Seller -->
<?php include('footer.php');?>
