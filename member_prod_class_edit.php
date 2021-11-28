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

function displayRequest($name, $data=null) {
    if (isset($_REQUEST[$name])) {
        return display($_REQUEST[$name]);
    } else {
        if (isset($data) && isset($data[$name])) {
            return display($data[$name]);
        } else {
            return "";
        }
    }
}

function selected($name, $value, $data=null) {
    if (isset($_REQUEST[$name])) {
        return $_REQUEST[$name]==$value?' selected ':'';
    } else {
        if (isset($data) && isset($data[$name])) {
            return $data[$name]==$value?' selected ':'';
        } else {
            return "";
        }
    }
}

function getRequest($name) {
    if (isset($_REQUEST[$name])) {
        return $_REQUEST[$name];
    } else {
        return "";
    }
}


function checkRequestLength($field_name, $min_len, $max_len) {
    $value = getRequest($field_name);
    if (!(mb_strlen($value, "utf-8")>=$min_len && mb_strlen($value, "utf-8")<=$max_len)) {
        return $field_name .' 字數不正確';
    }
    return '';
}


$error = False;
$error_text = '';

$category_id = getRequest('category_id');
$category = null;

if (empty($category_id)) {
    $error = True;
    $error_text = 'category_id 未設定';
} else {
    $product = new Product();
    if (isset($_REQUEST['name'])) {
        $category_id = getRequest('category_id');
        
        $error_text = checkRequestLength('name', 1, 20);

        if (empty($error_text)) {
            $product->editCategory($category_id, array(
                "member_id"=>$member_id,
                "name"=>getRequest('name'),
                "display"=>((getRequest('display')=='0')?'0':'1')
            ));
            header("Location: member_prod_class_list.php");
        }
    }
    $category = $product->getCategoryById($category_id);
}
?>

<?php include_once("include/header.php"); ?>

<div class="row">
  <div class="col-3" style="padding:20px">
    <?php include_once("include/member_menu.php"); ?>
  </div>
  <div class="col-9" style="padding:20px">
    <h5 style="margin-bottom:20px"><b>會員-商品分類</b></h5>
    
    <form action='member_prod_class_edit.php' method="post">
      <?php if (!empty($error_text)) { ?>
      <div class="alert alert-danger" role="alert">
          <?php echo $error_text; ?>
      </div>
      <?php } ?>
    
      <div class="form-group">
        <label>分類名稱</label>
        <input type="text" class="form-control" name="name" value="<?php echo displayRequest('name', $category); ?>">
      </div>
      <div class="form-group">
        <label>顯示</label>
        <select class="form-control" name="display">
          <option value="1" <?php echo selected('display', '1', $category); ?>>顯示</option>
          <option value="0" <?php echo selected('display', '0', $category); ?>>不顯示</option>
        </select>
      </div>
    
      <div class="container">
        <div class="row">
          <div class="col"><input style="margin:20px 0 20px 0" class="btn btn-primary" type="button" value="返回" onclick="window.history.back();"></div>
          <div class="col"><input style="margin:20px 0 20px 0" class="btn btn-primary float-right" type="submit" value="送出"></div>
        </div>
      </div>

      <input style="display:none" type="hidden" name="category_id" value="<?php echo display($category_id); ?>" />

    </form>

  </div>
</div>

<?php include_once("include/footer.php"); ?>