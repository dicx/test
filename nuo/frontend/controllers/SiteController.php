<?php
namespace frontend\controllers;

use frontend\models\Order;
use vendor\alipay\AlipayPay;
use Yii;
use yii\web\Controller;
use frontend\models\Product;
use frontend\models\User;
use frontend\models\Log;
use frontend\models\Error;


/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    private  $request;

    public function init(){
        parent::init();
        $this->request = Yii::$app->request;
    }

    //首页
    public function actionIndex()
    {
        $this->layout = 'main';
        $user = isset($_COOKIE['user'])?$_COOKIE['user']:"游客";
        if(preg_match("/^\d*$/",$user)){
            $userData = User::find()->where("id=$user")->select('cellPhone,username')->asArray()->one();
//            print_r($userData);
            if(empty($userData['username'])){
                $userData['uname'] = $userData['cellPhone'];
            }else{
                $userData['uname'] = $userData['username'];
            }
        }else{
            $userData['uname'] = $user;
        }
        $product = Product::find()->where('pStatus=1 and dStatus=0')->asArray()->all();
        $proShow = Product::find()->where("pType = 0")->asArray()->orderBy('pid DESC')->limit(1)->all();
        $sData = array();
        $nData = array();
        $pData = array();
        foreach ($product as $key => $val){
            if($val['lockOut'] > date('Y-m-d H:i:s')){
                $sData[] = $val;
            }
            if($val['pType'] == 2){
                $nData[] = $val;
            }else{
                $pData[] = $val;
            }
        }

        return $this->render('index',[
            'pData'=> $product,
            'sData'=> $sData,
            'nData'=> $nData,
            'pData'=> $pData,
            'proShow'=> $proShow,
            'userName'=>$userData
        ]);
    }
    //ajax传来值判断产品类型
    public function actionInvestment(){
        if($_POST){
            if(!SiteController::actionIsAdmin()){
                echo Error::reponse( 5000, '权限不足' );
                return false;
            }else{
            $status = $this->request->post('status');
            $proShow = SiteController::actionPshow($status);
            echo json_encode(array(
                'error'=>0,
                'msg'=>$proShow
            ));
            }
        }else{
            $proShow = SiteController::actionPshow();
            return $this->render('investment',array(
                'proShow'=> $proShow
            ));
        }
    }
    //根据产品类型获取对应的产品数据
    public function actionPshow($status=0){
        $pShow = Product::find()->where("pType = $status")->asArray()->all();
        $proShow = array();
        foreach ($pShow as $key => $val){
            if($val['lockOut'] < date('Y-m-d H:i:s') ){
                $proShow[] = $val;
            }
        }
        return $proShow;
    }
    //产品详情页
    public function actionDeat(){
        $this->layout = 'deat';
        $pid = $this->request->get('pid');
        if(!isset($_COOKIE['user'])){
            $this->redirect('index.php?r=login/login');
        }
        $uid = $_COOKIE['user'];
        $uName = User::find()->select('username')->where("id = $uid")->asArray()->one();
        $proData = Product::find()->where("pid = $pid")->asArray()->all();
        $log = Log::find()->where("uid = $uid")->asArray()->orderBy('id DESC')->limit(5)->all();
//        print_r($log);
        $data = array();
        foreach ($log as $key =>$val){
            print_r($val);
        }
        return $this->render('deat',array(
            'oneData'=>$proData,
            'uName'=>$uName
        ));
    }
    //用户购买产品提交
    public function actionAddpro()
    {
        if ($this->request->isAjax) {
            $pid = $this->request->post('pid');
            $moneyval = $this->request->post('moneyval');
            $proInfo = Product::find()->where("pid = $pid")->asArray()->one();
            if(empty($moneyval)){
                echo Error::reponse( 5001, '请填写要投资的金额' );
                return false;
            }
            if($moneyval<$proInfo['pMoney']){
                echo Error::reponse( 5002, '您投资金额小于产品金额' );
                return false;
            }

            $pDeadline = $proInfo['pDeadline']/30;
            $rate = $proInfo['rate']/12;
            $profit = $moneyval*$rate*$pDeadline;
            echo json_encode(array(
                'code'=>0,
                'msg'=>$profit
            ));
        }else{
            $pid = $this->request->get('pid');
            if(!isset($_COOKIE['user'])){
                $this->redirect('index.php?r=login/login');
            }
            $uid = $_COOKIE['user'];
            $userInfo = User::find()->where("id = $uid")->select('recharge')->asArray()->one();
            $proInfo  = Product::find()->where("pid = $pid")->asArray()->all();
            return $this->render('addpro', array(
                'proInfo' => $proInfo,
                'recharge'=>$userInfo
            ));
        }
    }
    //验证投资数据
    public function actionSure(){
        if($this->request->isAjax){
            $pid = $this->request->post('pid');
            $recharge = $this->request->post('recharge');
            $profit = $this->request->post('profit');
            $moneyval = $this->request->post('moneyval');
            if(!isset($recharge) && !isset($moneyval)){
                echo Error::reponse( 5003, '请准确填写信息' );
                return false;
            }
            if($moneyval>$recharge){
                echo Error::reponse( 5004, '您的余额不足' );
                return false;
            }
            if($moneyval<0){
                echo Error::reponse( 5005, '您提交的金额不合法' );
                return false;
            }
            echo json_encode(array(
                'error'=>0,
                'pid'=>$pid,
                'moneyval'=>$moneyval,
                'profit'=>$profit
            ));

        }else{
            echo '错误';
            return false;
        }
    }
    //确定订单
    public function actionSureorder(){
        if($this->request->get()){
            $uid =0;
            if(!isset($_COOKIE['user'])){
                $this->redirect('index.php?r=login/login');
            }else{
                $uid = $_COOKIE['user'];
            }
            $pid = $this->request->get('pid');
            $profit = $this->request->get('profit');
            $moneyval = $this->request->get('moneyval');
//        print_r($moneyval);die;
            //生成订单
            $connection = Yii::$app->db;
            //调用订单编号方法
            $ordNum = SiteController::actionOrdnum();
            $time = date('Y-m-d H:i:s');
            $pName = Product::find()->where("pid=$pid")->select('pName')->asArray()->one();
            $tr = Yii::$app->db->beginTransaction();
            try {
                $ins = $connection->createCommand()->insert('nuo_order', [
                    'ordName'=>$pName['pName'],
                    'ordNumber'  =>$ordNum,
                    'pid'        =>$pid,
                    'uid'        =>$uid,
                    'createTime' =>$time,
                    'userAmount' =>$moneyval
                ])->execute();
                $zid = $connection->getLastInsertId();
                if($ins){
                    echo Error::reponse( 0, '生成订单成功' );
                }else{
                    echo Error::reponse( 5005, '生成订单失败' );
                    return false;
                }
                //提交
                $tr->commit();
            } catch (Exception $e) {
                //回滚
                $tr->rollBack();

            }

            $proData = Product::find()->where("pid = $pid")->asArray()->all();
            $recharge = User::find()->where("id = $uid")->select('recharge')->asArray()->one();
            return $this->render('sureorder',array(
                'zid'=>$zid,
                'moneyval'=>$moneyval,
                'proData'=>$proData,
                'recharge'=>$recharge,
                'profit'=>$profit
            ));
        }else{
            echo '异常';
            return false;
        }
    }


    //立即投标--余额支付
    public function actionEndbit(){
        if($this->request->isAjax){
            $pid = $this->request->post('pid');
            $zid = $this->request->post('zid');
            if(!isset($_COOKIE['user'])){
                $this->redirect('index.php?r=login/login');
            }
            $uid = $_COOKIE['user'];
            $moneyval = $this->request->post('moneyval');
//            print_r($moneyval);die;
            $connection = Yii::$app->db;
            $time = date('Y-m-d H:i:s');
            $updata = $connection->createCommand("UPDATE nuo_user SET `recharge` = recharge-$moneyval WHERE id=$uid")->execute();
            $order = $connection->createCommand("UPDATE nuo_order SET `ordStatus`=1 WHERE id=$zid")->execute();
            if(!$updata){
                echo '用户扣减失败';
                return false;
            }
            if(!$order){
                echo '状态修改失败';
                return false;
            }
            $log = $connection->createCommand()->insert('nuo_log', [
                'zid'        =>$zid,
                'pid'        =>$pid,
                'uid'        =>$uid,
                'createTime' =>$time,
                'recharge'   =>$moneyval
            ])->execute();
            if($log){
                echo Error::reponse(0,'投标成功');
            }


            //根据产品id查询产品信息
            //$proInfo = Product::find()->where("pid = $pid")->asArray()->one();





            /*
            switch ($proInfo['repaymentType']){
                //1：按月付息，到期还本
                case 1:
                    //按30天为一月计算,计算产品期限有多少个30天
                    $pDeadline = $proInfo['pDeadline']/30;
                    //根据年利率除去12个月算出每个月的利率
                    $rate = $proInfo['rate']/12;
                    //投资的钱*每个月的利率得出每个月收益
                    $profit = $moneyval*$rate;
                    //得出每个月的利息每经过30天给用户余额添加上利息
                    break;
                //2：到期还本付息
                case 2:
                    break;
                //3：等额本息
                case 3:
                    break;

            }
            */

        }else{
            echo '请走正确渠道';
            return false;
        }
    }
    //立即投标--支付宝支付
    public function actionAlipay(){
        $zid = $this->request->post('zid');
        $moneyval = $this->request->post('moneyval');
        $order = Order::find()->where("id=$zid")->asArray()->one();
        $alipay = new AlipayPay();
        $payUrl = $alipay->requestPay($order['ordNumber'],$order['ordName'],$moneyval,'','');
//        $this->redirect($payUrl);
//        $this->render('sureorder',array(
//            'payUrl'=>$payUrl
//        ));
        echo json_encode(array(
            'error'=>0,
            'msg'=>$payUrl
        ));
    }
    //支付宝同步处理
    public function actionReturn(){
        $getData = $this->request->get();
        var_dump($getData);


    }
    //支付宝异步处理
    public function actionNotify(){
        $postData = $this->request->post();
        var_dump($postData);
        $alipay = new AlipayPay();
        $bool = $alipay->verifyNotify();

    }




    //生成订单编号
    public function actionOrdnum(){
        $ordnum = 'CSDN'.mt_rand(1000,9999).time();
        return $ordnum;
    }





    //权限验证
    public function actionIsAdmin(){

        return true;
    }

}
