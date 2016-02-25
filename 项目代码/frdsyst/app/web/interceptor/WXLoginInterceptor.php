<?php
/**
 * ---------------------------------------------------------------------------
 * 微信登录拦截器
 * ---------------------------------------------------------------------------
 *  <strong>copyright</strong>： ©版权所有 成都奇望网讯科技有限公司<br>
 * ----------------------------------------------------------------------------
 * @author:hewei
 * @time:2015-3-25 下午7:50:00
 * ---------------------------------------------------------------------------
 */
class WXLoginInterceptor implements interceptorInterface {
	
	/**
	 * 前置拦截器，在所有Action运行全会进行拦截
	 * 如果返回true，则拦截通过;如果返回false，则拦截
	 *
	 * @return boolean 返回布尔类型，如果返回false，则截断
	 */
	public function preHandle() {
		session_start ();
		// 保存微信code
		if (! empty ($_GET ['code']) && WX_OAUTH2_STATE_000 == $_GET ['state']) {
			$_SESSION [SESS_KEY_WX_CODE] = $_GET ['code'];
		}
		// 尝试自动登录，登录失败跳转登录页面
		$user = $_SESSION [SESS_KEY_WX_USER];
		if (empty ($user)) {
			// 如果cookie 信息存在，尝试自动登录
			$sv_user = InitPHP::getService ('user', 'wx');
			if ($sv_user->auto_login_wx ()) {
				return true;
			}
			// 跳转到登录页面
			header ("Location: " . rtrim (BASE_PATH, "/") . "/" . 'wx/user/login');
			exit ();
			return false;
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