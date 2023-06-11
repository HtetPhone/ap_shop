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


?>

<?php include "template/header.php"; ?>



      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Admin Panel</h1>
        </div>  
        <div class="col-12 my-2">
        </div>
        <!-- table here  -->
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Order Detials</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="mb-2 col-1 p-0">
                <a href="order_list.php" class="btn btn-warning btn-block"><i class="fas fa-search fa-table"></i> Back</a>
              </div>
              <?php
                  //retrieving data 
                  $stmt = $pdo->prepare("SELECT * FROM sale_order_detail ORDER BY id DESC");
                  $stmt->execute();
                  $orderDetail = $stmt->fetchAll();
                 
                  // for pagination 
                  if(!empty($_GET['pageno'])) {
                    $pageNo = $_GET['pageno'];
                  }else {
                    $pageNo = 1;
                  }
                  $numberOfrecs = 5; //to show
                  $offset = ($pageNo - 1) * $numberOfrecs;

                  $totalPage = ceil(count($orderDetail) / $numberOfrecs); //chopping down the posts into pages

                  $stmt = $pdo->prepare("SELECT * FROM sale_order_detail ORDER BY id DESC LIMIT $offset, $numberOfrecs");
                  $stmt->execute();
                  $pages = $stmt->fetchAll();
                ?>
              <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Order Date</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($pages as $key=>$value): ?>
                    <?php 
                        $pStmt = $pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                        $pStmt->execute();
                        $pResult = $pStmt->fetch();
                        // echo "<pre>";
                        // print_r($pResult); exit();   
                    ?>
                    <tr>
                      <td><?php echo $key + 1; ?></td>
                      <td><?php echo escape($pResult['name']) ?></td> 
                      <td><?php echo escape($value['quantity']) ?></td> 
                      <td><?php echo date("Y-m-d",strtotime(escape($value['order_date']))) ?></td> 
                  
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>


<?php include "template/footer.php"; ?>
  