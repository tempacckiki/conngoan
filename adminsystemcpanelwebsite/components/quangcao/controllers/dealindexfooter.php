<?php
class dealindexfooter extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $this->load->helper('file');
    }
    
    function ds(){
        $this->write_quangcao();
        $data['title'] = 'Danh sách quảng deal index';
        write_log(78,254,'Xem danh sách quảng cáo deal index');
        $data['add'] = 'quangcao/dealindexfooter/add|'.icon_add('quangcao/dealindexfooter/add');
        $data['delete'] = icon_dels('quangcao/dealindexfooter/dels');
        $data['list'] = $this->vdb->find_by_list('dealindex',array('position'=>3),array('ordering'=>'asc'));
        
        //*** load templates **********************
        $this->_templates['page'] = 'dealindexfooter/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $data['title'] = 'Thêm mới quảng cáo';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'quangcao/dealindexfooter/ds';
        $this->form_validation->set_rules('name','Tên quảng cáo','required');
       
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
        	$img =  $this->input->post('img');
          	if(!empty($img)){
          		$this->load->helper('img_helper');
          		$imgRoot    = ROOT.'alobuy0862779988/adv/dealindexfooter/full_images/'.$img;
          		$imgThumb   = ROOT.'alobuy0862779988/adv/dealindexfooter/thumb/'.$img;
          		vnitResizeImage($imgRoot,$imgThumb,200,170);
          	}	
            $vdata['name'] 			= $this->input->post('name');
            $vdata['decription'] 	= $this->input->post('decription');
            $vdata['price'] 		= str_replace('.','',$this->input->post('price'));
            $vdata['price_old'] 	= str_replace('.','',$this->input->post('price_old'));
            $vdata['link'] 			= $this->input->post('link');
            $vdata['images'] 		= $this->input->post('img');
            $vdata['ordering'] 		= $this->input->post('ordering');
            $vdata['position'] 		= 3;
            $vdata['published'] 	= $this->input->post('published');
         
            if($id = $this->vdb->update('dealindex',$vdata)){
               /// write_log(78,255,'Thêm quảng cáo deal index: '.$vdata['name']);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'quangcao/dealindexfooter/ds/';
                }else{
                    $url = 'quangcao/dealindexfooter/edit/'.$id;
                }
                redirect($url);
                
            }
        }
        $data['message'] = $this->pre_message;
        
        //***load templates *******************
        $this->_templates['page'] = 'dealindexfooter/add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $data['title'] = 'Cập nhật quảng cáo';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'quangcao/dealindexfooter/ds';
        $this->form_validation->set_rules('name','Tên quảng cáo','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id 	= $this->input->post('id');
            $img  =  $this->input->post('img');
            if(!empty($img)){
            	$this->load->helper('img_helper');
            	$imgRoot    = ROOT.'alobuy0862779988/adv/dealindexfooter/full_images/'.$img;
            	$imgThumb   = ROOT.'alobuy0862779988/adv/dealindexfooter/thumb/'.$img;
            	vnitResizeImage($imgRoot,$imgThumb,200,170);            	
            }
            
            $vdata['name'] 			= $this->input->post('name');
            $vdata['decription'] 	= $this->input->post('decription');
            $vdata['price'] 		= str_replace('.','',$this->input->post('price'));
            $vdata['price_old'] 	= str_replace('.','',$this->input->post('price_old'));
            $vdata['link'] 			= $this->input->post('link');
            $vdata['images'] 		= $this->input->post('img');
            $vdata['position'] 		= 3;
            $vdata['ordering'] 		= $this->input->post('ordering');
            $vdata['published'] 	= $this->input->post('published');
           
          
            if($this->vdb->update('dealindex',$vdata,array('id'=>$id))){
               // write_log(78,256,'Cập nhật quảng cáo dealindex: '.$vdata['name']);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'quangcao/dealindexfooter/ds/';
                }else{
                    $url = uri_string();
                }
                redirect($url);
                
            }
        }
        $data['rs'] = $this->vdb->find_by_id('dealindex',array('id'=>$this->uri->segment(4)));
        $data['message'] = $this->pre_message;
        //** load templates *********************
        $this->_templates['page'] = 'dealindexfooter/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');

            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $name = $this->vdb->find_by_id('dealindex',array('id'=>$ar_id[$i]))->name;
                    if($this->vdb->delete('dealindex',array('id'=>$ar_id[$i]))){
                         write_log(78,257,'Xóa quảng cáo footer: '.$name);
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }else{
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('quangcao/dealindexfooter/ds/'.$page);
    }
    //*************************************
    function write_quangcao(){
        $list = $this->vdb->find_by_list('dealindex',array('published'=>1,'position'=>3),array('ordering'=>'asc'));
        $total = count($list);
        $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File config_dealindex language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
        $str .= "\n\$config['advDeal_totalFooter'] = $total;\n"; 
        $i = 1;
        foreach($list as $rs):
            $name 		= $rs->name;
            $decription = $rs->decription;
            $price 		= $rs->price;
            $priceOld 	= $rs->price_old;
            $link 		= $rs->link;
            $img 		= $rs->images;
            $str .= "\n\$config['advDealFooter_name_$i'] = '$name';";
            $str .= "\n\$config['advDealFooter_decription_$i'] = '$decription';";
            $str .= "\n\$config['advDealFooter_price_$i'] = '$price';";
            $str .= "\n\$config['advDealFooter_priceOld_$i'] = '$priceOld';";
            $str .= "\n\$config['advDealFooter_link_$i'] = '$link';";
            $str .= "\n\$config['advDealFooter_img_$i'] = '$img';\n";
        $i ++;
        endforeach;
        $str .= "\n\n/* End of file config_dealindexfooter*/";        
        write_file(ROOT_ADMIN.'config/config_dealindexfooter.php', $str);
    }
    
   
    /*----------------------------------+
     * Uploader
    +----------------------------------*/
    function uploader(){
    	// $ProductID = $this->uri->segment(3);
    	/// $session_info = $this->session->userdata('session_id');
    	$dir 		= ROOT.'alobuy0862779988/adv/dealindexfooter/full_images/';
    	$dir_admin  = 'data/ads/225x101/';
    	//chmod($uploaddir,0777);
    	$size=$_FILES['uploadfile']['size'];
    	if($size>204857600)
    	{
    		echo "file_biger";
    		unlink($_FILES['uploadfile']['tmp_name']);
    		//exit;
    	}
    	$filename = stripslashes($_FILES['uploadfile']['name']);
    	$i = strrpos($filename,".");
    	if (!$i) { return ""; }
    	$l = strlen($filename) - $i;
    	$extension = substr($filename,$i+1,$l);
    	$extension = strtolower($extension);
    	$file_name = str_replace($extension,'',$filename);
    	$name = time();
    	$filename = $dir.$name.'.'.$extension;
    	$file_ext = $name.'.'.$extension;
    	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $filename)) {
    		echo $file_ext;
    
    	} else {
    		echo 'error';
    	}
    }
    
    /*----------------------------------+
     * END Uploader
    +----------------------------------*/
    
}
