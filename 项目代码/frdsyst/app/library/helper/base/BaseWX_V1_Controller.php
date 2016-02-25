<?php
/**
 * ---------------------------------------------------------------------------
 * APP 基础Controller V1 版本
 * ---------------------------------------------------------------------------
 *  <strong>copyright</strong>： ©版权所有 成都奇望网讯科技有限公司<br>
 * ----------------------------------------------------------------------------
 * @author:hewei
 * @time:2015-1-16 下午5:58:36
 * ---------------------------------------------------------------------------
 */
include_once APP_PATH . 'library/helper/tool/WXUtils.php';
include_once APP_PATH . 'library/helper/tool/waptj/cs.php';
include_once APP_PATH . 'library/helper/tool/waptj/hm.php';
class BaseWX_V1_Controller extends Controller {
	
	/**
	 * 前置Action
	 *
	 * @author hewei
	 */
	public function before() {
		/**
		 * *********************** 对于重复快速刷新提示 ****************************
		 */
		if (isset ($_GET ['ck_refresh_flag']) && $_GET ['ck_refresh_flag'] == 'refresh_n') {
			$this->view->display ('wx/comm/refresh_check');
			exit ();
		}
		/**
		 * *********************** 微信相关信息初始化 ****************************
		 */
		// 配置信息
		$app_conf = InitPHP::getAppConfig ();
		// 微信access_token,jsapi_ticket处理
		$cache = $this->getCache ();
		// 获取微信access_token
		$wx_access_token = $cache->get (CACHE_KEY_WX_ACCESS_TOKEN);
		$wx_jsapi_ticket = $cache->get (CACHE_KEY_WX_JSAPI_TICKET);
		// 如果二者过期或者不存在，缓存二者
		// 获取微信access_token
		if (! $wx_access_token) {
			$result = WXUtils::api_access_token ();
			if ($result != false) {
				// 缓存
				$cache->set (CACHE_KEY_WX_ACCESS_TOKEN, $result ['access_token'], $result ['expires_in'] - WX_EXPIRES_IN_BEFORE);
				$wx_access_token = $result ['access_token'];
			}
		}
		// 获取微信jsapi_ticket
		if ($wx_access_token && ! $wx_jsapi_ticket) {
			$result = WXUtils::api_jsapi_ticket ($wx_access_token);
			if ($result != false) {
				// 缓存
				$cache->set (CACHE_KEY_WX_JSAPI_TICKET, $result ['ticket'], $result ['expires_in'] - WX_EXPIRES_IN_BEFORE);
				$wx_jsapi_ticket = $result ['ticket'];
			}
		}
		// 设置全局
		define ('WX_ACCESS_TOKEN', $wx_access_token);
		define ('WX_JSAPI_TICKET', $wx_jsapi_ticket);
		define ('WX_APP_ID', $app_conf ['wx'] ['app_id']);
		
		// 设置JS 签名
		// 注意 URL 一定要动态获取，不能 hardcode.
		$protocol = (! empty ($_SERVER ['HTTPS']) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$wx_js_signature = WXUtils::js_signature (WX_JSAPI_TICKET, $url);
		
		$_REQUEST ['wx_js_signature'] = $wx_js_signature;
		
		/**
		 * *********************** WAP 版本统计 ****************************
		 */
		// 站长统计
		$tj = '<img src="' . _cnzzTrackPageView ($app_conf ['tj'] ['wap_cnzz']) . '" width="0" height="0"/>';
		// 百度统计
		$_hmt = new _HMT ($app_conf ['tj'] ['wap_baidu']);
		$tj .= '<img src="' . $_hmt->trackPageView () . '" width="0" height="0" />';
		define ('TJ_WAP_CODE', $tj);
		
		
		
	}
	
	/**
	 * 返回JSON
	 *
	 * @param unknown $msg        	
	 * @param unknown $status        	
	 * @author hewei
	 */
	public function return_json($msg, $status = 200) {
		header ("Content-Type:application/json; charset=utf-8");
		header('Access-Control-Allow-Origin:*');
		exit (json_encode (array (
				'msg' => $msg, // 当前中数据条数
				'status' => $status 
		)));
	}
	
	/**
	 *
	 * @param
	 *        	$msg
	 * @param number $status        	
	 * @author ly
	 */
	public function getUser() {
		Session_start ();
		// $_SESSION["SESS_KEY_WX_USER"]["member_code"] = "12345678";
		// $_SESSION["SESS_KEY_WX_USER"]["member_id"] = "2";
		return $_SESSION ["SESS_KEY_WX_USER"];
	}
	
	/**
	 * 将$resultArray数组中元素按$keyArray来过滤
	 * 例：$keyArray = array('id','spot_name','longitude','latitude','spot_list_picture');
	 *
	 * @param array $keyArray
	 *        	数据总数
	 * @param array $resultArray
	 *        	数据列
	 * @author liuyang
	 */
	public function arrayFilter($keyArray = null, $resultArray = null) {
		$array;
		foreach ($resultArray as $rvalue) {
			$temp;
			foreach ($keyArray as $key => $value) {
				if ($value == 'id') {
					$temp ['ids'] = $rvalue [$value];
				} else {
					$temp [$value] = $rvalue [$value];
				}
			}
			$array [] = $temp;
		}
		return $array;
	}
}
?>