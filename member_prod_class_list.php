<?php
include_once("include/session.php");
include_once("function/common.php");
include_once("class/product.php");
include_once('class/pagination.php');


if (!isset($_SESSION['mid'])) {
    header("Location: login.php");
    exit();
}
$member_id = $_SESSION['mid'];

$error_text = '';

$db = new DB;

$product = new Product();

if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}

if (isset($_GET['pageSize'])) {
    $page_size = (int)$_GET['pageSize'];
} else {
    $page_size = 10;
}

$category_arr = $product->getAllCategories($page, $page_size, $member_id);
//echo '<pre>product_arr'.print_r($product_arr).'</pre>';
$category_count = $product->getCategoriesCount($member_id);

if ($category_arr) {
    $page = new Pagination($category_count, $page_size);
    $page->pagerCount = 6;
    //$page->prevText = '上一頁';
    //$page->nextText = '下一頁';
}

?>
<?php include_once("include/header.php"); ?>

<link href="css/pagination.css" rel="stylesheet">

<div class="row">

  <?php if ($error_text!='') { ?>
    <div class="col-12">
      <div class="alert alert-danger" role="alert">
        <?php echo $error_text; ?>
      </div>
    </div>
  <?php } ?>

  <div class="col-3" style="padding:20px">
    <?php include_once("include/member_menu.php"); ?>
  </div>
  <div class="col-9" style="padding:20px">
    <h5 style="margin-bottom:20px"><b>會員-商品分類</b></h5>

    <div style="text-align:right; margin-bottom:10px">
        <a href="member_prod_class_add.php" class="btn btn-primary">新增分類</a>
    </div>

    <table class="table" id="dataTable">
      <thead class="thead-light">
        <tr>
          <th scope="col">商品分類名稱</th>
          <th scope="col">顯示</th>
          <th scope="col">管理</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($category_arr) { ?>
            <?php foreach ($category_arr as $ca) { ?>
            <tr>
              <td><?php echo display($ca['name']); ?></td>
              <td><?php echo display($ca['display']); ?></td>
              <td>
                <a href="member_prod_class_edit.php?category_id=<?php echo display($ca['id']); ?>">編輯</a>
                <a href="#" data-toggle="modal" data-target="#modal_delete_category"
                    onclick="
                        window.category_id='<?php echo display($ca['id']); ?>';
                    ">
                    刪除
                </a>
    
            </tr>
            <?php } ?>
        <?php } ?>

      </tbody>
    </table>
    <div class="row">
        <div class="col-12 mb-10">
            <?php if ($category_arr) { ?>
                <!-- 分頁頁碼_start -->
                <?php echo $page->links(['pager']); ?>
                <!-- 分頁頁碼_end -->
            <?php } else { ?>
                <div class="alert alert-dark" role="alert">
                   無分類
                </div>
            <?php } ?>
        </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modal_delete_category" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">刪除分類</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>你確定要刪除此分類嗎？</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick="deleteCategory()">刪除</a>
      </div>
    </div>
  </div>
</div>

<script>
function deleteCategory() {
    location.href='member_prod_class_delete.php?category_id=' + window.category_id;
}
</script>

<?php include_once("include/footer.php"); ?>