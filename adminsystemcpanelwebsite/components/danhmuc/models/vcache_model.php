<?php
 class vcache_model extends CI_Model{
     
    function __construct(){
        parent::__construct();
    }      
    
    function tab(){
        
        $list = $this->vdb->find_by_list('shop_cat',array('parentid'=>0),array('ordering'=>'asc'));
        foreach($list as $rs):
        $list_tab = $this->get_istab_by_cat($rs->catid);
            $str ='<div class="tab-items-i">
                <ul id="menutab">';
                    
                    $i = 0;
                    foreach($list_tab as $val):
                    $subcat = $this->get_subcat($val->catid);
                    $link1 = base_url_site().'chuyen-muc/'.$val->caturl.'-'.$val->catid.'.html';
                    $str .='<li>
                        <a href="'.$link1.'"><span class="ih">'.$val->catname;
                        if(count($subcat) > 0){
                        $str .='<span class="arrow"></span>';
                        }
                        $str .='</span>';
                        if($i != count($list_tab) - 1){$str .='|';}
                        $str .='</a>
                        <ul>';
                            
                            $j = 0;
                            foreach($subcat as $val1):
                            $border = ($j==0)?'style="border-top:0px"':'';
                            $link2 =  base_url_site().'chuyen-muc/'.$val1->caturl.'-'.$val1->catid.'.html';
                            $str .='<li '.$border.'><a href="'.$link2.'">'.$val1->catname.'</a></li>';
                            
                            $j++;
                            endforeach;
                        $str .='</ul>
                    </li>';
                    
                    $i++;
                    endforeach;                  
                $str .='</ul>
            </div>';
            write_file(ROOT.'technogory/config/tabhome/tab_'.$rs->catid.'.db', $str);
        endforeach;

    }
    
    function cat(){
        $list = $this->vdb->find_by_list('shop_cat',0,array('ordering'=>'asc'));
        foreach($list as $rs):
            $this->get_ar_cat($rs->catid);
        endforeach;
    }
    
    function get_ar_cat($catid){
        $str  = $catid.',';
        $list = $this->vdb->find_by_list('shop_cat',array('parentid'=>$catid));
        foreach($list as $rs):
            $list1 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs->catid));
            $str .=$rs->catid.',';
            foreach($list1 as $rs1):
                $list2 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs1->catid)); 
                 $str .=$rs1->catid.',';
                 foreach($list2 as $rs2): 
                      $str .=$rs2->catid.',';
                 endforeach; 
            endforeach;
            
        endforeach;
        $ar_id = trim($str,',');
        if($this->check_cat($catid)){
            $vdata['ar_cat'] = $ar_id;
            $this->vdb->update('cachecat',$vdata,array('catid'=>$catid));
        }else{
            $vdata['catid'] = $catid;
            $vdata['ar_cat'] = $ar_id;
            $this->vdb->update('cachecat',$vdata); 
        }
    }  
    
    
    function get_istab_by_cat($catid){
        $this->db->select('catid, catname,caturl');
        $this->db->where('published',1);
        $this->db->where('parentid',$catid);
        $this->db->where('istab',1);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result();
    }
    
    function get_subcat($catid){
        $this->db->select('catid, catname,caturl');
        $this->db->where('published',1);
        $this->db->where('parentid',$catid);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result();  
    }
    
    function check_cat($catid){
        $this->db->where('catid',$catid);
        return $this->db->get('cachecat')->row();
    }
 }
