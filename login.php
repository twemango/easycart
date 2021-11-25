<?php
include_once("include/session.php");
include_once("function/common.php");
include_once("class/pdo/Db.class.php");

if (isset($_POST['account'])) {
    $_SESSION['temp_account'] = $_POST['account'];
} else {
    $_SESSION['temp_account'] = null;
}

if (isset($_POST['password'])) {
    $_SESSION['temp_password'] =  $_POST['password'];
} else {
    $_SESSION['temp_password'] = null;
}

$error = False;
$error_text = '';

if (isset($_POST['account']) && isset($_POST['password'])) {
	$account = $_POST['account'];
  	$password = $_POST['password'];

    if (!preg_match("/^[a-zA-Z0-9]{3,20}$/", $account)) {
        $error = True;
        $error_text = '帳號長度3~20字元之間，格式必須為大小寫英文、數字';
    } elseif (!preg_match("/^[a-zA-Z0-9_]{3,20}$/", $password)) {
        $error = True;
        $error_text = '密碼長度3~20字元之間，格式必須為大小寫英文、數字、底線';
    }

    if (!$error) {
        $db = new Db();
        $db->bindMore(array("ac"=>$account, "pw"=>$password));
        $user_arr = $db->query("SELECT id FROM finder_user WHERE ac = :ac AND pw = :pw");
        //echo '<pre>user_arr'.print_r($user_arr, 1).'</pre>';

        if ($user_arr) {
            $uid = $user_arr[0]['id'];
            //echo "uid=[{$uid}]";
            $_SESSION['uid'] = $uid;
            unset($_SESSION['temp_account']);
            unset($_SESSION['temp_password']);
            header("Location: index.php");
        } else {
            $error = True;
            $error_text = '無效的帳號或密碼, 請重新登入';
        }
    }
}
?>

<?php include_once("include/header.php"); ?>
<div class="row shadow">
    <div class="col-12 card-body">
        <form action="login.php" method="post">

        <?php if ($error) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_text; ?>
        </div>
        <?php } ?>

        <div class="form-group">
            <label for="formGroupExampleInput">帳號</label>
            <input type="text" class="form-control" id="formGroupExampleInput" name="account" value="<?php echo display($_SESSION['temp_account']); ?>" placeholder="輸入帳號">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">密碼</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password" value="<?php echo display($_SESSION['temp_password']); ?>" placeholder="輸入密碼">
        </div>
        <button type="submit" class="btn btn-primary">送出</button>
        </form>
    </div>
</div>

<?php include_once("include/footer.php"); ?>