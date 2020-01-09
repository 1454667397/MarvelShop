<?php
session_start();
require_once 'db_operate.php';
@$id = product_count()+1;
@$product_name=$_POST["product_name"];
@$product_price=$_POST["product_price"];
@$product_sale=$_POST["product_sale"];
@$product_desc=$_POST["product_desc"];
@$product_user=$_SESSION["username"];
@$product_hero=$_POST["hero"];
@$product_num=$_POST["num"];

//判断属于哪个英雄
switch ($product_hero){
    case "钢铁侠":
        $product_hero="钢铁侠";
        break;
    case "绿巨人":
        $product_hero="绿巨人";
        break;
    case "美国队长":
        $product_hero="美国队长";
        break;
    case "蜘蛛侠":
        $product_hero="蜘蛛侠";
        break;
    case "黑寡妇":
        $product_hero="黑寡妇";
        break;
}





if (!empty($_FILES["file"]["name"])){
    $fileinfo = $_FILES["file"];
    $desc1 = $_FILES["desc1"];
    $desc2 = $_FILES["desc2"];
    $desc3 = $_FILES["desc3"];
    $desc4 = $_FILES["desc4"];
    if ($fileinfo["size"]< 20000000)
    {
        if (!file_exists("upload/user/".$product_user."/".$id))
        {mkdir("upload/user/".$product_user."/".$id);}
        move_uploaded_file($fileinfo["tmp_name"],"upload/user/".$product_user."/".$id."/".$fileinfo["name"]);
        mkdir("upload/user/".$product_user."/".$id."/detail");
        move_uploaded_file($desc1["tmp_name"],"upload/user/".$product_user."/".$id."/"."/detail/".$desc1["name"]);
        move_uploaded_file($desc2["tmp_name"],"upload/user/".$product_user."/".$id."/"."/detail/".$desc2["name"]);
        move_uploaded_file($desc3["tmp_name"],"upload/user/".$product_user."/".$id."/"."/detail/".$desc3["name"]);
        move_uploaded_file($desc4["tmp_name"],"upload/user/".$product_user."/".$id."/"."/detail/".$desc4["name"]);
        echo '<script>alert("上传成功！");</script>';
//        echo " alt=\"图片预览:\r文件名:"."upload/".$fileinfo["name"]."\r上传时间:\">";

        //将图片路径保存到数据库
        $product_image = "./upload/user/".$product_user."/".$id."/".$fileinfo["name"];
        $product_detail = "./upload/user/".$product_user."/".$id."/"."/detail/";
        $result = product_insert($product_name,$product_price,$product_sale,$product_detail,$product_image,$product_hero,$product_num);
        echo '<script>location.href="index.php";</script>';
    }
    else{
        echo '<script>alert("文件过大或未知错误")</script>';
    }
}
else{
    echo '<script>alert("未找到上传的文件！");</script>';
}

