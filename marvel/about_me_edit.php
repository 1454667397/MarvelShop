//验证是否登录
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
?>
//页面显示

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
    <li><a href="#">用户中心</a></li>
</ul>

<div class="left">
<div class="touxiang">
<input type="hidden" name="face" value=""/>
<img id=\'faceimg\' src='<?php echo $faceURL?>' onclick="javascript:window.open('face.php','face','width=420,height=600,top=0,left=0,scrollbars=1');">
</div>
<figure><?php echo $user?></figure>
<ul>
    <li><a href="about_me.php">发布商品</a></li>
    <li><a href="#">我的商品</a></li>
    <li><a href="login_out.php">退出</a></li>
</ul>
</div>
<div class="rightedit">
    <?php require_once 'db_operate.php';?>
    <?php $productlist = product_info();?>
    <?php $count = product_count();?>
    <?php $length = (int)$count->fetch_array(MYSQLI_NUM)[0];?>
    <?php for ($i=0;$i<$length;$i++){?>
    <?php $productinfo = $productlist->fetch_array(MYSQLI_ASSOC);?>
    <ul class="proinfo">
        <li class="list_info">
            <p><?php echo $productinfo['productid']?> </p>
        </li>
        <li class="list_con">
            <div class="list_img"><img src="<?php echo $productinfo['productimg']?>" alt=""></div>
            <div class="list_text"><?php echo $productinfo['productname']?></div>
        </li>
        <!-- 价格 -->
        <li class="list_price">
            <p class="price">￥<?php echo $productinfo['productsale']?></p>
        </li>
        <!-- 数量个数 -->
        <li class="list_amount">
            <div class="amount_box">
                <input type="number" value="<?php echo $productinfo['productnum']?>" class="num" min="1" onchange="changenum(this)">件
            </div>
        </li>
   </ul>
    <?php }?>
</div>
</body>
<script src="js/jquery.min.js"></script>
<script>
    function changenum(obj) {
        // console.log(obj.value);
        var newnum = obj.value;
        var productid = $(obj).parent().parent().parent().children("li").children("p").html()
        $.post("numchange.php",{
                productid:productid,
                newnum:newnum
            },
            function (result) {
                console.log(result)
                $('.model').fadeOut(300);
            })
    }
</script>
</html>

