<?php 
include_once("include/session.php");
include_once("function/common.php");
include_once("class/order.php");
include_once("class/product.php");

if (!isset($_SESSION['mid'])) {
  header("Location: login.php");
}

$order = new Order();
$product = new Product();
$order_details = $order->getOrderDetailByOrderId($_SESSION['mid'], $_GET['id']);
?>
<?php include_once("include/header.php"); ?>
<div class="row">
  <div class="col-3" style="padding:20px">
    <?php include_once("include/member_menu.php"); ?>
  </div>
  <div class="col-9" style="padding:20px">
    <h5 style="margin-bottom:20px"><b>會員-訂單明細</b></h5>
    
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">商品名稱</th>
          <th scope="col">數量</th>
          <th scope="col">金額</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          foreach ($order_details as $key => $val) { 
          $product_data = $product->getProduct($val['commodity_id']);
          ++$key;
        ?>
        <tr>
          <th scope="row"><?php echo $key; ?></th>
          <td><?php echo display($product_data['shop_name']); ?></td>
          <td><?php echo display($val['qty']); ?></td>
          <td><?php echo display($val['price']); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <input style="margin:20px 0 20px 0" class="btn btn-primary" type="button" value="返回" onclick="window.history.back();">
  </div>
</div>
<?php include_once("include/footer.php"); ?>