<?php
include_once("include/session.php");
include_once("function/common.php");
include_once("class/product.php");
include_once('class/pagination.php');

$product = new Product();
//$categories = $product->getCategories();
//echo '<pre>categories'.print_r($categories, 1).'</pre>';

//echo '<pre>sess'.print_r($_SESSION, 1).'</pre>';

if (isset($_GET['id'])) {
    $pid = (int)$_GET['id'];
} else {
    $pid = 0;
}

if (isset($_POST['buycount'])) {
    $buycount = (int)$_POST['buycount'];
} else {
    $buycount = 1;
}

foreach ($_SESSION['cart'] as $val) {
    $pid = $val['id'];
    $pro = $product->getProduct($pid);

    /* 購物按鈕判斷(商品規格:單一種類)_start */
    $buy_flag = True;
    $option_count = 10;
    if ($pro['shop_stock'] < $option_count) {
        $option_count = $pro['shop_stock'];
    }

    if ($pro['shop_stock'] <= 0) {
        $buy_flag = False;
    } elseif (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $val) {
            //$_SESSION['cart'][$key]['option_count'] = $option_count;
            $_SESSION['cart'][$key]['option_count'] = 1;
            if ($val['id'] == $pid) {
                // 購物車數量等於庫存量
                if ($val['count'] == $pro['shop_stock']) {
                    $buy_flag = False;
                }
                $_SESSION['cart'][$key]['option_count'] = $option_count;
                //$option_count = (int)($option_count-(int)$val['count']);
                //break;
            }
        }
    }
    /* 購物按鈕判斷(商品規格:單一種類)_end */


}

//$pid = 37;

//$pro = $product->getProduct($pid);
//echo '<pre>pro'.print_r($pro,1).'</pre>';

/* 庫存量判斷_start */
$buy_text = '';
$alert_class = 'alert-warning';
if (!empty($_POST)) {
    //echo '<pre>_POST'.print_r($_POST, 1).'</pre>';//exit;
    if ($pro['shop_spec_mode'] == 0) { // 商品規格:單一種類
        // 購物車內本商品的庫存量
        $total_buycount = $buycount;
        $newpro_flag = True;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $val) {
                if ($val['id'] == $pid) {
                    // 相同商品數量相加
                    $total_buycount += $val['count'];
                    $newpro_flag = False;
                    break;
                }
            }
        }

        if ($pro['shop_stock'] >= $total_buycount) {
            if ($newpro_flag) {
                $_SESSION['cart'][] = array ('id'=>$pro['id'], 'count'=>$buycount);
                //echo '<pre>sess_cart'.print_r($_SESSION['cart'], 1).'</pre>';//exit;
            } else {
                $_SESSION['cart'][$key]['count'] = $total_buycount;
            }
            $buy_text = '<strong>' . $pro['shop_name'] . '</strong> 已加入購物車！';
        } else {
            $alert_class = 'alert-danger';
            $buy_text = '商品購買數量超過庫存量';
        }
    } elseif ($pro['shop_spec_mode'] == 1) { // 商品規格:多規格
        // 購物車內本商品的庫存量
        $total_buycount = $buycount;
        $newpro_flag = True;

        //$specs = $product->getProductSpec($pid);
        //$pro['spec'] = $product->getProductSpec($pid);
        //echo '<pre>pro'.print_r($pro, 1).'</pre>';//exit;
        //$specs = $product->getProductSpec($pid);

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $val) {
                if ($val['id'] == $pid) {
                    // 相同商品數量相加
                    $total_buycount += $val['count'];
                    $newpro_flag = False;
                    break;
                }
            }
        }

        if ($pro['shop_stock'] >= $total_buycount) {
            if ($newpro_flag) {
                $_SESSION['cart'][] = array ('id'=>$pro['id'], 'count'=>$buycount);
                //echo '<pre>sess_cart'.print_r($_SESSION['cart'], 1).'</pre>';//exit;
            } else {
                $_SESSION['cart'][$key]['count'] = $total_buycount;
            }
            $buy_text = '<strong>' . $pro['shop_name'] . '</strong> 已加入購物車！';
        } else {
            $alert_class = 'alert-danger';
            $buy_text = '商品購買數量超過庫存量';
        }
    }
    
}
/* 庫存量判斷_end */



/* 購物按鈕判斷(商品規格:單一種類)_start */
/*
$buy_flag = True;
$option_count = 10;
if ($pro['shop_stock'] < $option_count) {
    $option_count = $pro['shop_stock'];
}

if ($pro['shop_stock'] <= 0) {
    $buy_flag = False;
} elseif (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $val) {
        //$_SESSION['cart'][$key]['option_count'] = $option_count;
        $_SESSION['cart'][$key]['option_count'] = 1;
        if ($val['id'] == $pid) {
            // 購物車數量等於庫存量
            if ($val['count'] == $pro['shop_stock']) {
                $buy_flag = False;
            }
            $_SESSION['cart'][$key]['option_count'] = $option_count;
            //$option_count = (int)($option_count-(int)$val['count']);
            //break;
        }
    }
}
*/
/* 購物按鈕判斷(商品規格:單一種類)_end */

//$specs = $product->getProductSpec($pid);
//echo '<pre>product_spec'.print_r($pro['spec'], 1).'</pre>';exit;

//echo '<pre>sess'.print_r($_SESSION, 1).'</pre>';


?>

<?php include_once("include/header.php"); ?>
<div style="padding:20px">
    <form>
    <table class="table">
    <thead class="thead-light">
        <tr>
        <th scope="col">#</th>
        <th scope="col">商品名稱</th>
        <th scope="col">規格</th>
        <th scope="col">數量</th>
        <th scope="col">金額</th>
        <th scope="col">刪除</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $k = 1;
    foreach ($_SESSION['cart'] as $val) {
    ?>
        <tr>
            <th scope="row"><?php echo $k; ?></th>
            <td><?php echo display($val['name']); ?></td>
            <td></td>
            <td>
                <div class="form-group">
                    <select class="form-control" id="exampleFormControlSelect1">
                    <?php for ($i=1; $i<=10; $i++) { ?>
                        <?php if ($i == $val['count']) { ?>
                        <option value="<?php echo $i; ?>" selected><?php echo $i; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    <?php } ?>
                    </select>
                </div>
            </td>
            <td><?php echo display($val['price']); ?></td>
            <td>
                <input class="btn btn-primary" type="button" value="刪除">
            </td>
        </tr>
    <?php
        $k++;
    }
    ?>
<!--
        <tr>
            <th scope="row">2</th>
            <td>pro2</td>
            <td>顏色: 紅</td>
            <td>
                <div class="form-group">
                    <select class="form-control" id="exampleFormControlSelect1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    </select>
                </div>
            </td>
            <td>1000</td>
            <td>
                <input class="btn btn-primary" type="button" value="刪除">
            </td>
        </tr>

        <tr>
            <th scope="row">3</th>
            <td>pro3</td>
            <td>顏色: 紅<br>尺寸: 大</td>
            <td>
                <div class="form-group">
                    <select class="form-control" id="exampleFormControlSelect1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    </select>
                </div>
            </td>
            <td>1000</td>
            <td>
                <input class="btn btn-primary" type="button" value="刪除">
            </td>
        </tr>
-->
    </tbody>
    </table>

    <h2>訂單總額: $8000</h2>

    <button style="margin:20px 0 20px 0" type="submit" class="btn btn-primary">結帳</button>
    </form>
</div>

<?php include_once("include/footer.php"); ?>