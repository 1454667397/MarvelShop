<!DOCTYPE html>
<html lang="utf-8">
<head>
    <meta charset="UTF-8">
    <title>注册页面</title>
    <link href="css/decorate_register.css" type="text/css" rel="stylesheet">
</head>

<body id="home">
<div class="container">
    <div class="border start">
        <form name="register_form" action="PHP/check_register.php" method="post" enctype="multipart/form-data" onsubmit="return check_info()">
            <label>username:</label>
            <input type="text" name="username"><br>
            <label>password:</label>
            <input type="password" name="password"><br>
            <label>repassword:</label>
            <input type="password" name="repassword"><br>
            <label>email:</label>
            <input type="email" name="email"><br>
            <input value="提交" type="submit" name="submit">
        </form>
    </div>
    <a href="login.php">已有账号？点击登录</a>
    <a href="index.php">返回首页</a>
</div>
</body>

<script>
    function check_info() {


        var infomation = document.getElementsByTagName("input");
        // alert(infomation.length);


        //检测未填写的信息     如何返回label值??
        for (var i = 0; i < infomation.length; i++)
            if (!infomation[i].value) {
                alert(infomation[i].name+"不能为空");
                // infomation[i].onfocus();         //自动获取未填写的焦点
                return false;
            }

        //检测密码与重复密码是否一致
        if (infomation[1].value!=infomation[2].value) {
            alert("密码与重复密码不一致！");
            return false;
        }
    }
</script>

</html>