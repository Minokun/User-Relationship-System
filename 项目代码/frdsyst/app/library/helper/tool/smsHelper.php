<?php
// php生成缩略图片的类
class SmsHelper {
	
	/**
	 * 短信发送
	 *
	 * @param string $phone
	 *        	手机号码
	 * @param string $msg
	 *        	短信内容
	 * @return boolean
	 * @author hewei
	 */
	public static function send($phone, $msg) {
		$app_conf = InitPHP::getAppConfig ();
		// 功能：发送短信
		// 使用GB2312编码
// 		$user = $app_conf ['sms'] ['user'];
// 		$pass = md5 ($app_conf ['sms'] ['password']); // 需要MD5
// 		$content = $msg;
// 		$content = urlEncode (urlEncode (mb_convert_encoding ($content, 'gb2312', 'utf-8')));
// 		$api = "http://sms.c8686.com/Api/BayouSmsApiEx.aspx?func=sendsms&username=$user&password=$pass&mobiles=$phone&message=$content&smstype=0&timerflag=0&timervalue=&timertype=0&timerid=0";
// 		$fp = fopen ($api, "r");
// 		$ret = fgets ($fp, 1024);
// 		fclose ($fp);
		
// 		$rest = self::xml_to_array ($ret);
// 		// 保存短信信息
// 		$service = InitPHP::getService ('comm', 'wx');
// 		$send_time = strtotime ($rest ['time']);
// 		$service->save_sms_validate ($phone, $msg, $rest ['errorcode'], $send_time, $rest ['errordescription'], mb_convert_encoding ($ret, 'utf-8', 'gb2312'));
// 		// 发送成功则返回
// 		if (is_array ($rest) && $rest ['errorcode'] == 0) {
// 			return true;
// 		} else {
// 			return false;
// 		}


		/**
		 * 互亿短信方法
		 */
		function Post($curlPost,$url){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_NOBODY, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
			$return_str = curl_exec($curl);
			curl_close($curl);
			return $return_str;
		}
		/**
		 * 互亿短信方法
		 */
		function xml_to_array($xml){
			$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
			if(preg_match_all($reg, $xml, $matches)){
				$count = count($matches[0]);
				for($i = 0; $i < $count; $i++){
					$subxml= $matches[2][$i];
					$key = $matches[1][$i];
					if(preg_match( $reg, $subxml )){
						$arr[$key] = xml_to_array( $subxml );
					}else{
						$arr[$key] = $subxml;
					}
				}
			}
			return $arr;
		}
		$user = $app_conf ['sms'] ['user'];
		$pass = $app_conf ['sms'] ['password']; // 需要MD5
		$content = $msg;		
		$target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
		
		//$mobile = $_POST['mobile'];
		//$send_code = $_POST['send_code'];
		$mobile = $phone;
		$send_code = $msg;
		
		$mobile_code = $msg;
		if(empty($mobile)){
			exit('手机号码不能为空');
		}
		
		$post_data = "account=".$user."&password=".$pass."&mobile=".$mobile."&content=".rawurlencode("您的验证码是：".$mobile_code."。请不要把验证码泄露给其他人。");
		//密码可以使用明文密码或使用32位MD5加密
		$gets =  xml_to_array(Post($post_data, $target));
		if($gets['SubmitResult']['code']==2){
			$_SESSION['mobile'] = $mobile;
			$_SESSION['mobile_code'] = $mobile_code;
		}
		
		// 保存短信信息
		$service = InitPHP::getService ('comm', 'wx');
		$send_time = strtotime ($rest ['time']);
// 		$service->save_sms_validate ($phone, $msg, $rest ['errorcode'], $send_time, $rest ['errordescription'], mb_convert_encoding ($ret, 'utf-8', 'gb2312'));
		// 发送成功则返回
		if ($gets['SubmitResult']['msg']=='提交成功') {
			return true;
		} else {
			return false;
		}
		
	}
	
	
	/**
	 * xml To string
	 *
	 * @param string $xml        	
	 * @return mixed array
	 * @author hewei
	 */
	private static function xml_to_array($xml) {
		return json_decode (json_encode ((array) simplexml_load_string ($xml)), true);
	}
	

	
}
?>