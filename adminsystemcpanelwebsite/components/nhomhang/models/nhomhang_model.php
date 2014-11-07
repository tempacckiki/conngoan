<?php
class nhomhang_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function get_all_nhomhang($num,$offset,$field, $order){
        $this->db->where('parentid',0);
        if($field != '' && $order != ''){
            $this->db->order_by($field,$order);
        }else{
            $this->db->order_by('ordering','asc');
        }
        return $this->db->get('shop_cat',$num,$offset)->result();
    }
    
    function get_num_nhomhang(){
        $this->db->where('parentid',0);
        return $this->db->get('shop_cat')->num_rows();
    }
    
    function create_menu(){
        $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* Cache file for config_menu fyi.vn.\n* Date: ".date('d/m/y H:i:s').".\n**/";
        
        $listcat_cap1 = $this->vdb->find_by_list('shop_cat',array('parentid'=>0,'published'=>1),array('ordering'=>'asc'));
        $c1=1;
        $total_menu =count($listcat_cap1);
        $str .= "\n";
        $str .= "\n\$config['total_menu'] = $total_menu;"; ;
        $str .= "\n";            
        $order = 1;
        foreach($listcat_cap1 as $cap1):
            
            $str .="/*********Cấp 1_".$c1."**************/";
            $cap1_id = $cap1->catid;
            $cap1_name = $cap1->catname;
            $cap1_alias = $cap1->caturl;
            $cap1_nolink = $cap1->nolink;
            $cap1_ismenuleft = $cap1->ismenuleft;
            $str .= "\n\$config['menu_id_leve_1_$c1'] = $cap1_id;";   
            $str .= "\n\$config['menu_name_leve_1_$c1'] = '$cap1_name';";   
            $str .= "\n\$config['menu_alias_leve_1_$c1'] = '$cap1_alias';";   
            $str .= "\n\$config['menu_nolink_leve_1_$c1'] = $cap1_nolink;";   
            $str .= "\n\$config['menu_ismenuleft_leve_1_$c1'] = $cap1_ismenuleft;";   
            $str .= "\n\$config['menu_img_leve_1_$c1'] = '$cap1->img_main';";   
            
            $listcat_cap2 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$cap1->catid,'published'=>1),array('ordering'=>'asc'));
            $total_cap2 = count($listcat_cap2);
            $str .= "\n\$config['menu_total_leve_1_$c1'] = $total_cap2;";
            if($total_cap2 > 0){
                $c2 = 1;
                foreach($listcat_cap2 as $cap2):
                    $str .= "\n";
                    $str .="\n/*********Cấp 2_".$c1."_".$c2."**************/";
                    $cap2_id = $cap2->catid;
                    $cap2_name = $cap2->catname;
                    $cap2_alias = $cap2->caturl;
                    $cap2_nolink = $cap2->nolink;
                    $cap2_ismenuleft = $cap2->ismenuleft;
                    $str .= "\n\$config['menu_id_leve_2_".$c1."_".$c2."'] = $cap2_id;";   
                    $str .= "\n\$config['menu_name_leve_2_".$c1."_".$c2."'] = '$cap2_name';"; 
                    $str .= "\n\$config['menu_alias_leve_2_".$c1."_".$c2."'] = '$cap2_alias';"; 
                    $str .= "\n\$config['menu_nolink_leve_2_".$c1."_".$c2."'] = $cap2_nolink;"; 
                    $str .= "\n\$config['menu_ismenuleft_leve_2_".$c1."_".$c2."'] = $cap2_ismenuleft;"; 
                       
                    $listcat_cap3 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$cap2->catid,'published'=>1),array('ordering'=>'asc'));
                    $total_cap3 = count($listcat_cap3);
                    $str .= "\n\$config['menu_total_leve_2_".$c1."_".$c2."'] = $total_cap3;";
                    if($total_cap3 > 0){
                        $c3 = 1;
                        foreach($listcat_cap3 as $cap3):
                            $str .= "\n";
                            $str .="\n/*********Cấp 3_".$c1."_".$c2."_".$c3."**************/";                            
                            $cap3_id = $cap3->catid;
                            $cap3_name = $cap3->catname;
                            $cap3_alias = $cap3->caturl;
                            $cap3_nolink = $cap3->nolink;
                            $cap3_ismenuleft = $cap3->ismenuleft;
                            $str .= "\n\$config['menu_id_leve_3_".$c1."_".$c2."_".$c3."'] = $cap3_id;";   
                            $str .= "\n\$config['menu_name_leve_3_".$c1."_".$c2."_".$c3."'] = '$cap3_name';";    
                            $str .= "\n\$config['menu_alias_leve_3_".$c1."_".$c2."_".$c3."'] = '$cap3_alias';";    
                            $str .= "\n\$config['menu_nolink_leve_3_".$c1."_".$c2."_".$c3."'] = $cap3_nolink;";    
                            $str .= "\n\$config['menu_ismenuleft_leve_3_".$c1."_".$c2."_".$c3."'] = $cap3_ismenuleft;";    
                            
                        $c3++;                   
                        endforeach;  
                    }   
                    $str .= "\n";                     
                $c2++;                   
                endforeach;  
            }
            $str .= "\n";
            $str .= "\n";
        $c1++;
        $order ++;
        endforeach;
        $str .= "\n";
        $str .= "\n";
        $str .= "\n\n/* End of file config_menu fyi.vn*/\n/* Location: .site/config/config_menu.php */";        
        write_file(ROOT.'technogory/config/config_menu.php', $str);
    }
      
      function create_ismainmenu(){
          
            $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* Cache file for config_ismainmenu Chonmua24h.vn.\n* Date: ".date('d/m/y H:i:s').".\n**/";
            
            $listcat_cap1 = $this->product->get_all_is_mainmenu();
            $list_ads_daugia = $this->product->get_ads_by_cat(9999);
            $c1=1;
            $total_menu =count($listcat_cap1);
            $str .= "\n";
            $str .= "\n\$config['total_main'] = $total_menu;"; ;
            $str .= "\n";     
            $i=1;
            foreach($list_ads_daugia as $rs):
                $ads_name = $rs->AdsName;
                $ads_link = $rs->AdsLink;
                $ads_img = $rs->AdsImg;
                $str .= "\n\$config['ads_daugia_name_".$i."'] = '$ads_name';"; 
                $str .= "\n\$config['ads_daugia_link_".$i."'] = '$ads_link';"; 
                $str .= "\n\$config['ads_daugia_img".$i."'] = '$ads_img';"; 
                $i++;             
            endforeach;
            
            $str .="/*********Quảng cáo - Khuyen mai**************/\n";  
            $listadskm = $this->product->get_ads_by_cat(0); 
            $i=1;
            foreach($listadskm as $ads):
                $ads_name = $ads->AdsName;
                $ads_link = $ads->AdsLink;
                $ads_img = $ads->AdsImg;
                $str .= "\n\$config['ads_km_name_".$i."'] = '$ads_name';"; 
                $str .= "\n\$config['ads_km_link_".$i."'] = '$ads_link';"; 
                $str .= "\n\$config['ads_km_img_".$i."'] = '$ads_img';"; 
                $i++; 
            endforeach;
                            
            foreach($listcat_cap1 as $cap1):
            $listads = $this->product->get_ads_by_cat($cap1->CategoryID);
            $str .="\n/*********Quảng cáo**************/\n";
            $i=1;
            foreach($listads as $ads):
                $ads_name = $ads->AdsName;
                $ads_link = $ads->AdsLink;
                $ads_img = $ads->AdsImg;
                $str .= "\n\$config['ads_name_".$i."_".$cap1->CategoryID."'] = '$ads_name';"; 
                $str .= "\n\$config['ads_link_".$i."_".$cap1->CategoryID."'] = '$ads_link';"; 
                $str .= "\n\$config['ads_img_".$i."_".$cap1->CategoryID."'] = '$ads_img';"; 
                $i++; 
            endforeach;            
                $str .="/*********Cấp 1_".$c1."**************/";
                $cap1_id = $cap1->CategoryID;
                $cap1_name = $cap1->CategoryName;
                $cap1_alias = $cap1->CategoryAlias;
                $str .= "\n\$config['main_id_leve_1_$c1'] = $cap1_id;";   
                $str .= "\n\$config['main_name_leve_1_$c1'] = '$cap1_name';";   
                $str .= "\n\$config['main_alias_leve_1_$c1'] = '$cap1_alias';";   
                
                $listcat_cap2 = $this->product->check_parentid($cap1->CategoryID);
                $total_cap2 = count($listcat_cap2);
                $str .= "\n\$config['main_total_leve_1_$c1'] = $total_cap2;";
                if($total_cap2 > 0){
                    $c2 = 1;
                    foreach($listcat_cap2 as $cap2):
                        $str .= "\n";
                        $str .="\n/*********Cấp 2_".$c1."_".$c2."**************/";
                        $cap2_id = $cap2->CategoryID;
                        $cap2_name = $cap2->CategoryName;
                        $cap2_alias = $cap2->CategoryAlias;
                        $str .= "\n\$config['main_id_leve_2_".$c1."_".$c2."'] = $cap2_id;";   
                        $str .= "\n\$config['main_name_leve_2_".$c1."_".$c2."'] = '$cap2_name';"; 
                        $str .= "\n\$config['main_alias_leve_2_".$c1."_".$c2."'] = '$cap2_alias';"; 
                           
                        $listcat_cap3 = $this->product->check_parentid($cap2->CategoryID);
                        $total_cap3 = count($listcat_cap3);
                        $str .= "\n\$config['main_total_leve_2_".$c1."_".$c2."'] = $total_cap3;";
                        if($total_cap3 > 0){
                            $c3 = 1;
                            foreach($listcat_cap3 as $cap3):
                                $str .= "\n";
                                $str .="\n/*********Cấp 3_".$c1."_".$c2."_".$c3."**************/";                            
                                $cap3_id = $cap3->CategoryID;
                                $cap3_name = $cap3->CategoryName;
                                $cap3_alias = $cap3->CategoryAlias;
                                $str .= "\n\$config['main_id_leve_3_".$c1."_".$c2."_".$c3."'] = $cap3_id;";   
                                $str .= "\n\$config['main_name_leve_3_".$c1."_".$c2."_".$c3."'] = '$cap3_name';";    
                                $str .= "\n\$config['main_alias_leve_3_".$c1."_".$c2."_".$c3."'] = '$cap3_alias';";    
                                
                            $c3++;                   
                            endforeach;  
                        }   
                        $str .= "\n";                     
                    $c2++;                   
                    endforeach;  
                }
                $str .= "\n";
                $str .= "\n";
            $c1++;
            endforeach;
            
            $str .= "\n\n/* End of file config_ismainmenu chonmua24h.vn*/\n/* Location: ./cf/config_ismainmenu.php */";        
            write_file('../cf/config_ismainmenu.php', $str);          
      }
}
