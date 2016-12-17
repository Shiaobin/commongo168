<?php

//error_reporting(E_ALL); //除錯用

if(!isset($_SESSION)){ session_start(); }  //判斷session是否已啟動

$ans_str=0; $ans_now=''; $s_x=0; $s_y=0; $ans_right_move=''; $_SESSION['ans_ckword'] = '';

mt_srand((double)microtime() * 1000000);  //重置隨機值

//隨機取得6個小寫英字a-z
for($i=0; $i<4; $i++){
$ans_str = mt_rand(97,122);  
$ans_now .= chr($ans_str);
}

$_SESSION['ans_ckword'] = $ans_now;  //將值放至session

//$ans_now='xyzabc';  //測試用

$im = imagecreate(60,24);

$red2 = imagecolorallocate($im,255,0,0);  //文字顏色

$gray2 = imagecolorallocate($im,255,255,0);  //背影顏色

imagefill($im,0,0,$gray2);

//隨機30點
$s_dot = imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,128));
for($i=0; $i<30; $i++){
     imagesetpixel($im,mt_rand(10,75),mt_rand(5,20),$s_dot);
}

//文字隨機浮動
$s_x = mt_rand(5,10);
for($i=0; $i<4; $i++){
     $ans_right_move = substr($ans_now,$i,1);
     $s_y = mt_rand(1,8);
     imagestring($im,5,$s_x,$s_y,$ans_right_move,$red2);
     $s_x = $s_x + mt_rand(8,14);
}

//輸出圖片
header('Content-type: image/png');

imagepng($im);

imagedestroy($im);

?>