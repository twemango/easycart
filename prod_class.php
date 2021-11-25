<?php
include_once("include/session.php");
include_once("function/common.php");
include_once("class/product.php");
include_once('class/pagination.php');

$product = new Product();
$category_arr = $product->getCategories();
//echo '<pre>category_arr'.print_r($category_arr, 1).'</pre>';

if ($category_arr) {
    if (isset($_GET['cid'])) {
        $cid = (int)$_GET['cid'];
    } else {
        $cid = (int)$category_arr[0]['id'];
        //echo "id=[$id]";
    }

    if (isset($_GET['page'])) {
        $page = (int)$_GET['page'];
    } else {
        $page = 1;
    }

    if (isset($_GET['pageSize'])) {
        $page_size = (int)$_GET['pageSize'];
    } else {
        $page_size = 3;
    }
    
    $product_arr = $product->getProducts($cid, $page, $page_size);
    //echo '<pre>product_arr'.print_r($product_arr).'</pre>';
    $product_count = $product->getProductsCount($cid);
    
    if ($product_arr) {
        $page = new Pagination($product_count, $page_size);
        $page->pagerCount = 6;
        $page->prevText = '上一頁';
        $page->nextText = '下一頁';
    }

}
?>

<?php include_once("include/header.php"); ?>
<link href="css/pagination.css" rel="stylesheet">

<div class="row shadow">
    <div class="col-4 card-body">
    <?php if ($category_arr) { ?>
        <div class="card mb-4">
            <div class="list-group">
            <?php foreach ($category_arr as $ca) { ?>
                <?php if ($ca['id'] == $cid) { ?>
                    <a href="prod_class.php?cid=<?php echo $ca['id']; ?>" class="list-group-item list-group-item-action active"><?php echo $ca['name']; ?></a>
                <?php } else { ?>
                    <a href="prod_class.php?cid=<?php echo $ca['id']; ?>" class="list-group-item list-group-item-action"><?php echo $ca['name']; ?></a>
                <?php } ?>
            <?php } ?>
            </div>
        </div>
    <?php } ?>
    </div>
    <div class="col-8 card-body">
    <?php foreach ($product_arr as $pro) { ?>
        <!-- 商品列表_start -->
        <figure class="figure" style="margin:10px;">
            <a href="prod_detail.php?id=<?php echo $pro['id']; ?>&cid=<?php echo $cid; ?>"><img src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22200%22%20height%3D%22200%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20200%20200%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17d2cede93b%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17d2cede93b%22%3E%3Crect%20width%3D%22200%22%20height%3D%22200%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2275.5%22%20y%3D%22104.8%22%3E200x200%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" class="figure-img img-fluid rounded" alt="..."></a>
        <figcaption class="figure-caption">
            <a href="prod_detail.php?id=<?php echo $pro['id']; ?>&cid=<?php echo $cid; ?>"><?php echo $pro['shop_name']; ?></a>
        </figcaption>
        <figcaption class="figure-caption">
            <?php echo $pro['shop_price']; ?>
        </figcaption>
        </figure>
        <!-- 產品列表_end -->
    <?php } ?>
    <?php if ($product_arr) { ?>
        <!-- 分頁頁碼_start -->
        <?php echo $page->links(['pager']); ?>
        <!-- 分頁頁碼_end -->
    <?php } else { ?>
        <div class="alert alert-dark" role="alert">
           無商品
        </div>
    <?php } ?>
    </div>
</div>
<?php include_once("include/footer.php"); ?>