<?php
use frontend\assets\MainAsset;
use yii\helpers\Url;
MainAsset::register($this);
$this->beginPage();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>index</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<!--banner-->
<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<script type="text/javascript">
    window.onload=function(){
        $(function () {
            // Slideshow
            $("#slider").responsiveSlides({
                auto: true,
                pager: false,
                nav: true,
                speed: 500,
                timeout:4000,
                pager: true,
                pauseControls: true,
                namespace: "callbacks"
            });
        });

        var q=0
        var f=$(".notice_f_in ul li").length
        $(".notice_f_in ul li").first().css({display:"block"}).siblings().css({display:"none"});
        function ggds(){
            q++
            if(q==f)
            {q=0}
            $(".notice_f_in ul li").eq(q).css({display:"block"}).siblings().css({display:"none"});
            }
        setInterval(ggds,4000);
    }
</script>
<?= $content?>

<script>
    function lock(){
            alert('该产品还在预售期中');
        return false;
        }
</script>


<script>
    window.onload=function () {
        $(".all").on('click',function(){
            var status = $(this).data('all');
            var csrf   = $('#csrf').val();
            $.ajax({
                url:"index.php?r=site/investment",
                type:"post",
                data:{status:status,_csrf:csrf},
                dataType:"json",
                success:function(msg){
                    //console.log(msg.msg);return;
                    $(".display_f").html(_str(msg.msg));
                }
            })
        })
    };
    function _str(data){
        var str = '';
        $.each(data,function(k,v){
            str+= '<div class=\"display_f_in\">';
            str+= '<div class=\"fourcp_1\">';
            str+= '<div class=\"novice_zs_f_in\">';
            str+= '<div class=\"novice_zs_f_in_l\">';
            str+= '<div class=\"novice_zs_f_in_l_top\">';
            str+= '<img src=\"images/biao.png\">';
            str+= '<span>测试标不要投</span>';
            str+= '</div>';
            str+= '<div class=\"novice_zs_f_in_l_bottom\">';
            str+= '<ul>';
            str+= '<li class=\"mark1_f\">';
            str+= '<em>'+v.rate*100+'</em>';
            str+= '<p>年利率</p>';
            str+= '</li>';
            str+= '<li class=\"mark2_f\">';
            str+= '<em>'+v.pDeadline+'<font>天</font></em>';
            str+= '<p>期限</p>';
            str+= '</li>';
            str+= '<li class=\"mark3_f\">';
            str+= '<em><font>￥</font>'+v.pMoney+'<font>元</font></em>';
            str+= '<p>投资金额</p>';
            str+= '</li>';
            str+= '<li class=\"mark4_f\">';
            str+= '<span>';
            str+= '<img src=\"images/redbl.png\" style=\"height:50%;\">';
            str+= ' <p>50%</p>';
            str+= '</span>';
            str+= '</li>';
            str+= '</ul>';
            str+= '</div>';
            str+= '</div>';
            str+= '<a href=\"index.php?r=site/deat&pid='+v.pid+'\"><div class=\"novice_zs_f_in_r\">';
            str+= '<span style=\" background:url(images/lijitoubiao.png) no-repeat center\"></span>';
            str+= '</div></a>';
            str+= '</div>';
            str+= '</div>';
            str+= '</div>';
        });
        return str;
    }
</script>
<!--底部导航栏-->
<div class="footerdhl_f">
    <a href="<?= Url::to(['site/index'])?>">
        <b class="movek_f"><img src="images/zhuye.png"/></b>
        <p>首页</p>
    </a>
    <a href="<?= Url::to(['site/investment'])?>">
        <b><img src="images/touzi.png"/></b>
        <p>投资</p>
    </a>
    <a href="<?= Url::to(['user/index'])?>">
        <b><img src="images/grzx.png"/></b>
        <p>账户</p>
    </a>
    <a href="more.html">
        <b><img src="images/mores.png"/></b>
        <p>更多</p>
    </a>
</div>

<?php $this->endBody() ?>
</body>        
</html>    
<?php $this->endPage();?>