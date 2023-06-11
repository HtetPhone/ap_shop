<?php
  session_start();

  require "../config/config.php";
  require "../config/common.php";

  if($_SESSION['user']['role'] != 1) {
    echo "<script> alert('You cant have access to this page!');window.location.href='login.php'; </script>
    ";
  }
   
  /* retrieving data from database */
  if($_GET['id']) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = $id");
    $stmt->execute();
    $result = $stmt->fetch();
    // print_r($result);
  }


  /*  Updating the dat */
  $nameErr = $descErr = $priceErr = $instockErr = $imgErr = $catErr = "";
  if(isset($_POST['submit'])) {

    if(empty($_POST['name'])) {
        $nameErr = '<p class="text-danger"> name is empty </p>';
    }else {
      $name = filter_input(INPUT_POST,'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if(empty($_POST['desc'])) {
        $descErr = '<p class="text-danger"> description is empty </p>';
    }else {
      $desc = filter_input(INPUT_POST,'desc', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    if(empty($_POST['price'])) {
      $priceErr = '<p class="text-danger"> price is empty </p>';
    }else {
      $price = filter_input(INPUT_POST,'price', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    if(empty($_POST['category'])) {
      $catErr = "<p class='text-danger'>Please select a category </p>";
    } else {
      $category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    if(empty($_POST['instock'])) {
      $instockErr = '<p class="text-danger"> instock number is empty </p>';
    }else {
      $instock = filter_input(INPUT_POST,'instock', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

      
    if(empty($nameErr) && empty($descErr) && empty($priceErr) && empty($instockErr) && empty($catErr) ) {
      $id = $_POST['id'];
      if($_FILES['img']['name']) {
        // image 
        $dir = "img/";
        $img_name = $_FILES['img']['name'];
        $tmp_name = $_FILES['img']['tmp_name'];
        move_uploaded_file($tmp_name, $dir.$img_name);

        $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, price =?, quantity = ?, category_id=?, image=?  WHERE id='$id' ");
        $result = $stmt->execute([$name,$desc,$price,$instock,$category,$img_name]);
        if($result) {
          echo "<script> alert('Successfully Updated!'); window.location.href='index.php'; </script>";
        }
      }else {
        $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, price =?, quantity =?, category_id=?  WHERE id='$id' ");
        $result = $stmt->execute([$name,$desc,$price,$instock,$category]);
        if($result) {
          echo "<script> alert('Successfully Updated!'); window.location.href='index.php'; </script>";
        }
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
              <h3 class="card-title">Upate Your Post</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data" >
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                      <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                      <label for="">Name</label>
                      <input type="text" class="form-control <?php echo $nameErr ? 'is-invalid' : null; ?>" value="<?php echo escape($result['name'])?>" name="name">
                      <?php echo $nameErr; ?>
                  </div>
                  <div class="form-group">
                      <label for="">Description</label>
                      <textarea name="desc" id="" cols="30" rows="4 " class="form-control <?php echo $descErr ? 'is-invalid' : null; ?>"><?php echo escape($result['description']) ;?></textarea>
                      <?php echo $descErr; ?>
                  </div>
                  <div class="form-group">
                      <label for="">Pirce</label>
                      <input type="text" class="form-control <?php echo $priceErr ? 'is-invalid' : null; ?>" value="<?php echo escape($result['price'])?>" name="price">
                      <?php echo $priceErr; ?>
                  </div>
                  <div class="form-group">
                      <label for="">Category</label>
                      <?php 
                        $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
                        $stmt->execute();
                        $catResult = $stmt->fetchAll();
                      ?>

                      <select name="category" class="form-control">
                        <option value="">Select Category</option>
                        <?php foreach($catResult as $cat): ?>

                          <option <?php echo $result['category_id']==$cat['id'] ? 'selected' : null ; ?> value="<?php echo $cat['id'] ?>" ><?php echo $cat['name']; ?></option>
                        <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="">In Stock</label>
                      <input type="text" class="form-control <?php echo $instockErr ? 'is-invalid' : null; ?>" value="<?php echo escape($result['quantity'])?>" name="instock">
                      <?php echo $instockErr; ?>
                  </div>
                  <div class="form-group">
                      <label for="">Image</label> <br>
                      <img src="img/<?php echo $result['image'] ?>"> <br> <br>
                      <input type="file" class="form-control <?php echo $imgErr ? 'is-invalid' : null; ?>" name="img">
                      <?php echo $imgErr; ?>
                  </div>
                  <div class="form-group">
                      <button type="submit" name="submit" class="btn btn-success">Update</button>
                      <a href="index.php" class="btn btn-warning">Back</a>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>


<?php include "template/footer.php"; ?>
  