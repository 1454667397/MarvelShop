<?php
session_start();  //启动session
require_once 'db_operate.php'; //包含并运行数据库操作文件

//对数据进行预处理
$name=trim($_POST["username"]);
$password=trim($_POST["password"]);
$email=trim($_POST["email"]);

//用户是否已存在
if($name==user_exist($name)["username"])
{
    echo "<script>alert('该用户已存在!');location.href='../login.html'</script>";
}
else{
    if (user_insert($name,$password,$email))
        {
            $_SESSION["username"]=$name;
            echo "<script>alert('注册成功!');location.href='../index.html'</script>";
        }
    else
        echo "<script>alert('注册失败!');</script>";
}
