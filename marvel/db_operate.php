<?php


//对用户表的操作
function user_exist($name)   //检测用户是否存在
{
    //用面对对象方式连接数据库
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "select * from user where username='$name'";
    $result = $conn->query($sql);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $conn->close();
    return $row;
}

function user_insert($name,$password,$email)  //往数据库插入用户
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "insert into user(username,password,email) values('$name','$password','$email') ";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function user_password($name)   //获取用户密码1
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "select password from user where username='$name'";
    $result = $conn->query($sql);
    $pwd = $result->fetch_array(MYSQLI_ASSOC);
    $conn->close();
    return $pwd;
}

function user_face($name)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "select face from user where username='$name'";
    $result = $conn->query($sql);
    $pwd = $result->fetch_array(MYSQLI_ASSOC);
    $conn->close();
    return $pwd;
}

function user_face_update($name,$face)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "update  user set face='$face' where username='$name'";
    $result = $conn->query($sql);
//    $pwd = $result->fetch_array(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}

//对商品表的操作
function product_insert($productname,$productprice,$productsale,$productdetail,$productimg,$producthero,$productnum)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "insert into product(productname,productprice,productsale,productdetail,productimg,producthero,productnum) values('$productname','$productprice','$productsale','$productdetail','$productimg','$producthero','$productnum') ";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function product_count()
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "select count(*) from product";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function product_info()
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "select * from product";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}
function product_detail($id)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "select * from product where productid = '$id'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function product_delete($id){
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "delete from product where productid='$id'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}
function product_info_edit($id)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "select * from product where productid='$id'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function product_update($aaa,$id)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "update product set productnum={$aaa} where productid='$id'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}


//对购物车表的操作
function shoppingcar_insert($id,$username,$productamount,$productsale)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "insert into shoppingcar(productid,username,productamount,productsale) values('$id','$username','$productamount','$productsale') ";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}
function shoppingcar_select($username)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "select * from shoppingcar where username = '$username'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}
function shppingcar_count($username)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "select count(*) from shoppingcar where username = '$username'";
    $result = $conn->query($sql);
    $pwd = $result->fetch_array(MYSQLI_NUM);
    $conn->close();
    return $pwd;
}
function shoppingcar_delete($id,$username){
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "delete from shoppingcar where productid='$id' and username='$username'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}
//对订单表的操作
function orderform_insert($orderformid,$id,$username,$productnum,$productsale,$amount,$timebuy,$uwho,$uhow,$uwhere)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "insert into orderform(orderformid,productid,username,productnum,productprice,productamount,timebuy,uwho,utel,uwhere) values('$orderformid','$id','$username','$productnum','$productsale','$amount','$timebuy','$uwho','$uhow','$uwhere')";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}
function orderform_select($username)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "select * from orderform where username = '$username'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}
function orderform_count($username)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "select count(*) from orderform where username = '$username'";
    $result = $conn->query($sql);
    $pwd = $result->fetch_array(MYSQLI_NUM);
    $conn->close();
    return $pwd;
}



//对商品评论表的操作
function comment_select($id)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "select * from comment where productid = '$id'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}
function comment_count($id)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "select count(*) from comment where productid = '$id'";
    $result = $conn->query($sql);
    $pwd = $result->fetch_array(MYSQLI_NUM);
    $conn->close();
    return $pwd;
}
function comment_insert($productid,$username,$content,$score)
{
    $conn = new mysqli("localhost","root","root","wang");
    $sql = "insert into comment(productid,username,content,score) values('$productid','$username','$content','$score')";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

//$aaa = 100;
//$id=1;
//$sql = "update product set productnum = '{$aaa}' where product_id='$id'";
//var_dump($sql);

//$shoppingcarlist = shoppingcar_select('aaa');
//$pwd = $shoppingcarlist->fetch_array(MYSQLI_ASSOC);
//var_dump($pwd);



//$i = 0;
//$a = comment_select(1);
//while ($i<3){
//    $b = $a->fetch_array(MYSQLI_ASSOC);
//    var_dump($b);
//    $i++;
//}


//$result = user_face("aaa");
//var_dump($result["face"]);
//var_dump(user_insert("eee","123456","123456@qq.com"));
//md5($password)  加密
//var_dump(user_password("aaa"));
//var_dump(user_exist(""));
//var_dump(product_insert('a',5,'aaa','a','C:\\Users\\王鸿发\\Desktop\\设计图\\注册.PNG'));
//$result = product_count();
//$result1 = $result->fetch_array(MYSQLI_NUM);
//var_dump($result1);
//$result2 = $result->fetch_array(MYSQLI_ASSOC);
//var_dump($result2);
//$result = user_face_update('aaa','face/003cap_ons_crd_03.jpg');
//var_dump($result);

//$information = product_detail(1);
//$result1 = $information->fetch_array(MYSQLI_ASSOC);
//var_dump($result1);

//$a = date("Y/m/d h:i:sa");
//$a = (string)$a;
//$result1 = orderform_insert('2','bbb',5,99,500,"2019/11/12 01:45:20am");
//var_dump($result1);
//var_dump($a);

//var_dump(user_face('aaa'));