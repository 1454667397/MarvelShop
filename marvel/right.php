<?php
require_once "db_operate.php";

//统计数据库product表有多少个
$product_count = product_count();
$product_count = $product_count->fetch_row();
$length = (int)$product_count[0];
//获取product表各行的数据
$product_info = product_info();
$products_info=[];
for ($i=0;$i<$length;$i++)
{
    $products_info[$i] = $product_info->fetch_array(MYSQLI_ASSOC);
    //product_info[]是二维数组，存放product表
}

//var_dump($products_info);