<?php 
  session_start();

  require "config/config.php";
  require "config/common.php";

  // print_r($_SESSION['user']['role']);
  if(!isset($_SESSION['user'])) {
    echo "<script> alert('Please login first!');window.location.href='login.php'; </script>";
  }
  $id = $_GET['id'];
  $stmt= $pdo->prepare("SELECT * FROM products WHERE id =?");
  $stmt->execute([$id]);
  $product = $stmt->fetch();
  // print_r($product);
?>


<?php include('header.php') ?>

<!--================Single Product Area =================-->
<div class="product_image_area mt-0">
  <div class="container">
    <div class="row mt-3">
      <div class="col-lg-6">
        <img class="img-fluid w-100" src="admin/img/<?php echo $product['image'] ?>" alt="">
      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text mt-0">
          <h3><?php echo escape($product['name'])?></h3>
          <h2><?php echo escape($product['price'])?> MMK</h2>
          <ul class="list">
            <li><a class="active" href="#"><span>Category</span> : Household</a></li>
            <li><a href="#"><span>Availibility</span> : <?php echo escape($product['quantity'])?> In Stock
          </ul>
          
          <p><?php echo escape($product['description'])?></p>
          <form action="addtocart.php" method="post">
            <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
            <input type="hidden" name="id" value="<?php echo escape($product['id'])?>">
            <div class="product_count">
              <label for="qty">Quantity:</label>
              <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
              class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
              <button class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
            </div>
            <div class="card_area d-flex align-items-center">
              <button class="primary-btn border-0" name="submit" type="submit">Add to Cart</button>
              <a class="primary-btn" href="index.php">Go Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div><br>

<?php include('footer.php');?>
