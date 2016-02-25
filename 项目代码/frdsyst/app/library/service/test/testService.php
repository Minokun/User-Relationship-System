<?php
class testService extends Service{
	
	private $name = "Minok";
	
	private function _getDao() {
		return InitPHP::getDao ("test","test");
	}
	
	public function query_all_count(){
		return $this->_getDao()->query_all_count();
	}
	
	public function getdata(){
		return $this->_getDao()->getdata();
	}
	public function getnew(){
		return $this->_getDao()->getnew();
	}
	public function add(){
	    return "uu";
	}
}