<?php
namespace frontend\assets;
use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/common.css',
        'css/style1.css',
        'css/responsiveslides.css',
    ];
    public $js = [
        'js/jquery-1.11.0.min.js',
        'js/public.js',
        'js/responsiveslides.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
?>