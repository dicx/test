<body>
<!--项目详情-->
<div class="projectd_f">
    <div class="projectd_f_in">
        <a href="Investment details.html"><img src="images/jian.png"/></a>
        确认订单
    </div>
</div>
<!--2占固定定位的块-->
<div class="occupy_f2"></div>
<!--项目名字-->
<?php foreach ($proData as $key =>$val):?>
<div class="project_name_f">
    <div class="project_name_f_in">
        <?= $val['pName']?>
    </div>
</div>
<!--简单描述-->
<div class="sxdymy_f">
    <div class="sxdymy_f_in">
        <ul>
            <input type="hidden" id="zid" value="<?= $zid?>">
            <input type="hidden" id="pid" value="<?= $val['pid']?>">
            <li>
                <span>标的类型</span>
                <img src="images/biao.png"/>
                <img src="images/biao2.png"/>
            </li>
            <li>
                <span>产品期限</span>
                <i><?= $val['pDeadline']?></i>
            </li>
            <li>
                <span>年利率</span>
                <i><?= $val['rate']*100?>%</i>
            </li>
            <li>
                <span>还款方式</span>
                <i><?php if($val['repaymentType']==1){echo '按月付息，到期还本';}elseif ($val['repaymentType']==2){echo '到期还本付息';}else{echo '等额本息';}?></i>
            </li>
            <li>
                <span>计息方式</span>
                <i><?php if($val['interestRateMethod']==1){echo '当日计息';}else{echo '次日计息';}?></i>
            </li>
            <li>
                <span>投资金额</span>
                <i id="moneyval"><?= $moneyval?></i>
            </li>
            <li>
                <span>利息收益</span>
                <i id="profit"><?= $profit?></i>
            </li>
        </ul>
    </div>
</div>
<!--投注金额-->
<div class="amount_f">
    <div class="amount_f_in">
        支付方式:
        <select name="" id="select">
            <option value="1">余额</option>
            <option value="2">支付宝</option>
            <option value="3">微信</option>
        </select>
    </div>
    <!--可用余额和充值-->
    <div class="kydye_cz">
        <em>可用余额:￥<font id="recharge"><?= $recharge['recharge']?></font></em>
        <a href="#">充值</a>
    </div>
</div>
<!--立即投标-->
<a href="javascript:void(0)" class="woxzjtl_f" id="endbid">立即投标</a>
    <div id="div"></div>
<?php endforeach;?>
<script src="js/jquery.js"></script>
<script>
    $("#endbid").click(function(){
        var select = $("#select").val();
        var zid = $("#zid").val();
        var moneyval = $("#moneyval").text();
        var pid = $("#pid").val();
        var recharge = $("#recharge").text();
        var profit = $("#profit").text();
        if(select ==1){
            $.ajax({
                url:"<?= \yii\helpers\Url::to(['site/endbit'])?>",
                type:"post",
                data:{pid:pid,moneyval:moneyval,profit:profit,recharge:recharge,zid:zid},
                dataType:"json",
                success:function(msg){
                    if(msg.error==0){
                        alert('投标成功');
                        window.location.href='index.php?r=site/index';
                    }else{
                        alert(msg.msg);
                    }
                }
            })
        }else if (select ==2){
            $.ajax({
                url:"<?= \yii\helpers\Url::to(['site/alipay'])?>",
                type:"post",
                data:{moneyval:moneyval,zid:zid},
                dataType:"json",
                success:function(msg){
                    $("#endbid").html(msg.msg);
                }
            })
        }else{
            alert(3);
        }



    })
</script>





