<?php include_once("include/header.php"); ?>

<div class="row">
  <div class="col-3" style="padding:20px">
    <?php include_once("include/member_menu.php"); ?>
  </div>
  <div class="col-9" style="padding:20px">
    <h5 style="margin-bottom:20px"><b>會員-商品分類</b></h5>
    
    <form>
      <div class="form-group">
        <label for="exampleFormControlSelect1">選擇商品分類</label>
        <select class="form-control" id="exampleFormControlSelect1">
          <option>商品分類1</option>
          <option>商品分類2</option>
          <option>商品分類3</option>
          <option>商品分類4</option>
          <option>商品分類5</option>
        </select>
      </div>
    
      <div class="container">
        <div class="row">
          <div class="col"><input style="margin:20px 0 20px 0" class="btn btn-primary" type="button" value="返回" onclick="window.history.back();"></div>
          <div class="col"><input style="margin:20px 0 20px 0" class="btn btn-primary float-right" type="button" value="送出"></div>
        </div>
      </div>
    </form>

  </div>
</div>

<?php include_once("include/footer.php"); ?>