<?php 
$path = $_SERVER['PHP_SELF'];
$a = $b = $c = '';
if (strstr($path,"member_order_list")) {
  $a = 'active';
} elseif (strstr($path,"member_prod_class_list")) {
  $b = 'active';
} elseif (strstr($path,"member_prod_list")) {
  $c = 'active';
} 
?>
<div class="list-group">
  <a href="member_order_list.php" class="list-group-item list-group-item-action <?php echo $a; ?>">會員-訂單</a>
  <a href="member_prod_class_list.php" class="list-group-item list-group-item-action <?php echo $b; ?>">會員-商品分類</a>
  <a href="member_prod_list.php" class="list-group-item list-group-item-action <?php echo $c; ?>">會員-商品</a>
</div>