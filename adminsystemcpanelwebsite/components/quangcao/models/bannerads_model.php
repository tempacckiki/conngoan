<?php
class bannerads_model extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function addBanner($aVals){
        $aInsert = array(
            'link' => $aVals['link'], 
            'images' => $aVals['images'], 
            'published' => $aVals['published'], 
            'position' => $aVals['position'], 
        );
        if($this->db->insert('bannerads',$aInsert)){
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function getBannerByPosition($position){
        $this->db->where('position',$position);
        return $this->db->get('bannerads')->row();
    }

    public function deleteByPosition($position){
        $this->db->where('position',$position);                   
        if($this->db->delete('bannerads')){
           return true;
        }else{
            return false;
        }
    }
}
?>