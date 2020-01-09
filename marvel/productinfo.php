<?php
//验证登录
session_start();
if (!@$_SESSION["username"])
{$username=0;}
else{$username = $_SESSION["username"];}
//导入数据库操作的文件
include_once "db_operate.php";



$productid = $_GET['productid'];
$information = product_detail($productid);
$result = $information->fetch_array(MYSQLI_ASSOC);

if (!$productid){echo '<script>alert("参数错误！");location.href=\'index.php\';</script>';}

//获得商品总评论数
$commentcount = comment_count($productid)[0];
//获取评论
$commentlist = comment_select($productid);
//获取评论的用户头像
//$face = user_face($comment['username']);
//echo '<script>alert('.$face["face"].');</script>';
?>
<html>
<head>
    <title>漫威购物网站</title>
    <link href="css/decorate_index.css" type="text/css" rel="stylesheet">
    <link href="css/productinfo.css" type="text/css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
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
        <li><a href="orderForm.php">订单管理</a></li>
        <li><a href="about_me.php">用户中心</a></li>
    </ul>

    <div class="productinfo">
        <div class="info1">
            <div class="product-img">
                <img src="<?php echo $result['productimg']?>" alt="">
            </div>
            <div class="product-buy">
                <p><?php echo $result['productname']?></p>
                <div class="price">
                    <p>价格：<del>￥<?php echo $result['productprice']?></del></p>
                    <p>促销价：<span class="red">￥<?php echo $result['productsale']?></span></p>
                </div>
                <div class="amount_box">
                    <a  class="reduce reSty" onclick="reducenum()">-</a>
                    <input type="text" value="1" class="sum" readonly>
                    <a  class="plus" onclick="addnum()">+</a>
                </div>
<!--                <div class="cansu">-->
<!--                    <p>规模参数</p>-->
<!--                    <input type="button" value="男">-->
<!--                    <input type="button" value="男">-->
<!--                </div>-->
                <div class="buy">
                    <input type="button" value="加入购物车" class="add">
                    <input type="button" value="立即购买" class="gotobuy">
                </div>
            </div>
        </div>
        <!--代码部分begin-->
        <div id="menu">
            <!--tag标题-->
            <ul id="nav" class="info2">
                <li><a href="#" class="selected">商品详情</a></li>
                <li><a href="#" class="">累积评论(<?php echo $commentcount?>)</a></li>
            </ul>
            <!--二级菜单-->
            <div id="menu_con">
                <div class="tag detail" style="display:block">
                    <?php @$detail = scandir($result['productdetail']); unset($detail[0]);unset($detail[1]);?>
                    <!-- 将商品详情的图片循环输出-->
                    <?php foreach ($detail as $value) {?>
                        <img src="<?php echo $result['productdetail'].$value;?>" alt="">
                    <?php }?>
                </div>
                <div class="tag" style="display:none">

                        <ul class="commentList">
                            <!-- 将评论表中每一行数据循环输出  -->
                            <?php for ($i=0;$i<(int)$commentcount;$i++){?>
                            <li class="commentInfo">
                                <span class="face">
                                    <?php $comment = $commentlist->fetch_array(MYSQLI_ASSOC);$face = user_face($comment['username']);?>
                                    <img src="<?php echo $face['face']?>" alt="" class="faceImg">
                                    <p><?php echo $comment['username']?></p>
                                </span>
                                <!-- 评论 -->
                                <span class="content">
                                    <p><?php echo $comment['content']?></p>
                                </span>

                                <!-- 评分 -->
                                <span class="score"><?php echo $comment['score']?></span>
                                <?php }?>
                            </li>
                        </ul>

                </div>
            </div>
        </div>
    </div>


    <section class="my_model">
        <div class="pinfo">
            <img src="<?php echo $result['productimg']?>" alt="">
            <p>X<span id="pnum"></span></p>
            <span id="pamount">￥</span>
        </div>
        <div class="uinfo">
            <form action="" id="buyform">
                <label>
                    <span>姓名:</span>
                    <input type='text' id="uwho" required="required">
                </label>
                <label>
                    <span>电话:</span>
                    <input type='text' id="utel" required="required">
                </label>
                <label>
                    <span>收货地址:</span>
                    <input type='text' id="uwhere" required="required">
                </label>
            </form>
        </div>
        <div class="btnbuy">
            <input type="button" value="关闭" id="btnclose">
            <input type="button" value="购买" id="buy">
        </div>
    </section>
</div>
</body>
</html>
<script>
//    tabs为一个类
    var tabs=function(){
        //获取name标签名的元素列表
        function tag(name,elem){
            return (elem||document).getElementsByTagName(name);
        }
        //获得相应ID的元素
        function id(name){
            return document.getElementById(name);
        }
        //如果该节点的第一个孩子是元素节点，则返回元素节点，否则调用next()函数
        function first(elem){
            elem=elem.firstChild;
            return elem&&elem.nodeType==1? elem:next(elem);
        }
        //循环判断兄弟节点是否为元素节点，是则返回该节点
        function next(elem){
            do{
                elem=elem.nextSibling;
            }while(
                elem&&elem.nodeType!=1
                )
            return elem;
        }
        return {
            set:function(elemId,tabId){
                var elem=tag("li",id(elemId)); //获取id值为elemId的节点下li标签的节点列表
                var tabs=tag("div",id(tabId)); //获取id值为elemId的节点下div标签的节点列表
                var listNum=elem.length;
                var tabNum=tabs.length;
                //对id值为elemId的节点下的元素遍历点击事件
                for(var i=0;i<listNum;i++){
                    elem[i].onclick=(function(i){
                        return function(){
                            for(var j=0;j<tabNum;j++){
                                if(i==j){
                                    tabs[j].style.display="block";
                                    //alert(elem[j].firstChild);
                                    elem[j].firstChild.className="selected";
                                }
                                else{
                                    tabs[j].style.display="none";
                                    elem[j].firstChild.className="";
                                }
                            }
                        }
                    })(i)
                }
            }
        }
    }();
    tabs.set("nav","menu_con");//执行
</script>
<script>

    //   将php变量赋给JavaScript变量
    var productid = <?php echo $result['productid'];?>;
    var productsale = <?php echo $result['productsale'];?>;
    var maxnum = <?php echo $result['productnum'];?>;
    var username = '<?php echo $username?>';
    var productnum = 0;
    //jQuery 加入购物车点击事件
    $(".add").click(function(){
        var num = document.getElementsByClassName('sum')[0].value;
        productnum = num;
        if (username==0){ return alert("请先进行登录！");location.href='login.php'}
        else if (productnum>maxnum){return alert("商品数量有限");}
        //jQuery发起post请求，将数据传递给addshoppingcar.php页面
        $.post("addshoppingcar.php",
            {
                id:productid,
                username:username,
                productsale:productsale,
                productnum:productnum
            },
            function(result){
            console.log(result)
        });
    });
    //jQuery 立即购买点击事件
    $(".gotobuy").click(function(){
        var num = document.getElementsByClassName('sum')[0].value;
        productnum = num;
        if (username==0){alert("请先进行登录！");location.href='login.php'}
        else if (productnum>maxnum){return alert("商品数量有限");}
        // var choice = confirm("是否确认购买？")
        // var model = document.getElementsByClassName('my_model')[0];
        else {
            $('.my_model').fadeIn(300);
            $('#pnum').append(productnum);
            $('#pamount').append(productnum*productsale);
        }
        });
    $("#btnclose").click(function () {
        $('.my_model').fadeOut(300);
        $('#pnum').text("");
        $('#pamount').text("");
    });
    $("#buy").click(function () {
        var uwho = document.getElementById('uwho').value;
        var uhow = document.getElementById('utel').value;
        var uwhere = document.getElementById('uwhere').value;
        if (uwho=="" || uhow=="" || uwhere=="")
        {alert("请将信息补充完整")}
        else {
            // jQuery发起post请求，将数据传递给gotobuy.php页面
            $.post("gotobuy.php",
                {
                    id: productid,
                    username: username,
                    productsale: productsale,
                    productnum: productnum,
                    uwho: uwho,
                    uhow: uhow,
                    uwhere: uwhere
                },
                function (result) {
                    console.log(result)
                });
        }
    });

</script>
<script>
    function addnum() {
        var num = document.getElementsByClassName('sum')[0].value;
        var maxnum = <?php echo $result['productnum']?>;
        num = parseInt(num)+1;
        document.getElementsByClassName('sum')[0].value = num;
        if (num>maxnum){
            alert("商品数量有限");
            document.getElementsByClassName('sum')[0].value = maxnum;
        }
    }
    function reducenum() {
        var num = document.getElementsByClassName('sum')[0].value;
        var maxnum = <?php echo $result['productnum']?>;
        num = parseInt(num)-1;
        document.getElementsByClassName('sum')[0].value = num;
        if (num<1){
            alert("数量至少为1个单位");
            document.getElementsByClassName('sum')[0].value = 1;
        }
    }
</script>