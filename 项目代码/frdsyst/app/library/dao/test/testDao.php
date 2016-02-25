<?php
class testDao extends Dao{
	private $table_Name1 = "user_agent" ;
	private $table_Name2 = "testtable" ;
	public function query_all_count(){

		return $this->init_db('test')->get_count($this->table_Name1);
	}
	
	public function getdata(){
		$sql = sprintf("select * from %s limit 1400,14",$this->table_Name1);
		$result = $this->init_db('default')->query($sql);
		if (!$result) return false;
		$temp = array();
		while ($row = $this->dao->db->fetch_assoc($result)) {
			$temp[] = $row;
		}
		return $temp;
	}
	
	public function getnew() {
		$sql = sprintf("select * from %s",$this->table_Name2);
		$result = $this->init_db('test1')->query($sql);
		if (!$result) return false;
		$temp = array();
		while ($row = $this->dao->db->fetch_assoc($result)) {
			$temp[] = $row;
		}
		return $temp;
	}
	public function yoyo(){
	    $uid = 16;
	    $sql = "select * from user_friends";
	    $res = $this->dao->db->get_one_sql($sql);
	    print_r($res);
	}
}
?>