<?php
class danhmuc extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('danhmuc_model','danhmuc');
        
    }
    
    function active(){
        $list = $this->danhmuc->get_all_danhmuc();
        foreach($list as $rs):
        $this->load->database('fyi',true);
        $list1 = $this->danhmuc->get_all_danhmuc($rs->CategoryID); 
        $vdata['catid'] = $rs->CategoryID;
        $vdata['catname'] = $rs->CategoryName;
        $vdata['caturl'] = vnit_change_title($rs->CategoryName);
        $this->db = $this->load->database('default',true); 
        $this->db->insert('shop_cat',$vdata);
        $this->load->database('fyi',true);
        foreach($list1 as $val):
            $this->load->database('fyi',true);
            $list2 = $this->danhmuc->get_all_danhmuc($val->CategoryID);
        
            $vdata1['catid'] = $val->CategoryID;
            $vdata1['parentid'] = $val->ParentID;
            $vdata1['catname'] = $val->CategoryName;
            $vdata1['caturl'] = vnit_change_title($val->CategoryName);
            $this->db = $this->load->database('default',true); 
            $this->db->insert('shop_cat',$vdata1);
            
            foreach($list2 as $val2):
                $this->load->database('fyi',true);
                $list3 = $this->danhmuc->get_all_danhmuc($val2->CategoryID);
                
                $vdata2['catid'] = $val2->CategoryID;
                $vdata2['parentid'] = $val2->ParentID;
                $vdata2['catname'] = $val2->CategoryName;
                $vdata2['caturl'] = vnit_change_title($val2->CategoryName);
                $this->db = $this->load->database('default',true); 
                $this->db->insert('shop_cat',$vdata2);
                
                foreach($list3 as $val3):

                    
                    $vdata3['catid'] = $val3->CategoryID;
                    $vdata3['parentid'] = $val3->ParentID;
                    $vdata3['catname'] = $val3->CategoryName;
                    $vdata3['caturl'] = vnit_change_title($val3->CategoryName);
                    $this->db = $this->load->database('default',true); 
                    $this->db->insert('shop_cat',$vdata3);
                
                endforeach;
            
            endforeach;
        
        endforeach;
        
        endforeach;
        
    }
}
