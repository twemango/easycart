<?php
if (!isset($_SESSION)) {
    session_start();

    // 刪除 temp_session
    $page_self = $_SERVER['PHP_SELF'];
    //echo "page_self=[$page_self]";
    if (!stristr($page_self, 'login')) {
        unset($_SESSION['temp_account']);
        unset($_SESSION['temp_password']);
    }

    //echo '<pre>$_SESSION'.print_r($_SESSION, 1).'</pre>';
}
?>