<?php 
include_once("include/session.php");
include_once("function/common.php");
include_once("class/order.php");

if (!isset($_SESSION['mid'])) {
  header("Location: login.php");
}

$order = new Order();
$orders = $order->getOrderByMemberId($_SESSION['mid']);
?>
<?php include_once("include/header.php"); ?>
<div class="row">
  <div class="col-3" style="padding:20px">
    <?php include_once("include/member_menu.php"); ?>
  </div>
  <div class="col-9" style="padding:20px">
    <h5 style="margin-bottom:20px"><b>會員-訂單</b></h5>
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">訂單編號</th>
          <th scope="col">訂單金額</th>
          <th scope="col">建立日期</th>
          <th scope="col">檢視</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $key => $val) { ++$key ?>
        <tr>
          <th scope="row"><?php echo $key; ?></th>
          <td><?php echo display($val['order_No']); ?></td>
          <td><?php echo display($val['amount']); ?></td>
          <td><?php echo $val['createDate']; ?></td>
          <td><a href="member_order_detail.php?id=<?php echo $val['id']; ?>">訂單明細</a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php include_once("include/footer.php"); ?>