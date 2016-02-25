<?php 
define ('APP_PATH', '../app/');
header ('Content-Type:text/html; charset=utf-8');
if (empty($_COOKIE['_Cmz'])) {//设置cookie:用于访问UV统计（1年过期）
	mt_srand ( ( double ) microtime () * 10000 ); // optional for php 4.2.0 and up.随便数播种，4.2.0以后不需要了。
	$str = strtoupper ( md5 ( uniqid ( rand (), true ) ) ); // 根据当前时间（微秒计）生成唯一id.
	setcookie('_Cmz', $str, time()+31536000, '/');
	$_COOKIE['_Cmz'] = $str;
}
date_default_timezone_set('PRC'); //设置中国时区
require_once ('../initphp/initphp.php'); // 导入配置文件-必须载入
require_once (APP_PATH . 'conf/constant.conf.php'); // 常量定义模块
require_once (APP_PATH . 'conf/app.conf.php'); // 模块配置文件
require_once (APP_PATH . 'conf/app.v1.conf.php');	// 一些其他基础配置文件
                                                    
// 导入基础类
InitPHP::import (APP_PATH . 'library/helper/base/BaseWX_V1_Controller.php');
InitPHP::import (APP_PATH . 'library/helper/base/BaseWX_V1_Service.php');
InitPHP::import (APP_PATH . 'library/helper/base/BaseWX_V1_Dao.php');
InitPHP::import (APP_PATH . 'library/helper/base/BaseAdminController.php');
InitPHP::import (APP_PATH . 'library/helper/base/BaseMerchantController.php');

InitPHP::import (APP_PATH . 'library/helper/base/BaseAdminDao.php');
InitPHP::import (APP_PATH . 'library/helper/tool/build_sql_ex.php');
InitPHP::import (APP_PATH . 'library/helper/tool/class-phpass.php');
InitPHP::import (APP_PATH . 'library/helper/tool/logTool.php');
InitPHP::import (APP_PATH . 'library/helper/tool/ResizeImage.php');
InitPHP::init (); // 框架初始化
?>