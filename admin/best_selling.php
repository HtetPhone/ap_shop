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
              <h3 class="card-title font-weight-bold text-orange">Best Selling Items</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <?php
                  //retrieving data 
                  $stmt = $pdo->prepare("SELECT * FROM `sale_order_detail` GROUP BY product_id HAVING SUM(quantity) > 2");
                  $stmt->execute();
                  $result = $stmt->fetchAll();
                  // echo "<pre>";print_r($result); exit();
                ?>

              <table id="dTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($result as $key=>$value): ?>
                    <?php 
                        // print_r($value); exit();
                            $prodId = $value['product_id'];
                            $prod = $pdo->prepare("SELECT * FROM products WHERE id=?");
                            $prod->execute([$prodId]);
                            $prodResult = $prod->fetch();
                        ?>
                    <tr>
                      <td><?php echo $key + 1; ?></td>
                      <td><?php echo escape($prodResult['name']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                    
                </tbody>
              </table>
              
          </div>
        </div>
      </div>


<?php include "template/footer.php"; ?>
  