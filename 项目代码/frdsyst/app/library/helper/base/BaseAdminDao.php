<?php
class BaseAdminDao extends Dao {
	/*********************************************************************************
	 * BaseAdminDao数据层
	 *-------------------------------------------------------------------------------
	 *版权所有: CopyRight By GUOTENG
	 *-------------------------------------------------------------------------------
	 * @author LY
	 * @version 1.0
	 * @since 1.0
	 * @data:2013-10-15
	 ***********************************************************************************/
	public function getBuildSql() {
		return  new build_sql_ex();
	}
	
	
	/**
	 * SQL操作-获取数据
	 * DAO中使用方法：$this->dao->db->get_all()
	 * @param string $table_name 表名
	 * @param array  $field 条件语句 键值数组 进行where and 语句sql的拼接
	 * @param int    $num 每页显示条数
	 * @param int    $page 当前页数
	 * @param int    $offest 取值起始值
	 * @param int    $key_id 排序字段
	 * @param string $sort 排序键（DESC,ASC）
	 * @return array array(数组数据，统计数)
	 */
	public function run($sql,$sql_count){  
	   $result = $this->dao->db->get_all_sql($sql);
	   if (!$result) return false; 
	   $resultCount = $this->dao->db->query($sql_count, false);
	   $resultCount =  $this->dao->db->fetch_assoc($resultCount);
	   return array($result, $resultCount['count']);
	}
		
	/**
	 * SQL操作-保存数据
	 * 新增用户
	 * @param $user
	 * @return id 返回生成主键id
	 */
	public function save($data, $table_name) {		
		return $this->dao->db->insert($data, $table_name);	
	}
	
	/**
	 * 返回查询对象 (返回一表单实体对象)
	 * @param $id
	 * @return array 该条记录的实体
	 */
	public function show($id, $table_name, $id_key = 'id') {
		return $this->dao->db->get_one($id, $table_name, $id_key = 'id');
	}
	
	/**
	 * 更新用户信息
	 * @param $user
	 * @return bool
	 */
	public function update($id, $data, $table_name, $id_key = 'id') {
			return $this->dao->db->update($id, $data, $table_name, $id_key);
	}
	
	
	/**
	 * 删除对象
	 * @param $id
	 * @return bool
	 */
	public function delete($id,$tableName,$id_key) {
			return $this->dao->db->delete($id,$tableName,$id_key);			
	}

}