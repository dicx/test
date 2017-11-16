<?php
namespace frontend\assets;

use yii\web\AssetBundle;
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/css.css',
        'css/home.css',
    ];
    public $js = [
        
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
?>