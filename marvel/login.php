
<!DOCTYPE html>
<html lang="utf-8">
<head>
    <meta charset="UTF-8">
    <title>登录页面</title>
    <link href="css/decorate_login.css" type="text/css" rel="stylesheet">
</head>
<body id="home">
<div class="container">
    <div class="border start">
        <form name="register_form" action="check_login.php" method="post" enctype="multipart/form-data" onsubmit="return check_info()">
            <label>username:</label>
            <input type="text" name="username"><br>
            <label>password:</label>
            <input type="password" name="password"><br>
            <input value="登录" type="submit" name="submit">
        </form>
    </div>
    <a href="register.php">没有账号？点击注册</a>
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

    }
</script>

</html>