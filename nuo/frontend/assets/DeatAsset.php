<?php
namespace frontend\assets;
use yii\web\AssetBundle;

class DeatAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/common.css',
        'css/style1.css',
    ];
    public $js = [
        'js/jquery-1.11.0.min.js',
        'js/public.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
?>