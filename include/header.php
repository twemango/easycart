<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <head>
        <meta charset="utf-8">
        <title>title</title>
        <link rel="stylesheet" href="style.css">

        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <script src="js/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <script src="script.js"></script>
    </head>
    <body>

    <div class="container-xl">
        <div class="row bg-primary text-white shadow">
            <div class="col-8 card-body">
                <a class="text-white" href="index.php">首頁</a>
                <a class="text-white" href="prod_class.php">商品</a>
                <a class="text-white" href="cart.php">購物車</a>
                <?php if (isset($_SESSION['uid'])) { ?>
                <a class="text-white" href="member_order_list.php">會員-訂單</a>
                <?php } ?>
            </div>
            <div class="col-4 card-body text-right">
                <?php if (!isset($_SESSION['uid'])) { ?>
                <a class="text-white" href="login.php">登入</a>
                <?php } else { ?>
                <a class="text-white" href="logout.php">登出</a>
                <?php } ?>
            </div>
        </div>




    

