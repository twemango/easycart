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

function checked($name, $value, $data=null, $default=false) {
    if (isset($_REQUEST[$name])) {
        return $_REQUEST[$name]==$value?' checked ':'';
    } else {
        if (isset($data) && isset($data[$name])) {
            return $data[$name]==$value?' checked ':'';
        } else {
            return $default?' checked ':'';
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
        return $field_name .' 字數不正確<br>';
    }
    return '';
}

function checkRequestIntRange($field_name, $min, $max) {
    $value = intval(getRequest($field_name));
    if (!($value>=$min && $value<=$max)) {
        return $field_name .' 數值範圍錯誤<br>';
    }
    return '';
}

function checkRequestFloatRange($field_name, $min, $max) {
    $value = floatval(getRequest($field_name));
    if (!($value>=$min && $value<$max)) {
        return $field_name .' 數值範圍錯誤<br>';
    }
    return '';
}

function checkRequestSet($field_name, $set) {
    $value = getRequest($field_name);
    if (!in_array($value, $set)) {
        return $field_name .' 欄位值不正確<br>';
    }
    return '';
}


$error = False;
$error_text = '';

$product_id = getRequest('product_id');
$pro = null;

$product = new Product();

if (isset($_REQUEST['shop_name'])) {
    
    $error_text = checkRequestLength('shop_name', 1, 20);
    $error_text .= checkRequestSet('shop_spec_mode', array("0", "1"));
    $error_text .= checkRequestFloatRange('shop_price', 0, 10000000);
    $error_text .= checkRequestIntRange('shop_stock', 0, 10000000);
    $error_text .= checkRequestIntRange('category_id', 0, 10000000);
    $error_text .= checkRequestSet('shop_display', array("0", "1"));

    if (empty($error_text)) {
        $new_data = array(
            "member_id"=>$member_id,
            "shop_name"=>getRequest('shop_name'),
            "shop_spec_mode"=>intval(getRequest('shop_spec_mode')),
            "shop_price"=>floatval(getRequest('shop_price')),
            "shop_stock"=>intval(getRequest('shop_stock')),
            "category_id"=>intval(getRequest('category_id')),
            "shop_display"=>intval(getRequest('shop_display')),
            "commodity_spec"=>"[]",
            "commodity_price"=>"[]"
        );
        
        if (empty($product_id)) {
            $product->addProduct($new_data);
        } else {
            $product->editProduct($product_id, $new_data);
        }
        header("Location: member_prod_list.php");
        exit();
    }
}


if (!empty($product_id)) {
    $pro = $product->getProductById($product_id);

}
$category_arr = $product->getAllCategories(-1, -1, $member_id);


$commodity_spec = json_decode($pro['commodity_spec'], true);
$commodity_spec = is_null($commodity_spec)?array():$commodity_spec;
$commodity_price = json_decode($pro['commodity_price'], true);
$commodity_price = is_null($commodity_price)?array():$commodity_price;

//print_r($commodity_spec);


function countSize($commodity_spec, $start=0) {
    $all_size = 0;
    $size = count($commodity_spec);
    for ($j=$start; $j<$size; $j++) {
        $spec = $commodity_spec[$j];
        if ($all_size==0) {
            $all_size = count($spec['items']);
        } else {
            $all_size *= count($spec['items']);
        }
    }
    return $all_size;
}

$all_size = countSize($commodity_spec);
$commodity_spec_flat = array();
for ($j=0; $j<$all_size; $j++) {
    array_push($commodity_spec_flat, array());
}

$size_commodity_spec = count($commodity_spec);
for ($i=0; $i<$size_commodity_spec; $i++) {
    $spec = $commodity_spec[$i];
    $child_size = countSize($commodity_spec, $i+1);
    if ($child_size==0) {
        $child_size=1;
    }
    $j=0;
    while($j<$all_size) {
        foreach ($spec['items'] as $item) {
            for ($k=0; $k<$child_size; $k++) {
                $commodity_spec_flat[$j][$i] = $item;
                $j ++;
            }
        }
    }
}

//echo '<pre>';
//print_r($commodity_spec_flat);
//echo '</pre>';


?>
<?php include_once("include/header.php"); ?>

<div class="row">
  <div class="col-3" style="padding:20px">
    <?php include_once("include/member_menu.php"); ?>
  </div>
  <div class="col-9" style="padding:20px">
    <h5 style="margin-bottom:20px"><b>會員-商品</b></h5>
    
    <form method="post">
    
      <?php if (!empty($error_text)) { ?>
      <div class="alert alert-danger" role="alert">
          <?php echo $error_text; ?>
      </div>
      <?php } ?>
    
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">商品名稱</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" placeholder="" name="shop_name" value="<?php echo displayRequest('shop_name', $pro); ?>">
        </div>
      </div>

      <fieldset class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-2 pt-0">商品類型</legend>
          <div class="col-sm-10">
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" id="shop_spec_mode_0" name="shop_spec_mode" value="0" <?php echo checked('shop_spec_mode', '0', $pro, true); ?>>
              <label class="form-check-label" for="shop_spec_mode_0">
                單一種類
              </label>
            </div>
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" id="shop_spec_mode_1" name="shop_spec_mode" value="1" <?php echo checked('shop_spec_mode', '1', $pro); ?>>
              <label class="form-check-label" for="shop_spec_mode_1">
                多規格
              </label>
            </div>
          </div>
        </div>
      </fieldset>

      <fieldset class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-2 pt-0">是否上架</legend>
          <div class="col-sm-10">
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" id="shop_display_0" name="shop_display" value="0" <?php echo checked('shop_display', '0', $pro); ?>>
              <label class="form-check-label" for="shop_display_0">
                關閉
              </label>
            </div>
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" id="shop_display_1" name="shop_display" value="1" <?php echo checked('shop_display', '1', $pro, true); ?>>
              <label class="form-check-label" for="shop_display_1">
                開啟
              </label>
            </div>
          </div>
        </div>
      </fieldset>

      <!-- 商品類型單一種類_start -->
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">售價</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" placeholder="" name="shop_price" value="<?php echo displayRequest('shop_price', $pro); ?>">
        </div>
      </div>
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">庫存</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" placeholder="" name="shop_stock" value="<?php echo displayRequest('shop_stock', $pro); ?>">
        </div>
      </div>
      <!-- 商品類型單一種類_end -->


    
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">商品規格</label>
        <div class="col-sm-10">
          <div class="">
            <?php foreach ($commodity_spec as $spec) { ?>
                <div class="" style="margin-bottom:5px">
                    <div class="" style="margin-bottom:5px">
                        規格名稱：<input type="text" class="form-control" style="width:10rem; display:inline-block;" placeholder="" name="shop_name" value="<?php echo display($spec['spec_name']); ?>">
                    </div>
                    <div class="">
                        <div style="margin-left:3rem">
                            <?php foreach ($spec['items'] as $item) { ?>
                                <div style="margin-bottom:5px">
                                    項目名稱：<input type="text" class="form-control" style="width:8rem; display:inline-block;" placeholder="" name="shop_name" value="<?php echo display($item); ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
          </div>
        </div>
      </div>



      <!-- 商品規格多規格_start -->
      <!--
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">主規格名稱</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
        </div>
      </div>
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">主規格項目</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
        </div>
      </div>

      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">副規格名稱</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
        </div>
      </div>
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">副規格項目</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
        </div>
      </div>
      -->

      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">商品設定</label>
        <div class="col-sm-10">
          
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <?php foreach ($commodity_spec as $spec) { ?>
                  <th scope="col-1"><?php echo display($spec['spec_name']); ?></th>
                <?php } ?>
                <th scope="col-md-auto">價格</th>
                <th scope="col-md-auto">庫存</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($commodity_spec_flat as $spec_flat) { ?>
                <tr x="<?php echo count($commodity_spec); ?>">
                  <?php for ($j=0; $j<count($commodity_spec); $j++) { ?>
                    <td><?php echo display($spec_flat[$j]); ?></td>
                  <?php } ?>
                  <td><input type="text" class="form-control" id="formGroupExampleInput" placeholder=""></td>
                  <td><input type="text" class="form-control" id="formGroupExampleInput" placeholder=""></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

        </div>
      </div>

      <!-- 商品規格多規格_end -->

      <!--

      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">安全庫存量</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
          <small class="form-text text-danger">若庫存是空白, 此項失效</small>
        </div>
      </div>
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">開始銷售日期</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="formGroupExampleInput" placeholder="2021-11-19 15:00:00">
        </div>
      </div>
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">結束銷售日期</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
        </div>
      </div>

      <fieldset class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-2 pt-0">課稅別</legend>
          <div class="col-sm-10">
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" name="gridRadios2" id="gridRadios1" value="option1" checked>
              <label class="form-check-label" for="gridRadios1">
                應稅
              </label>
            </div>
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" name="gridRadios2" id="gridRadios2" value="option2">
              <label class="form-check-label" for="gridRadios2">
                零稅率
              </label>
            </div>
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" name="gridRadios2" id="gridRadios3" value="option3">
              <label class="form-check-label" for="gridRadios3">
                免稅
              </label>
            </div>
          </div>
        </div>
      </fieldset>
      -->

      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">分類</label>
        <div class="col-sm-10">
          <select class="form-control" name="category_id">
            <?php foreach ($category_arr as $ca) { ?>
                <option value="<?php echo display($ca["id"]); ?>" <?php echo selected('category_id', $ca["id"], $pro); ?>><?php echo display($ca["name"]); ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="exampleFormControlFile1" class="col-sm-2 col-form-label">商品圖片</label>
        <div class="col-sm-10">
          <input type="file" class="form-control-file" id="exampleFormControlFile1">
          <img src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22200%22%20height%3D%22200%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20200%20200%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17d2cede93b%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17d2cede93b%22%3E%3Crect%20width%3D%22200%22%20height%3D%22200%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2275.5%22%20y%3D%22104.8%22%3E200x200%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" class="figure-img img-fluid rounded" alt="...">
        </div>
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