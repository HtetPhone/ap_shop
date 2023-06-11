<?php
  session_start();

  require "../config/config.php";
  require "../config/common.php";

  if($_SESSION['user']['role'] != 1) {
    echo "<script> alert('You cant have access to this page!');window.location.href='login.php'; </script>
    ";
  }



  
  $nameErr = $descErr = $priceErr = $instockErr = $catErr = $imgErr ="";

  if(isset($_POST['submit'])){
    if(empty($_POST['name'])) {
        $nameErr = "<p class='text-danger'>Name is empty </p>";
    }else {
      $name = filter_input(INPUT_POST,'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if(empty($_POST['desc'])) {
        $descErr = "<p class='text-danger'>Description is empty </p>";
    }else {
      $desc = filter_input(INPUT_POST,'desc', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    if(empty($_POST['price'])) {
      $priceErr = "<p class='text-danger'>price is empty </p>";
    }else {
      if(!is_numeric($_POST['price'])) {
        $priceErr = "<p class='text-danger'>Set a Valid Price </p>";
      }else {
        $price = filter_input(INPUT_POST,'price', FILTER_SANITIZE_NUMBER_INT);
      }
    }
    if(empty($_POST['instock'])) {
      $instockErr = "<p class='text-danger'>Quantity is empty </p>";
    }else {
      if(!is_numeric($_POST['instock'])) {
        $instockErr = "<p class='text-danger'>Set a valid number.</p>";
      }else {
        $instock = filter_input(INPUT_POST,'instock', FILTER_SANITIZE_NUMBER_INT);
      }
    }
    if(empty($_POST['category'])) {
      $catErr = "<p class='text-danger'>Please select a category </p>";
    } else {
      $category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    if(empty($_FILES['img'])) {
      $imgErr = "<p class='text-danger'>Select an image</p>";
    }else {
      $file = $_FILES['img']['name'];
      $imgType = pathinfo($file, PATHINFO_EXTENSION);
      if($imgType != 'jpg' && $imgType !='jpeg' &&  $imgType != "png") {
        $imgErr = "<p class='text-danger'>Image type has to be Jpeg, Jpg or Png </p>";
      }
    }


    if(empty($nameErr) && empty($descErr) && empty($priceErr) && empty($instockErr) && empty($catErr) && empty($imgErr)) {
      // files 
      $dir = "img/";
      $img_name = $_FILES['img']['name'];
      $tmp_name = $_FILES['img']['tmp_name'];

      move_uploaded_file($tmp_name, $dir.$img_name);


      $sql = "INSERT INTO products(name, description, price, quantity, category_id, image) VALUES (?,?,?,?,?,?)";
      $stmt = $pdo->prepare($sql);
      $result = $stmt->execute([$name,$desc,$price, $instock, $category, $img_name]);
 
      if($result) {
        echo "<script> alert('Successfully added!'); window.location.href='index.php'; </script>";
      }
    }
  
}


?>


<?php include "template/header.php"; ?>



      <div class="row mb-2">
        <!-- table here  -->
        
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Add New Product</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data" >
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                      <label for="">Name</label>
                      <input type="text" class="form-control <?php echo $nameErr ? 'is-invalid' : null; ?>" name="name">
                      <?php echo $nameErr; ?>
                  </div>
                  <div class="form-group">
                      <label for="">Description</label>
                      <textarea name="desc" id="" cols="30" rows="4" class="form-control <?php echo $descErr ? 'is-invalid' : null; ?>"></textarea>
                      <?php echo $descErr; ?>
                  </div>
                  <div class="form-group">
                      <label for="">Pirce</label>
                      <input type="number" class="form-control <?php echo $priceErr ? 'is-invalid' : null; ?>" name="price">
                      <?php echo $priceErr; ?>
                  </div>
                  <div class="form-group">
                      <label for="">Category</label>
                      <?php 
                        $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                      ?>

                      <select name="category" id="" class="form-control">
                        <option value="">Select Category</option>
                        <?php foreach($result as $cat): ?>
                          <option value="<?php echo $cat['id'] ?>"><?php echo $cat['name']; ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?php echo $catErr; ?>
                  </div>
                  <div class="form-group">
                      <label for="">In Stock</label>
                      <input type="number" class="form-control <?php echo $instockErr ? 'is-invalid' : null; ?>" name="instock">
                      <?php echo $instockErr; ?>
                  </div>
                  <div class="form-group">
                      <label for="">Image</label>
                      <input type="file" class="form-control <?php echo $imgErr ? 'is-invalid' : null; ?>" name="img">
                      <?php echo $imgErr; ?>
                  </div>
                  <div class="form-group">
                      <button type="submit" name="submit" class="btn btn-primary">Create</button>
                      <a href="index.php" class="btn btn-warning">Back</a>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>


<?php include "template/footer.php"; ?>
  