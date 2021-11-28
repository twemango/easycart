<?php
include_once("include/session.php");
include_once("function/common.php");
include_once("class/product.php");
include_once("class/member.php");

if (!isset($_SESSION['mid'])) {
    header("Location: login.php");
    exit();
}
$product_id = $_SESSION['mid'];

if (isset($_REQUEST['product_id'])) {
    $product_repository = new Product();
    $product_repository->deleteProduct($_REQUEST['product_id'], $product_id);
    header("Location: member_prod_list.php");
} else {
    echo 'product_id 未輸入';
}
?>