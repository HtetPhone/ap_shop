<?php
  session_start();

  require "../config/config.php";
  require "../config/common.php";

  // print_r($_SESSION['user']['role']);
  if($_SESSION['user']['role'] != 1) {
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
          <a href="cat_add.php" class="btn btn-primary">Add New Category</a>
        </div>
        <!-- table here  -->
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Categories</h3>
            </div>

            <div class="card-body">
                <?php
                    //retrieving data 
                    $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
                    $stmt->execute();
                    $cats = $stmt->fetchAll();
                    // print_r($cats); exit();
  
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
  
                      $totalPage = ceil(count($cats) / $numberOfrecs); //chopping down the posts into pages
  
                      $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC LIMIT $offset, $numberOfrecs");
                      $stmt->execute();
                      $pages = $stmt->fetchAll();
                      // for pagination 
                    }else {
                      // when u search 
                      $searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
                      $stmt = $pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
                      // print_r($stmt); exit();
                      $stmt->execute();
                      $cats = $stmt->fetchAll();
  
                      // for pagination 
                      if(!empty($_GET['pageno'])) {
                        $pageNo = $_GET['pageno'];
                      }else {
                        $pageNo = 1;
                      }
                      $numberOfrecs = 4; //two show
                      $offset = ($pageNo - 1) * $numberOfrecs;
  
                      $totalPage = ceil(count($cats) / $numberOfrecs); //chopping down the categories into pages
  
                      $stmt = $pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset, $numberOfrecs");                                  //right here % is very important
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
                        <th scope="col">Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pages as $key=>$cat): ?>
                        <tr>
                            <th scope="row"><?php echo $key + 1; ?></th>
                            <td><?php echo escape($cat['name']) ?></td>
                            <td><?php echo escape($cat['description']) ?></td>
                            <td class="w-25">
                                <a href="cat_edit.php?id=<?php echo $cat['id'] ?>" class="btn btn-warning">Edit</a>
                                <a href="cat_del.php?id=<?php echo $cat['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- pagination  -->
                  <br>
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


<?php include "template/footer.php"; ?>
  