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

if (!empty($_FILES["file"]["name"])) {
	if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
	) 
	//&& ($_FILES["file"]["size"] < 100000) //Approx. 100kb files can be uploaded
		 ) {
		if ($_FILES["file"]["error"] > 0) {
			echo "Return Code: " . $_FILES["file"]["error"];
		} else {
			if (file_exists('upload/images/' . $_FILES["file"]["name"])) {
				echo $_FILES["file"]["name"] . " already exists.";
			} else {
				$sourcePath = $_FILES['file']['tmp_name'];
				$targetPath = 'upload/images/' . $_FILES['file']['name'];
				move_uploaded_file($sourcePath, $targetPath);
			}
		}
	} else {
		echo "圖片格式錯誤，圖片必須為jpeg、png、jpg";
	}
}

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

        $shop_image = 'no_image.png';
        if (!empty($_FILES["file"]["name"])) {
          $shop_image = $_FILES["file"]["name"];
        } else {
          if (!empty($product_id)) {
            $pro2 = $product->getProductById($product_id);
            $shop_image = $pro2["shop_image"];
          }
        }
        $new_data["shop_image"] = $shop_image;
        
        if (empty($product_id)) {
            $product->addProduct($new_data);
        } else {
            $product->editProduct($product_id, $new_data);
        }
        header("Location: member_prod_list.php");
        exit();
    }
}

$image = 'images/no_image.png';
if (!empty($product_id)) {
    $pro = $product->getProductById($product_id);
    if (!empty($pro['shop_image'])) {
        if (isImage('upload/images/' . $pro['shop_image'])) {
          $image = 'upload/images/' . $pro['shop_image'];
        }
    }
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

?>
<?php include_once("include/header.php"); ?>
<script src="js/ajax_upload_image.js"></script>

<div class="row">
  <div class="col-3" style="padding:20px">
    <?php include_once("include/member_menu.php"); ?>
  </div>
  <div class="col-9" style="padding:20px">
    <h5 style="margin-bottom:20px"><b>會員-商品</b></h5>
    
    <form id="" action="" method="post" enctype="multipart/form-data">
    
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
          <input type="file" class="form-control-file" name="file" id="file">
          <div id="image_preview" class="mt-2"><img id="previewing" src="<?php echo $image; ?>" class="figure-img img-fluid rounded" style="width:250px;" /></div>
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