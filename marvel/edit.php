<?php
session_start();
require "db_operate.php";
if (!@$_SESSION["username"])
{
    echo '<script>alert("请先进行登录！");location.href=\'login.php\';</script>';
}
else
    @$user = $_SESSION["username"];
$Id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '';
if(!$Id)
{
    echo '<script>alert("参数非法！");location.href="about_me_edit.php";</script>';
}
$result = product_info_edit($Id);
if (!$result)
{
    echo '<script>alert("商品不存在！");location.href="about_me_edit.php";</script>';
}
$products_info=[];
$products_info = $result->fetch_array(MYSQLI_ASSOC);


?>
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
<li>description</li>
<li><a href="index.php">product</a></li>
<li><a href="about_me.php">about me</a></li>
</ul>

<div class="left">
<div class="touxiang"><img src="img/002irm_ons_crd_03.jpg"></div>
<figure><?php echo $user?></figure>
<ul>
<li><a href="about_me.php">发布商品</a></li>
<li><a href="about_me_edit.php">我的商品</a></li>
</ul>
</div>
<div class="right">
	<form name="product_sell" enctype="multipart/form-data" method="post" action="do_edit.php" onsubmit="return check_info()">
	<table>
		<tr>
			<td>商品名称:</td>
			<td><input type="text" name="product_name" value="<?php echo $products_info["product_name"]?>"></td>
		</tr>
		<tr>
			<td>价格:</td>
			<td><input type="text" name="product_price" id="product_price" value="<?php echo $products_info["product_price"]?>">元</td>
		</tr>
		<tr>
			<td>图片:</td>
			<td><input type="file" name="file" accept="image/png,image/gif,imgae/jpeg"></td>
		</tr>
		<tr>
			<td>英雄:</td>
			<td>
				<input type="radio" name="hero" value="钢铁侠" <?php if($products_info["product_hero"]=="钢铁侠") echo("checked");?>>钢铁侠
				<input type="radio" name="hero" value="美国队长" <?php if($products_info["product_hero"]=="美国队长") echo("checked");?>>美国队长
				<input type="radio" name="hero" value="蜘蛛侠" <?php if($products_info["product_hero"]=="蜘蛛侠") echo("checked");?>>蜘蛛侠
				<input type="radio" name="hero" value="绿巨人" <?php if($products_info["product_hero"]=="绿巨人") echo("checked");?>>绿巨人
				<input type="radio" name="hero" value="黑寡妇" <?php if($products_info["product_hero"]=="黑寡妇") echo("checked");?>>黑寡妇
			</td>
		</tr>
		<tr>
			<td>商品描述:</td>
			<td><textarea cols="50" rows="25" placeholder="请输入0至300个字" name="product_desc"><?php echo $products_info["product_desc"]?></textarea></td>
		</tr>
        <tr><td><input type="hidden" name="product_id" value="<?php echo $products_info['product_id']?>"></td></tr>
		<tr>
			<td><input type="submit" name="submit" value="发布"></td>
			<td><input type="reset" name="reset" value="重置"></td>
		</tr>
	</table>
	</form>
</div>
</div>
</body>
</html>
<script type="text/javascript">
   function check_info() {


       var right = document.getElementsByClassName("right");
       var infomation = right[0].getElementsByTagName("input");
        // alert(infomation.length);
 
        // //检测未填写的信息     如何返回label值??
        for (var i = 0; i < infomation.length; i++)
        {
            if (infomation[i].type=='file')
            {continue;}
            if (!infomation[i].value) {
                alert(infomation[i].parentNode.previousSibling.previousSibling.innerHTML+"不能为空");
                // infomation[i].onfocus();         //自动获取未填写的焦点
                return false;

            }
        }
        var describtion = document.getElementsByTagName('textarea');
        // alert(typeof(describtion[0].value.length))
        if (describtion[0].value.length>300) {
        	alert("商品描述不能超过300字");
        	return false;
        }
        if (describtion[0].value.length==0) {
        	alert("请添加商品描述");
        	return false;
        }



    }


</script>
