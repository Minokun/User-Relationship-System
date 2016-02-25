<?php
/**
 * ---------------------------------------------------------------------------
 * 微信Api接口
 * ---------------------------------------------------------------------------
 *  <strong>copyright</strong>： ©版权所有 成都奇望网讯科技有限公司<br>
 * ----------------------------------------------------------------------------
 * @author:hewei
 * @time:2015-3-25 上午10:27:50
 * ---------------------------------------------------------------------------
 */
include_once APP_PATH . 'library/helper/tool/CurlUtils.php';
class WXUtils {
	
	/**
	 * 获取微信用户授权access_token
	 *
	 * @return Ambigous <boolean, mixed>
	 * @author hewei
	 */
	public static function oauth2_access_token($code) {
		$conf = self::_get_conf (); // 配置信息
		$json = CurlUtils::curl_get_json ($conf ['wx'] ['oauth2_access_token'] ['url'], array_merge ($conf ['wx'] ['oauth2_access_token'] ['params'], array (
				'code' => $code 
		)));
		return $json;
	}
	
	/**
	 * 获取微信access_token
	 *
	 * @return Ambigous <boolean, mixed>
	 * @author hewei
	 */
	public static function api_access_token() {
		$conf = self::_get_conf (); // 配置信息
		$json = CurlUtils::curl_get_json ($conf ['wx'] ['api_access_token'] ['url'], $conf ['wx'] ['api_access_token'] ['params']);
		return empty ($json ['errcode']) ? $json : false;
	}
	
	/**
	 * 获取微信jsapi_ticket
	 *
	 * @return Ambigous <boolean, mixed>
	 * @author hewei
	 */
	public static function api_jsapi_ticket($access_token) {
		$conf = self::_get_conf (); // 配置信息
		$json = CurlUtils::curl_get_json ($conf ['wx'] ['api_jsapi_ticket'] ['url'], array_merge ($conf ['wx'] ['api_jsapi_ticket'] ['params'], array (
				'access_token' => $access_token 
		)));
		return empty ($json ['errcode']) ? $json : false;
	}
	
	/**
	 * 获取用户基本信息
	 *
	 * @return Ambigous <boolean, mixed>
	 * @author hewei
	 */
	public static function api_user_info($access_token, $openid) {
		$conf = self::_get_conf (); // 配置信息
		$json = CurlUtils::curl_get_json ($conf ['wx'] ['api_user_info'] ['url'], array_merge ($conf ['wx'] ['api_user_info'] ['params'], array (
				'access_token' => $access_token,
				'openid' => $openid 
		)));
		return $json;
	}
	
	/**
	 * 创建菜单
	 *
	 * @param string $access_token
	 *        	access_token
	 * @param string $menu
	 *        	菜单
	 * @return Ambigous <boolean, mixed>
	 * @author hewei
	 */
	public static function api_menu_create($access_token, $menu) {
		$conf = self::_get_conf (); // 配置信息
		                            
		// 请求
		$ch = curl_init ();
		curl_setopt ($ch, CURLOPT_URL, $conf ['wx'] ['api_menu_create'] ['url'] . '?access_token=' . $access_token);
		// 以返回的形式接收信息
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		// 设置为POST方式
		curl_setopt ($ch, CURLOPT_POST, 1);
		// 设置请求参数
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $menu);
		// 不验证https证书
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
		// 发送数据
		$response = curl_exec ($ch);
		// 不要忘记释放资源
		curl_close ($ch);
		
		return $response;
	}
	
	/**
	 * jsapi 签名算法
	 *
	 * @param string $jsapi_ticket        	
	 * @param string $url        	
	 * @return multitype:NULL unknown string number |multitype:
	 * @author hewei
	 */
	public static function js_signature($jsapi_ticket, $url) {
		if ($jsapi_ticket) {
			$conf = self::_get_conf (); // 配置信息
			                            
			// 时间戳
			$timestamp = time ();
			// 随机字符串
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$nonceStr = "";
			for($i = 0; $i < 16; $i ++) {
				$nonceStr .= substr ($chars, mt_rand (0, strlen ($chars) - 1), 1);
			}
			
			// 这里参数的顺序要按照 key 值 ASCII 码升序排序
			$string = "jsapi_ticket=$jsapi_ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
			
			$signature = sha1 ($string);
			
			$signPackage = array (
					"appId" => $conf ['wx'] ['app_id'],
					"nonceStr" => $nonceStr,
					"timestamp" => $timestamp,
					"url" => $url,
					"signature" => $signature,
					"rawString" => $string 
			);
			return $signPackage;
		} else {
			return array ();
		}
	}
	
	/**
	 * 微信接口配置
	 *
	 * @return multitype:string multitype:NULL
	 * @author hewei
	 */
	private static function _get_conf() {
		$app_conf = InitPHP::getAppConfig (); // 配置信息
		                                      
		// 微信配置
		$wx_conf = array ();
		// 获取access token
		$wx_conf ['wx'] ['api_access_token'] = array (
				'url' => 'https://api.weixin.qq.com/cgi-bin/token',
				'params' => array (
						'grant_type' => 'client_credential', // 获取access_token填写client_credential
						'appid' => $app_conf ['wx'] ['app_id'], // 第三方用户唯一凭证
						'secret' => $app_conf ['wx'] ['app_secret']  // 第三方用户唯一凭证密钥，即appsecret
								) 
		);
		// 获取网页授权 access token
		$wx_conf ['wx'] ['oauth2_access_token'] = array (
				'url' => 'https://api.weixin.qq.com/sns/oauth2/access_token',
				'params' => array (
						'grant_type' => 'authorization_code', // 获取access_token填写authorization_code
						'appid' => $app_conf ['wx'] ['app_id'], // 第三方用户唯一凭证
						'secret' => $app_conf ['wx'] ['app_secret'], // 第三方用户唯一凭证密钥，即appsecret
						'code' => null  // 交换码
								) 
		);
		// 获取jsapi_ticket
		$wx_conf ['wx'] ['api_jsapi_ticket'] = array (
				'url' => 'https://api.weixin.qq.com/cgi-bin/ticket/getticket',
				'params' => array (
						'access_token' => null, // access_toke
						'type' => 'jsapi'  // ticket 类型
								) 
		);
		// 自定义菜单创建接口
		$wx_conf ['wx'] ['api_menu_create'] = array (
				'url' => 'https://api.weixin.qq.com/cgi-bin/menu/create',
				'params' => array (
						'access_token' => null  // access_toke
								) 
		);
		// 获取用户信息
		$wx_conf ['wx'] ['api_user_info'] = array (
				'url' => 'https://api.weixin.qq.com/cgi-bin/user/info',
				'params' => array (
						'access_token' => null, // access_toke
						'openid' => null,
						'lang' => 'zh_CN' 
				) 
		);
		
		return $wx_conf;
	}
}
?>