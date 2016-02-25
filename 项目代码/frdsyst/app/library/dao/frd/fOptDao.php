<?php
class fOptDao extends Dao{
    
    private $tablename1 = "user_friends";   //好友表
    private $tablename2 = "user_group";     //用户群表
    private $tablename3 = "group_members";  //群成员表
    private $tablename4 = "user_resource";  //用户资源表
    private $tablename5 = "user_control";   //角色控制表
    private $tablename6 = "group_resource"; //群资源表
    private $tablename7 = "user_message";   //用户消息表
    
    private $db_conf = "default";           //默认数据库连接
    
    //查询数据库中是否有该用户数据
    public function checkoutone($uid){
        $sql = "select * from ".$this->tablename1." where uid = '".$uid."'";
        return $this->init_db($this->db_conf)->get_one_sql($sql);
    }
    
    //在数据库中添加一条
    public function add_frds($uid,$add_uid,$rid,$remark){
        //第一次将数组变成json格式
		$fids = json_encode(array($add_uid=>$rid));
		$remark = json_encode(array($add_uid=>$remark),JSON_UNESCAPED_UNICODE);
        $result = $this->init_db($this->db_conf)->insert(array("uid"=>$uid,"fids"=>$fids,"remark"=>$remark),$this->tablename1);
		return $result;
    }
    
    //更新好友昵称
    public function remark_change($uid,$remark){
        $this->init_db($this->db_conf)->update_by_field(array('remark'=>$remark), array('uid' => $uid), $this->tablename1);
    }
    
    //取出指定用户的好友列表
    public function checkoutall($uid){
        $sql = "select fids from ".$this->tablename1." where uid = '".$uid."'";
        return $this->init_db($this->db_conf)->get_one_sql($sql);
    }
    
    //根据用户备注名查看好友id
    public function uid_by_remark($uid,$remark){
        $sql = "select * from ".$this->tablename1." where uid = '".$uid."' and remark like '%".$remark."%'";
        return $this->init_db($this->db_conf)->get_one_sql($sql);
    }
    
    //取出指定用户的好友备注名列表
    public function checkout_remark($uid){
        $sql = "select remark from ".$this->tablename1." where uid = '".$uid."'";
        return $this->init_db($this->db_conf)->get_one_sql($sql);
    }
    
    //取出指定用户的群列表
    public function checkout_group($uid){
        $sql = "select gids from ".$this->tablename1." where uid = '".$uid."'";
        return $this->init_db($this->db_conf)->get_one_sql($sql);
    }
    
    //取出创建的用户群ID
    public function query_id($uid,$gname){
        $sql = 'select gid from '.$this->tablename2.' where uid = "'.$uid.'" and gname = "'.$gname.'"';
        return $this->init_db($this->db_conf)->get_one_sql($sql);
    }
    
    //根据群id查群的信息
    public function query_group_by_gid($gid){
        $sql = sprintf('select * from %s where gid = %d',$this->tablename2,$gid);
        return $this->init_db($this->db_conf)->get_one_sql($sql);
    }
    
    //根据群名称查所有群的信息
    public function query_group_by_gname($gname){
        $sql = sprintf('select * from %s where gname = "%s"',$this->tablename2,$gname);
        return $this->init_db($this->db_conf)->get_all_sql($sql);
    }
    //更新好友列表
    public function updatefrds($uid,$frds_new,$remark){
        $this->init_db($this->db_conf)->update_by_field(array('remark'=>$remark), array('uid' => $uid), $this->tablename1);
        return $this->init_db($this->db_conf)->update_by_field(array('fids'=>$frds_new), array('uid' => $uid), $this->tablename1);
    }
    
    //更新用户的群列表
    public function updategids($uid,$gids_new){
        return $this->init_db($this->db_conf)->update_by_field(array('gids'=>$gids_new), array('uid' => $uid), $this->tablename1);
    }
    
    //创建用户群
    public function create_group($uid,$gname,$gdesc,$create_time,$level){
        $this->init_db($this->db_conf)->insert(array("uid"=>$uid,"gname"=>$gname,"gdesc"=>$gdesc,"create_time"=>$create_time,"level"=>$level),$this->tablename2);
    }
    
    //在群成员表里添加一个成员
    public function add_members($gid,$uid,$rid,$jointime,$group_name){
        $this->init_db($this->db_conf)->insert(array("uid"=>$uid,"gid"=>$gid,"rid"=>$rid,"jointime"=>$jointime,"group_name"=>$group_name),$this->tablename3);
    }
    
    //查询成员表里是否有该成员
    public function query_member($gid,$uid){
        $sql = 'select * from '.$this->tablename3.' where uid = "'.$uid.'" and gid = '.$gid;
        return $this->init_db($this->db_conf)->get_one_sql($sql);
    }
    
    //根据群id查询所有群成员
    public function query_members_by_gid($gid){
        $sql = 'select * from '.$this->tablename3.' where gid = '.$gid;
        return $this->init_db($this->db_conf)->get_all_sql($sql);
    }
    
    //删除成员表里的一条
    public function del_member($gid,$uid){
        $this->init_db($this->db_conf)->delete_by_field(array('gid'=>$gid,'uid'=>$uid), $this->tablename3);
    }
    
    //在用户的资源表里插一条信息
    public function share($uid,$urls,$cid,$fids,$createtime,$desc){
        $this->init_db($this->db_conf)->insert(array("uid"=>$uid,"urls"=>$urls,"cid"=>$cid,"fids"=>$fids,"createtime"=>$createtime,"descr"=>$desc),$this->tablename4);
    }
    
    //删除用户分享的信息
    public function del_share($uid,$pid) {
        $this->init_db($this->db_conf)->delete_by_field(array("uid"=>$uid,"pid"=>$pid), $this->tablename4);
    }
    
   //更新用户上传的资源状态
   public function update_share($uid,$pid,$cid,$fids,$desc){
       $this->init_db($this->db_conf)->update_by_field(array('cid'=>$cid,'fids'=>$fids,'descr'=>$desc), array('uid' => $uid,'pid'=>$pid), $this->tablename4);
   }
   
   //查询用户分享的所有图片
   public function query_share($uid){
       $sql = "select * from ".$this->tablename4." where uid = '".$uid."' order by createtime desc";
       return $this->init_db($this->db_conf)->get_all_sql($sql);
   }
   
   //取出某角色的权限
   public function query_access($role){
       $sql = sprintf("select cids from %s where rid = %s",$this->tablename5,$role);
       return $this->init_db($this->db_conf)->get_all_sql($sql);
   }
   
   //根据权限和uid查出所有图片资源的信息
   public function query_share_by_uc($uid,$cid){
       $sql = "select * from ".$this->tablename4." where uid ='".$uid."' and cid = ".$cid;
       return $this->init_db($this->db_conf)->get_all_sql($sql);
   }
   
   //在群的资源表里插一条信息
   public function insert_group_resource($gid,$uid,$createtime,$pdesc,$purls,$pstatus){
       $this->init_db($this->db_conf)->insert(array("gid"=>$gid,"uid"=>$uid,"createtime"=>$createtime,"pdesc"=>$pdesc,"purls"=>$purls,"pstatus"=>$pstatus),$this->tablename6);
   }
   
   //在群的资源表里删除一条信息 
   public function del_group_resource($gid,$pid) {
       $this->init_db($this->db_conf)->delete_by_field(array('gid'=>$gid,'pid'=>$pid), $this->tablename6);
   }
   
   //查询群资源表里某个群的全部资源
   public function query_group_share($gid){
       $sql = sprintf("select * from %s where gid = %s",$this->tablename6,$gid);
       return $this->init_db($this->db_conf)->get_all_sql($sql);
   }
   
   //根据pid和gid查询资源信息
   public function query_gshare_by_gp($gid,$pid){
       $sql = sprintf("select * from %s where gid = %s and pid = %s",$this->tablename6,$gid,$pid);
       return $this->init_db($this->db_conf)->get_all_sql($sql);
   }
   
   //在用户消息表里插入一条信息
   public function insert_user_message($uid,$to_uid,$urls,$describe,$create_time,$type,$status){
       $this->init_db($this->db_conf)->insert(array('uid'=>$uid,'to_uid'=>$to_uid,'urls'=>$urls,'pic_describe'=>$describe,'create_time'=>$create_time,'type'=>$type,'status'=>$status), $this->tablename7);
   }
   
   //在user_group表里将群删除
   public function del_group_by_id($gid) {
       $this->init_db($this->db_conf)->delete_by_field(array('gid'=>$gid), $this->tablename2);;
   }
   
   //根据群号和用户id查询群信息
   public function query_group_by_gu($gid,$uid) {
       return $this->init_db($this->db_conf)->get_one_by_field(array('gid'=>$gid,'uid'=>$uid),$this->tablename2);
   }
   
   //更新群主
    public function update_gmaster($uid,$gid){
       $this->init_db($this->db_conf)->update_by_field(array('uid'=>$uid), array('gid' => $gid), $this->tablename2);
   }
   
   //更新群成员表里的角色
   public function update_gm_role($uid,$gid){
       $this->init_db($this->db_conf)->update_by_field(array('rid'=>1), array('uid'=>$uid,'gid' => $gid), $this->tablename3);
   }
   
   //在群成员表里查询所有该用户所加的群
   public function query_gids_by_uid($uid){
       $sql = "select gid,rid from ".$this->tablename3." where uid = '".$uid."'";
       return $this->init_db($this->db_conf)->get_all_sql($sql);
   }
   
   //根据pid查询用户分享的图片
   public function query_pic_by_pid($uid,$pid){
       return $this->init_db($this->db_conf)->get_one_by_field(array('pid'=>$pid,'uid'=>$uid),$this->tablename4);
   }
   
}