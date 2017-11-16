<?php
use yii\helpers\Url;
?>
<body>
<!--2灵活收益&理财计划&散标专区&债权转让-->
<div class="xfdsctz_f">
    <ul>
        <input type="hidden" id="csrf" value="<?= Yii::$app->request->csrfToken?>">
        <li class="all" data-all="0">灵活收益</li>
        <li class="all" data-all="1">理财计划</li>
        <li class="all" data-all="3">散标专区</li>
        <li class="all" data-all="4">债券转让</li>
    </ul>
</div>
<!--占固定定位的块-->
<div class="occupy_f"></div>
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
                                    <em><font>￥</font><?= $val['pMoney']?><font>元</font></em>
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
<script>
    var eee=$(".display_f_in .fourcp_1 div").length
    alert(eee)
</script>


