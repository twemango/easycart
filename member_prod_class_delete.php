<?php
include_once("include/session.php");
include_once("function/common.php");
include_once("class/product.php");
include_once("class/member.php");

if (!isset($_SESSION['mid'])) {
    header("Location: login.php");
    exit();
}
$member_id = $_SESSION['mid'];

if (isset($_GET['category_id'])) {
    $product = new Product();
    $product->deleteCategory($_GET['category_id'], $member_id);
    header("Location: member_prod_class_list.php");
} else {
    echo 'category_id 未輸入';
}
?>