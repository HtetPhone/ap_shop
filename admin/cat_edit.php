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

    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = $id");
    $stmt->execute();
    $result = $stmt->fetch();
  }

  $nameErr = $descErr = "";
  /*  Updating the dat */
  if(isset($_POST['submit'])) {
    $id = $_POST['id'];

    if(empty($_POST['name'])) {
      $nameErr = "<p class='text-danger'>Category is empty </p>";
    }else {
      $name = filter_input(INPUT_POST,'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if(empty($_POST['desc'])) {
        $descErr = "<p class='text-danger'>Description is empty </p>";
    }else {
      $desc = filter_input(INPUT_POST,'desc', FILTER_SANITIZE_SPECIAL_CHARS);
    }

    if(empty($nameErr) && empty($descErr)) {
        $id = $_POST['id'];
  
        $stmt = $pdo->prepare("UPDATE categories SET name='$name', description='$desc' WHERE id='$id' ");
        $result = $stmt->execute();
        if($result) {
            echo "<script> alert('Successfully Updated!'); window.location.href='cat.php'; </script>";
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
              <h3 class="card-title">Upate Category</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="cat_edit.php?id=<?php echo $_GET['id'];?>" method="post">
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                      <input type="hidden" name="id" value="<?php echo escape( $_GET['id']) ?>">
                      <label for="">Category Name</label>
                      <input type="text" class="form-control <?php echo $nameErr ? 'is-invalid' : null; ?>" value="<?php echo escape($result['name'])?>" name="name">
                      <?php echo $nameErr; ?>
                  </div>
                  <div class="form-group">
                      <label for="">Description</label>
                      <input type="text" class="form-control <?php echo $descErr ? 'is-invalid' : null; ?>" value="<?php echo escape($result['description'])?>" name="desc">
                      <?php echo $descErr; ?>
                  </div>
                  <div class="form-group">
                      <button type="submit" name="submit" class="btn btn-success">Update</button>
                      <a href="cat.php" class="btn btn-warning">Back</a>
                  </div>
                </form>
            </div>
          </div>
        </div>


<?php include "template/footer.php"; ?>
  