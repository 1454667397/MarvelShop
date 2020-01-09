<?php
require 'db_operate.php';
$Id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';

//如果id不存在 跳转到商品列表
if(!$Id)
{
    echo '<script>alert("参数非法！");location.href="about_me_edit.php";</script>';
}
else{
        if (!$obj = product_delete($Id)) {
            echo '<script>alert("商品不存在！");location.href="about_me_edit.php";</script>';
        } else
            echo '<script>alert("删除成功！");location.href="about_me_edit.php";</script>';

}
