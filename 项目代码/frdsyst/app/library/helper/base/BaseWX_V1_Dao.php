<?php
/**
 * ---------------------------------------------------------------------------
 * V1 版本基础 Dao
 * ---------------------------------------------------------------------------
 *  <strong>copyright</strong>： ©版权所有 成都奇望网讯科技有限公司<br>
 * ----------------------------------------------------------------------------
 * @author:hewei
 * @time:2015-1-19 下午3:47:09
 * ---------------------------------------------------------------------------
 */
class BaseWX_V1_Dao extends Dao {
	/**
	 * SQL操作-获取数据
	 * DAO中使用方法：$this->dao->db->get_all()
	 *
	 * @param string $table_name
	 *        	表名
	 * @param array $field
	 *        	条件语句 键值数组 进行where and 语句sql的拼接
	 * @param int $num
	 *        	每页显示条数
	 * @param int $page
	 *        	当前页数
	 * @param int $offest
	 *        	取值起始值
	 * @param int $key_id
	 *        	排序字段
	 * @param string $sort
	 *        	排序键（DESC,ASC）
	 * @return array array(数组数据，统计数)
	 */
	public function run($sql, $sql_count) {
		$result = $this->dao->db->get_all_sql ( $sql );
		if (! $result)
			return false;
		$resultCount = $this->dao->db->query ( $sql_count, false );
		$resultCount = $this->dao->db->fetch_assoc ( $resultCount );
		return array (
				$result,
				$resultCount ['count'] 
		);
	}
	
	/**
	 * 原生插入语句
	 *
	 * @param array $data
	 *        	array('key值'=>'值')
	 * @param string $table_name
	 *        	表名
	 * @return id
	 * @author hewei
	 */
	public function insertDb($data, $table_name) {
		return $this->dao->db->insert ( $data, $table_name );
	}
	
	/**
	 * 原生更新语句
	 *
	 * @param int $id
	 *        	主键ID
	 * @param array $data
	 *        	参数
	 * @param string $table_name
	 *        	表名
	 * @param string $id_key
	 *        	主键名
	 * @return bool
	 * @author hewei
	 */
	public function updateDb($id, $data, $table_name, $id_key = 'id') {
		return $this->dao->db->update ( $id, $data, $table_name, $id_key );
	}
	
	/**
	 * 原生按字段更新
	 *
	 * @param array $data
	 * @param array $field
	 * @param string $table_name
	 * @return boolean
	 * @author hewei
	 */
	public function updateByFieldDb($data, $field, $table_name) {
		return $this->dao->db->update_by_field ( $data, $field, $table_name );
	}
	
	/**
	 * 原生查询语句
	 *
	 * @param array $field
	 *        	条件数组 array('username' => 'username')
	 * @param string $table_name
	 *        	表名
	 * @return bool
	 * @author hewei
	 */
	public function getOneByFieldDb($field, $table_name) {
		return $this->dao->db->get_one_by_field ( $field, $table_name );
	}
	
	/**
	 * 原生获取所有
	 *
	 * @param string $table_name
	 *        	表名
	 * @param array $field
	 *        	条件语句
	 * @param int $num
	 *        	分页参数
	 * @param int $offest
	 *        	获取总条数
	 * @param int $key_id
	 *        	KEY值
	 * @param string $sort
	 *        	排序键
	 * @return array array(数组数据，统计数)
	 * @author hewei
	 */
	public function getAllDb($table_name, $num = 20, $offest = 0, $field = array(), $id_key = 'id', $sort = 'DESC') {
		return $this->dao->db->get_all ( $table_name, $num, $offest, $field, $id_key, $sort );
	}
	
	/**
	 * sql 查询
	 * 
	 * @param string $sql sql
	 * @return Ambigous <multitype:, boolean>
	 * @author hewei
	 */
	public function getAllSqlDb($sql){
		return $this->dao->db->get_all_sql($sql);
	}
	
	/**
	 * 原生获取数量
	 *
	 * @param string $table_name
	 *        	表名
	 * @param array $field
	 *        	条件语句
	 * @return int
	 * @author hewei
	 */
	public function getCountDb($table_name, $field = array()) {
		return $this->dao->db->get_count ( $table_name, $field );
	}
	
	/**
	 * 原生删除语句
	 *
	 * @param array $field
	 *        	条件数组
	 * @param string $table_name
	 *        	表名
	 * @return bool
	 * @author hewei
	 */
	public function deleteByFieldDb($field, $table_name) {
		return $this->dao->db->delete_by_field ( $field, $table_name );
	}
	
	/**
	 * 过滤array,只取$key 对应
	 *
	 * @param array $key
	 *        	作为key的数组
	 * @param array $arr
	 *        	作为value的数组
	 */
	public function _array_filter_kv($key, $arr) {
		$temp = array ();
		foreach ( $key as $k => $v ) {
			$temp [$v] = $arr [$v];
		}
		return $temp;
	}
	
	/**
	 * 移除空字段
	 *
	 * @param array $arr
	 * @return multitype:arry
	 * @author hewei
	 */
	public function _removeEmpty($arr){
		$tmp = array();
		foreach ($arr as $k => $v){
			if (isset($v) && trim($v) !== ''){
				$tmp[$k] = $v;
			}
		}
		return $tmp;
	}
	
	/**
	 * SQL组装-私有SQL过滤
	 *
	 * @param  string $val 过滤的值
	 * @param  int    $iskey 0-过滤value值，1-过滤字段
	 * @return string
	 */
	public function _build_escape_single($val, $iskey = 0) {
		if ($iskey === 0) {
			if (is_numeric($val)) {
				return " '" . $val . "' ";
			} else {
				return " '" . addslashes(stripslashes($val)) . "' ";
			}
		} else {
			$val = str_replace(array('`', ' '), '', $val);
			return ' `'.addslashes(stripslashes($val)).'` ';
		}
	}
}
?>