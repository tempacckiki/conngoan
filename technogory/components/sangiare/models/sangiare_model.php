<?php
class sangiare_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    /*--------------------------------+
     *@getAllListDeal
     +---------------------------------*/
    public function getAllListDeal(){
    	$this->db->where("published",1);
    	$this->db->order_by("ordering","ASC");
    	$query = $this->db->get("sangiare");
    	if(($query->num_rows)>0){
    		return $query->result();
    	}else{
    		return array();
    	}
    	
    }
    
	/*--------------------------------+
     *@get num sum catid
     +---------------------------------*/
    public function getNumDealCatID($catID){
    	//get all catid
    	$ar_cat = $this->get_ar_cat($catID);  	
    	$this->db->where_in("catid",$ar_cat);
    	$this->db->where("published",1);
    	$this->db->order_by("ordering","ASC");
    	$query = $this->db->get("sangiare");
    	if(($query->num_rows)>0){
    		return $query->num_rows();
    	}else{
    		return 0;
    	}
    	
    }
    
    
 	/*--------------------------------+
     *@getAllListDeal
     +---------------------------------*/
    public function getAllListDealCatID($catID, $limit = null){
    	//get all catid
    	$ar_cat = $this->get_ar_cat($catID);  	
    	$this->db->where_in("catid",$ar_cat);
    	$this->db->where("published",1);
    	$this->db->order_by("ordering","ASC");
    	if($limit != null){
    		$this->db->limit($limit);
    	}
    	$query = $this->db->get("sangiare");
    	if(($query->num_rows)>0){
    		return $query->result();
    	}else{
    		return array();
    	}
    	
    }
    
    /*--------------------------------+
     * 
     +-----------------------------------*/
	function get_ar_cat($catid){
        $ar_id = array($catid);
        $list = $this->vdb->find_by_list('shop_cat',array('parentid'=>$catid,'published'=>1));
       
        foreach($list as $rs):
            $list1 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs->catid,'published'=>1));
            array_push($ar_id,$rs->catid);
            foreach($list1 as $rs1):
                $list2 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs1->catid,'published'=>1)); 
                 array_push($ar_id,$rs1->catid);
                 foreach($list2 as $rs2): 
                      array_push($ar_id,$rs2->catid);
                 endforeach; 
            endforeach;
            
        endforeach;
        return $ar_id;
    }
    
}
