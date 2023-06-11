<?php
  session_start();

  require "../config/config.php";
  require "../config/common.php";

  // print_r($_SESSION['user']['role']);
  if(isset($_SESSION['user'])) {
    if($_SESSION['user']['role'] != 1) {
      echo "<script> alert('You cant have access to this page!');window.location.href='login.php'; </script>
      ";
    }
  }else {
    echo "<script> alert('You cant have access to this page!');window.location.href='login.php'; </script>
      ";
  }

  if(isset($_POST['search'])){
    setcookie('search', $_POST['search'], time() + (86400 * 3), "/");
    // echo $_COOKIE['search'];
    // exit();
  }else {
    if(empty($_GET['pageno'])){
      unset($_COOKIE['search']); 
      setcookie('search', null, -1, '/'); 
    }
  }

?>

<?php include "template/header.php"; ?>



      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Admin Panel</h1>
        </div>  
        <div class="col-12 my-4">
          <a href="add.php" class="btn btn-primary">Add New Product</a>
        </div>
        <!-- table here  -->
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Products</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <?php
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

                    $totalPage = ceil(count($products) / $numberOfrecs); //chopping down the posts into pages

                    $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT $offset, $numberOfrecs");
                    $stmt->execute();
                    $pages = $stmt->fetchAll();
                    // for pagination 
                  }else {
                    // when u search 
                    $searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
                    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
                    // print_r($stmt); exit();
                    $stmt->execute();
                    $products = $stmt->fetchAll();

                    // for pagination 
                    if(!empty($_GET['pageno'])) {
                      $pageNo = $_GET['pageno'];
                    }else {
                      $pageNo = 1;
                    }
                    $numberOfrecs = 4; //two show
                    $offset = ($pageNo - 1) * $numberOfrecs;

                    $totalPage = ceil(count($products) / $numberOfrecs); //chopping down the products into pages

                    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset, $numberOfrecs");                                  //right here % is very important
                    $stmt->execute();
                    $pages = $stmt->fetchAll();
                  }
                ?>
              <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">In Stock</th>
                    <th scope="col">Category</th>
                    <th class="w-25" scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($pages as $key=>$value): ?>
                    <tr>
                      <td><?php echo $key + 1; ?></td>
                      <td><?php echo escape($value['name']) ?></td>
                      <td><?php echo escape($value['description']) ?></td> 
                      <td><?php echo escape($value['price']) ?></td> 
                      <td><?php echo escape($value['quantity']) ?></td> 
                      <?php
                        if($value['category_id'] == 1){
                          $categoryName = 'Shoes';
                        }elseif($value['category_id'] == 2) {
                          $categoryName = 'Bikes';
                        }elseif($value['category_id'] == 4){
                          $categoryName = 'Phones';
                        }
                       ?>
                      <td><?php echo escape($categoryName); ?></td>   
                      <td>
                        <a href="edit.php?id=<?php echo $value['id'] ?>" class="btn btn-warning">Edit</a>
                        <a href="delete.php?id=<?php echo $value['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item')">Delete</a>
                      </td> 
                    </tr>
                  <?php endforeach; ?>
                    
                </tbody>
              </table>
              <div class="col-12 mt-3 p-0">
                <!-- pagination  -->
                <nav aria-label="Page navigation example" class="float-right">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageNo <=1){ echo "disabled";} ?>">
                      <a class="page-link" href="<?php if($pageNo <= 1) { echo "#";} else { echo "?pageno=".($pageNo - 1);} ?>">Prev</a>
                    </li>
                    <li class="page-item"><a class="page-link" href=""><?php echo $pageNo; ?></a>
                    </li>
                    <li class="page-item <?php if($pageNo >= $totalPage) { echo "disabled";}?>">
                      <a class="page-link" href="<?php if($pageNo >= $totalPage) { echo "#";} else { echo "?pageno=".($pageNo + 1);} ?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $totalPage?>">Last</a></li>
                  </ul>
                </nav>
              </div>
              
          </div>
        </div>
      </div>


<?php include "template/footer.php"; ?>
  