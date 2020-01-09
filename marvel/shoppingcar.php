<?php

//导入数据库操作的文件
include_once "db_operate.php";

//验证登录
session_start();
if (!@$_SESSION["username"])
{echo '<script>alert("请先进行登录！");location.href=\'login.php\';</script>';}
else
{@$user = $_SESSION["username"];}

//获取购物车表的数据
$shoppingcarlist = shoppingcar_select($user);


//购物车商品总数量
$length = shppingcar_count($user)[0];
?>

<html>
<head>
    <title></title>
    <link href="css/decorate_index.css" type="text/css" rel="stylesheet">
    <link href="css/carts.css" type="text/css" rel="stylesheet">
    <meta charset="utf-8">
</head>
<body>
<header>
    <img src="img/160621.87815178.jpg">
</header>
<div class="container">
    <ul class="head_ul">
        <li><a href="index.php">全部商品</a></li>
        <li><a href="#">购物车</a></li>
        <li><a href="orderForm.php">订单管理</a></li>
        <li><a href="#" onclick="userwho('about_me.php','user.php')">用户中心</a></li>
    </ul>
</div>
<div>
    <!-- 购物车内容 -->
    <section class="cartMain">
        <!-- 购物车头部信息 -->
        <div class="cartMain_hd">
            <ul class="order_lists cartTop">
                <li class="list_chk">
                    <!--所有商品全选-->
                    <input type="checkbox" id="all" class="whole_check">
                    <label for="all"></label>
                    全选
                </li>
                <li class="list_con">商品信息</li>
                <li class="list_info">库存量</li>
                <li class="list_price">单价</li>
                <li class="list_amount">数量</li>
                <li class="list_sum">金额</li>
                <li class="list_op">操作</li>
            </ul>
        </div>

        <!-- 单个店铺的购物车信息 -->
        <?php for ($i=0;$i<(int)$length;$i++){?>
        <?php $shoppingcar = $shoppingcarlist->fetch_array(MYSQLI_ASSOC);?>
        <?php $information = product_detail($shoppingcar['productid'])?>
            <?php $productinfo = $information->fetch_array(MYSQLI_ASSOC);?>
        <div class="cartBox">
            <!-- 商品信息区域 -->
            <div class="order_content">
                <!-- order_lists 单个商品的信息 -->
                <ul class="order_lists">
                    <!-- 单选框 -->
                    <li class="list_chk">
                        <input type="checkbox" id="<?php echo $shoppingcar['productid']?>" class="son_check">
                        <label for="<?php echo $shoppingcar['productid']?>"></label>
                    </li>
                    <!-- 商品图片和商品文字 -->
                    <li class="list_con">
                        <div class="list_img"><a href="javascript:;"><img src="<?php echo $productinfo['productimg']?>" alt=""></a></div>
                        <div class="list_text"><a href="javascript:;"><?php echo $productinfo['productname']?></a></div>
                    </li>
                    <!-- 商品规格 -->
                    <li class="list_info">
                        <p><?php echo $productinfo['productnum']?>  </p>
                    </li>
                    <!-- 价格 -->
                    <li class="list_price">
                        <p class="price">￥<?php echo $productinfo['productsale']?></p>
                    </li>
                    <!-- 数量个数 -->
                    <li class="list_amount">
                        <div class="amount_box">
                            <a href="javascript:;" class="reduce reSty">-</a>
                            <input type="text" value="<?php echo $shoppingcar['productamount']?>" class="sum">
                            <a href="javascript:;" class="plus">+</a>
                        </div>
                    </li>
                    <!-- 总价格 -->
                    <li class="list_sum">
                        <p class="sum_price">￥<?php echo $productinfo['productsale']*$shoppingcar['productamount']?></p>
                    </li>
                    <!-- 移除商品选项 -->
                    <li class="list_op">
                        <p class="del"><a href="javascript:;" class="delBtn">移除商品</a></p>
                    </li>
                </ul>
            </div>
        </div>
        <?php }?>


        <!--底部-->
        <div class="bar-wrapper">
            <div class="bar-right">
                <div class="piece">已选商品<strong class="piece_num">0</strong>件</div>
                <div class="totalMoney">共计: <strong class="total_text">0.00</strong></div>
                <div class="calBtn"><a href="javascript:;">结算</a></div>
            </div>
        </div>
    </section>
    <section class="model_bg"></section>

    <!-- 移除商品弹出框 -->
    <section class="my_model">
        <p class="title">删除宝贝<span class="closeModel">X</span></p>
        <p>您确认要删除该宝贝吗？</p>
        <div class="opBtn"><a href="javascript:;" class="dialog-sure">确定</a><a href="javascript:;" class="dialog-close">关闭</a></div>
    </section>

    <section class="model">
        <div>
            <ul id="pshow">
            </ul>
        </div>
        <div class="uinfo">
            <form action="" id="buyform">
                <div class="lab">
                    <span>姓名:</span>
                    <input type='text' id="uwho" required="required">
                </div>
                <div class="lab">
                    <span>电话:</span>
                    <input type='text' id="utel" required="required">
                </div>
                <div class="lab">
                    <span>收货地址:</span>
                    <input type='text' id="uwhere" required="required">
                </div>
            </form>
        </div>
        <div class="btnbuy">
            <input type="button" value="关闭" id="btnclose">
            <input type="button" value="购买" id="buy">
        </div>
    </section>


</div>
</body>
<script src="js/jquery.min.js"></script>
<script>
    $(function () {

        //全局的checkbox选中和未选中的样式
        var $allCheckbox = $('input[type="checkbox"]'),     //全局的全部checkbox
            $wholeChexbox = $('.whole_check'),
            $cartBox = $('.cartBox'),                       //每个商铺盒子
            $sonCheckBox = $('.son_check');//每个商铺下的商品的checkbox


        $allCheckbox.click(function () {
            if ($(this).is(':checked')) {
                $(this).next('label').addClass('mark');
            } else {
                $(this).next('label').removeClass('mark')
            }
        });

        //===============================================全局全选与单个商品的关系================================
        $wholeChexbox.click(function () {
            var $checkboxs = $cartBox.find('input[type="checkbox"]');
            if ($(this).is(':checked')) {
                $checkboxs.prop("checked", true);
                $checkboxs.next('label').addClass('mark');
            } else {
                $checkboxs.prop("checked", false);
                $checkboxs.next('label').removeClass('mark');
            }
            totalMoney();
        });


        $sonCheckBox.each(function () {
            $(this).click(function () {
                if ($(this).is(':checked')) {
                    //判断：所有单个商品是否勾选
                    var len = $sonCheckBox.length;
                    var num = 0;
                    $sonCheckBox.each(function () {
                        if ($(this).is(':checked')) {
                            num++;
                        }
                    });
                    if (num == len) {
                        $wholeChexbox.prop("checked", true);
                        $wholeChexbox.next('label').addClass('mark');
                    }
                } else {
                    //单个商品取消勾选，全局全选取消勾选
                    $wholeChexbox.prop("checked", false);
                    $wholeChexbox.next('label').removeClass('mark');
                }
            })
        })



        //========================================每个店铺checkbox与其下商品的checkbox的关系======================================================

        //店铺$sonChecks有一个未选中，店铺全选按钮取消选中，若全都选中，则全选打对勾
        $cartBox.each(function () {
            var $this = $(this);
            var $sonChecks = $this.find('.son_check');
            $sonChecks.each(function () {
                $(this).click(function () {
                    if ($(this).is(':checked')) {
                        //判断：如果所有的$sonChecks都选中则店铺全选打对勾！
                        var len = $sonChecks.length;
                        var num = 0;
                        $sonChecks.each(function () {
                            if ($(this).is(':checked')) {
                                num++;
                            }
                        });

                    } else {
                        //否则，店铺全选取消
                        $(this).parents('.cartBox').find('.shopChoice').prop("checked", false);
                        $(this).parents('.cartBox').find('.shopChoice').next('label').removeClass('mark');
                    }
                    totalMoney();
                });
            });
        });


        //=================================================商品数量==============================================
        var $plus = $('.plus'),
            $reduce = $('.reduce'),
            $all_sum = $('.sum');
        $plus.click(function () {
            var $inputVal = $(this).prev('input'),
                $count = parseInt($inputVal.val())+1,
                $obj = $(this).parents('.amount_box').find('.reduce'),
                $priceTotalObj = $(this).parents('.order_lists').find('.sum_price'),
                $price = $(this).parents('.order_lists').find('.price').html(),  //单价
                $priceTotal = $count*parseInt($price.substring(1));
            $inputVal.val($count);
            $priceTotalObj.html('￥'+$priceTotal);
            if($inputVal.val()>1 && $obj.hasClass('reSty')){
                $obj.removeClass('reSty');
            }
            totalMoney();
        });

        $reduce.click(function () {
            var $inputVal = $(this).next('input'),
                $count = parseInt($inputVal.val())-1,
                $priceTotalObj = $(this).parents('.order_lists').find('.sum_price'),
                $price = $(this).parents('.order_lists').find('.price').html(),  //单价
                $priceTotal = $count*parseInt($price.substring(1));
            if($inputVal.val()>1){
                $inputVal.val($count);
                $priceTotalObj.html('￥'+$priceTotal);
            }
            if($inputVal.val()==1 && !$(this).hasClass('reSty')){
                $(this).addClass('reSty');
            }
            totalMoney();
        });

        $all_sum.keyup(function () {
            var $count = 0,
                $priceTotalObj = $(this).parents('.order_lists').find('.sum_price'),
                $price = $(this).parents('.order_lists').find('.price').html(),  //单价
                $priceTotal = 0;
            if($(this).val()==''){
                $(this).val('1');
            }
            $(this).val($(this).val().replace(/\D|^0/g,''));
            $count = $(this).val();
            $priceTotal = $count*parseInt($price.substring(1));
            $(this).attr('value',$count);
            $priceTotalObj.html('￥'+$priceTotal);
            totalMoney();
        })

        //======================================移除商品========================================

        var $order_lists = null;
        var $order_content = '';
        $('.delBtn').click(function () {
            $order_lists = $(this).parents('.order_lists');
            $order_content = $order_lists.parents('.order_content');
            $('.model_bg').fadeIn(300);
            $('.my_model').fadeIn(300);
        });

        //关闭模态框
        $('.closeModel').click(function () {
            closeM();
        });
        $('.dialog-close').click(function () {
            closeM();
        });
        function closeM() {
            $('.model_bg').fadeOut(300);
            $('.my_model').fadeOut(300);
        }
        //确定按钮，移除商品
        $('.dialog-sure').click(function () {
            $order_lists.remove();
            if($order_content.html().trim() == null || $order_content.html().trim().length == 0){
                $order_content.parents('.cartBox').remove();
            }
            closeM();
            $sonCheckBox = $('.son_check');
            totalMoney();
            var productid = $($order_lists[0]).find('input')[0].id;
            var username = "<?php echo $user?>";
            // 将获取到的商品id发送给服务器进行购物车商品删除
            $.post("shopcardel.php",{
                    productid:productid,
                    username:username
                },
                function (result) {
                    console.log(result)
                })
        })

        //======================================总计==========================================

        function totalMoney() {
            var total_money = 0;
            var total_count = 0;
            var calBtn = $('.calBtn a');
            $sonCheckBox.each(function () {
                if ($(this).is(':checked')) {
                    var goods = parseInt($(this).parents('.order_lists').find('.sum_price').html().substring(1));
                    var num =  parseInt($(this).parents('.order_lists').find('.sum').val());
                    total_money += goods;
                    total_count += num;
                }
            });
            $('.total_text').html('￥'+total_money);
            $('.piece_num').html(total_count);

            // console.log(total_money,total_count);

            if(total_money!=0 && total_count!=0){
                if(!calBtn.hasClass('btn_sty')){
                    calBtn.addClass('btn_sty');
                }
            }else{
                if(calBtn.hasClass('btn_sty')){
                    calBtn.removeClass('btn_sty');
                }
            }
        }


    });

</script>
<script>
//    定义数组存储多个商品的信息
    var id = new Array();
    var productnum = new Array();
    var productsale = new Array();
    var productamount = new Array();
    $(".calBtn").click(function () {
        //模拟框淡进
        $('.model').fadeIn(300);
        //对每个商品循环
        $(".cartBox").each(function () {
            var check = $(this).find("input[type=checkbox]")[0];
            // console.log($(check).is(':checked'))
            //当单选框被选中时，进行以下操作
            if ($(check).is(':checked')){
                var imgsrc = $(this).find("img").attr("src");
                var num = $(this).find(".sum")[0].value;
                var total = $(this).find(".sum_price")[0];
                    total = $(total).text().slice(1);
                //    购买页面追加商品信息
                $("#pshow").append("<li class=\"pinfo\">\n" +
                    "                    <img src="+imgsrc+">\n" +
                    "                    <p>X<span class=\"pnum\">"+num+"</span></p>\n" +
                    "                    <span class=\"pamount\">"+total+"</span>\n" +
                    "                </li>")
                // console.log(check.id)
                id.push(check.id)
                productnum.push(num)
                productsale.push(total/num)
                productamount.push(total)
            }
        })
    });
    //"购买"按钮点击时，将信息传递给gotobuy.php进行下单
    $("#buy").click(function () {
        var uwho = document.getElementById('uwho').value;
        var uhow = document.getElementById('utel').value;
        var uwhere = document.getElementById('uwhere').value;
        var username = "<?php echo $user?>"
        if (uwho=="" || uhow=="" || uwhere=="")
        {alert("请将信息补充完整")}
        else {
    //         // jQuery发起post请求，将数据传递给gotobuy.php页面
            $.post("gotobuy.php",{
                uwho: uwho,
                uhow: uhow,
                uwhere: uwhere,
                id:id.join(),
                productnum:productnum.join(),
                productsale:productsale.join(),
                productamount:productamount.join(),
                username:username

            },
                function (result) {
                    // console.log(result)
                    alert("购买成功!")
                    $('.model').fadeOut(300);
                })
        }
        });

    $("#btnclose").click(function () {
        $('.model').fadeOut(300);
        $(".pinfo").remove();
    });


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