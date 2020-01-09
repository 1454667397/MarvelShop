<?php
session_start();
require_once 'db_operate.php';
$name=trim($_POST["username"]);
$password=trim($_POST["password"]);

//用户是否存在
if (user_exist($name))
{
    //用户输入密码是否正确
    if($password==user_password($name)["password"]) {
        $_SESSION["username"]=$name;
        echo "<script>alert('登录成功!');location.href='index.php'</script>";
    }
    else
        echo "<script>alert('密码错误');location.href='login.php'</script>";
}
else
    echo "<script>alert('该用户不存在!')</script>";

//echo $name;
//var_dump(user_exist($name))