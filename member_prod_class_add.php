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

if (isset($_POST['category_name'])) {
    $category_name = $_POST['category_name'];
} else {
    $category_name = '';
}

if (isset($_POST['category_display'])) {
    $category_display = ($_POST['category_display']=='0')?'0':'1';
} else {
    $category_display = '1';
}

$error = False;
$error_text = '';

if (!empty($category_name)) {
    if (!(mb_strlen($category_name, "utf-8")>=1 && mb_strlen($category_name, "utf-8")<=20)) {
        $error = True;
        $error_text = '分類長度必須為1~20字元之間';
    }

    if (!$error) {
        $product = new Product();
        $product->addCategory(array(
            "member_id"=>$member_id,
            "name"=>$category_name,
            "display"=>$category_display
        ));
        header("Location: member_prod_class_list.php");
    }
}
?>

<?php include_once("include/header.php"); ?>

<div class="row">
  <div class="col-3" style="padding:20px">
    <?php include_once("include/member_menu.php"); ?>
  </div>
  <div class="col-9" style="padding:20px">
    <h5 style="margin-bottom:20px"><b>會員-商品分類</b></h5>
    
    <form action='member_prod_class_add.php' method="post">
      <?php if ($error) { ?>
      <div class="alert alert-danger" role="alert">
          <?php echo $error_text; ?>
      </div>
      <?php } ?>
    
      <div class="form-group">
        <label>分類名稱</label>
        <input type="text" class="form-control" name="category_name">
      </div>
      <div class="form-group">
        <label>顯示</label>
        <select class="form-control" name="category_display">
          <option value="0">不顯示</option>
          <option value="1" selected>顯示</option>
        </select>
      </div>
    
      <div class="container">
        <div class="row">
          <div class="col"><input style="margin:20px 0 20px 0" class="btn btn-primary" type="button" value="返回" onclick="window.history.back();"></div>
          <div class="col"><input style="margin:20px 0 20px 0" class="btn btn-primary float-right" type="submit" value="送出"></div>
        </div>
      </div>
    </form>

  </div>
</div>

<?php include_once("include/footer.php"); ?>