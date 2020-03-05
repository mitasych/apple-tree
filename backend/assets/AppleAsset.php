<?php

namespace backend\assets;

use yii\web\AssetBundle;

class AppleAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/circle.css',
    ];
    public $js = [
    ];
    public $depends = [
        AppAsset::class
    ];
}