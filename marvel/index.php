<?php
session_start();
if (!@$_SESSION["username"])
{$username=0;}
else{$username = $_SESSION["username"];}
//导入数据库操作的文件
include_once "db_operate.php";
?>

<html>
<head>
	<title></title>
	<link href="css/decorate_index.css" type="text/css" rel="stylesheet">
	<meta charset="utf-8">
</head>
<body onload="bbb()">
<header>
    <img src="img/160621.87815178.jpg">
</header>
<div class="container">
<ul class="head_ul">
<li>全部商品</li>
<li><a href="#" onclick="tohref('shoppingcar.php')">购物车</a></li>
<li><a href="#" onclick="tohref('orderForm.php')">订单管理</a></li>
<li><a href="#" onclick="userwho('about_me.php','user.php')">用户中心</a></li>
</ul>

<div class="left" >
<ul>
<li class="a">全部</li>
<li  class="a">钢铁侠</li>
<li  class="a">美国队长</li>
<li class="a">蜘蛛侠</li>
<li class="a">绿巨人</li>
<li class="a">黑寡妇</li>
</ul>
</div>
<!--    右侧商品-->
<div class="right">
    <ul>
    <?php
    require "right.php";
    for ($i=0;$i<count($products_info);$i++)
    {
        echo '<li><div class="product"><ul>
<a href="productinfo.php?productid='.$products_info[$i]["productid"].'">
<li><img width=100%  height="228" src="'.$products_info[$i]["productimg"].'"></li>
<li>￥'.$products_info[$i]["productprice"].'</li>
<li>'.$products_info[$i]["productname"].'</li>
<li>'.$products_info[$i]["productnum"].'件</li>
<li>'.$products_info[$i]["producthero"].'</li>
</a>
</ul></li>';
    }



    ?>
    </ul>
</div>
</div>
</body>
</html>
<script>
    //当点击英雄名时可以进行筛选
    function bbb() {
        var herosList = document.getElementsByClassName('a')
        for (var i = 0; i < herosList.length; i++) {
            herosList[i].onclick = function () {
                var div_product = document.getElementsByClassName("product");
                var hero = this.firstChild.nodeValue;
                for (var i = 0; i < div_product.length; i++) {
                    var pro_ul = div_product[i].firstChild;
                    var pro_li = pro_ul.getElementsByTagName("li");
                    if (hero == '全部')
                    {div_product[i].parentElement.style.display = "block";continue}
                    if (hero != pro_li[4].firstChild.nodeValue) {
                        div_product[i].parentElement.style.display = "none";
                    }
                    else
                    {div_product[i].parentElement.style.display = "block";}
                    // alert(div_product[i].firstChild);  //获取li的文本内容
                    //pro_li[3].firstChild.nodeValue  //hero名

                }
            }
        }
    }

    // function display() {
    //     var left = document.getElementsByClassName("left");
    //     // alert(left.length);
    //     for (var i = 0; i < left.length; i++) {
    //         var div_content = left[i].childNodes;
    //         var heros = div_content[1].childNodes;  //节点为ul
    //         for (var i = 0; i < heros.length; i++)
    //             if (heros[i].nodeType==1){
    //                 var hero = heros[i].childNodes;
    //                 alert(hero);
    //                 // hero.onClick=function(){
    //                 //     var div_product = document.getElementsByClassName("product");
    //                 //
    //                 //     alert("bbbbbbbbbbbbb");
    //                 //
    //                 // }
    //                 // alert(hero[i].innerhTML);
    //
    //             }
    //     }
    // }
    // function aaa(){
    //
    //     document.getElementById('a').onclick=function() {
    //         var div_product = document.getElementsByClassName("product");
    //         var hero = this.firstChild.nodeValue;
    //         for (var i = 0; i < div_product.length; i++) {
    //             var pro_ul = div_product[i].firstChild;
    //             var pro_li = pro_ul.getElementsByTagName("li");
    //             if ( hero != pro_li[3].firstChild.nodeValue)
    //                 {div_product[i].style.display = "none";}
    //             // alert(div_product[i].firstChild);  //获取li的文本内容
    //             //pro_li[3].firstChild.nodeValue  //hero名
    //         }
    //     }
    // }

</script>
<script>
    function tohref(where) {
        var username = '<?php echo $username?>';
        if (username==0){
        alert("请先进行登录！");location.href='login.php';
        }
        else {
            location.href=where;
        }
    }
    function userwho(a,b) {
        var username = '<?php echo $username?>';
        if (username==0){
            alert("请先进行登录！");location.href='login.php';
        }
        else {
            if (username=='aaa'){location.href=a;}
            else {location.href=b;}
        }
    }
</script>