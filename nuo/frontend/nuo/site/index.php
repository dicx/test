<?php
use yii\helpers\Url;

?>
<style>
    #write{
        color: #fffefe;
    }
</style>
<!--top-->
<div class="top_f">
    <div class="top_f_in">
        <?php if(!isset($_COOKIE['user'])){?>
        <a href="index.php?r=login/login" class="login_f">登录</a>
        <a href="index.php?r=login/register" class="register_f">注册</a>
        <img src="images/logo3.png"/>
         <?php }else{?>
            <p id="write" style="text-align: center">欢迎【<?= $userName['uname']?>】来到一诺理财</p>
        <?php }?>
    </div>
</div>

<!--banner-->
<div class="callbacks_container">
    <ul class="rslides" id="slider">
        <?php for($i=1;$i<=4;$i++){?>
            <li><a href="banner_xqy.html"><img src="images/pic_home_slider_<?= $i?>.jpg"></a></li>
        <?php }?>
    </ul>
</div>

<!--公告-->
<div class="notice_f">
    <div class="notice_f_in">
        <img src="images/gaogao.png"/>
        <ul>
            <li><a href="#">公告1今日信富微信端上线</a></li>
            <li><a href="#">公告2今日信富微信端上线</a></li>
            <li><a href="#">公告3今日信富微信端上线</a></li>
        </ul>
    </div>
</div>

<!--数据-->
<div class="data_f">
    <ul>
        <li>
            <em>321,103,540</em>
            <span>用户累计投资</span>
        </li>
        <li>
            <em>321,103,540</em>
            <span>用户累计收益</span>
        </li>
        <li>
            <em>321,103,540</em>
            <span>注册用户数量</span>
        </li>
    </ul>
</div>
<!--视频链接-->
<div class="video_f">
    <a class="video_f_in">进入理财教室</a>
</div>
<!--推广标标题-->
<div class="novice_f">
    <div class="novice_f_in">
        <img src="images/tuigpng.png"/>
        <h2>预售产品</h2>
    </div>
</div>
<!--锁定产品-->
<?php foreach ($sData as $key => $val):?>
<div class="novice_zs_f">
    <div class="novice_zs_f_in">
    <!--left-->

        <div class="novice_zs_f_in_l" style="background:url(images/013b1ec6df24.png) no-repeat center; background-size:cover;">
            <!--top-->
            <div class="novice_zs_f_in_l_top">
                <span>敬请期待</span>
            </div>
            <!--bottom-->

            <div class="novice_zs_f_in_l_bottom">
                <ul>
                    <li class="mark1_f" style="width:33%">
                        <em><?= $val['rate']*100?>%</em>
                        <p>年利率</p>
                    </li>
                    <li class="mark2_f" style="width:33%">
                        <em><?= $val['pDeadline']?><font>天</font></em>
                        <p>期限</p>
                    </li>
                    <li class="mark3_f" style="width:33%">
                        <em><font>￥</font><?= round($val['pMoney'],2)?><font>元</font></em>
                        <p>起投金额</p>
                    </li>
                </ul>
            </div>


        </div>
    <!--right-->
        <a href="javascript:void(0)" onclick="lock()">
            <div class="novice_zs_f_in_r">
                <span style=" background:url(images/lijitoubiao.png) no-repeat center"></span>
            </div>
        </a>

    </div>
</div>
<?php endforeach;?>

<!--新手专区标题-->
<div class="novice_f">
    <div class="novice_f_in">
        <img src="images/cainiao.png"/>
        <h2>新手专享</h2>
    </div>
</div>
<!--新手专享-->
<?php foreach ($nData as $key => $val):?>
<div class="novice_zs_f">
    <div class="novice_zs_f_in">
    <!--left-->
        <div class="novice_zs_f_in_l">
            <!--top-->
            <div class="novice_zs_f_in_l_top">
                <img src="images/biao5.png"/>
                <span><?= $val['pName']?></span>
            </div>
            <!--bottom-->
            <div class="novice_zs_f_in_l_bottom">
                <ul>
                    <li class="mark1_f">
                        <em><?= $val['rate']*100?>%</em>
                        <p>年利率</p>
                    </li>
                    <li class="mark2_f">
                        <em><?= $val['pDeadline']?><font>天</font></em>
                        <p>期限</p>
                    </li>
                    <li class="mark3_f">
                        <em><font>￥</font><?= round($val['pMoney'],2)?><font>元</font></em>
                        <p>起投金额</p>
                    </li>
                    <li class="mark4_f">
                        <span>
                            <img src="images/redbl.png"/ style="height:98%;">
                            <p>98%</p>
                        </span>
                    </li>
                </ul>
            </div>
        </div>

    <!--right-->
        <a href="<?= Url::to(['site/deat','pid'=>$val['pid']])?>"><div class='novice_zs_f_in_r'>
            <span style=" background:url(images/lijitoubiao.png) no-repeat center"></span>
        </div></a>
    </div>
</div>
<?php endforeach;?>
<!--1灵活收益&理财计划&散标专区&债权转让-->
<div class="sizdzh_f">
    <ul>
        <input type="hidden" id="csrf" value="<?= Yii::$app->request->csrfToken?>">
       <li class="all" data-all="0">灵活收益</li>
       <li class="all" data-all="1">理财计划</li>
       <li class="all" data-all="3">散标专区</li>
       <li class="all" data-all="4">债券转让</li>
    </ul>
</div>
<!--显示区域-->

<div class="display_f">
    <?php foreach ($proShow as $key => $val):?>
    <!--包的内容-->
    <div class="display_f_in">
        <!--灵活收益-->

        <div class="fourcp_1">
            <!--一条开始-->
            <div class="novice_zs_f_in">
    <!--left-->
        <div class="novice_zs_f_in_l">
            <!--top-->
            <div class="novice_zs_f_in_l_top" >
                <img src="images/biao.png"/>
                <span>测试标不要投</span>
            </div>
            <!--bottom-->

            <div class="novice_zs_f_in_l_bottom">
                <ul>
                    <li class="mark1_f">
                        <em><?= $val['rate']*100?></em>
                        <p>年利率</p>
                    </li>
                    <li class="mark2_f">
                        <em><?= $val['pDeadline']?><font>天</font></em>
                        <p>期限</p>
                    </li>
                    <li class="mark3_f">
                        <em><font>￥</font><?= round($val['pMoney'],2)?><font>元</font></em>
                        <p>投资金额</p>
                    </li>
                    <li class="mark4_f">
                        <span>
                            <img src="images/redbl.png"/ style="height:50%;">
                            <p>50%</p>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    <!--right-->
        <a href="<?= Url::to(['site/deat','pid'=>$val['pid']])?>"><div class="novice_zs_f_in_r">
            <span style=" background:url(images/lijitoubiao.png) no-repeat center"></span>
        </div></a>
    </div>
        </div>
    </div>




    <?php endforeach;?>
</div>

