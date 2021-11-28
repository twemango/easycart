<?php
include_once("include/session.php");
include_once("function/common.php");
include_once("class/product.php");
include_once('class/pagination.php');

$product = new Product();
$category_arr = $product->getCategories();
//echo '<pre>category_arr'.print_r($category_arr, 1).'</pre>';

if ($category_arr) {
    if (isset($_GET['cname'])) {
        $cname = $_GET['cname'];
    } else {
        $cname = $category_arr[0]['name'];
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
    
    $product_arr = $product->getProductsByName($cname, $page, $page_size);
    //echo '<pre>product_arr'.print_r($product_arr).'</pre>';
    $product_count = $product->getProductsCountByName($cname);
    
    if ($product_arr) {
        $page = new Pagination($product_count, $page_size);
        $page->pagerCount = 6;
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
    <?php foreach ($product_arr as $pro) { 
        if (isImage('upload/images/' . $pro['shop_image'])) {
            $image = 'upload/images/' . $pro['shop_image'];
        } else {
            $image = 'images/no_image.png';
        }
    ?>
        <!-- 商品列表_start -->
        <div class="row border";>
            <div class="col-4">
                <a href="prod_detail.php?id=<?php echo $pro['id']; ?>&cname=<?php echo urlencode($cname); ?>"><img src="<?php echo $image; ?>" class="img-fluid img-thumbnail" alt="..."></a>
            </div>
            <div class="col">
                <a href="prod_detail.php?id=<?php echo $pro['id']; ?>&cname=<?php echo urlencode($cname); ?>"><?php echo display($pro['shop_name']); ?></a>
            </div>
        </div>
        <!-- 產品列表_end -->
    <?php } ?>
    <?php if ($product_arr) { ?>
        <div style="margin-top:20px";>
        <!-- 分頁頁碼_start -->
        <?php echo $page->links(['pager']); ?>
        <!-- 分頁頁碼_end -->
    </div>
    <?php } else { ?>
        <div class="alert alert-dark" role="alert">
           無商品
        </div>
    <?php } ?>
    </div>
</div>
<?php include_once("include/footer.php"); ?>