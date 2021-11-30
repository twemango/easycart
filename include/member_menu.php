<div class="list-group" id="member_menu">
  <a href="member_order_list.php" class="list-group-item list-group-item-action">會員-訂單</a>
  <a href="member_prod_class_list.php" class="list-group-item list-group-item-action">會員-商品分類</a>
  <a href="member_prod_list.php" class="list-group-item list-group-item-action">會員-商品</a>
</div>
<script>
var url = window.location.pathname;
var filename = url.substring(url.lastIndexOf('/')+1);
var memberclass = filename.substring(0,filename.lastIndexOf('_'));
//$('#member_menu').find('a[href="'+filename+'"]').addClass('active');
$('#member_menu a[href*="'+memberclass+'"]').addClass('active');
if (memberclass == 'member_prod') {
  $('#member_menu a[href*="'+memberclass+'_class"]').removeClass('active');
}
</script>
