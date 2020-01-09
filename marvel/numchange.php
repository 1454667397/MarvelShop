<?php
$a = file_get_contents("php://input");
parse_str($a, $param);
var_dump($param);
$num = (int)$param['newnum'];
$productid = (int)$param['productid'];

var_dump($num,$productid);
require_once 'db_operate.php';

$result = product_update($num,$productid);
var_dump($result);