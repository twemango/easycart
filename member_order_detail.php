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
        <tr>
          <th scope="row">1</th>
          <td>pro_x</td>
          <td>5</td>
          <td>1000</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>pro_x</td>
          <td>5</td>
          <td>1000</td>
        </tr>    
        <tr>
          <th scope="row">3</th>
          <td>pro_x</td>
          <td>5</td>
          <td>1000</td>
        </tr>

      </tbody>
    </table>

    <input style="margin:20px 0 20px 0" class="btn btn-primary" type="button" value="返回" onclick="window.history.back();">

  </div>
</div>




<?php include_once("include/footer.php"); ?>