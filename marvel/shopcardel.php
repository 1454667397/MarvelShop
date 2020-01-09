<?php
//购物车删除商品
$a = file_get_contents("php://input");
parse_str($a, $param);
var_dump($param);

require_once 'db_operate.php';

$productid = $param['productid'];
$username = $param['username'];

$b = shoppingcar_delete($productid,$username);
var_dump($b);