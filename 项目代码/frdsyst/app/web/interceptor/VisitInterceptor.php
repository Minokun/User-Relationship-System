<?php
/**
 * ---------------------------------------------------------------------------
 * 访问统计拦截器
 * ---------------------------------------------------------------------------
 *  <strong>copyright</strong>： ©版权所有 成都奇望网讯科技有限公司<br>
 * ----------------------------------------------------------------------------
 * @author:xstar
 * @time:2015-3-25 下午7:50:00
 * ---------------------------------------------------------------------------
 */
class VisitInterceptor implements interceptorInterface {
	
	/**
	 * 前置拦截器，在所有Action运行全会进行拦截
	 * 如果返回true，则拦截通过;如果返回false，则拦截
	 *
	 * @return boolean 返回布尔类型，如果返回false，则截断
	 */
	public function preHandle() {
		// 防止页面频繁刷新
		$sv_comm = InitPHP::getService ('comm', 'wx');
		if ($sv_comm->refresh_check () == true) {
			// ajax异步请求不记录
			if (isset ($_SERVER ['HTTP_X_REQUESTED_WITH']) && $_SERVER ['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
				return true;
			}
			
			// BUGFIX: hewei 20150508 修正统计时把动态加载微信js也计数的异常：wx/utils/wx_conf_js不要计入统计
			if ($_GET['c'] == 'utils' && $_GET['a'] == 'wx_conf_js'){
				return true;
			}
			
			$req ["url"] = $_SERVER ["REDIRECT_URL"];
			$req ["args"] = $_SERVER ["QUERY_STRING"];
			$req ["cookie"] = $_COOKIE ["_Cmz"];
			date_default_timezone_set ('PRC');
			$req ["add_date"] = date ("Y-m-d H:i:s");
			$req ["agent"] = $_SERVER ["HTTP_USER_AGENT"];
			$req ["ip"] = $_SERVER ["REMOTE_ADDR"];
			session_start ();
			$user = $_SESSION [SESS_KEY_WX_USER];
			if (! empty ($user)) {
				$req ["member_id"] = $user ["member_id"];
			}
			$s = InitPHP::getService ("visit", "count");
			$s->visit ($req);
		} else {
			$_GET['ck_refresh_flag'] = 'refresh_n';
		}
		
		return true;
	}
	
	/**
	 * 后置拦截器，在所有操作进行完毕之后进行拦截
	 */
	public function postHandle() {
	}
}
?>