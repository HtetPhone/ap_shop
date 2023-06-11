<?php
    session_start();
    include 'config/config.php';

    if(isset($_POST)) {
        $id = $_POST['id'];
        $qty = $_POST['qty'];

        //retrieving data to check the amount
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
        $stmt->execute();
        $result = $stmt->fetch();

        if($qty > $result['quantity']) {
           echo "<script> alert('out of stock!!'); window.location.href='product_detail.php?id=$id'; </script>";
        }else {
            if($_SESSION['cart']['id'.$id]) {
                $_SESSION['cart']['id'.$id] += $qty;
            }else {
                $_SESSION['cart']['id'.$id] = $qty;
            }
    
            header("Location: cart.php");
        }
        
    }