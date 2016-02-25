<?php
if (! defined ('IS_INITPHP'))
	exit ('Access Denied!');
/**
 * ---------------------------------------------------------------------------
 * 仿照ECMALL 模板引擎进行拓展以及修正
 * ---------------------------------------------------------------------------
 * <strong>copyright</strong>： ©版权所有 成都奇望网讯科技有限公司<br>
 * ----------------------------------------------------------------------------
 *
 * @author :hewei
 *         @time:2015-3-23 下午4:38:41
 *         ---------------------------------------------------------------------------
 */
class qwtInit {
	private $_foreach_arr = array (); // 记录foreach 临时编译信息
	private $_tag_left = '<!--{'; // 左标签
	private $_tag_right = '}-->'; // 右标签
	
	/**
	 * 构造函数
	 *
	 * @author hewei
	 */
	public function __construct() {
		$this->qwtInit ();
	}
	public function qwtInit() {
	}
	
	/**
	 * 模板驱动
	 *
	 * @param string $str
	 *        	模板文件数据
	 * @return string
	 */
	public function init($str, $left, $right) {
		$this->_tag_left = $left;
		$this->_tag_right = $right;
		return preg_replace ("/({|<!--{)([^\}\{\n]*)(}-->|})/e", "\$this->select('\\2');", $str);
	}
	
	/**
	 * 处理{}标签
	 *
	 * @author wj
	 * @param string $tag        	
	 *
	 * @return sring
	 */
	function select($tag) {
		$tag = stripslashes (trim ($tag));
		
		if (empty ($tag)) {
			return '{}';
		} else if ($tag {0} == '*' && substr ($tag, - 1) == '*') {
			// 注释部分
			return '';
		} else if ($tag {0} == '$') {
			// 变量
			return '<?php echo ' . $this->get_val (substr ($tag, 1)) . '; ?>';
		} else if ($tag {0} == '/') {
			// 结束 tag
			switch (substr ($tag, 1)) {
				case 'if' :
					return '<?php endif; ?>';
					break;
				
				case 'foreach' :
					// 移除foreach 记录
					array_pop ($this->_foreach_arr);
					return '<?php endforeach; endif; unset($_from); ?>';
					break;
				
				default :
					return '{' . $tag . '}';
					break;
			}
		} else {
			$tag_all = explode (' ', $tag);
			$tag_sel = array_shift ($tag_all);
			switch ($tag_sel) {
				case 'if' :
					return $this->_compile_if_tag (substr ($tag, 3));
					break;
				
				case 'else' :
					return '<?php else: ?>';
					break;
				
				case 'elseif' :
					return $this->_compile_if_tag (substr ($tag, 7), true);
					break;
				
				case 'foreach' :
					return $this->_compile_foreach_start (substr ($tag, 8));
					break;
				
				case 'res' :
					$t = $this->get_para (substr ($tag, 4), 0);
					return '<?php echo rtrim(BASE_PATH, "/") . "/" . ' . "'$t[file]'" . '; ?>';
					break;
				
				case 'lib' :
					$t = $this->get_para (substr ($tag, 4), 0);
					return '<?php echo rtrim(BASE_PATH, "/") . "/" . ' . "'$t[file]'" . '; ?>';
					break;
				
				case 'insert' :
					$t = $this->get_para (substr ($tag, 7), 0);
					$file = InitPHP::getAppPath ($t ['file']);
					if (file_exists ($file) && ! is_dir ($file)) {
						$str = @file_get_contents ($file);
						$str = $this->init ($str, $this->_tag_left, $this->_tag_right);
						return $str;
					} else {
						return '{' . $tag . '}';
					}
					break;
				
				case 'url' :
					$t = $this->get_para (substr ($tag, 4), 0);
					$url = $t ['url'] {0} == '$' ? $t ['url'] : "'" . $t ['url'] . "'";
					return '<?php echo rtrim(BASE_PATH, "/") . "/" . ' . "$url" . '; ?>';
					break;
				
				default :
					return '{' . $tag . '}';
					break;
			}
		}
	}
	
	/**
	 * 处理foreach标签
	 *
	 * @access public
	 * @param string $tag_args        	
	 *
	 * @return string
	 */
	function _compile_foreach_start($tag_args) {
		$attrs = $this->get_para ($tag_args, 0);
		$arg_list = array ();
		$from = $attrs ['from'];
		
		$item = '$' . $attrs ['item'];
		
		if (! empty ($attrs ['key'])) {
			$key = $attrs ['key'];
			$key_part = $this->get_val ($key) . ' => ';
		} else {
			$key = null;
			$key_part = '';
		}
		
		if (! empty ($attrs ['name'])) {
			$name = $attrs ['name'];
		} else {
			$name = null;
		}
		
		// 记录foreach 编译信息
		array_push ($this->_foreach_arr, array (
				'from' => $attrs ['from'],
				'item' => $attrs ['item'],
				'key' => $attrs ['key'],
				'name' => $attrs ['name'] 
		));
		
		$output = '<?php ';
		$output .= "\$_from = $from; if (!is_array(\$_from) && !is_object(\$_from)) { settype(\$_from, 'array'); }; ";
		
		if (! empty ($name)) {
			$foreach_props = '$' . $name;
			$output .= "{$foreach_props} = array('total' => count(\$_from), 'iteration' => 0);\n";
			$output .= "if ({$foreach_props}['total'] > 0):\n";
			$output .= "    foreach (\$_from AS $key_part$item):\n";
			$output .= "        {$foreach_props}['iteration']++;\n";
		} else {
			$output .= "if (count(\$_from)):\n";
			$output .= "    foreach (\$_from AS $key_part$item):\n";
		}
		
		return $output . '?>';
	}
	
	/**
	 * 处理insert外部函数/需要include运行的函数的调用数据
	 *
	 * @access public
	 * @param string $val        	
	 * @param int $type        	
	 *
	 * @return array
	 */
	function get_para($val, $type = 1) {
		$pa = $this->str_trim ($val);
		foreach ($pa as $value) {
			if (strrpos ($value, '=')) {
				list ( $a, $b ) = explode ('=', str_replace (array (
						' ',
						'"',
						"'",
						'&quot;' 
				), '', $value));
				if ($b {0} == '$') {
					if ($type) {
						eval ('$para[\'' . $a . '\']=' . $this->get_val (substr ($b, 1)) . ';');
					} else {
						$para [$a] = $this->get_val (substr ($b, 1));
					}
				} else {
					$para [$a] = $b;
				}
			}
		}
		
		return $para;
	}
	function str_trim($str) {
		/* 处理'a=b c=d k = f '类字符串，返回数组 */
		while (strpos ($str, '= ') != 0) {
			$str = str_replace ('= ', '=', $str);
		}
		while (strpos ($str, ' =') != 0) {
			$str = str_replace (' =', '=', $str);
		}
		
		return explode (' ', trim ($str));
	}
	
	/**
	 * 处理smarty标签中的变量标签
	 *
	 * @author wj
	 * @param string $val
	 *        	标签
	 *        	
	 * @return bool
	 */
	function get_val($val) {
		if (strrpos ($val, '[') !== false) {
			$val = preg_replace ("/\[([^\[\]]*)\]/eis", "'.'.str_replace('$','\$','\\1')", $val);
		}
		
		if (strrpos ($val, '|') !== false) {
			$moddb = explode ('|', $val);
			$val = array_shift ($moddb);
		}
		
		if (empty ($val)) {
			return '';
		}
		
		if (strpos ($val, '.$') !== false) {
			$all = explode ('.$', $val);
			
			foreach ($all as $key => $val) {
				$all [$key] = $key == 0 ? $this->make_var ($val) : '[' . $this->make_var ($val) . ']';
			}
			$p = implode ('', $all);
		} else {
			$p = $this->make_var ($val);
		}
		
		if (! empty ($moddb)) {
			foreach ($moddb as $key => $mod) {
				$s = explode (':', $mod);
				switch ($s [0]) {
					case 'escape' :
						$s [1] = trim ($s [1], '"');
						if ($s [1] == 'html') {
							$p = 'htmlspecialchars(' . $p . ')';
						} elseif ($s [1] == 'url') {
							$p = 'urlencode(' . $p . ')';
						} elseif ($s [1] == 'quotes') {
							$p = 'addslashes(' . $p . ')';
						} elseif ($s [1] == 'input') {
							$p = 'str_replace(\'"\', \'&quot;\',' . $p . ')';
						} elseif ($s [1] == 'editor') {
							$p = 'html_filter(' . $p . ')';
						} else {
							$p = 'htmlspecialchars(' . $p . ')';
						}
						$test1 = true;
						break;
					case 'price' :
						$p = 'number_format(' . $p . ', 2)';
						break;
					default :
						// code...
						break;
				}
			}
		}
		
		return $p;
	}
	
	/**
	 * 处理去掉$的字符串
	 *
	 * @access public
	 * @param string $val        	
	 *
	 * @return bool
	 */
	function make_var($val) {
		if (strrpos ($val, '.') === false) {
			$is_foreach = false;
			foreach ($this->_foreach_arr as $v) {
				if ($v ['item'] == $val || $v ['name'] == $val) {
					$p = '$' . $v ['item'];
					$is_foreach = true;
				}
			}
			if (! $is_foreach) {
				$p = '$this->view[\'' . $val . '\']';
			}
		} else {
			$t = explode ('.', $val);
			$_var_name = array_shift ($t);
			if ($_var_name == 'smarty') {
				$p = $this->_compile_smarty_ref ($t);
			} else if (! empty ($this->_foreach_arr)) { // 如果foreach 存在，中间元素需要处理
				$is_foreach = false;
				foreach ($this->_foreach_arr as $v) {
					if ($v ['item'] == $_var_name) {
						$p = '$' . $v ['item'];
						$is_foreach = true;
					} else if ($v ['name'] == $_var_name) {
						$p = '$' . $v ['name'];
						$is_foreach = true;
					}
				}
				if (! $is_foreach) {
					$p = '$this->view[\'' . $_var_name . '\']';
				}
			} else {
				$p = '$this->view[\'' . $_var_name . '\']';
			}
			foreach ($t as $val) {
				$p .= '[\'' . $val . '\']';
			}
		}
		
		return $p;
	}
	
	/**
	 * 处理smarty开头的预定义变量
	 *
	 * @access public
	 * @param array $indexes        	
	 *
	 * @return string
	 */
	function _compile_smarty_ref(&$indexes) {
		/* Extract the reference name. */
		$_ref = $indexes [0];
		
		switch ($_ref) {
			case 'now' :
				$compiled_ref = 'time()';
				break;
			
			case 'get' :
				$compiled_ref = '$_GET';
				break;
			
			case 'post' :
				$compiled_ref = '$_POST';
				break;
			
			case 'cookies' :
				$compiled_ref = '$_COOKIE';
				break;
			
			case 'env' :
				$compiled_ref = '$_ENV';
				break;
			
			case 'server' :
				$compiled_ref = '$_SERVER';
				break;
			
			case 'request' :
				$compiled_ref = '$_REQUEST';
				break;
			
			case 'session' :
				$compiled_ref = '$_SESSION';
				break;
			
			case 'const' :
				array_shift ($indexes);
				$compiled_ref = '@constant("' . strtoupper ($indexes [0]) . '")';
				break;
				
			case 'href':
				$compiled_ref = '((! empty ($_SERVER ["HTTPS"]) && $_SERVER ["HTTPS"] !== "off" || $_SERVER ["SERVER_PORT"] == 443) ? "https://" : "http://").$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]';
				break;
			
			default :
				// $this->_syntax_error('$smarty.' . $_ref . ' is an unknown reference', E_USER_ERROR, __FILE__, __LINE__);
				break;
		}
		array_shift ($indexes);
		
		return $compiled_ref;
	}
	
	/**
	 * 处理if标签
	 *
	 * @access public
	 * @param string $tag_args        	
	 * @param bool $elseif        	
	 *
	 * @return string
	 */
	function _compile_if_tag($tag_args, $elseif = false) {
		preg_match_all ('/\-?\d+[\.\d]+|\'[^\'|\s]*\'|"[^"|\s]*"|[\$\w\.]+|!==|===|==|!=|<>|<<|>>|<=|>=|&&|\|\||\(|\)|,|\!|\^|=|&|<|>|~|\||\%|\+|\-|\/|\*|\@|\S/', $tag_args, $match);
		
		$tokens = $match [0];
		// make sure we have balanced parenthesis
		$token_count = array_count_values ($tokens);
		if (! empty ($token_count ['(']) && $token_count ['('] != $token_count [')']) {
			// $this->_syntax_error('unbalanced parenthesis in if statement', E_USER_ERROR, __FILE__, __LINE__);
		}
		
		for($i = 0, $count = count ($tokens); $i < $count; $i ++) {
			$token = &$tokens [$i];
			switch (strtolower ($token)) {
				case 'eq' :
					$token = '==';
					break;
				
				case 'ne' :
				case 'neq' :
					$token = '!=';
					break;
				
				case 'lt' :
					$token = '<';
					break;
				
				case 'le' :
				case 'lte' :
					$token = '<=';
					break;
				
				case 'gt' :
					$token = '>';
					break;
				
				case 'ge' :
				case 'gte' :
					$token = '>=';
					break;
				
				case 'and' :
					$token = '&&';
					break;
				
				case 'or' :
					$token = '||';
					break;
				
				case 'not' :
					$token = '!';
					break;
				
				case 'mod' :
					$token = '%';
					break;
				
				default :
					if ($token [0] == '$') {
						$token = $this->get_val (substr ($token, 1));
					}
					break;
			}
		}
		
		if ($elseif) {
			return '<?php elseif (' . implode (' ', $tokens) . '): ?>';
		} else {
			return '<?php if (' . implode (' ', $tokens) . '): ?>';
		}
	}
}
