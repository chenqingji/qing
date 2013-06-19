<?php

/*
 * 缩略图处理demo
 * and open the template in the editor.
 */
include_once('./image.class.php');
$a = new Images();
$LF = "D:\WebServer\PHPnow\htdocs\u\\1.jpg";
$NF = "D:\WebServer\PHPnow\htdocs\u\\2.jpg";
$a->Thumbnail($LF,$NF,300,300);

?>
