<?php
session_start();
if (!@$_SESSION["username"])
{
    echo '<script>alert("参数错误！");location.href=\'login.php\';</script>';
}
else
    @$user = $_SESSION["username"];

function myreaddir($dir) {
    $handle=opendir($dir);
    $i=0;
    while(!!$file = readdir($handle)) {
        if (($file!=".")and($file!="..")) {
            $list[$i]=$file;
            $i=$i+1;
        }
    }
    closedir($handle);
    return $list;
}
?>
<?php @$facearray = myreaddir(dirname(__FILE__)."/face"); ?>
<div id="face">
    <h3>请选择头像：</h3>

    <?php foreach ($facearray as $num){
        echo "<img width=150px height=150px src='face/".$num."' alt='face/".$num."' title='".$num."'/>";
    } ?>

</div>
<!-- 点击更换头像 -->
<script type="text/javascript">
    window.onload =  function() {
        //获取face.php页面中的头像对象
        var img = document.getElementsByTagName('img');
        //进行循环
        for(var i=0;i<img.length;i++){
            //对选择的对象触发点击事件
            img[i].onclick = function (){
                //调用 _opener()函数
                _opener(this.alt);
            };
        }
    }

    //显示头像函数
    function _opener(src){
        //获取父页面头像对象
        var faceimg = opener.document.getElementById('faceimg');
        //将头像的img更换
        faceimg.src = src;
        var name = 'faceimgSrc';
        document.cookie = name +"="+faceimg.src;
        window.close();
    }
</script>
<?php
//查看$_COOKIE是否保存头像路径；
$faceSrc = $_COOKIE["faceimgSrc"];
$faceSrc = ltrim($faceSrc,'http://localhost:63342/marvel/');
//echo $faceSrc;   //头像的路径

//将路径保存于数据库
require_once "db_operate.php";
$result = user_face_update($user,$faceSrc);
?>