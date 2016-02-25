<?php
/**
 * ---------------------------------------------------------------------------
 * CURL 基础类
 * ---------------------------------------------------------------------------
 *  <strong>copyright</strong>： ©版权所有 成都奇望网讯科技有限公司<br>
 * ----------------------------------------------------------------------------
 * @author:hewei
 * @time:2015-1-19 下午5:05:56
 * ---------------------------------------------------------------------------
 */
class CurlUtils {
	
	/**
	 * post 请求
	 *
	 * @param string $url
	 *        	地址
	 * @param array $params
	 *        	请求参数
	 * @param number $timeout
	 *        	超时
	 * @return mixed
	 * @author hewei
	 */
	public static function curl_post($url, $params = array(), $timeout = 30) {
		$ch = curl_init ();
		curl_setopt ($ch, CURLOPT_URL, $url);
		// 以返回的形式接收信息
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		// 设置为POST方式
		curl_setopt ($ch, CURLOPT_POST, 1);
		// 设置请求参数
		curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query ($params));
		// 不验证https证书
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_TIMEOUT, $timeout);
		// 发送数据
		$response = curl_exec ($ch);
		// 不要忘记释放资源
		curl_close ($ch);
		return $response;
	}
	
	/**
	 * post 请求 JSON
	 *
	 * @param string $url
	 *        	地址
	 * @param array $params
	 *        	请求参数
	 * @param number $timeout
	 *        	超时
	 * @return mixed
	 * @author hewei
	 */
	public static function curl_post_json($url, $params = array(), $timeout = 30) {
		return json_decode (CurlUtils::curl_post ($url, $params, $timeout), true);
	}
	
	/**
	 * get 请求
	 *
	 * @param string $url
	 *        	地址
	 * @param array $params
	 *        	请求参数
	 * @param number $timeout
	 *        	超时
	 * @return mixed
	 * @author hewei
	 */
	public static function curl_get($url, $params = array(), $timeout = 30) {
		$url = $url . '?' . http_build_query ($params);
		$ch = curl_init ($url);
		// 以返回的形式接收信息
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		// 不验证SSL证书和host
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt ($ch, CURLOPT_TIMEOUT, $timeout);
		// 发送数据
		$response = curl_exec ($ch);
		// 不要忘记释放资源
		curl_close ($ch);
		return $response;
	}
	
	/**
	 * get 请求 JSON 信息
	 *
	 * @param string $url
	 *        	地址
	 * @param array $params
	 *        	请求参数
	 * @param number $timeout
	 *        	超时
	 * @return mixed
	 * @author hewei
	 */
	public static function curl_get_json($url, $params = array(), $timeout = 30) {
		return json_decode (CurlUtils::curl_get ($url, $params, $timeout), true);
	}
}
?>