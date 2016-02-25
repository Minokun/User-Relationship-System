<?php
class optService extends Service{
    
    private function _getDao() {
    
        return InitPHP::getDao ("frd","add_frds");
    
    }
    
    public function add(){
        //return $this->_getDao()->add_frds($uid,$add_uid);
        return "asdf";
    }
}
?>