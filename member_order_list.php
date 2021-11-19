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
        <tr>
          <th scope="row">1</th>
          <td>order001</td>
          <td>$8000</td>
          <td>2021-10-11 19:27:14</td>
          <td><a href="member_order_detail.php">訂單明細</a></td>
        </tr>

        <tr>
          <th scope="row">2</th>
          <td>order001</td>
          <td>$8000</td>
          <td>2021-10-11 19:27:14</td>
          <td><a href="member_order_detail.php">訂單明細</a></td>
        </tr>

        <tr>
          <th scope="row">3</th>
          <td>order001</td>
          <td>$8000</td>
          <td>2021-10-11 19:27:14</td>
          <td><a href="member_order_detail.php">訂單明細</a></td>
        </tr>

      </tbody>
    </table>

  </div>
</div>




<?php include_once("include/footer.php"); ?>