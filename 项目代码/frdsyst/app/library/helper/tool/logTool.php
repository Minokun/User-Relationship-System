<?php 
//php生成缩略图片的类
class logTool{
	
	public function save($msg,$data){
		
// 		$dao = InitPHP::getDao("log","log");
		
// 		$fields = array();
		
// 		$fields['msg'] = $msg;
		
// 		$fields['url'] = $_SERVER['REQUEST_URI'];
		
// 		if(isset($_GET['password'])){
// 			unset($_GET['password']);
// 		}
		
// 		if(isset($_POST['password'])){
// 			unset($_POST['password']);
// 		}
		
// 		$fields['get'] = $this->encode_json(json_encode($_GET));
		
// 		$fields['post'] = $this->encode_json(json_encode($_POST));
		
// 		$fields['params'] = $this->encode_json(array_merge($_GET,$_POST));
		
// 		$fields['m'] = InitPHP::getM();
// 		$fields['c'] = InitPHP::getC();
// 		$fields['a'] = InitPHP::getA();
// 		if(is_array($data)){
// 			$data = $this->encode_json($data);
// 		}
// 		$fields['data'] = $data;
// 		$fields['add_date'] = date("Y-m-d H:i:s");
		
// 		$fields['username'] = $_SESSION["manage_user"]['username'];
		
// 		$dao->insertLog($fields,"log");
		
	}
	
	public function business_save($msg,$data,$store_id){
	
// 		$dao = InitPHP::getDao("log","log");
	
// 		$fields = array();
	
// 		$fields['msg'] = $msg;
	
// 		$fields['url'] = $_SERVER['REQUEST_URI'];
	
// 		if(isset($_GET['password'])){
// 			unset($_GET['password']);
// 		}
	
// 		if(isset($_POST['password'])){
// 			unset($_POST['password']);
// 		}
	
// 		$fields['get'] = $this->encode_json(json_encode($_GET));
	
// 		$fields['post'] = $this->encode_json(json_encode($_POST));
	
// 		$fields['params'] = $this->encode_json(array_merge($_GET,$_POST));
	
// 		$fields['m'] = InitPHP::getM();
// 		$fields['c'] = InitPHP::getC();
// 		$fields['a'] = InitPHP::getA();
// 		if(is_array($data)){
// 			$data = $this->encode_json($data);
// 		}
// 		$fields['data'] = $data;
// 		$fields['add_date'] = date("Y-m-d H:i:s");
// 		$fields['store_id'] = $store_id;
// 		$fields['username'] = $_SESSION["business_user"]['username'];
// 		$dao->insertLog($fields,"log_business");
	}
	
	
	function encode_json($str) {
		return urldecode(json_encode($this->url_encode($str)));
	}
	
	/**
	 *
	 */
	function url_encode($str) {
		if(is_array($str)) {
			foreach($str as $key=>$value) {
				$str[urlencode($key)] = $this->url_encode($value);
			}
		} else {
			$str = urlencode($str);
		}
	
		return $str;
	}
	
}
?>