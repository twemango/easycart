<?php
// 顯示資料
function display($str) {
    return htmlentities(trim($str));
}

// 判斷檔案室否為圖片
function isImage($filename) {
    if (file_exists($filename)) {
        $mimetype = exif_imagetype($filename);
        if ($mimetype == IMAGETYPE_GIF || $mimetype == IMAGETYPE_JPEG || $mimetype == IMAGETYPE_PNG || $mimetype == IMAGETYPE_BMP)
        {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

?>