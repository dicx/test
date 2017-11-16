<?php
use frontend\assets\DeatAsset;
use yii\helpers\Url;
DeatAsset::register($this);
$this->beginPage();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>投资页</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<script>
    /*var mask_height=document.documentElement.clientHeight-84+'px';
     var mask_img=$(".mask_f_c img").eq(djg).height();
     $(".mask_f_c").css({height:mask_height});*/
    ////////////////////////////////////////////////////////////////
    var sl=$(".tuatua_f img").length
    $(".tuatua_f img").click(function(){
        $(".mask_f").css({display:"block"});
        djg=$(this).index()//这是获取当前点击的是第几张图片，加1的目的是让图片一一对应起来，不然弹出的数会与实际数少个1
        $(".mask_f_c img").eq(djg).show().siblings().hide();
    });
    $(".left_f").click(function(){
        djg--
        if(djg==-1){
            djg=sl-1
        }
        $(".mask_f_c img").eq(djg).show().siblings().hide();
    })
    $(".right_f").click(function(){
        djg++
        if(djg==sl){
            djg=0
        }
        $(".mask_f_c img").eq(djg).show().siblings().hide();
    })
    $(".mask_f_b").click(function(){
        $(".mask_f").css({display:"none"})
    });
</script>

<?= $content?>



<!--立即投标-->



<?php $this->endBody() ?>
</body>        
</html>    
<?php $this->endPage();?>