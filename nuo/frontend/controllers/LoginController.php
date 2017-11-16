<?php 
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;

/**
 * Site controller
 */
class LoginController extends Controller
{

	public $enableCsrfValidation = false;
	public $layout = false;


 /**
     * [actionRegisterdo description]
     * @return [type] [description]
     * 判断是否是post传值
     * 接值
     * 操作数据库
     * 查询该手机号以及邮箱是否已经注册
     * 入库成功
     *
     * 渲染视图
     * @return
     */
    public function actionRegister()
    {
        if(Yii::$app->request->post())
        {
            $data = Yii::$app->request->post();
            $data['pwd'] = md5($data['pwd']);
            $data['tradingPassword'] = md5($data['tradingPassword']);
            $data['headImg'] = 'images/tou.png';
            // $data['headImg'] = 'images/vipdbj.png';

            $db = Yii::$app->db;
            $user_find = $db->createCommand("select * from nuo_user where cellPhone=".$data['cellPhone'])->queryOne();
            if($user_find){
                 echo 0;die;
                }
            $res = $db->createCommand()->insert('nuo_user', $data)->execute();
            if($res){
                echo 1;
            }else{
               echo 2;
            }
        }
        else
        {
            return $this->render('register.html');
        }
        
    }

    /**
     * [actionDo description]
     * @return [type] [description]
     * 登录。
     * 接值判断
     * 存储cookie  session
     */
    public function actionLogin()
    {
        if(Yii::$app->request->post())
        {
            $cellPhone = Yii::$app->request->post('cellPhone');
            $pwd = md5(Yii::$app->request->post('pwd'));
            // echo $pwd;die;
            //查询该手机号是否存在
            $db = Yii::$app->db;
            $info = $db->createCommand("select * from nuo_user where cellPhone='$cellPhone'")->queryOne();
            if(!$info){
                echo 0;die;
            }
            $list = $db->createCommand("select * from nuo_user where cellPhone = '$cellPhone' and pwd = '$pwd'")->queryOne();
//            print_r($list);die;
            if($list){
                setcookie('user',$list['id'],time()+3600);
                echo 1;
            }else{
                echo 2;
            }
        }
        else
        {
            return $this->render('login.html');
        }
        
    }

    /**
     * 注销登录
     * @return   [description]
     */
    public function actionLogout()
    {
        setcookie('user',1,time()-1);
        echo "<script>alert('注销成功');location.href='".Url::to(['login/login'])."'</script>";
    }










}