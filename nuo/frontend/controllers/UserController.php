<?php 
namespace frontend\controllers;

use Yii;

use yii\web\Controller;
use yii\helpers\Url;

/**
 * User controller
 */
class UserController extends Controller
{
	public $enableCsrfValidation = false;
    public $layout = 'main';
    /**
     * 个人账户首页
     * 如果没有cookie跳转至登录页面
     * 根据cookie查询该用户全部数据
     */
    public function actionIndex()
    {
        if(!isset($_COOKIE['user'])){
            echo "<script>alert('请先登录！');location.href='".Url::to(['login/login'])."'</script>";
        }else{
                $cellPhone = $_COOKIE['user'];

                $db = Yii::$app->db;
                $list = $db->createCommand("select * from nuo_user where id = '$cellPhone'")->queryOne();

                return $this->render('user.html',['list'=>$list]);
        }
    }
    /*
     *个人信息详情
     *cookie查询数据
     * 查询数据，返回前台
     */
    public function actionInfo()
    {
        if(!isset($_COOKIE['user'])){
            echo "<script>alert('请先登录');location.href='".Url::to(['login/login'])."'</script>";die;
        }
        $cellPhone = $_COOKIE['user'];
        
        $db = Yii::$app->db;
        $info = $db->createCommand("select * from nuo_user where id = '$cellPhone'")->queryOne();

        return $this->render('info.html',['info'=>$info]);
    }
    /**
    *接值
    *调用k780接口查询身份证是否合法
    *实名制入库
    * @return
    */
   public function actionRealname()
   {
        $username = Yii::$app->request->post('username');
        $idCard = Yii::$app->request->post('idCard');
        $headImg = Yii::$app->request->post('headImg');

        // //调用k780接口
        $appkey = 29294;
        $sign = "77596fee36b3565aa3b7eeb99b1fd06f";
        $url = "http://api.k780.com/?app=idcard.get&idcard=".$idCard."&appkey=29294&sign=77596fee36b3565aa3b7eeb99b1fd06f&format=json";
        $api_list = json_decode(file_get_contents($url));
        if($api_list->success != 1)
        {
            echo 0;die;//身份证不合法die   
        }

        $db = Yii::$app->db;
        $info = $db->createCommand("select * from nuo_user where idCard=".$idCard)->queryOne();
        if($info){
          echo 4;die;
        }
        $cellPhone = $_COOKIE['user'];
        //身份证号以及姓名入库
        $res = $db->createCommand()
                  ->update('nuo_user',['idCard'=>$idCard,'username'=>$username],"id=".$cellPhone)
                  ->execute();
        if(!$res){
            echo 1;die;
        }
        //头像修改
        $img_res = $db->createCommand()
                      ->update('nuo_user',['headImg'=>$headImg],"id=".$cellPhone)
                      ->execute();
        if(!$img_res)
        {
            echo 2;die;
        }
        echo 3;
    }

    /**
     * 绑定邮箱
     * 判断是否post提交
     * 发送邮件认证
     * @return
     */

    public function actionMail()
    {
        
        if(Yii::$app->request->post())
        {
            $rand = rand(1000,9999);
            $email = Yii::$app->request->post('email');
                $EmailInfo=\Yii::$app->mailer->compose() 
                ->setFrom(['494931028@qq.com'=>'一诺网']) 
                ->setTo($email)
                ->setSubject('一诺理财')  
                ->setHtmlBody('欢迎绑定邮箱，验证码：'.$rand) 
                ->send();
                echo $rand;
        }
        else
        {
            return $this->render('mail.html');
        }
    }
    /**
     * 接值邮箱
     * 数据库修改绑定
     * @return
     */
    public function actionRealmail()
    {
        $email = Yii::$app->request->get('email');
        
        $cellPhone = $_COOKIE['user'];
        $db = Yii::$app->db;
        $info = $db->createCommand("select * from nuo_user where email='$email'")->queryOne();
        if($info){
          echo 2;die;
        }
        $res = $db->createCommand()
                  ->update('nuo_user',['email'=>$email],"id=".$cellPhone)
                  ->execute();
        if($res){
          echo 1;
        }else{
          echo 0;
        }
    }

    /*
     * 银行卡充值
     * @return
     */
    public function actionRecharge()
    {
        return $this->render('recharge.html ');
    }

    /**
     * 
     */
    public function actionQq_login()
    {
      return $this->render('qq_login.html');
    }







}






 ?>