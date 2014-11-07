<?php
class vanchuyen extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('vanchuyen_model','vanchuyen');
        $this->pre_message = "";
    }
    function ds(){
        $data['title'] = 'Vận chuyển';
        write_log(71,227,'Xem danh sách phương thức vận chuyển'); 
        $data['add'] = 'phuongthuc/vanchuyen/add|'.icon_add('phuongthuc/vanchuyen/add');
        $data['delete'] = icon_dels('phuongthuc/vanchuyen/dels');
        $data['list'] = $this->vdb->find_by_list('shop_shipping',0,array('ordering'=>'asc'));
        $data['num'] = count($data['list']);
        $this->_templates['page'] = 'vanchuyen/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $data['title'] = 'Thêm phương thức vận chuyển';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'phuongthuc/vanchuyen/ds';
        $this->form_validation->set_rules('pay_vi[shipping_name]','Phuong thức','required');
        $this->form_validation->set_rules('pay_vi[shipping_intro]','Giới thiệu','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $pay_vi = $this->input->post('pay_vi');
            $pay_en = $this->input->post('pay_en');
            $ordering = $this->input->post('ordering');
            $published = $this->input->post('published');
            $shipping_id = $this->input->post('shipping_id');
            $pay_vi['ordering'] = $ordering;
            $pay_en['ordering'] = $ordering;
            /*$pay_en['shipping_free'] = $pay_vi['shipping_free'];*/
            $img  =  $this->input->post('img');
             
            if(!empty($img)){
            	$this->load->helper('img_helper');
            	$imgRoot    = ROOT.'alobuy0862779988/payment/shipping/'.$img;
            	$imgThumb   = ROOT.'alobuy0862779988/payment/shipping/thumb/'.$img;
            	 
            	vnitResizeImage($imgRoot,$imgThumb,100,100);
            }
            
            $pay_vi['shipping_img']	 = $img;
            
            if($shipping_id = $this->vdb->update('shop_shipping',$pay_vi)){
                write_log(71,228,'Thêm phương thức vận chuyển: '.$pay_vi['shipping_name']);
                $pay_en['shipping_id'] = $shipping_id;
               // $this->vdb->update('shop_shipping_en',$pay_en);
                
                // Insert Rate Shipping
                $rate['shipping_id'] = $shipping_id;
                $rate['rate_cost'] = 0;
                $rate['rate_price'] = 0;
                $rate['rate_price_type'] = '$';
                $rate['rate_default'] = 1;
                $this->vdb->update('shop_shipping_rate',$rate);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'phuongthuc/vanchuyen/ds/';
                }else{
                    $url = 'phuongthuc/vanchuyen/edit/'.$shipping_id;
                }
                redirect($url);
            }
       
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'vanchuyen/add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $js_array = array(
            array(base_url().'components/phuongthuc/views/esset/vanchuyen.js')
        );
        $this->esset->js($js_array);
        $data['title'] = 'Cập nhật thức vận chuyển';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'phuongthuc/vanchuyen/ds';
        $this->form_validation->set_rules('pay_vi[shipping_name]','Phương thức','required');
        $this->form_validation->set_rules('pay_vi[shipping_intro]','Giới thiệu','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $pay_vi = $this->input->post('pay_vi');
           
            $ordering = $this->input->post('ordering');
            $published = $this->input->post('published');
            $shipping_id = $this->input->post('shipping_id');
            $pay_vi['ordering'] = $ordering;
            $img  =  $this->input->post('img');
             
            if(!empty($img)){
            	$this->load->helper('img_helper');
            	$imgRoot    = ROOT.'alobuy0862779988/payment/shipping/'.$img;
            	$imgThumb   = ROOT.'alobuy0862779988/payment/shipping/thumb/'.$img;
            	 
            	vnitResizeImage($imgRoot,$imgThumb,100,100);
            }
            
            $pay_vi['shipping_img']	 = $img;
             
            
            
            if($this->vdb->update('shop_shipping',$pay_vi,array('shipping_id'=>$shipping_id))){
                write_log(71,229,'Cập nhật phương thức vận chuyển: '.$pay_vi['shipping_name']);
              
                $ar_pay = $this->input->post('ar_pay');
               // $this->vdb->delete('shop_payment_shipping',array('shipping_id'=>$shipping_id));
                /* for($i = 0; $i < sizeof($ar_pay); $i++){
                    if($ar_pay[$i]){
                        $sp['shipping_id'] = $shipping_id;
                        $sp['payment_id'] =  $ar_pay[$i];
                        $this->vdb->update('shop_payment_shipping',$sp);
                    }
                }
                 */
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'phuongthuc/vanchuyen/ds/';
                }else{
                    $url = uri_string();
                }
                redirect($url);
            }
        }
        $data['rs_vi'] = $this->vdb->find_by_id('shop_shipping',array('shipping_id'=>$this->uri->segment(4)));
        
        $data['listrate'] = $this->vdb->find_by_list('shop_shipping_rate',array('shipping_id'=>$this->uri->segment(4)),array('rate_cost'=>'asc'));
        $data['payment'] = $this->vdb->find_by_list('shop_payment',0,array('ordering'=>'asc'));
        $data['message'] = $this->pre_message;
        
        //*** load templates ********************
        $this->_templates['page'] = 'vanchuyen/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    // Xoa nhieu ban ghi
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');

            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $vc = $this->vdb->find_by_id('shop_shipping',array('shipping_id'=>$ar_id[$i]))->shipping_name;
                    if($this->vdb->delete('shop_shipping',array('shipping_id'=>$ar_id[$i]))){
                        write_log(71,230,'Xóa phương thức vận chuyển: '.$vc);
                       // $this->vdb->delete('shop_shipping_en',array('shipping_id'=>$ar_id[$i]));
                        $this->vdb->delete('shop_shipping_rate',array('shipping_id'=>$ar_id[$i]));
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }else{
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('phuongthuc/vanchuyen/ds/'.$page);
    }
    
    function addrate(){
        /*
        $html = form_open(uri_string(),array('shipping_rate'));
        $html .='<table class="form">';
        $html .='<tr>';
        $html .='<td>Giá đơn hàng lớn hơn</td>';
        $html .='<td><input type="text" name="rate_cost"></td>';
        $html .='</tr>';
        $html .='<tr>';
        $html .='<td>Phí vận chuyển</td>';
        $html .='<td><input type="text" name="rate_price"></td>';
        $html .='</tr>';
        $html .='<tr>';
        $html .='<td>Kiểu tính</td>';
        $html .='<td>
                <select name="rate_price_type">
                    <option value="$"> VNĐ</option>
                    <option value="%"> %</option>
                </select>
        </td>';
        $html .='</tr>';
        $html .='</table>';
        $html .= form_close();
        echo $html;*/
        $data['shipping_id'] = $this->uri->segment(4);
        $this->_templates['page'] = 'vanchuyen/rate/add';
        $this->load->view($this->_templates['page'],$data);
        
    }
    
    function save_add_rate(){
        $shipping_id = $this->input->post('shipping_id');
        $rate_cost = $this->input->post('rate_cost');
        $rate_price = $this->input->post('rate_price');
        $rate_price_type = $this->input->post('rate_price_type');
        $vdata['rate_cost'] = $rate_cost;
        $vdata['rate_price'] = $rate_price;
        $vdata['rate_price_type'] = $rate_price_type;
        $vdata['shipping_id'] = $shipping_id;
        if($id = $this->vdb->update('shop_shipping_rate',$vdata)){
            $rs = $this->vdb->find_by_id('shop_shipping_rate',array('rate_id'=>$id));
            $html = '<tr class="row1" id="rate_'.$id.'">';
                $html .='<td>Lớn hơn <input type="text" id="rate_cost_'.$id.'" value="'.$rs->rate_cost.'" style="width: 70px;"></td>';
                $html .='<td><input  type="text" id="rate_cost_'.$id.'" value="'.$rs->rate_price.'" style="width: 100px;"></td>';
                $html .='<td>
                            <select id="rate_price_type_'.$id.'">';
                            $vnd = ($rs->rate_price_type == 1)?'selected="selected"':'';
                            $tyle = ($rs->rate_price_type == 2)?'selected="selected"':'';
                                $html .='<option value="1" '.$vnd.'> VNĐ</option>';
                                $html .='<option value="2" '.$tyle.'> %</option>';
                $html .='</select>
                        </td>';
                $html .='<td>
                    <a href="javascript:;" title="Xóa"><img src="'.base_url().'templates/icon/del.png" align="right"></a> 
                    <a href="javascript:;" onclick="save_rate('.$id.')" title="Lưu"><img src="'.base_url().'templates/icon/save.png" align="right"></a>
                </td>';
            $html .= '</tr>';
            $data['html'] = $html;
            $data['msg'] = 'Thêm mới thành công';
            $data['error'] = 0;
        }else{
            $data['error'] = 1;
            $data['msg'] = 'Thêm mới không thành công';
        }
        echo json_encode($data);
    }
    
    function save_rate_edit(){
        $rate_id = $this->input->post('rate_id');
        $vdata['rate_cost'] = $this->input->post('rate_cost');
        $vdata['rate_price'] = $this->input->post('rate_price');
        $vdata['rate_price_type'] = $this->input->post('rate_price_type');
        if($this->vdb->update('shop_shipping_rate',$vdata,array('rate_id'=>$rate_id))){
            $data['msg'] = 'Lưu thành công';
        }else{
            $data['msg'] = 'Lưu không thành công';
        }
        echo json_encode($data);
    }
    
    function del_rate(){
        $rate_id = $this->input->post('rate_id');
        if($this->vdb->delete('shop_shipping_rate',array('rate_id'=>$rate_id))){
            $data['msg'] = 'Xóa thành công';
        }else{
            $data['msg'] = 'Xóa không thành công';
        }
        echo json_encode($data);
    }
    
    
    /*----------------------------------+
     * Uploader
    +----------------------------------*/
    function uploader(){
    	// $ProductID = $this->uri->segment(3);
    	/// $session_info = $this->session->userdata('session_id');
    	$dir 		= ROOT.'alobuy0862779988/payment/shipping/';
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
