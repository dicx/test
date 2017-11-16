<?php

use yii\helpers\Url;

?>

<!--项目详情-->
<div class="projectd_f">
    <div class="projectd_f_in">
        <a href="<?= Url::to(['site/index'])?>"><img src="images/jian.png"/></a>
        项目详情
    </div>
</div>
<!--2占固定定位的块-->
<div class="occupy_f2"></div>
<!--内容-->
<?php foreach ($oneData as $val):?>
<div class="neirbg_f">

    <div class="neirbg_f_in">
        <h2>用户:<?= $uName['username']?></h2>
        <div class="twobf_f">
            <ul>
                <li>
                    <em>年化收益</em>
                    <p><?= $val['rate']*100?><font>%</font></p>
                </li>
                <li>
                    <em>投资期限</em>
                    <p><?= $val['pDeadline']?><font>天</font></p>
                </li>
            </ul>
        </div>
    </div>

</div>

<!--投资金额和进度-->
<div class="tozije_f">
    <div class="tozije_f_in">
        <ul>
            <li>
                <em>金额</em>
                <p><font>￥</font><?= $val['upperAmount']?></p>
            </li>
            <li>
                <em>可投金额</em>
                <p><font>￥</font><?= $val['upperAmount']?></p>
            </li>
            <li>
                <em>起投金额</em>
                <p><font>￥</font><?= $val['pMoney']?></p>
            </li>
        </ul>
    </div>
</div>
<!--这几项不知道有没有用，没有用就注释了-->
<div class="sxdymy_f">
    <div class="sxdymy_f_in">
        <ul>
            <li>
                <span>标的类型</span>
                <img src="images/biao.png"/>
                <img src="images/biao2.png"/>
            </li>
            <li>
                <span>保障方式</span>
                <i><?= $val['guaranteeMode']?></i>
            </li>
            <li>
                <span>月投资金额</span>
                <i>500-20,000元</i>
            </li>
            <li>
                <span>退出日期</span>
                <i><?= $val['exitDate']?></i>
            </li>
            <li>
                <span>收益处理方式</span>
                <i style="color:#3DB1FA"><?php if($val['repaymentType']==1){echo '按月付息，到期还本';}else if($val['repaymentType']==2){echo '到期还本付息';}else{echo '等额本息';}?></i>
            </li>
        </ul>
    </div>
</div>
<!--两个选择项-->
<div class="zslgxzx_f">
    <div class="zslgxzx_f_in">
        <ul>
            <li class="addys_f3">计划介绍</li>
            <li>投标记录</li>
        </ul>
    </div>
</div>

<!--显示区域2-->
<div class="xsiqy_f">
    <!--包2-->
    <div class="xsiqy_f_in">
        <!--借入描述-->
        <div class="xsiqy_f_in_1">
            <!--文字信息-->
            <div class="wnzims_f">
                <dl>
                    <dt>计划介绍</dt>
                    <dd><?= $val['productIntroduction']?></dd>
                </dl>
            </div>

        </div>
        <!--投标记录-->
        <div class="xsiqy_f_in_1">
            <div class="huankdxy_f">

            </div>
        </div>
    </div>
</div>
    <a href="<?= Url::to(['site/addpro','pid'=>$val['pid']])?>" class="lijitoubiaocx_f">立即投标</a>
<?php endforeach;?>
            
                
	
                            
