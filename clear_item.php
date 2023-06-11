<?php
    session_start();
    $id = $_GET['id'];

    unset($_SESSION['cart']['id'.$id]);

    header('Location: cart.php');