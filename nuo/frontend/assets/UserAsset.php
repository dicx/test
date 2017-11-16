<?php
namespace frontend\assets;
use yii\web\AssetBundle;

class UserAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/common.css',
        'css/home.css',
        'css/xinfugai.css',
        'css/css.css',
    ];
    public $js = [
        'js/jquery.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
?>