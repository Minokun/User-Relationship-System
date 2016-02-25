<?php
if (!defined('IS_INITPHP')) exit('Access Denied!');
/*********************************************************************************
 * InitPHP 3.3 国产PHP开发框架  Dao-db 常用SQL方法封装
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By initphp.com
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 *-------------------------------------------------------------------------------
 * $Author:zhuli
 * $Dtime:2013-5-29 
***********************************************************************************/
$path = $_SERVER['DOCUMENT_ROOT'];
require_once(DOC_ROOT."initphp/core/dao/db/sqlbuild.init.php"); 
class build_sql_ex extends  sqlbuildInit{
	/*********************************************************************************
	 * test XXX 模块 DAO 数据层
	 *-------------------------------------------------------------------------------
	 *版权所有: CopyRight By GUOTENG
	 *-------------------------------------------------------------------------------
	 * @author LY
	 * @version 1.0
	 * @since 1.0
	 * @data:2013-08-20
	 ***********************************************************************************/
public function build_equal($val = array()){
	if (!is_array($val) || empty($val)) return '';
	$temp = array();
	foreach ($val as $k => $v) {
		$v = trim($v);
		if(!is_null($v)&&($v!="")){ //isset
			$temp[] =  $k . " = '".$v."'";
		}
	}
	if(!is_array($temp) || empty($temp)){
		return '';
	}else {
		return ' AND ' . implode(' AND ', $temp);
	}
 	}
	
	public function build_like($val = array()){
		if (!is_array($val) || empty($val)) return '';
		$temp = array();
		foreach ($val as $k => $v) {
			$temp[] =  $k . " like '%".str_replace(" ","%",trim($v))."%'";
		}
		return ' AND ' . implode(' AND ', $temp);
	}
	
	public function build_key_in($key,$val = array()){
		if (!is_array($val) || empty($val)) return '';
		return ' AND '.$key . $this->build_in($val);
	}
	
	public function build_between($key,$start,$end){
		$sql_temp ;
			$start =trim($start);
			if(!empty($start)){
				$sql_temp = $sql_temp." AND ".$key." >='".$start."' ";
			}
			$end =trim($end);
			if(!empty($end)){
				$sql_temp = $sql_temp." AND ".$key." <='".$end."' ";
			}
		return $sql_temp;
	}	
	public function t(){
//  		$a = array('k1'=>'v1','k2'=>'   ','k3'=>'  v3   ');
// // 		echo $this->build_equal($a)."<br>";
//  		echo $this->build_like($a)."<br>";
//  		echo $this->build_key_in('age',$a)."<br>";
// 		echo$this->build_between('age','2','8')."<br>";
// // echo "asdkfjalskdfjlaskdfasdfasd";
	}
}



