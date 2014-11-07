<?php
class  createmenu extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();  
        $this->load->model('createmenu_model','mmenu');
    }
    function ds(){
        $data['title'] = 'Xây dựng Main menu';
        write_log(84,271,'Xây dựng Main menu');
        $data['list'] = $this->vdb->find_by_list('shop_cat',array('parentid'=>0),array('ordering'=>'ASC'));
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
       
        $id = $this->uri->segment(3);
        $data['apply'] = true;
        $rs = $this->vdb->find_by_id('shop_cat',array('catid'=>$id));
        $data['title'] = 'Xây dụng Main menu: '.$rs->catname;
        $data['catid'] = $rs->catid;
        $data['listcat'] = $this->vdb->find_by_list('shop_cat',array('parentid'=>0),array('ordering'=>'ASC'));
        $data['list'] = $this->vdb->find_by_list('shop_cat',array('parentid'=>$id));
        $this->form_validation->set_rules('catid','','');
        if($this->form_validation->run()){
            $catid = $this->input->post('catid'); 
            $name = $this->vdb->find_by_id('shop_cat',array('catid'=>$catid))->catname;
            write_log(82,265,'Cập nhật menu: '.$name); 
            //create menu
            $this->build_menu();
            $this->vdb->delete('built_menu',array('maincat'=>$catid));
           
            for($i = 1; $i <= 8; $i++){
                $ar_id = $this->input->post('ar_id_'.$i);
                for($j = 0; $j < sizeof($ar_id); $j++){
                   if($ar_id[$j]){
                       $vdata['maincat'] 	= $catid;
                       $vdata['col'] 		= $i;
                       $vdata['catid'] 		= $ar_id[$j];
                      
                       //$vdata['ordercat'] = $this->vdb->find_by_id('shop_cat',array('catid'=>$catid))->ordering;
                       $this->vdb->update('built_menu',$vdata);
                   }
                }
            }
            $this->session->set_flashdata('message','Lưu dữ liệu thành công');
            redirect('createmenu/edit/'.$catid);
        }
        $this->_templates['page'] = 'edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function build_menu(){
        $this->load->helper('file');
        $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* Cache file for config_mainmenu fyi.vn.\n* Date: ".date('d/m/y H:i:s').".\n**/";
        $str .= "\n";
        $listmaincat = $this->mmenu->get_all_maincat();
     	
        $total_maincat = count($listmaincat);
        $str .= "\n\$config['total_maincat'] = $total_maincat;\n\n"; 
        $i = 1;
       
        foreach($listmaincat as $main):
       		
            $listsub2_col1 = $this->mmenu->get_sub2($main->maincat,1);
            $listsub2_col2 = $this->mmenu->get_sub2($main->maincat,2);
            $listsub2_col3 = $this->mmenu->get_sub2($main->maincat,3);
            $listsub2_col4 = $this->mmenu->get_sub2($main->maincat,4);
            $listsub2_col5 = $this->mmenu->get_sub2($main->maincat,5);
            $listsub2_col6 = $this->mmenu->get_sub2($main->maincat,6);
            
            $idmaincat = $main->maincat;
           
            $rs = $this->vdb->find_by_id('shop_cat',array('catid'=>$idmaincat,'parentid'=>0));
            
            $str .= "\n\$config['m_id_".$i."'] = $idmaincat;";
            $str .= "\n\$config['m_name_".$i."'] = '$rs->catname';";
            $str .= "\n\$config['m_slug_".$i."'] = '$rs->caturl';";
            $totalcol_fyi = $this->mmenu->get_total_col($idmaincat);
            $str .= "\n\n\$config['m_totalcol_".$i."'] = $totalcol_fyi;"; 
            // Submenu2
            $total_sub2_col1 = count($listsub2_col1);
            $total_sub2_col2 = count($listsub2_col2);
            $total_sub2_col3 = count($listsub2_col3);
            $total_sub2_col4 = count($listsub2_col4);
            $total_sub2_col5 = count($listsub2_col5);
            $total_sub2_col6 = count($listsub2_col6);
 
            //Col1 
            $str .= "\n\n/****Col1****/;"; 
            $str .= "\n\$config['m_totalcol_".$i."_1'] = $total_sub2_col1;";  
            $j = 1;
            foreach($listsub2_col1 as $val1):
                
                $str .= "\n\$config['m_name_".$i."_1_$j'] = '$val1->catname';"; 
                $str .= "\n\$config['m_id_".$i."_1_$j'] = '$val1->catid';"; 
                $str .= "\n\$config['m_slug_".$i."_1_$j'] = '$val1->caturl';"; 
                $listsub3 = $this->mmenu->get_sub3($val1->catid);
                $t = count($listsub3);
                $str .= "\n\$config['m_total_".$i."_1_$j'] = $t;";
                $k = 1;
                foreach($listsub3 as $val2):
                    $str .= "\n\$config['m_name_".$i."_1_".$j."_".$k."'] = '$val2->catname';"; 
                    $str .= "\n\$config['m_id_".$i."_1_".$j."_".$k."'] = '$val2->catid';"; 
                    $str .= "\n\$config['m_slug_".$i."_1_".$j."_".$k."'] = '$val2->caturl';"; 
                $k++;
                endforeach; 
            $j++;
            endforeach;
            //Col2 
            $str .= "\n\n/****Col2****/;";
            $str .= "\n\$config['m_totalcol_".$i."_2'] = $total_sub2_col2;"; 
            
            $j = 1;
            foreach($listsub2_col2 as $val1):
                $str .= "\n\$config['m_name_".$i."_2_$j'] = '$val1->catname';"; 
                $str .= "\n\$config['m_id_".$i."_2_$j'] = '$val1->catid';"; 
                $str .= "\n\$config['m_slug_".$i."_2_$j'] = '$val1->caturl';"; 
                $listsub3 = $this->mmenu->get_sub3($val1->catid);
                $t = count($listsub3);
                $str .= "\n\$config['m_total_".$i."_2_$j'] = $t;";
                $k = 1;
                foreach($listsub3 as $val2):
                    $str .= "\n\$config['m_name_".$i."_2_".$j."_".$k."'] = '$val2->catname';"; 
                    $str .= "\n\$config['m_id_".$i."_2_".$j."_".$k."'] = '$val2->catid';"; 
                    $str .= "\n\$config['m_slug_".$i."_2_".$j."_".$k."'] = '$val2->caturl';"; 
                $k++;
                endforeach; 
            $j++;
            endforeach;
            
            //Col3 
            $str .= "\n\n/****Col3****/;";
            $str .= "\n\$config['m_totalcol_".$i."_3'] = $total_sub2_col3;";
            $j = 1;
            foreach($listsub2_col3 as $val1):
                $str .= "\n\$config['m_name_".$i."_3_$j'] = '$val1->catname';"; 
                $str .= "\n\$config['m_id_".$i."_3_$j'] = '$val1->catid';"; 
                $str .= "\n\$config['m_slug_".$i."_3_$j'] = '$val1->caturl';"; 
                $listsub3 = $this->mmenu->get_sub3($val1->catid);
                $t = count($listsub3);
                $str .= "\n\$config['m_total_".$i."_3_$j'] = $t;";
                $k = 1;
                foreach($listsub3 as $val2):
                    $str .= "\n\$config['m_name_".$i."_3_".$j."_".$k."'] = '$val2->catname';"; 
                    $str .= "\n\$config['m_id_".$i."_3_".$j."_".$k."'] = '$val2->catid';"; 
                    $str .= "\n\$config['m_slug_".$i."_3_".$j."_".$k."'] = '$val2->caturl';"; 
                $k++;
                endforeach; 
            $j++;
            endforeach;
            
            //Col4 
            $str .= "\n\n/****Col4****/;";
            $str .= "\n\$config['m_totalcol_".$i."_4'] = $total_sub2_col4;";
            $j = 1;
            foreach($listsub2_col4 as $val1):
                $str .= "\n\$config['m_name_".$i."_4_$j'] = '$val1->catname';"; 
                $str .= "\n\$config['m_id_".$i."_4_$j'] = '$val1->catid';"; 
                $str .= "\n\$config['m_slug_".$i."_4_$j'] = '$val1->caturl';"; 
                $listsub3 = $this->mmenu->get_sub3($val1->catid);
                $t = count($listsub3);
                $str .= "\n\$config['m_total_".$i."_4_$j'] = $t;";
                $k = 1;
                foreach($listsub3 as $val2):
                    $str .= "\n\$config['m_name_".$i."_4_".$j."_".$k."'] = '$val2->catname';"; 
                    $str .= "\n\$config['m_id_".$i."_4_".$j."_".$k."'] = '$val2->catid';"; 
                    $str .= "\n\$config['m_slug_".$i."_4_".$j."_".$k."'] = '$val2->caturl';"; 
                $k++;
                endforeach; 
            $j++;
            endforeach;
            
            
            //Col5
            $str .= "\n\n/****Col5****/;";
            $str .= "\n\$config['m_totalcol_".$i."_5'] = $total_sub2_col5;"; 
            $j = 1;
            foreach($listsub2_col5 as $val1):
                $str .= "\n\$config['m_name_".$i."_5_$j'] = '$val1->catname';"; 
                $str .= "\n\$config['m_id_".$i."_5_$j'] = '$val1->catid';"; 
                $str .= "\n\$config['m_slug_".$i."_5_$j'] = '$val1->caturl';";
                $listsub3 = $this->mmenu->get_sub3($val1->catid);
                $t = count($listsub3);
                $str .= "\n\$config['m_total_".$i."_5_$j'] = $t;";
                $k = 1;
                foreach($listsub3 as $val2):
                    $str .= "\n\$config['m_name_".$i."_5_".$j."_".$k."'] = '$val2->catname';"; 
                    $str .= "\n\$config['m_id_".$i."_5_".$j."_".$k."'] = '$val2->catid';"; 
                    $str .= "\n\$config['m_slug_".$i."_5_".$j."_".$k."'] = '$val2->caturl';"; 
                $k++;
                endforeach; 
            $j++;
            endforeach;
            
            //Col6 
            $str .= "\n\n/****Col6****/;";
            $str .= "\n\$config['m_totalcol_".$i."_6'] = $total_sub2_col6;"; 
            
            $j = 1;
            foreach($listsub2_col6 as $val1):
                $str .= "\n\$config['m_name_".$i."_6_$j'] = '$val1->catname';"; 
                $str .= "\n\$config['m_id_".$i."_6_$j'] = '$val1->catid';"; 
                $str .= "\n\$config['m_slug_".$i."_6_$j'] = '$val1->caturl';"; 
                $listsub3 = $this->mmenu->get_sub3($val1->catid);
                $t = count($listsub3);
                $str .= "\n\$config['m_total_".$i."_6_$j'] = $t;";
                $k = 1;
                foreach($listsub3 as $val2):
                    $str .= "\n\$config['m_name_".$i."_6_".$j."_".$k."'] = '$val2->catname';"; 
                    $str .= "\n\$config['m_id_".$i."_6_".$j."_".$k."'] = '$val2->catid';"; 
                    $str .= "\n\$config['m_slug_".$i."_6_".$j."_".$k."'] = '$val2->caturl';"; 
                $k++;
                endforeach; 
            $j++;
            endforeach;
            
        $i++;
        endforeach;
        
        $str .= "\n";
        $str .= "\n\n/* End of file config_mainmenu fyi.vn*/\n/* Location: .site/config/config_mainmenu.php */";        
        write_file(ROOT.'technogory/config/config_mainmenu.php', $str);
    }
}
