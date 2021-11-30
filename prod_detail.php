<?php
include_once("include/session.php");
include_once("function/common.php");
include_once("class/product.php");
include_once('class/pagination.php');

$product = new Product();
$categories = $product->getCategories();
//echo '<pre>categories'.print_r($categories, 1).'</pre>';

if ($categories) {
    if (isset($_GET['cname'])) {
        $cname = $_GET['cname'];
    } else {
        $cname = $categories[0]['name'];
        //echo "id=[$id]";
    }

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

    $pro = $product->getProduct($pid);
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
                    //$_SESSION['cart'][] = array ('id'=>$pro['id'], 'count'=>$buycount);
                    $_SESSION['cart'][] = array (
                        'id' => $pro['id'], 
                        'name' => $pro['shop_name'], 
                        'price' => $pro['shop_price'], 
                        'count' => $buycount
                    );
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
    $buy_flag = True;
    $option_count = 10;
    if ($pro['shop_stock'] < $option_count) {
        $option_count = $pro['shop_stock'];
    }

    if ($pro['shop_stock'] <= 0) {
        $buy_flag = False;
    } elseif (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $val) {
            if ($val['id'] == $pid) {
                // 購物車數量等於庫存量
                if ($val['count'] == $pro['shop_stock']) {
                    $buy_flag = False;
                }
                $option_count = (int)($option_count-(int)$val['count']);
                break;
            }
        }
    }
    /* 購物按鈕判斷(商品規格:單一種類)_end */

    $image = 'images/no_image.png';
    if (!empty($pro['shop_image'])) {
        if (isImage('upload/images/' . $pro['shop_image'])) {
            $image = 'upload/images/' . $pro['shop_image'];
        }
    }

    $specs = $product->getProductSpec($pid);

    //echo '<pre>sess'.print_r($_SESSION, 1).'</pre>';
}

?>

<?php include_once("include/header.php"); ?>
<link href="css/pagination.css" rel="stylesheet">

<div class="row shadow">
    <div class="col-4 card-body">
    <?php if ($categories) { ?>
        <div class="card mb-4">
            <div class="list-group">
            <?php foreach ($categories as $ca) { ?>
                <?php if ($ca['name'] == $cname) { ?>
                    <a href="prod_class.php?cname=<?php echo urlencode($ca['name']); ?>" class="list-group-item list-group-item-action active"><?php echo display($ca['name']); ?></a>
                <?php } else { ?>
                    <a href="prod_class.php?cname=<?php echo urlencode($ca['name']); ?>" class="list-group-item list-group-item-action"><?php echo display($ca['name']); ?></a>
                <?php } ?>
            <?php } ?>
            </div>
        </div>
    <?php } ?>
    </div>
    <div class="col-8 card-body">
    <?php if ($buy_text) { ?>
        <div id="alert_div" class="alert <?php echo $alert_class ?> alert-dismissible fade show" role="alert">
        <?php echo $buy_text; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    <?php } ?>
        <div>
            <img src="<?php echo $image; ?>" alt="" class="img-thumbnail img-responsive">
        </div>
        <div class="col-3 card-body"></div>

        <!-- 商品名稱 -->
        <h2><?php echo display($pro['shop_name']); ?></h2>
        <!-- 商品價格 -->
        <h3>NT$<?php echo display($pro['shop_price']); ?></h3>
        <form action="prod_detail.php?id=<?php echo $pid; ?>&cname=<?php echo urlencode($cname); ?>" method="post">
        <?php if ($pro['shop_spec_mode'] == 1) { ?>
        <!-- 商品規格_start -->
        <?php foreach ($specs as $spec_name => $items) { ?>
        <div class="form-group row">
            <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label"><?php echo display($spec_name); ?></label>
            <div class="col-sm-10">
                <select class="form-control" id="exampleFormControlSelect1">
                <?php foreach ($items as $item_key => $item) { ?>
                    <option value="<?php echo $item_key; ?>"><?php echo display($item['item_name']); ?></option>
                <?php } ?>
                </select>
            </div>
        </div>
        <?php } ?>
        <!-- 商品規格_end -->
        <?php } ?>
        <?php if ($buy_flag) { ?>
        <!-- 購買數量_start -->
        <div class="form-group row">
            <label for="exampleFormControlSelect3" class="col-sm-2 col-form-label">購買數量</label>
            <div class="col-sm-10">
                <select class="form-control" id="buycount" name="buycount">
                    <?php for ($i=1; $i<=$option_count; $i++) { ?>
                        <?php if ($i == $buycount) { ?>
                        <option value="<?php echo $i; ?>" selected><?php echo $i; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <!-- 購買數量_end -->
        <button style="margin-top:20px" type="submit" class="btn btn-primary">購買</button>
        <?php } else { ?>
        <button style="margin-top:20px" type="button" class="btn btn-secondary" disabled>已售完</button>
        <?php } ?>
        </form>

    </div>

</div>
<?php include_once("include/footer.php"); ?>




