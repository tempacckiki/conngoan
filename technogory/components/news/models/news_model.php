<?php             
class news_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_all_cat($parentid = 0){
        $this->db->where('parentid',$parentid);
        $this->db->where('published',1);
        $this->db->order_by('ordering','asc');
        return $this->db->get('news_cat')->result();
    }
    
	function getAllCatArr($parentid = 0){
        $this->db->where('parentid',$parentid);
        $this->db->where('published',1);
        $this->db->order_by('catname',"random");         
        $query = $this->db->get('news_cat',5);
       // shuffle($query);
       // $this->db->shuffle($query);
        return $query->result_array();
    }
    
    function get_lastnew_by_cat($catid){
        $ar_id = $this->get_ar_cat($catid);        
        $this->db->where_in('catid',$ar_id);
        $this->db->order_by('newsid','desc');
        $this->db->limit(6);
        return $this->db->get('news_detail')->result();
    }
    
	function getNewsThumb($catid,$limit =null){
        $ar_id = $this->get_ar_cat($catid);
        $this->db->where_in('catid',$ar_id);
        $this->db->order_by('newsid','desc');
        $this->db->limit($limit);
        return $this->db->get('news_detail')->result();
    }
    
	public function get_lastnew_by_catThumb($catid){
        $ar_id = $this->get_ar_cat($catid);
        $this->db->where_in('catid',$ar_id);
        $this->db->where_in('is_thumb',1);
        $this->db->order_by('order_thumb','ASC');
        $this->db->limit(6);
        return $this->db->get('news_detail')->result();
    }
    
    function get_ar_cat($catid){
        $ar_id = array($catid);
        $list = $this->vdb->find_by_list('news_cat',array('parentid'=>$catid));
        foreach($list as $rs):
            array_push($ar_id, $rs->catid);
        endforeach;
        return $ar_id;
    }
    
	public function getParentsIdArray($sourceArr, $id){
		$arrParents[] = $id;
		$this->findParents($sourceArr,$id, &$arrParents);
		return $arrParents;
	}
	
	public function findParents($sourceArr,$id, &$arrParents){
			foreach ($sourceArr as $key => $value){		
				if($value['catid'] == $id){
					if( $value['parentid'] >0 ){
						$arrParents[] = $value['parentid'];
						unset($sourceArr[$key]);
						$newID = $value['parentid'];
						$this->findParents($sourceArr,$newID, $arrParents);
					}
				}
			}
	}
    
	
   function getListAllCat(){       
        $this->db->where('published',1);
        $this->db->order_by('ordering','asc');
        return $this->db->get('news_cat')->result_array();
    }
    /*--- index ---*/
    function get_list_noibat(){
        $this->db->where('hot',1);
        $this->db->order_by('newsid','desc');
        $this->db->limit(8);
        return $this->db->get('news_detail')->result();
    }
    
 	function get_list_noibatNext(){
        $this->db->where('hot',1);
        $this->db->order_by('newsid','desc');
        return $this->db->get('news_detail',4,8)->result();
    }
    
    
 	function get_listNoibatCatID($catid){
        $this->db->where('catid',$catid);
       // $this->db->where('hot',1);
        $this->db->order_by('newsid','desc');
        $this->db->limit(8);
        return $this->db->get('news_detail')->result();
    }
    
 
    
    
    function get_all_news($num, $offset, $catid){
        $ar_id = $this->get_ar_cat($catid);
       
        $this->db->where_in('catid',$ar_id);
        $this->db->order_by('newsid','desc');
        return $this->db->get('news_detail',$num, $offset)->result();
    }
    
    function get_num_news($catid){
        $ar_id = $this->get_ar_cat($catid);
        $this->db->where_in('catid',$ar_id);
        return $this->db->get('news_detail')->num_rows();
    }
    
    
    
    function get_orther_news($catid, $newsid){
        $ar_id = $this->get_ar_cat($catid);
        $this->db->where_in('catid',$ar_id);
        $this->db->where('newsid !=',$newsid);
        $this->db->order_by('newsid','desc');
        $this->db->limit(10);
        return $this->db->get('news_detail')->result();
    }
    
  function get_orther_newsView($catid, $newsid){
        $ar_id = $this->get_ar_cat($catid);
        $this->db->where_in('catid',$ar_id);
        $this->db->where('newsid !=',$newsid);
        $this->db->order_by('created','desc');
        return $this->db->get('news_detail',10,11)->result();
    }
    
	public function getAlllThumbNewsRelative($ar_id){       
        $this->db->select('catid,newsid,caturl,title,title_alias,images_thumb');      
        $this->db->where_in('catid',$ar_id);      
        $this->db->order_by('created','desc');
        return $this->db->get('news_detail',4)->result();
    }
    
    function get_list_comment($newsid){
        $this->db->where('published',1);
        $this->db->where('newsid',$newsid);
        $this->db->order_by('add_date','desc');
        $this->db->limit(5);
        return $this->db->get('news_comment')->result();
    }
  
    function get_list_product($scatid){
        if($scatid != ''){
            $ar_id = $this->get_arr_product($scatid);
            $this->db->where_in('catid',$ar_id);
            $this->db->limit(8);
            return $this->db->get('shop_product')->result();
        }else{
            return false;
        }
    }

    function get_arr_product($scatid){
        $scatid = trim($scatid,',');
        $str = explode(',',$scatid);
        for($i = 0; $i < count($str); $i++){
            $ar_id = array($str[$i]);
            $this->db->where('parentid',$str[$i]);
            $this->db->where('published',1);
            $list = $this->db->get('shop_cat')->result();
            if(count($list) > 0){
              foreach($list as $rs):
                $infocat = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs->parentid,'published'=>1));
                array_push($ar_id,$rs->catid);
                if(count($infocat) > 0)
                {
                    foreach($infocat as $rs1):
                        array_push($ar_id,$rs1->catid);
                    endforeach;
                }
              endforeach;
            }
        }
        return $ar_id;
    }    
    
    /// Col Right
    function get_tindocnhieu($catid = 0 ,$newsid = 0){
      if($catid != 0){
          $ar_id = $this->get_ar_cat($catid);
          $this->db->where_in('catid',$ar_id);
      }
      if($newsid != 0){
        $this->db->where('newsid !=',$newsid);
      }
      $this->db->where('view_many',1);
      $this->db->where('published',1);
      $this->db->order_by('order_many','ASC');
      $this->db->limit(10);
      return $this->db->get('news_detail')->result();
      
    }
    
	/// Col Right
   public function get_listPhoto(){      
      $this->db->where('is_photo',1);
      $this->db->where('published',1);
      $this->db->order_by('order_photo','ASC');
      $this->db->limit(10);
      return $this->db->get('news_detail')->result();
      
    }
    
    
}
