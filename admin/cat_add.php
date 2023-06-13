<?php
  session_start();

  require "../config/config.php";
  require "../config/common.php";

  if($_SESSION['user']['role'] != 1) {
    echo "<script> alert('You cant have access to this page!');window.location.href='login.php'; </script>
    ";
  }



  
  $nameErr = $descErr = "";

  if(isset($_POST['submit'])){
    
    if(empty($_POST['name'])) {
        $nameErr = "<p class='text-danger'>Title is empty </p>";
    }else {
      $name = filter_input(INPUT_POST,'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if(empty($_POST['desc'])) {
        $descErr = "<p class='text-danger'>Description is empty </p>";
    }else {
      $desc = filter_input(INPUT_POST,'desc', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if(empty($nameErr) && empty($descErr)) {

      $sql = "INSERT INTO categories(name, description) VALUES (?,?)";
      $stmt = $pdo->prepare($sql);
      $result = $stmt->execute([$name,$desc]);

      if($result) {
        echo "<script> alert('New Category added!'); window.location.href='cat.php'; </script>";
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
              <h3 class="card-title">Add A New Post</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="" method="post">
                    <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                    <div class="form-group">
                        <label for="">Category Name</label>
                        <input type="text" class="form-control <?php echo $nameErr ? 'is-invalid' : null; ?>" placeholder="Category Name" name="name">
                        <?php echo $nameErr ?>
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="desc" id="" cols="30" rows="10" placeholder="Leave a description.." class="form-control <?php echo $descErr ? 'is-invalid' : null; ?>"></textarea>
                        <?php echo $descErr ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-success">Create</button>
                        <a href="cat.php" class="btn btn-warning">Back</a>
                    </div>
                </form>
            </div>
          </div>
        </div>


<?php include "template/footer.php"; ?>
  