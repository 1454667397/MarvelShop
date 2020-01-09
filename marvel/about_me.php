<?php
session_start();
if (!@$_SESSION["username"])
{
    echo '<script>alert("请先进行登录！");location.href=\'login.php\';</script>';
}
else
    @$user = $_SESSION["username"];

//获取头像
require_once "db_operate.php";
$faceURL = user_face($user);
$faceURL = $faceURL["face"];
if ($faceURL==""){
    $faceURL = './face/002irm_ons_crd_03.jpg';
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="css/decorate_index.css" type="text/css" rel="stylesheet">
	<link href="css/decorate_about_me.css" type="text/css" rel="stylesheet">
	<meta charset="utf-8">
</head>
<body>
<header><img src="img/160621.87815178.jpg"></header>
<div class="container">
<ul class="head_ul">
    <li><a href="index.php">全部商品</a></li>
    <li><a href="shoppingcar.php">购物车</a></li>
    <li><a href="orderForm.php">订单管理</a></li>
    <li><a href="about_me.php">用户中心</a></li>
</ul>

<div class="left">
<div class="touxiang">
<input type="hidden" name="face" value=""/>
<img id="faceimg" src='<?php echo $faceURL?>' onclick="javascript:window.open('face.php','face','width=420,height=600,top=0,left=0,scrollbars=1');">

</div>
<figure><?php echo $user?></figure>
<ul>
<li><a href="#">发布商品</a></li>
<li><a href="about_me_edit.php">商品库存</a></li>
<li><a href="login_out.php">退出</a></li>
</ul>
</div>
<div class="right">
	<form name="product_sell" enctype="multipart/form-data" method="post" action="product_dispose.php" onsubmit="return check_info();">
	<table>
		<tr>
			<td>商品名称:</td>
			<td><input type="text" name="product_name"></td>
		</tr>
		<tr>
			<td>原价:</td>
			<td><input type="text" name="product_price" id="product_price" oninput="value=value.replace(/[^\d]/g,\'\')">元</td>
		</tr>
        <tr>
            <td>售价:</td>
            <td><input type="text" name="product_sale" id="product_sale" oninput="value=value.replace(/[^\d]/g,\'\')">元</td>
        </tr>
		<tr>
			<td>图片:</td>
			<td><input type="file" name="file" accept="image/png,image/gif,imgae/jpeg"></td>
		</tr>
        <tr>
            <td>商品详情:</td>
            <td><input type="file" name="desc1" accept="image/png,image/gif,imgae/jpeg">
            <input type="file" name="desc2" accept="image/png,image/gif,imgae/jpeg">
            <input type="file" name="desc3" accept="image/png,image/gif,imgae/jpeg">
            <input type="file" name="desc4" accept="image/png,image/gif,imgae/jpeg"></td>
        </tr>
		<tr>
			<td>英雄:</td>
			<td>
				<input type="radio" name="hero" value="钢铁侠">钢铁侠
				<input type="radio" name="hero" value="美国队长">美国队长
				<input type="radio" name="hero" value="蜘蛛侠">蜘蛛侠
				<input type="radio" name="hero" value="绿巨人">绿巨人
				<input type="radio" name="hero" value="黑寡妇">黑寡妇
			</td>
		</tr>
		<tr>
			<td>库存数量:</td>
			<td><input type="number" name="num"></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="发布"></td>
			<td><input type="reset" name="reset" value="重置"></td>
		</tr>
	</table>
	</form>
</div>
</div>
</body>
<script type="text/javascript">
    function check_info() {
        var right = document.getElementsByClassName("right");
        var infomation = right[0].getElementsByTagName("input");
        // alert(infomation.length);

        //检测未填写的信息     如何返回label值??
        for (var i = 0; i < infomation.length; i++)
            // alert(infomation[i].value)
            if (!infomation[i].value) {
                alert(infomation[i].parentNode.previousSibling.previousSibling.innerHTML+"不能为空");
                // infomation[i].onfocus();         //自动获取未填写的焦点
                return false;
            }

    }
</script>
</html>
