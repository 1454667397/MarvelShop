<?php
$a = file_get_contents("php://input");
parse_str($a, $param);
var_dump($param);

require_once 'db_operate.php';

$num = $param['productnum'];
$sale = $param['productsale'];
if (isset($param['productamount']))
{$amount = $param['productamount'];}
else
{$amount = $num*$sale;}
date_default_timezone_set('PRC');
$timebuy = date("Y/m/d h:i:sa");
$formid = (string)time();
for ($i=0;$i<strlen($param['username']);$i++)
{
    $a = (string)ord($param['username'][$i]);
    $formid = $formid.$a;
    if (strlen($formid)>=16){break;}
}
if (strlen($formid)<16){str_pad($formid,16,'0');}

//var_dump($formid);
$b = orderform_insert($formid,$param['id'],$param['username'],$num,$sale,$amount,$timebuy,$param['uwho'],$param['uhow'],$param['uwhere']);
var_dump($b) ;
$idlist = explode(',',$param['id']);
$numlist = explode(',',$num);
for ($i=0;$i<count($idlist);$i++){
    $information = product_detail((int)$idlist[$i]);
    $productinfo = $information->fetch_array(MYSQLI_ASSOC);
    $oldnum = $productinfo['productnum'];
    $newnum = $oldnum - (int)$numlist[$i];
    product_update($newnum,(int)$idlist[$i]);
}
//foreach ($idlist as $productid) {
//    $information = product_detail($productid['id']);
//    $productinfo = $information->fetch_array(MYSQLI_ASSOC);
//    $oldnum = $productinfo['productnum'];
//    $newnum = $oldnum -
//    }
//echo $formid,$param['id'],$param['username'],$num,$sale,$amount,$timebuy,$param['uwho'],$param['uhow'],$param['uwhere'];

