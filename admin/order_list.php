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
              <h3 class="card-title">Orders</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <?php
                  //retrieving data 
                  $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC");
                  $stmt->execute();
                  $orders = $stmt->fetchAll();
                 
                  // for pagination 
                  if(!empty($_GET['pageno'])) {
                    $pageNo = $_GET['pageno'];
                  }else {
                    $pageNo = 1;
                  }
                  $numberOfrecs = 5; //to show
                  $offset = ($pageNo - 1) * $numberOfrecs;

                  $totalPage = ceil(count($orders) / $numberOfrecs); //chopping down the posts into pages

                  $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC LIMIT $offset, $numberOfrecs");
                  $stmt->execute();
                  $pages = $stmt->fetchAll();
                ?>
              <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Order Date</th>
                    <th class="w-25" scope="col">Check</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($pages as $key=>$value): ?>
                    <?php 
                        $userStmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['customer_id']);
                        $userStmt->execute();
                        $userResult = $userStmt->fetch();
                        // echo "<pre>";
                        // print_r($userResult); exit();   
                    ?>
                    <tr>
                      <td><?php echo $key + 1; ?></td>
                      <td><?php echo escape($userResult['name']) ?></td> 
                      <td><?php echo escape($value['total_price']) ?></td> 
                      <td><?php echo escape(date("Y-m-d",strtotime($value['order_date'])) )?></td> 
                      <td>
                        <a href="order_detail.php?id=<?php echo $value['id'] ?>" class="btn btn-default">View</a>
                        
                      </td> 
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>


<?php include "template/footer.php"; ?>
  