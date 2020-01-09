<?php
/**
 * Created by PhpStorm.
 * User: 王鸿发
 * Date: 2019/6/18
 * Time: 16:50
 */
session_start();
//释放user
unset($_SESSION['username']);
echo '<script>alert("退出登录成功!！");location.href=\'login.php\';</script>';