<?php
class testController extends Controller{
	public $initphp_list = array (
			'run','display','test','yoyo'
		
	);
	private $n = 0;
	private $totalNum;
	private $singlePageNum = 14;
	private function _getService() {
		return InitPHP::getService("test",'test');
	}
	
	public function display(){
		$this->view->display('test/test');
	}
	
	public  function run(){
		//总条数		
		$this->totalNum = $this->_getService()->query_all_count();
		$this->view->assign("TotalPageNum", ceil($this->totalNum/$this->singlePageNum));
		//获取数据信息
		$data = $this->_getService()->getdata();
		foreach($data as $k=>$v){
			foreach ($v as $key=>$value){
				$this->view->assign($key.$k,$value);
			}
		}
		$this->display();
	}
	
	public function test(){
		header("Content-Type: text/event-stream");

		while(true){
			
			$data = $this->_getService()->getnew();
			foreach($data as $key=>$value){
				$str = '';
				foreach($value as $k=>$v){
					$str = "  ".$str."  ".$v;
				}
				echo "data:".date("Y-m-d H:i:s")."<br/>".$str."\n\n"."";
			}
  			@ob_flush();@flush();

  			sleep(1);

 		}
		
	}
	public function yoyo(){
		InitPHP::getDao("test","test")->yoyo();
		
	}
}
?>