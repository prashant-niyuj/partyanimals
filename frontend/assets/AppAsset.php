<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
	'css/bootstrap.css',
	'css/bootstrap-datepicker.standalone.css',
	'css/bootstrapValidator.css',
	'css/custom.css',
	'css/owl.carousel.css',
	'css/font-awesome.min.css',
	'css/main.css',
    ];
    public $js = [
	'js/bootstrap.js',
	'js/bootstrap-datepicker.js',
	'js/typeahead.min.js',
	'js/bootstrapValidator.min.js',
	'js/jquery.cookie.js',
	'js/json3.min.js',
	'js/bootstrap-tooltip.js',
	'js/bootstrap-popover.js',
	'js/mobile-detect.min.js',
	'js/jquery.SuperCookie.js',
	'js/jquery.mobile.custom.min.js',
	'js/bootbox.min.js',
	'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

