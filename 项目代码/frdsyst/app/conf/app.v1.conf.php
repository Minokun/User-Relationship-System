<?php
/**
 * ---------------------------------------------------------------------------
 * 一些其他基础配置信息
 * ---------------------------------------------------------------------------
 *  <strong>copyright</strong>： ©版权所有 成都奇望网讯科技有限公司<br>
 * ----------------------------------------------------------------------------
 * @author:hewei
 * @time:2015-3-25 上午9:48:56
 * ---------------------------------------------------------------------------
 */
$App_conf = array ();
/**
 * ************************************ 短信 **********************************
 */
// $App_conf ['sms'] = array (
// 		'user' => 'qwtech', // 用户名
// 		'password' => 'gt702123'  // 密码
// );
/**
 * 互亿短信 
 */
$App_conf ['sms'] = array (
		'user' => 'cf_qwwx', // 用户名
		'password' => 'wanzhuan'  // 密码
);

/**
 * ************************************ 微信 **********************************
 */

$App_conf ['wx'] ['token'] = 'A194916A5B294FE6BEA13FD8D53905AC'; // 微信Token
$App_conf ['wx'] ['app_id'] = 'wx8c79da141df94c71'; // 微信APPID
$App_conf ['wx'] ['app_secret'] = '0bac30fd0c3ac71628ba4744a4aefa6f'; // 微信 AppSecret
$App_conf ['wx'] ['encoding_aes_key'] = 'XmswU30FeERBjzaY4FMOQLqfMEjBEQJ3R8ZBO1Nntvp'; // 微信 加密key
                                                                                       
// 微信菜单
$App_conf ['wx'] ['menu'] = '
		{
			"button":[
				{
					"type":"view",
					"name":"进入玩转",
					"url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $App_conf ['wx'] ['app_id'] . '&redirect_uri=http%3A%2F%2Fwww.qw6u.com%2Fkuangzhuan%2Fwx%2FuserCenter%2Findex&response_type=code&scope=snsapi_base&state=' . WX_OAUTH2_STATE_000 . '#wechat_redirect"
				},
				{
					"type":"view",
					"name":"疯狂赚钱",
					"url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $App_conf ['wx'] ['app_id'] . '&redirect_uri=http%3A%2F%2Fwww.qw6u.com%2Fkuangzhuan%2Fwx%2Farticle&response_type=code&scope=snsapi_base&state=' . WX_OAUTH2_STATE_000 . '#wechat_redirect"
				},
				{
					"name":"免费领取",
					"sub_button":[
						{
							"type":"view",
							"name":"开心一笑",
							"url":"http://www.qw6u.com/kuangzhuan/wx/user/zhaoshang"
						},
						{
							"type":"view",
							"name":"微福利",
							"url":"http://www.qw6u.com/kuangzhuan/wx/UserCenter/weihuli"
						}]
				}]
		}';

/**
 * ************************************ 第三方统计工具 **********************************
 */
$App_conf ['tj'] ['wap_cnzz'] = 1254694009; // 站长Wap统计Id
$App_conf ['tj'] ['wap_baidu'] = 'b426ac44fd25db964077e5e75bc9ac8e'; // 百度Wap统计Id

?>