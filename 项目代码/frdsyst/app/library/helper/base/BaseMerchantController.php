<?php
/*********************************************************************************
 * 后台管理control控制层
 *-------------------------------------------------------------------------------
 *版权所有: CopyRight By GUOTENG
 *-------------------------------------------------------------------------------
 * @author yk
 * @version 1.0
 * @since 1.0
 * @data:2014-12-01
 ***********************************************************************************/

class BaseMerchantController extends Controller {
		private $controller_white = array( //权限白名单，不过滤判断直接通过
			"user"=>array(
				"update_password","update_password_temp",
				"update_user_infor","update_infor"
		)
				
		);
		/**
		 * 前置执行Action
		 */
		public function before(){
			$tool = new logTool();
			if($this->getA()!='login'&&$this->getA()!='loginSubmit'){
				session_start();
				//退出登录
				if($this->getA()=='loginout'){
					$tool->save("管理员退出", array(
							"user"=>$_SESSION["manage_merchant_user"],
							"data"=>array("newData"=>"","oldData"=>"")
					));
					if(isset($_SESSION["manage_merchant_user"])){
						unset($_SESSION["manage_merchant_user"]);
					}
					if(isset($_SESSION["manage_merchant_user_group"])){
						unset($_SESSION["manage_merchant_user_group"]);
					}
					$message['status']="退出成功";
					$message['url']=BASE_PATH."merchant/index/login";
					$message['infor']="返回首页";
					$this->view->assign("message", $message);
					$this->view->display("admin/comm/message");
					exit();
				}
				//登录判断
				if($this->isLogin()){
					$usergroup = $_SESSION["manage_merchant_user_group"];
					$a = $this->getA();
					$c = $this->getC();
					
					$white = $this->controller_white;
					if(in_array($a,$white[$c])){
						return true;
					}
					
// 					if(!in_array($a,$usergroup[$c])){
// 						$message['status']="你没有权限访问";
// 						$message['url']="javascript:history.back()";
// 						$message['infor']="返回";
// 						$this->view->assign("message", $message);
// 						$this->view->display("admin/comm/message");
// 						exit();
// 					}
					
					return true;
				}else{
					$this->view->display("merchant/index/login");
					exit();
				}
			}
			if($this->getA()=="login"){
				if($this->isLogin()){
					$this->view->display("merchant/index/index");
					exit();
				}
				$this->view->display("merchant/index/login");
			}
		}
		
		//判断登录
		public function isLogin(){
			session_start();
			if($this->getA()=="uploadArticlePic"){//文章图片上传不做验证
				return true;
			}
			if($this->getA()=="uploadPic"){//文章图片上传不做验证
				return true;
			}
			if($this->getA()=="backup"){//文章图片上传不做验证
				return true;
			}
			if($this->getA()=="test"){//文章图片上传不做验证
				return true;
			}
			if(isset($_SESSION["manage_merchant_user"])){
				return true;
			}else{
				return false;
			}
		}
		
		

		/**
		 * 封装并返回后台页面json数据格式
		 * @author liuyang
		 */
		public function return_web_json($total = null, $rows = null) {
			if(!$rows){
				$rows = '';
				$total = 0;
			}
			header ( "Content-Type:application/json; charset=utf-8" );
			// echo ('=');
			exit ( json_encode ( array (
				'total' => $total, // 当前中数据条数
				'rows' => $rows
			) ) );
		}

		/**
		 * 将$resultArray数组中元素按$keyArray来过滤
		 * 例：$keyArray = array('id','spot_name','longitude','latitude','spot_list_picture');
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
					if($value=='id'){
						$temp['ids'] = $rvalue[$value];
					}else{
						$temp[$value] = $rvalue[$value];
					}
				}
				$array[] = $temp;
			}
			return $array;
		}
	
		public function log($msg,$data){
			$logTool = new logTool();
			$logTool->save($msg, $data);
		}
		
	}