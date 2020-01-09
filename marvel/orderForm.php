<?php

//导入数据库操作的文件
include_once "db_operate.php";

//验证登录
session_start();
if (!@$_SESSION["username"])
{echo '<script>alert("请先进行登录！");location.href=\'login.php\';</script>';}
else
{@$user = $_SESSION["username"];}

//获取订单表的数据
$orderformlist = orderform_select($user);

//订单商品总数量
$length = orderform_count($user)[0];
?>

<html>
<head>
    <title></title>
    <link href="css/decorate_index.css" type="text/css" rel="stylesheet">
    <link href="css/orderForm.css" type="text/css" rel="stylesheet">
    <meta charset="utf-8">
</head>
<body>
<header>
    <img src="img/160621.87815178.jpg">
</header>
<div class="container">
    <ul class="head_ul">
        <li><a href="index.php">全部商品</a></li>
        <li><a href="shoppingcar.php">购物车</a></li>
        <li><a href="#">订单管理</a></li>
        <li><a href="#" onclick="userwho('about_me.php','user.php')">用户中心</a></li>
    </ul>
</div>
<?php for ($i=0;$i<(int)$length;$i++){?>
<?php $orderform = $orderformlist->fetch_array(MYSQLI_ASSOC);?>
<div class="orderinfo">
<ul>
    <li class="ordernum">
        <span><?php echo $orderform['timebuy']?></span>
        <span><?php echo $orderform['orderformid'];?></span>
    </li>
    <li class="orderdetail">
        <div class="prolist">
        <?php $idlist = explode(',',$orderform['productid'])?>
        <?php foreach ($idlist as $productid){?>
            <?php $information = product_detail($productid)?>
            <?php $productinfo = $information->fetch_array(MYSQLI_ASSOC);?>
        <div class="proa">
            <div class="productinfo">
            <ul>
                <li class="listproduct">
                    <div class="list_img"><a href="javascript:;"><img src="<?php echo $productinfo['productimg']?>" alt=""></a></div>
                    <div class="desc">
                        <div class="list_text"><a href="javascript:;"><?php echo $productinfo['productname']?></a></div>
                    <div>
                </li>
            </ul>
            </div>
            <div class="price">
            <p >￥<?php echo $productinfo['productsale']?></p>
            </div>
            <div class="comment">
                <a href="javascript:;" class="com" id="<?php echo $productid?>">评价</a>
            </div>
        </div>
        <?php }?>
            </div>
        <div class="static">
            <p>订单状态：<span><?php echo $orderform['static']?></span></p>
        </div>
    </li>
</ul>
</div>
<?php }?>

<section class="model_com">
    <textarea  id="textcom" cols="30" rows="10" placeholder="评论内容不要超过300字"  maxlength="300" ></textarea>
    <br>
    商品评分：<input type="number" min="0" max="5" step="0.1" id="score">
    <div class="opBtn"><a href="javascript:;" class="dialog-sure">确定</a><a href="javascript:;" class="dialog-close">关闭</a></div>
</section>

</body>
<script src="js/jquery.min.js"></script>
<script>
    var proid = 0;  //保存商品id
    var username = "<?php echo $user?>";
    $('.com').click(function () {
        // console.log(this.id)
        proid = this.id;
        $('.model_com').fadeIn(300);
    });
    $('.dialog-close').click(function () {
        $("#textcom").val("");
        $("#score").val("");
        $('.model_com').fadeOut(300);
    });
    $(".dialog-sure").click(function () {
        var content = $("#textcom").val();
        var score = $("#score").val();
        if (score>5){alert("评分在0~5之间")}
        else {
            $.post("comment.php", {
                    username: username,
                    productid: proid,
                    content: content,
                    score: score
                },
                function (result) {
                    console.log(result)
                    $('.model_com').fadeOut(300);
                    $("#textcom").val("");
                    $("#score").val("");
                })
        }
    })


    function userwho(a,b) {
        var username = '<?php echo $user?>';
        if (username==0){
            alert("请先进行登录！");location.href='login.php';
        }
        else {
            if (username=='aaa'){location.href=a;}
            else {location.href=b;}
        }
    }
</script>
</html>