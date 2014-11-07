<?php
class vcache extends CI_Controller{
    protected $_templates;    
    function __construct(){
        parent::__construct();
        $this->load->helper('file');
        $this->load->model('vcache_model','vcache');
        $this->load->model('fcache_model');
    }
    
    function index(){
        $data['title'] = 'Ghi file';
		//xoa cache
       	$this->vdb->delcache(ROOT."technogory/cache/category/");
		//xoa cache
       	$this->vdb->delcache(ROOT."technogory/cache/features/");
		//xoa cache
       	$this->vdb->delcache(ROOT."technogory/cache/manufacture/");
		//xoa cache
       	$this->vdb->delcache(ROOT."technogory/cache/products/");
		
        $this->fcache_model->write_file_cat(); 
        
        //load template *************************
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function tab(){
        $list = $this->vdb->find_by_list('shop_cat',array('parentid'=>0),array('ordering'=>'asc'));
        foreach($list as $rs):
        $list_tab = $this->vcache->get_istab_by_cat($rs->catid);
            $str ='<div class="tab-items-i">
                <ul id="menutab">';
                    
                    $i = 0;
                    foreach($list_tab as $val):
                    $subcat = $this->vcache->get_subcat($val->catid);
                    $link1 = base_url_site().'category/'.$val->caturl.'-'.$val->catid.'.html';
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
                            $link2 =  base_url_site().'category/'.$val1->caturl.'-'.$val1->catid.'.html';
                            $str .='<li '.$border.'><a href="'.$link2.'">'.$val1->catname.'</a></li>';
                            
                            $j++;
                            endforeach;
                        $str .='</ul>
                    </li>';
                    
                    $i++;
                    endforeach;                  
                $str .='</ul>
            </div>';
            write_file(ROOT.'site/config/tabhome/tab_'.$rs->catid.'.db', $str);
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
        if($this->vcache->check_cat($catid)){
            $vdata['ar_cat'] = $ar_id;
            $this->vdb->update('cachecat',$vdata,array('catid'=>$catid));
        }else{
            $vdata['catid'] = $catid;
            $vdata['ar_cat'] = $ar_id;
            $this->vdb->update('cachecat',$vdata); 
        }
    }  
}
