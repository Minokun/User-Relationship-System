<?php
class fOptService extends Service {
    
	private function _getDao() {
	    return InitPHP::getDao('fOpt', 'frd');
	}
	
	//首先检查好友表里是否已有该用户记录
	public function checkoutone($uid){
	    return $this->_getDao()->checkoutone($uid);
	}
	
	//查看好友列表
	public function checkoutall($uid){
	    return $this->_getDao()->checkoutall($uid);
	}
	
	//根据用户备注名查看好友id
	public function uid_by_remark($uid,$remark){
	       $json_remark = $this->_getDao()->uid_by_remark($uid,$remark);
	       if($json_remark == ''){
	           return 300;
	       }else{
    	       $res = explode(',',$json_remark['remark']);
    	       $list = '';
    			foreach($res as $key=>$value){
    			    $val = json_decode($value,ture);
    			    foreach ($val as $k=>$v){
    			        if(preg_match('/.*'.$remark.'.*/',$v)){
    			            $list .= $k.',';
    			        }
    			    }
    			}
    			return substr($list,0,strlen($list)-1);
	       }
	}
	
	//修改好友的昵称
	public function remark_change($uid,$frd_uid,$remark){
	    //查找好友是否存在,存在则跟新数据，不存在返回
	    $mark = 0;
	    $result = $this->_getDao()->checkoutone($uid);
	    $msg = explode(',',$result['fids']);
	    foreach($msg as $key=>$value){
	        $val = json_decode($value,ture);
	        foreach ($val as $k=>$v){
	           if($k == $frd_uid){
	               $mark += 1;
               }
           }
        }
        if($mark == 0){
            return 300;
        }else{
//             $remark = explode(',',$result['remark']);
//             foreach($remark as $rkey=>$rvalue){
//                 $val = json_decode($rvalue,ture);
//                 foreach ($val as $rk=>$rv){
//                     if($rk == $frd_uid){
//                         $val[$rk] = $remark;
//                     }
//                 }
//             }
            //更新昵称
            $res = preg_replace('/(.*\"'.$frd_uid.'\"\:\")[^\"]*(\".*)/','$1'.$remark.'$2',$result['remark']);
            $this->_getDao()->remark_change($uid,$res);
        }
	    
	}
	
	//查看用户群列表
	public function checkout_group($uid){
	    return $this->_getDao()->checkout_group($uid);
	}
	
	//添加好友
	public function add_frds($uid,$add_uid,$remark){
	    //好友角色为2
	    $rid = 2;
	    //好友的备注名，第一次默认为原名
	    //检查是否有记录
	    $result = $this->checkoutone($uid);
	    if(empty($result)){
	        //没有记录则直接插入一条
	        $this->_getDao()->add_frds($uid,$add_uid,$rid,$remark);
	    }else{
	       //有记录则查看好友是否已经存在，否，更新数据
            $json = $this->_getDao()->checkoutall($uid);
            $list = explode(',',$json['fids']);
	        //如果好友已存在则返回2
	        foreach ($list as $value){
				$value = json_decode($value,true);
	            foreach($value as $k=>$v){
					if($k == $add_uid){
						return 2;
					}
				}
	        }
	        //列表里没有好友的id 
	        //更新好友列表
	        $frds_new = $json['fids'].','.json_encode(array($add_uid=>$rid));
	        //查出好友备注名的数据
	        $json_remark = $this->_getDao()->checkout_remark($uid);
	        $remark_new = $json_remark['remark'].','.json_encode(array($add_uid=>$remark),JSON_UNESCAPED_UNICODE);
	        $this->_getDao()->updatefrds($uid,$frds_new,$remark_new);
	    }
	}
	
	//删除好友
	public function del_frds($uid,$del_uid) {
	    //首先将用户的好友列表取出来
	    $json = $this->_getDao()->checkoutall($uid);
	    $list = explode(',',$json['fids']);
		$list_del = array();
		$status = 300;
		foreach ($list as $value){
				$value = json_decode($value,true);
				foreach($value as $k => $v){
					if($k != $del_uid){
						$list_del[] =json_encode($value);
					}else{
					    $status = 200;
					}
				}
	        }
	    //更新好友列表
	    $frds_new = implode(',',$list_del);
		$this->_getDao()->updatefrds($uid,$frds_new);
		return $status;
	}
	
	//删除用户的群列表的群号
	public function del_gids($uid,$del_gid) {
	    //首先将用户的好友列表取出来,将字符串变成数组后，去掉删除的组号，在将数组变成字符串，更新数据库
	    $res = $this->_getDao()->checkout_group($uid);
	    $list = explode(',', $res['gids']);
	    foreach ($list as $k=>$v){
	        if($del_gid == $v){
	            $unset_gid = $k;
	        }
	    }
	    if(empty($unset_gid)){
	       unset($list[$unset_gid]);
	    }
	    //更新用户群列表
	    $gids_new = implode(',',$list);
	    $this->_getDao()->updategids($uid,$gids_new);
	}
	
	//创建用户群
	public function create_group($uid,$gname,$gdesc){
	    //直接插入一条
	    $create_time = date("Y-m-d H:i:s");
	    $level = 1;
	    //查询该用户是否重复提交,重复则返回2
	    $res = $this->_getDao()->query_id($uid,$gname);
	    if($res['gid'] != ''){
	        return 2;
	    }
	    $this->_getDao()->create_group($uid,$gname,$gdesc,$create_time,$level);
	    //取出该用户的群列表
	    $result = $this->_getDao()->checkout_group($uid);
	    //取出新建的群id
	    $gid = $this->_getDao()->query_id($uid,$gname);
	    //更新用户的群列表
	    if($result['gids']==''){
	       $gids_new = $gid['gid'];
	    }else{
	        $gids_new = $result['gids'].','.$gid['gid'];
	    }
	    $this->_getDao()->updategids($uid,$gids_new);
	}
	
	//根据群名和群主id查找群id 
	public function query_group_id($uid,$gname){
		return $this->_getDao()->query_id($uid,$gname);
	}
	
	//根据群id查群的信息
	public function query_group_by_gid($gid){
	    $res = $this->_getDao()->query_group_by_gid($gid);
        foreach ( $res as $k => $v ) {
            $res[$k] = urlencode ( $v );
        }
	    return $res;
	}
	
	//根据群名称查所有群的信息
	public function query_group_by_gname($gname){
	    $res = $this->_getDao()->query_group_by_gname($gname);
	    foreach ( $res as $key => $value ) {
    	    foreach ( $value as $k => $v ) {
    	        $res[$key][$k] = urlencode ( $v );
    	    }
	    }
	    return $res;
	}
	//添加群主
	public function add_master($gid,$uid){
		$rid = 1;
	    $jointime = date("Y-m-d H:i:s");
	    $group_name = '';
		$this->_getDao()->add_members($gid,$uid,$rid,$jointime,$group_name);
	}
	
	//添加群成员
	public function add_members($gid,$list){
	    $rid = 2;
	    $jointime = date("Y-m-d H:i:s");
	    $group_name = '';
	    //首先在成员表里一条
	    //查看群号是否正确
	    $info = $this->_getDao()->query_group_by_gid($gid);
	    if($info['gname'] == ''){
	        return 2;
	    }
	    
		foreach($list as $k=>$uid){
			//查询uid是否已在群中
			$res = $this->_getDao()->query_member($gid,$uid);
			if($res['gid'] == ''){
				$this->_getDao()->add_members($gid,$uid,$rid,$jointime,$group_name);
				//在被添加用户的群列表里添加群号
				//取出该用户的群列表
				$result = $this->_getDao()->checkout_group($uid);
				if($result['gids']==''){
				    $gids_new = $gid;
				}else{
				    //判断群号是否已存在
				    $list = explode(',',$result['gids']);
				    if(in_array($gid,$list)){
				        $gids_new = '';
				    }else{
				        $gids_new = $result['gids'].','.$gid;
				    }
				}
				$this->_getDao()->updategids($uid,$gids_new);
			}else{
			    return 3;
			}
			
		}
	    
	}
	
	//退群
	public function del_members($gid,$del_uid){
	    //查询成员是否存在该群众，不存在返回300
	    $result = $this->_getDao()->query_member($gid,$del_uid);
	    if(empty($result)){
	        $status['id'] = 300;
	        return $status;
	    }
	    //删除成员表里信息
	    $this->_getDao()->del_member($gid,$del_uid);
	    //删除用户的群列表里的信息
	    $this->del_gids($del_uid, $gid);
	    //查询该群的群成员表里是否还有成员，否：删除该群 ，是：则判断删除的用户uid是否为群主，是则换一个群主（更新user_group表,更新group_member表）
	    $res = $this->_getDao()->query_members_by_gid($gid); 
	    if(empty($res)){
	        $this->_getDao()->del_group_by_id($gid);
	        $status['id'] = 202;
	        return $status;
	    }else{
	        //查询是否为群主
	        $r = $this->_getDao()->query_group_by_gu($gid,$del_uid);
	        if (empty($r['gid'])){
	        }else{
	            //是群主，更新群表和群成员表
	            $this->_getDao()->update_gmaster($res[0]['uid'],$gid);
	            $this->_getDao()->update_gm_role($res[0]['uid'],$gid);
	            $status['id'] = 201;
	            $status['uid'] = $res[0]['uid'];
	           return $status;
	        }
	        
	    }
	}
	
	//查询群成员
	public function query_gmembers($gid){
	    $res = $this->_getDao()->query_members_by_gid($gid);
	    return $res;
	}
	
	//分享图片
	public function share($uid,$urls,$cid,$fids,$desc){
	    $createtime = date("Y-m-d H:i:s");
	    $this->_getDao()->share($uid,$urls,$cid,$fids,$createtime,$desc);
	}
	
	//删除分享的图片
	public function del_share($uid,$pid){
	    //查询pid是否存在
	    $res = $this->_getDao()->query_pic_by_pid($uid,$pid);
	    if(empty($res)){
	        return 300;
	    }
	    $this->_getDao()->del_share($uid,$pid);
	}
	
	//更新上传的资源
	public function update_share($uid,$pid,$cid,$fids,$desc) {
	    //查询pid是否存在
	    $res = $this->_getDao()->query_pic_by_pid($uid,$pid);
	    if(empty($res)){
	        return 300;
	    }
	    $this->_getDao()->update_share($uid,$pid,$cid,$fids,$desc);
	}
	
	//查询用户分享的所有图片信息
	public function query_share($uid){
	    $res = $this->_getDao()->query_share($uid);
	    foreach ( $res as $key => $value ) {
	        foreach ( $value as $k => $v ) {
	            $res[$key][$k] = urlencode ( $v );
	        }
	    }
	    return $res;
	}
	
	//查出访问者能看到的所有图片信息
	public function display_share($uid,$visit_uid) {
	    //先查出访问者在被访问者中的好友里权限是什么
	    if($uid == $visit_uid){
	        $list_ace = array(0,1,2,3);
	    }else{
	        //取出被访问者的好友列表
    	    $json_str = $this->_getDao()->checkoutall($uid);
    	    $json_arr = explode(',', $json_str['fids']);
    	    foreach ($json_arr as $k=>$value){
    	        $list[] = json_decode($value,true);
    	    }
    	    foreach ($list as $key=>$value){
    	        foreach ($value as $k=>$v){
    	            $list_a[$k] = $v;
    	        }
    	    }
    	    //取出访问者的角色
    	    $role = $list_a[$visit_uid];
    	    //如果访问角色为空 返回300报错
    	    if(empty($role)){
    	        return 300;
    	    }
    	    //取出该角色相应权限
    	    $access = $this->_getDao()->query_access($role);
    	    $ace = $access[0]['cids'];
    	    $list_ace = explode(',', $ace);
	    }
	    //根据权限开始取出所有的资源
	    foreach ($list_ace as $k=>$v){
	        $res = $this->_getDao()->query_share_by_uc($uid,$v);
	        foreach ($res as $key=>$value){
	            //判断当该资源为指定好友开放时，访问用户的id是否在fids里,1是，0不是
	            $list_judge = explode(',', $value['fids']);
	            if(in_array($visit_uid, $list_judge)){
	                $judge = 1;
	            }else{
	                $judge = 0;
	            }
	            if($value['cid'] == 3 and $judge == 0){
	                continue;
	            }
	            $result[] = $value;
	        }
	    }
	    //16位编码
	    foreach ( $result as $key => $value ) {
	        foreach ( $value as $k => $v ) {
	            $r[$key][$k] = urlencode ( $v );
	        }
	    }
	    return $r;
	    
	}
	
	//向群空间上传资源
	public function group_share($gid,$uid,$pdesc,$purls){
	    $createtime = date("Y-m-d H:i:s");
	    $pstatus = 1;
	    //查询该用户是否为该群成员
	    $res = $this->_getDao()->query_member($gid,$uid);
	    if (empty($res)){
	        return 300;
	    }
	    $this->_getDao()->insert_group_resource($gid,$uid,$createtime,$pdesc,$purls,$pstatus);
	}
	
	//向群空间删除资源
	public function del_group_share($gid,$pid){
	    //查询资源是否存在
	    $res = $this->_getDao()->query_gshare_by_gp($gid,$pid);
	    if (empty($res)){
	        return 300;
	    }
	    $this->_getDao()->del_group_resource($gid,$pid);
	}
	
	//查询某群的所有群资源
	public function query_group_share($gid) {
	    $res = $this->_getDao()->query_group_share($gid);
	    foreach ( $res as $key => $value ) {
	        foreach ( $value as $k => $v ) {
	            $res[$key][$k] = urlencode ( $v );
	        }
	    }
	    return $res;
	}
	
	//向用户消息列表里插入一条记录
	public function user_message($uid,$to_uid,$urls,$describe,$type){
	    $status = 0;
	    $create_time = date("Y-m-d H:i:s");
	    //如果type = 1 那么查询群号是否存在
	    $res = $this->_getDao()->query_group_by_gid;
	    if (empty($res)){
	        return 300;
	    }
	    $this->_getDao()->insert_user_message($uid,$to_uid,$urls,$describe,$create_time,$type,$status);
	}
	
	//在成员表里查看用户加的群
	public function query_gids_by_uid($uid){
	    return $this->_getDao()->query_gids_by_uid($uid);
	}
	
}
?>