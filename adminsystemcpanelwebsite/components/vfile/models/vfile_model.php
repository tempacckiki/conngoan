<?php
class vfile_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function dir_vfile(){
        $this->db->where('parentid',0);
        $list= $this->db->get('vfile')->result();
        $vf ='<ul id="browser" class="filetree">';
            foreach($list as $rs):
                $vf .='<li id="'.$rs->id.'"><span class="folder"><a href="javascript:;" onclick="get_dir(\'data/'.$rs->path.'\')">'.$rs->name.'</a></span>'.$this->get_subfile($rs->id,$rs->name).'</li>';
            endforeach;
        $vf .='</ul>';
        echo $vf;
    }
    
    function get_subfile($parentid,$name){
        $this->db->where('parentid',$parentid);
        $list = $this->db->get('vfile')->result();
        $vf = '';
        if(count($list) > 0){
            $vf .='<ul>';
            foreach($list as $rs):
                $vf .='<li id="'.$rs->id.'"><span class="folder"><a href="javascript:;" onclick="get_dir(\'data/'.$rs->path.'\')">'.$rs->name.'</a></span>'.$this->get_subfile($rs->id,$rs->name).'</li>';
            endforeach;
            $vf .='</ul>';
        }
        return $vf;
    }
    
    function get_type_file($path){
        $extension = end(explode('.',$path));
        if($extension =='jpg' || $extension =='jpeg' || $extension == 'jpg' || $extension =='png' || $extension =='gif'){
            return $path;
        }else{
            return base_url().'components/vfile/views/esset/files/big/'.$extension.'.png';
        }
    }

}
