<?php
class fOptController extends Controller{
    public $initphp_list = array (
        'add_frds','del_frds',
        'create_group','add_members','del_members','checkout_frds','checkout_group','info_group','query_gmembers','uid_by_remark','remark_change',
        'share','del_share','update_share','query_share','display_share',
        'group_share','del_group_share','query_group_share',
        'user_message'
    );
    
    public function return_json($msg,$status,$error='',$list=''){
        header ("Content-Type:application/json; charset=utf-8");
	   header('Access-Control-Allow-Origin:*');
	   if($status == 400){
		   $server_error = $msg;
		   $msg = '';
	   }elseif($status == 300 or $status == 201){
	       $server_error = $error;
	   }else{
		   $server_error = "<null>";
	   }
	   exit (json_encode (array (
	        'list' => $list,
			'msg' => $msg, 			
			'server_status' => $status,   
			'server_error' => $server_error
	   )));
    }
    
    private function _getService(){
        return InitPHP::getService('fOpt','frd');
    }
    
    //添加好友
    public function add_frds(){
        if($uid = $this->controller->get_gp('uid') and $add_uid = $this->controller->get_gp('add_uid') and $user_name = $this->controller->get_gp('user_name')  and $frd_name = $this->controller->get_gp('frd_name')){
            $status = $this->_getService()->add_frds($uid,$add_uid,$frd_name);
			$this->_getService()->add_frds($add_uid,$uid,$user_name);
            //如果返回结果是2,则好友已添加
            if($status == 2){
                $msg = "the add_uid is already exist!";
                $this->return_json($msg, 300);
            }
            $this->return_json("Successful!",200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //删除好友
    public function del_frds(){
        if($uid = $this->controller->get_gp('uid') and $del_uid = $this->controller->get_gp('del_uid')){
            $status = $this->_getService()->del_frds($uid,$del_uid);
            if ($status == 300){
                $this->return_json("",300,'The del_uid is not exist in friends list!');
            }
            $this->return_json("Successful!",200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //查看好友列表
    public function checkout_frds(){
        if($uid = $this->controller->get_gp('uid')){
            $result = $this->_getService()->checkoutone($uid);
            if($result['fids'] == ''){
				$msg = "The uid does't have friends!";
				$this->return_json($msg, 400);
			}
			//取出好友id
			$msg = explode(',',$result['fids']);
			foreach($msg as $key=>$value){
				//$msg[$key] = json_decode($value,ture);
				$val = json_decode($value,ture);
				foreach ($val as $k=>$v){
				    $list[$key]['UID'] = $k;
				    $list[$key]['RID'] = $v;
				}
			}
			//取出好友备注
			$remark = explode(',',$result['remark']);
			foreach($remark as $rkey=>$rvalue){
			    $val = json_decode($rvalue,ture);
			    foreach ($val as $rk=>$rv){
			        $list[$rkey]['REMARK'] = $rv;
			    }
			}
			$this->return_json('', 200,'',$list);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //根据好友备注名查询好友id号
    public function uid_by_remark(){
        if($uid = $this->controller->get_gp('uid') and $remark = $this->controller->get_gp('remark')){
            //查询该用户是否有该昵称的好友
            $result = $this->_getService()->uid_by_remark($uid,$remark);
            if($result == 300){
                $msg = 'No friends match the condition!';
                $this->return_json($msg, 300);
            }else{
                $this->return_json('', 200,'',$result);
            }
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //修改好友备注名
    public function remark_change(){
        if($uid = $this->controller->get_gp('uid') and $remark = $this->controller->get_gp('remark') and $frd_uid = $this->controller->get_gp('frd_uid')){
            $result = $this->_getService()->remark_change($uid,$frd_uid,$remark);
            if($result == 300){
                $msg = "The friend doesn't exist!";
                $this->return_json($msg, 300);
            }
            $this->return_json("Successful!",200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //创建用户群
    public function create_group(){
        //在群组表里插一条数据
        if($uid = $this->controller->get_gp('uid') and $gname = $this->controller->get_gp('gname')){
            if(($gdesc = $this->controller->get_gp('gdesc')) == '' ){
                $gdesc = 'shi';
            }
			//查群id
			$group_id = $this->_getService()->query_group_id($uid,$gname);
			if($group_id == ''){
				$res = $this->_getService()->create_group($uid,$gname,$gdesc);
				//把群主加进群里
				$group_id = $this->_getService()->query_group_id($uid,$gname);
				$gid = $group_id['gid'];
				$this->_getService()->add_master($gid,$uid);
				//在群主的群列表里加入新的群号
			}else{
                $this->return_json($group_id, 300 , 'The group was already exist!');
            }
            $this->return_json($group_id,200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //查看用户所加的群列表
    public function checkout_group(){
        if($uid = $this->controller->get_gp('uid')){
            $result = $this->_getService()->query_gids_by_uid($uid);
            if (empty($result)){
                $this->return_json('', 201 ,'The group list is empty!');
            }
            $this->return_json($result, 200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //查看群信息
    public function info_group(){
        if($gid = $this->controller->get_gp('gid') or $gname = $this->controller->get_gp('gname')){
            if($gid != ''){
                $res = $this->_getService()->query_group_by_gid($gid);
                $res = eval('return '.urldecode(var_export($res,true)).';');
                $this->return_json(array($res), 200);
            }else{
                $res = $this->_getService()->query_group_by_gname($gname);
                $res = eval('return '.urldecode(var_export($res,true)).';');
                $this->return_json($res, 200);
            }
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //添加群成员
    public function add_members(){
        if($add_uid = $this->controller->get_gp('add_uid') and $gid = $this->controller->get_gp('gid')){
			//多个群成员
			$list = explode(',',$add_uid);
			$status = $this->_getService()->add_members($gid,$list);
            if($status == 2){
                $msg = "The groupID is not exist!";
                $this->return_json($msg, 400);
            }else if($status == 3){
                $error = "The uid is already exist in this group!";
                $this->return_json($msg, 300,$error);
            }
            $this->return_json("Successful!",200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //根据群号查询群成员
    public function query_gmembers($gid){
        if($gid = $this->controller->get_gp('gid')){
            $res = $this->_getService()->query_gmembers($gid);
            if(empty($res)){
                $this->return_json($res,300,'The group is not exist!');
            }
            $this->return_json($res,200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
	
    //删除群成员
    public function del_members(){
        if($del_uid = $this->controller->get_gp('del_uid') and $gid = $this->controller->get_gp('gid')){
            $status = $this->_getService()->del_members($gid,$del_uid);
            if ($status['id'] == 300){
                $this->return_json('',300,"The del_uid is not exist in this group!");
            }elseif ($status['id'] == 201){
                $this->return_json('The group master has been changed to \''.$status['uid']."'",201);
            }elseif ($status['id'] == 202){
                $this->return_json('The group has been deleted!',202);
            }
            $this->return_json("Successful!",200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //分享图片
    public function share(){
        if($uid = $this->controller->get_gp('uid') and $urls = $this->controller->get_gp('urls') and ($cid = $this->controller->get_gp("cid")) != '' ){
            $fids = $this->controller->get_gp("fids");
            $desc = $this->controller->get_gp("desc");
            if($cid != 3){
                $fids = '';
            }
            $status = $this->_getService()->share($uid,$urls,$cid,$fids,$desc);
            $this->return_json("Successful!",200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //删除分享图片
    public function del_share() {
        if($uid = $this->controller->get_gp('uid') and $pid = $this->controller->get_gp('pid')){
            $status = $this->_getService()->del_share($uid,$pid);
            if ($status == 300){
                $this->return_json("",300,"The pid or uid is not exitst in user_resource!");
            }
            $this->return_json("Successful!",200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //更新分享图片
    public function update_share(){
        if($uid = $this->controller->get_gp('uid') and $pid = $this->controller->get_gp('pid') and ($cid = $this->controller->get_gp("cid")) != ''){
            $fids = $this->controller->get_gp("fids");
            $desc = $this->controller->get_gp("desc");
            if($cid != 3){
                $fids = "";
            }
            //在更新前先查询是否存在，不存在则返回300
            $status = $this->_getService()->update_share($uid,$pid,$cid,$fids,$desc);
            if($status == 300){
                $this->return_json("",300,'The resouce is not exist!');
            }
            $this->return_json("Successful!",200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //查询用户分享的所有图片信息
    public function query_share(){
        if($uid = $this->controller->get_gp('uid')){
            $res = $this->_getService()->query_share($uid);
            $res = eval('return '.urldecode(var_export($res,true)).';');
            if(empty($res)){
                $this->return_json('', 201,'No resources available for viewing!');
            }
            $this->return_json($res, 200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //查询出访问者能够看的所有资源信息
    public function display_share($uid,$visit_uid) {
        if($uid = $this->controller->get_gp('uid') and $visit_uid = $this->controller->get_gp('visit_uid')){
            $res = $this->_getService()->display_share($uid,$visit_uid);
            if($res == 300){
                $this->return_json('',300,'The visit_uid is not exist in user\'s friend\'s list!');
            }
            $res = eval('return '.urldecode(var_export($res,true)).';');
            if  (empty($res)){
                $this->return_json('', 201,'No resources available for viewing!');
            }
            $this->return_json($res, 200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //向群空间上传资源
    public function group_share(){
        if($uid = $this->controller->get_gp('uid') and $gid = $this->controller->get_gp('gid') and $purls = $this->controller->get_gp('purls')){
            $pdesc = $this->controller->get_gp('pdesc');
            $status = $this->_getService()->group_share($gid,$uid,$pdesc,$purls);
            if ($status == 300){
                $this->return_json("",300,"The uid is not a member of the group!");
            }
            $this->return_json("Successful!",200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //删除群空间里的资源
    public function del_group_share(){
        if($pid = $this->controller->get_gp('pid') and $gid = $this->controller->get_gp('gid')){
            $status = $this->_getService()->del_group_share($gid,$pid);
            if ($status ==300){
                $this->return_json("",300,"The resource is not exist!");
            }
            $this->return_json("Successful!",200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //查看群空间里的所有资源
    public function query_group_share(){
        if($gid = $this->controller->get_gp('gid')){
            $res = $this->_getService()->query_group_share($gid);
            $res = eval('return '.urldecode(var_export($res,true)).';');
            $this->return_json($res, 200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
    
    //用户消息发送记录
    public function user_message(){
        if($uid = $this->controller->get_gp('uid') and $to_uid = $this->controller->get_gp('to_uid') and $urls = $this->controller->get_gp('urls') and ($type = $this->controller->get_gp('type')) != ''){
            $describe = $this->controller->get_gp('describe');
            $status = $this->_getService()->user_message($uid,$to_uid,$urls,$describe,$type);
            if ($status == 300){
                $this->return_json("",300,'The groupid is not exist,please check out the to_uid!');
            }
            $this->return_json("Successful!",200);
        }else{
            $msg = "uncorrect parameter!";
            $this->return_json($msg, 400);
        }
    }
}

?>