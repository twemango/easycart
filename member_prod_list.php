<?php include_once("include/header.php"); ?>

<div class="row">
  <div class="col-3" style="padding:20px">
    <?php include_once("include/member_menu.php"); ?>
  </div>
  <div class="col-9" style="padding:20px">
    <h5 style="margin-bottom:20px"><b>會員-商品</b></h5>

    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">商品名稱</th>
          <th scope="col">建立日期</th>
          <th scope="col">修改日期</th>
          <th scope="col">管理</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>商品1</td>
          <td>2021-10-11 19:27:14</td>
          <td>2021-10-15 19:27:14</td>
          <td><a href="member_prod_add.php">新增</a> <a href="member_prod_edit.php">編輯</a> <a href="#">刪除</a></td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>商品1</td>
          <td>2021-10-11 19:27:14</td>
          <td>2021-10-15 19:27:14</td>
          <td><a href="member_prod_add.php">新增</a> <a href="member_prod_edit.php">編輯</a> <a href="#">刪除</a></td>
        </tr>    <tr>
          <th scope="row">3</th>
          <td>商品1</td>
          <td>2021-10-11 19:27:14</td>
          <td>2021-10-15 19:27:14</td>
          <td><a href="member_prod_add.php">新增</a> <a href="member_prod_edit.php">編輯</a> <a href="#">刪除</a></td>
        </tr>

      </tbody>
    </table>

  </div>
</div>




<?php include_once("include/footer.php"); ?>