<?php
/**
 * ---------------------------------------------------------------------------
 * V1 版本基础AppService
 * ---------------------------------------------------------------------------
 *  <strong>copyright</strong>： ©版权所有 成都奇望网讯科技有限公司<br>
 * ----------------------------------------------------------------------------
 * @author:hewei
 * @time:2015-1-19 下午3:46:29
 * ---------------------------------------------------------------------------
 */
class BaseWX_V1_Service extends Service{
	
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
}
?>