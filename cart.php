<?php
include_once("include/session.php");
include_once("function/common.php");
include_once("class/product.php");
include_once("class/order.php");
include_once('class/pagination.php');

$product = new Product();
$order = new Order();
//$categories = $product->getCategories();
//echo '<pre>categories'.print_r($categories, 1).'</pre>';
//echo '<pre>sess'.print_r($_SESSION, 1).'</pre>';
//echo '<pre>_POST'.print_r($_POST, 1).'</pre>';

if (isset($_POST['buycount'])) {
    $buycount = (int)$_POST['buycount'];
} else {
    $buycount = 1;
}

if (isset($_SESSION['cart'])) {
    $order_price = 0;

    if (!empty($_POST)) {
        
        if (isset($_POST['checkout'])) {
            if (empty($_SESSION['mid'])) {
                echo '<script>alert("請先登入"); parent.location.href="login.php";</script>';
                return;
            }

            $order_data = array(
                "order_No"=>'BK'.date("YmdHis"), 
                "buyer_id"=>$_SESSION['mid'],
                "amount"=>$_SESSION['order_price']
            );
            $lastInsertId = $order->addOrder($order_data);

            foreach ($_SESSION['cart'] as $key => $val) {
                $pid = (int)$val['id'];
                $pro = $product->getProduct($pid);
                $order_detail_data = array(
                    "order_id"=>(int)$lastInsertId,
                    "commodity_id"=>(int)$val['id'], 
                    "price"=>(float)$val['price'],
                    "qty"=>(int)$val['count'],
                    "originalData"=>json_encode($pro)
                );
                $insert = $order->addOrderCommodity($order_detail_data);
                if ($insert) {
                    $product_data = array(
                        "shop_stock"=>(int)$pro['shop_stock']-(int)$val['count']
                    );
                    $product->editProductStock((int)$val['id'], $product_data);
                }
            }

            unset($_SESSION['order_price']);
            unset($_SESSION['cart']);
            echo '<script>alert("結帳成功"); parent.location.href="member_order_list.php";</script>';
            return;
        }

        if (!empty($_POST['sel_count'])) {
            $sel_count = explode(",", $_POST['sel_count']);
            //$_SESSION['cart'][1]['count'] = 5;
            $_SESSION['cart'][$sel_count[0]]['count'] = $sel_count[1];
        }
        
        if ($_POST['del_id'] != '') {
            $del_id = (int)$_POST['del_id'];
            unset($_SESSION['cart'][$del_id]);
        }
    }

    foreach ($_SESSION['cart'] as $key => $val) {
        $order_price += (int)$val['price']*(int)$val['count'];
        $pid = (int)$val['id'];
        $pro = $product->getProduct($pid);

        /* 購物按鈕判斷(商品規格:單一種類)_start */
        $buy_flag = True;
        $option_count = 10;
        if ($pro['shop_stock'] < $option_count) {
            $option_count = $pro['shop_stock'];
        }
        //echo "option_count=[$option_count]";

        if ($pro['shop_stock'] <= 0) {
            $buy_flag = False;
        }

        if ($val['id'] == $pid) {
            // 購物車數量大於庫存量
            if ($val['count'] > $pro['shop_stock']) {
                $buy_flag = False;
            }
            $_SESSION['cart'][$key]['option_count'] = $option_count;
            //$option_count = (int)($option_count-(int)$val['count']);
            //break;
        }
        /* 購物按鈕判斷(商品規格:單一種類)_end */

    }
    $_SESSION['order_price'] = $order_price;
}

//echo '<pre>sess'.print_r($_SESSION, 1).'</pre>';


?>

<?php include_once("include/header.php"); ?>

<div style="padding:20px">
<?php if (!empty($_SESSION['cart'])) { ?>
    <form id="form1" action="cart.php" method="post">
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
    foreach ($_SESSION['cart'] as $key => $val) {
    ?>
        <tr>
            <th scope="row"><?php echo $k; ?></th>
            <td><?php echo display($val['name']); ?></td>
            <td></td>
            <td>
                <div class="form-group">
                    <select class="form-control" id="exampleFormControlSelect<?php echo $key; ?>" onchange="select_count(<?php echo $key; ?> ,this.options[this.options.selectedIndex].value)">
                    <?php for ($i=1; $i<=$val['option_count']; $i++) { ?>
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
            <button onclick="delete_product(<?php echo $key; ?>)" class="btn btn-primary">刪除</button>
            
            </td>
        </tr>
    <?php
        $k++;
    }
    ?>

    </tbody>
    </table>

    <h2>訂單總額: $<?php echo $order_price; ?></h2>
    <?php if ($buy_flag) { ?>
        <button style="margin:20px 0 20px 0" type="submit" name="checkout" class="btn btn-primary">結帳</button>
    <?php } ?>
    <input type="hidden" name="del_id" id="del_id">
    <input type="hidden" name="sel_count" id="sel_count">
    </form>
<?php } else { ?>
    <p>購物車無商品</p>
<?php } ?>
</div>
<script language="javascript">

function delete_product(del_key) {
    $("#del_id").val(del_key);
    $("#form1").submit();
}

function select_count(key, val) {
    $("#sel_count").val(key + ',' + val);
    $("#form1").submit();
}



</script>
<?php include_once("include/footer.php"); ?>