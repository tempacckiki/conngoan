<?php
  class thanhpho extends CI_Controller{
      protected $_templates;
      function __construct(){
          parent::__construct();
      }
      function listthanhpho(){
        $this->create_config();

        $data['title'] = 'Danh sách thành phố';
        write_log(86,276,'Danh sách thành phố'); 
        $data['delete'] = icon_dels('thanhpho/dels');
        $data['add'] = 'thanhpho/add|'.icon_add('thanhpho/add');
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);   
        if($field =='' && $order == ''){
          $order = 'asc';
        }       
        $config['suffix'] = '/'.$field.'/'.$order;            
        $config['base_url'] = base_url().'thanhpho/listthanhpho/';  
        $config['total_rows']   =  $this->vdb->find_by_num('city',array('parentid'=>0));
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->vdb->find_by_all('city',$config['per_page'],$this->uri->segment(3),array('parentid'=>0),$field,$order);
        $data['pagination']    = $this->pagination->create_links(); 
        $this->_templates['page'] = 'listthanhpho';
        $this->templates->load($this->_templates['page'],$data);
      }
      function add(){
        $data['title'] = 'Thêm mới thành phố';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'thanhpho/listthanhpho';        
        $data['list'] = $this->vdb->find_by_list('city',array('parentid'=>0));
        $this->form_validation->set_rules('tp[city_name]','Tên thành phố','required');
        if($this->form_validation->run() === false){
            $this->pre_message  = validation_errors();
        }
        else{
            $site = (int)$this->input->post('site');
            $tp = $this->input->post('tp');
            $tp_en = $this->input->post('tp_en');
            $tp['city_url'] = vnit_change_title($tp['city_name']);
            // English
            $tp_en['parentid'] = $tp['parentid'];
            $tp_en['city_url'] = vnit_change_title($tp_en['city_name']);
            //$tp_en['ordering'] = $tp['ordering'];
            $tp_en['site'] = $site;
            if($tp['parentid'] == 0){
               $tp_en['rate'] = $tp['rate']; 
            }
            $tp_en['published'] = $tp['published'];
            if($city_id = $this->vdb->update('city',$tp)){
                $this->write_config();
                write_log(86,277,'Thêm thành phố'); 
                $tp_en['city_id'] = $city_id;
                $this->vdb->update('city_en',$tp_en);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'thanhpho/listthanhpho';
                }else{
                    $url = 'thanhpho/edit/'.$city_id;
                }
                redirect($url);
            }
            
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
        
      }
      function edit(){
        $this->load->config('config_popcity');
        $data['title'] = 'Cập nhật thành phố';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'thanhpho/listthanhpho';
        $data['list'] = $this->vdb->find_by_list('city',array('parentid'=>0));
        $data['rs'] = $this->vdb->find_by_id('city',array('city_id'=>$this->uri->segment(3)));
        $data['rs_en'] = $this->vdb->find_by_id('city_en',array('city_id'=>$this->uri->segment(3)));
        // Form validation
        $this->form_validation->set_rules('tp[city_name]','Tên thành phố','required');
        $this->form_validation->set_rules('con[published]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $city_id = (int)$this->input->post('city_id');
            $site = (int)$this->input->post('site');
            $tp = $this->input->post('tp');  
            $tp_en = $this->input->post('tp_en');  
            $tp['city_url'] = vnit_change_title($tp['city_name']);
            
            // English
            $tp_en['parentid'] = $tp['parentid'];
            $tp_en['city_url'] = vnit_change_title($tp_en['city_name']);  
            if($tp['parentid'] == 0){
               $tp_en['rate'] = $tp['rate']; 
            }
            $tp['site'] = $site;  
            $tp_en['published'] = $tp['published'];
            if($this->vdb->update('city',$tp,array('city_id'=>$city_id))){
                $this->write_config();
                write_log(86,278,'Cập nhật thành phố'); 
                $this->vdb->update('city_en',$tp_en,array('city_id'=>$city_id));
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'thanhpho/listthanhpho';
                }else{
                    $url = uri_string();
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'edit';
        $this->templates->load($this->_templates['page'],$data);
      }
      
      function del(){
          $city_id = $this->uri->segment(3);
          $page = $this->uri->segment(4);
          if($this->vdb->delete('city', array('city_id'=>$id))){
              write_log(86,280,'Xóa thành phố'); 
              $this->session->set_flashdata('message','Đã xóa thành công');
          }
                
          else $this->session->set_flashdata('message','Xóa không thành công');
          redirect('thanhpho/listthanhpho/'.$page);
      }
      // Xoa nhieu ban ghi
      function dels(){
            if(!empty($_POST['ar_id']))
            {
                $page = (int)$this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->vdb->delete('city', array('city_id'=>$ar_id[$i]))) {
                            write_log(86,279,'Xóa nhiều thành phố');
                            $this->session->set_flashdata('message','Đã xóa thành công'); 
                        }
                        
                        else $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
            redirect('thanhpho/listthanhpho/'.$page);
      }
      
      
      function write_config(){
          $this->load->helper('file');
          $check = $this->config->item('published');
          $str = "";
          if($check == 1){ 
            $listcity = $this->vdb->find_by_list('city',array('site'=>1),array('ordering'=>'asc'));
            if(count($listcity) > 0){
                   $str .="<div class=\"bg_pop_city\" id=\"bg_pop_city\"></div>\n";
                   $str .="<div class=\"pop_city\" id=\"pop_city\">\n
                            <div class=\"p_city_title\">\n
                                <h3>Mời bạn chọn khu vực</h3>\n
                                <select name=\"pop_city_id\" id=\"pop_city_id\">\n";
                            foreach($listcity as $rs):
                                $str .="<option value=\"".$rs->city_id."\">".$rs->city_name."</option>\n";
                            endforeach;
                       $str .="</select>\n";
                       $str .="<input type=\"button\" onclick=\"close_pop_city();\" class=\"submit\" value=\"Chọn\">\n";
                   $str .="</div>\n";
                   $str .="</div>\n";
                   $str .="
                        <script type=\"text/javascript\">
                            if($.cookie('fyi_pop_city') == null || $.cookie('fyi_pop_city') == 1){
                                $(\"#bg_pop_city\").show();
                                $(\"#pop_city\").show();
                                $.cookie('fyi_pop_city',2);
                            }
                        </script>
                   ";
               }
                            
            }
            write_file(ROOT.'technogory/config/home/popcity.db', $str);
            $strcache = "<?php";
            $strcache .= "\n\$config['published'] = $check;";
            write_file(ROOT_ADMIN.'config/config_popcity.php', $strcache);
      }
      
      function create_config(){
          $this->load->helper('file');
          $list = $this->vdb->find_by_list('city',array('site'=>1),array('city_id'=>'asc'));
          $total = count($list);
          $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File Config_site language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
          $str .= "\n\$config['total_city'] = $total;\n\n"; 
          $i = 1;
          foreach($list as $rs):
            
            $id = $rs->city_id;
            $city_vi_name = $rs->city_name;
            $city_en_name = $rs->city_name;
            $str .= "\n\$config['city_id_$i'] = $id;";
            $str .= "\n\$config['city_name_".$id."_$i'] = '$city_vi_name';";
            $i ++;  
          endforeach;
          $str .= "\n\n/* End of file config_site*/";        
          write_file(ROOT.'technogory/config/config_city.php', $str);
      }
  }
?>