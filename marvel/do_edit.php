<?php
require "db_operate.php";
//表单进行了提交处理
if(!empty($_POST['product_name']))
{
    $id = $_POST["product_id"];
    $name = $_POST["product_name"];
    $price = $_POST["product_price"];
    $hero = $_POST["hero"];
    $desc = $_POST["product_desc"];
    //根据商品id校验商品信息
    $result = product_info_edit($id);
    if (!$result)
        echo '<script>alert("参数非法！");location.href="about_me_edit.php";</script>';




    //更新数组
    $update = array(
        'product_name'    => $name,
        'product_price'   => $price,
        'product_desc'     => $desc,
        'product_hero' => $hero
    );

    //仅当用户选择上传图片 才进行图片上传处理
    if($_FILES['file']['size'] > 0)
    {
        $pic = move_uploaded_file($_FILES['file']["tmp_name"],"upload/user/".$_SESSION["username"]."/".$name);
        $update['pic'] = $pic;
    }
    $products_info[] = $result->fetch_array(MYSQLI_ASSOC);

    //只更新被用户修改的信息 对比数据库数据跟用户表单数据

    foreach($update as $k => $v)
    {
        if($products_info[0][$k] == $v)//对应key相等 删除要更新的字段
        {
            unset($update[$k]);
        }
    }

    //对比2个数组 如果没有需要更新的字段
    if(empty($update))
    {
        echo '<script>alert("操作成功！");location.href="about_me_edit.php";</script>';
    }


    $updateSql = '';
    foreach($update as $k => $v)
    {
        $updateSql .= "`{$k}` = '{$v}' ,";
    }
    //去除多余 ,
    $updateSql = rtrim($updateSql, ',');
//
//    unset($sql, $obj, $result);

    //当更新成功
    if(product_update($updateSql,$id))
    {
        //mysql_affected_rows();//影响行数
        echo '<script>alert("操作成功！");location.href="about_me_edit.php";</script>';
    }
    else
    {
        echo '<script>alert("操作失败！");location.href="about_me_edit.php";</script>';
    }

}