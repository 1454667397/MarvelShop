<?php

$a = file_get_contents("php://input");
parse_str($a, $param);
var_dump($param);

require_once 'db_operate.php';

$num = (int)$param['productnum'];
$sale = (float)$param['productsale'];

shoppingcar_insert($param['id'],$param['username'],$num,$sale);

