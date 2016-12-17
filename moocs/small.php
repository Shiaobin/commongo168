<?php
//---------------web img-------------------//
function resize_web_image($file) {
$imM = new Imagick("../images/webimg/".$file);
$imS = new Imagick("../images/webimg/".$file);

foreach ($imM as $frameM) {
$frameM->thumbnailImage(600,500,true);
$frameM->setImagePage(600,500, 0, 0);
}

foreach ($imS as $frameS) {
$frameS->thumbnailImage(300,200,true);
$frameS->setImagePage(300,200, 0, 0);
}

$imM->writeimages("../images/webimg/medium/".$file, true);
$imS->writeimages("../images/webimg/small/".$file, true);
unlink("../images/webimg/".$file);
}
//---------------APP img-----------------//
function resize_midcode_image($file) {
$imM = new Imagick("../images/app/".$file);

foreach ($imM as $frameM) {
$frameM->thumbnailImage(78,78,true);
$frameM->setImagePage(78,78, 0, 0);
}

$imM->writeimages("../images/app/".$file, true);
}
//---------------goods img-------------------//
function resize_goods_image($file) {
$imM = new Imagick("../images/goodsimg/".$file);
$imS = new Imagick("../images/goodsimg/".$file);

foreach ($imM as $frameM) {
$frameM->thumbnailImage(600,500,true);
$frameM->setImagePage(600,500, 0, 0);
}

foreach ($imS as $frameS) {
$frameS->thumbnailImage(120,100,true);
$frameS->setImagePage(120,100, 0, 0);
}

$imM->writeimages("../images/goodsimg/medium/".$file, true);
$imS->writeimages("../images/goodsimg/small/".$file, true);
unlink("../images/goodsimg/".$file);
}
//---------------news img-------------------//
function resize_new_image($file) {
$imM = new Imagick("../images/newsimg/".$file);
$imS = new Imagick("../images/newsimg/".$file);

foreach ($imM as $frameM) {
$frameM->thumbnailImage(600,500,true);
$frameM->setImagePage(600,500, 0, 0);
}

foreach ($imS as $frameS) {
$frameS->thumbnailImage(120,100,true);
$frameS->setImagePage(120,100, 0, 0);
}

$imM->writeimages("../images/newsimg/medium/".$file, true);
$imS->writeimages("../images/newsimg/small/".$file, true);
unlink("../images/newsimg/".$file);
}
//---------------banner img-----------------//
function resize_banner_image($file) {
$imM = new Imagick("../images/bannerimg/".$file);

foreach ($imM as $frameM) {
$frameM->thumbnailImage(1500,500,true);
$frameM->setImagePage(1500,500, 0, 0);
}

$imM->writeimages("../images/bannerimg/".$file, true);
}
//---------------slide img-----------------//
function resize_slide_image($file) {
$imM = new Imagick("../images/slideimg/".$file);

foreach ($imM as $frameM) {
$frameM->thumbnailImage(300,200,true);
$frameM->setImagePage(300,200, 0, 0);
}

$imM->writeimages("../images/slideimg/".$file, true);
}
//----------------album img----------------//
function resize_album_image($file) {
$imM = new Imagick("../images/albumimg/".$file);
$imS = new Imagick("../images/albumimg/".$file);

foreach ($imM as $frameM) {
$frameM->thumbnailImage(600,500,true);
$frameM->setImagePage(600,500, 0, 0);
}

foreach ($imS as $frameS) {
$frameS->thumbnailImage(100,80,true);
$frameS->setImagePage(100,80, 0, 0);
}

$imM->writeimages("../images/albumimg/medium/".$file, true);
$imS->writeimages("../images/albumimg/small/".$file, true);
unlink("../images/albumimg/".$file);
}
//-----------------------------------------//
?>
