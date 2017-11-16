<body>
<!--项目详情-->
<div class="projectd_f">
	<div class="projectd_f_in">
    	<a href="javascript:void(0)" class="history"><img src="images/jian.png"/></a>
        立即投标
    </div>
</div>
<?php foreach ($proInfo as $key => $val):?>
<!--2占固定定位的块-->
<div class="occupy_f2"></div>

<!--简单描述-->
<div class="sxdymy_f">
	<div class="sxdymy_f_in">
    	<ul>
        	<li>
            	<span>标的类型</span>
                <img src="images/biao.png"/>
                <img src="images/biao2.png"/>
            </li>
            <li>
                <input type="hidden" id="pid" value="<?= $val['pid']?>">
                <span>年利率</span>
                <i><?= $val['rate']*100?>%</i>
            </li>
        	<li>
            	<span>起投金额</span>
                <i>￥<?= $val['pMoney']?></i>
            </li>
            <li>
            	<span>可投金额</span>
                <i>￥<?= $val['upperAmount']?></i>
            </li>
        </ul>
    </div>
</div>
<!--投注金额-->
<div class="amount_f">
	<div class="amount_f_in">
		<input type="text" id="money" value="">
    </div>
    <!--预期收益-->
    <div class="wcydl_f" style="width:94%;height:30px;margin:0 auto;line-height:30px;font-size:14px;">
    <em style="font-style:normal;color:#999;">预期收益：¥</em><i id="profit" style="font-style:normal;color:#999;">0</i>
    </div>
    <!--可用余额和充值-->
    <div class="kydye_cz">
    	<em>可用余额:¥<font id="recharge"><?= $recharge['recharge']?></font></em>
        <a href="#">充值</a>
    </div>    
</div>
    <!--立即投标-->
    <a href="javascript:void(0)" class="woxzjtl_f" id="endbid">立即投标</a>
<?php endforeach;?>

</body>
<script src="js/jquery.js"></script>
<script>
    //计算收益
        $("#money").blur(function(){
            var moneyval = $(this).val();
            var pid = $("#pid").val();
            $.ajax({
                url:"<?= \yii\helpers\Url::to(['site/addpro'])?>",
                type:"post",
                data:{moneyval:moneyval,pid:pid},
                dataType:"json",
                success:function(msg){
                    if(msg.code ==0){
                        $("#profit").text(msg.msg);
                    }else{
                        $("#profit").text(msg.msg);
                    }
                }
            })
        });
    //返回上一页
        $(".history").click(function() {
            history.go(-1);
        });

    //立即投标
        $("#endbid").click(function(){
            var moneyval = $("#money").val();
            var pid = $("#pid").val();
            var recharge = $("#recharge").text();
            var profit = $("#profit").text();
            if(moneyval > recharge){
                alert('余额不足');
                return false;
            }else{
                $.ajax({
                    url:"<?= \yii\helpers\Url::to(['site/sure'])?>",
                    type:"post",
                    data:{pid:pid,moneyval:moneyval,profit:profit,recharge:recharge},
                    dataType:"json",
                    success:function(msg){
                        if(msg.error==0){
                            alert('点击确定进入确认订单页面');
                            window.location.href='index.php?r=site/sureorder&pid='+msg.pid+'&moneyval='+msg.moneyval+'&profit='+msg.profit+'';
                        }else{
                            alert(msg.msg);
                        }
                    }
                })
            }



        })
</script>
    

            
            
        
