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
        <!-- table here  -->
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title font-weight-bold text-orange">Weekly Report</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <?php
                  //retrieving data 
                  $currentDate = date("Y-m-d");
                  $startingDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                  $past7Date = date('Y-m-d', strtotime($currentDate . ' -7 day'));
                //   print_r($past7Date); exit();
                  $stmt = $pdo->prepare("SELECT * FROM sale_orders WHERE order_date < ? AND order_date >= ? ORDER BY id DESC");
                  $stmt->execute([$startingDate, $past7Date]);
                  $result = $stmt->fetchAll();
                //   echo "<pre>";
                //   print_r($result); exit();
                ?>
              <table id="dTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Order Ddate</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($result as $key=>$value): ?>
                    <?php 
                            $cusId = $value['customer_id'];
                            $cus = $pdo->prepare("SELECT * FROM users WHERE id=?");
                            $cus->execute([$cusId]);
                            $cusResult = $cus->fetch();
                        ?>
                    <tr>
                      <td><?php echo $key + 1; ?></td>
                      <td><?php echo escape($cusResult['name']) ?></td>
                      <td><?php echo escape($value['total_price']) ?> MMK</td> 
                      <td><?php echo escape(date('Y-m-d', strtotime($value['order_date']))) ?></td> 
                    </tr>
                  <?php endforeach; ?>
                    
                </tbody>
              </table>
              
          </div>
        </div>
      </div>


<?php include "template/footer.php"; ?>
  