<?php
$a = file_get_contents("php://input");
parse_str($a, $param);
var_dump($param);


require_once 'db_operate.php';

$result = comment_insert($param['productid'],$param['username'],$param['content'],$param['score']);
var_dump($result);