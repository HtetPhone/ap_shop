<?php 
    session_start();

    include "config/config.php";
    include "config/common.php";
?>

    <?php include "header.php"?>
    <!--================Cart Area =================-->
    <section class="cart_area mt-5">
        <div class="container">
            <div class="cart_inner">
                
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <!-- retrieve items thru session -->
                        <?php 
                            if(isset($_SESSION['cart'])):
                        ?>
                        <?php 
                            $cart_items = $_SESSION['cart'];
                            $total = 0;
                            foreach($cart_items as $key => $val): {
                                $id= str_replace('id','',$key);
                                $qty = $val;
                                
                                $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
                                $stmt->execute();
                                $result= $stmt->fetch();
                                $total += $result['price'] * $qty;
                            }
                        ?>
                        <!-- retrieve items thru session -->

                            <tbody class="">
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="admin/img/<?php echo escape($result['image']) ?>" alt="" width="150">
                                            <p class= "mx-3"> <?php echo escape($result['name']) ?></p>
                                        </div>
                                    </td>
                                    <td>
                                        <h5><?php echo escape($result['price']) ?> MMK</h5>
                                    </td>
                                    <td>
                                        <div class="product_count">
                                            <input type="text"  value="<?php echo escape($qty) ?>" title="Quantity:" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <h5><?php echo escape($result['price'] * $qty) ?> MMK</h5>
                                    </td>
                                    <td>
                                        <a href="clear_item.php?id=<?php echo $result['id']?>" class="btn btn-outline-warning px-4">Clear</a>
                                    </td>
                                
                            </tbody>
                            <?php endforeach;?>
                 
                            </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <h5>Subtotal</h5>
                                    </td>
                                    <td>
                                        <h5><?php echo escape($total); ?> MMK</h5>
                                    </td>
                                </tr>
                             <?php endif;?>
                                <tr class="out_button_area">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="checkout_btn_inner d-flex align-items-center justify-content-end">
                                            <a class="primary-btn" href="clearall.php">Clear All</a>
                                            <a class="gray_btn" href="index.php">Continue Shopping</a>
                                            <a class="primary-btn" href="#">Proceed to checkout</a>
                                        </div>
                                    </td>
                                </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

    <!-- start footer Area -->
   <?php include "footer.php" ?>