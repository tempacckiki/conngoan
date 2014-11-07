<?php
class import extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('import_model','import');
    }
    function action(){
        $data['title'] = 'Import dữ liệu';
        $this->_templates['page'] = 'action';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function docfile(){
        $file = $this->input->post('file');
        
        $data['filename'] = $file;
        $data['listcat'] = $this->import->get_main_cat(); 
        //$data['dsnhomhang'] = $this->vdb->find_by_list('nhomhanghoa');
        //$data['dsdonvitinh'] = $this->vdb->find_by_list('donvitinh');
        $this->_templates['page'] = 'import/docfile';
        $this->load->view($this->_templates['page'],$data);
    }
    
    function save_import(){
        $catid = $this->input->post('catid');
        $ar_id = $this->input->post('ar_id');
        for($i = 0; $i < sizeof($ar_id); $i++){
            if($ar_id[$i]){
                $productid = $this->input->post('productid_'.$ar_id[$i]);
                $barcode = $this->input->post('barcode_'.$ar_id[$i]);
                $productname = $this->input->post('productname_'.$ar_id[$i]);
                $city_id = $this->input->post('city_'.$ar_id[$i]);
                $baohanh = $this->input->post('baohanh_'.$ar_id[$i]);
                $tangpham = $this->input->post('tangpham_'.$ar_id[$i]);
                $giathitruong = str_replace(',','',$this->input->post('giathitruong_'.$ar_id[$i]));
                $giamgia = str_replace(',','',$this->input->post('giamgia_'.$ar_id[$i]));
                $giaban = str_replace(',','',$this->input->post('giaban_'.$ar_id[$i]));

                $vdata['productid'] = $productid;
                $vdata['barcode'] = $barcode;
                $vdata['productname'] = $productname;
                $vdata['baohanh'] = $baohanh;
                
                $this->vdb->update('shop_product',$vdata,array('productid'=>$productid));
                
                $vprice['giathitruong'] = $giathitruong;
                $vprice['giamgia'] = $giamgia;
                $vprice['giaban'] = $giaban;
                $vprice['phantram'] = round( (($giamgia * 100)/ $giathitruong) ,0);
                $vprice['lastupdate'] = time();
                if($this->import->check_price_product($productid, $city_id)){

                    $this->vdb->update('shop_price',$vprice,array('productid'=>$productid,'city_id'=>$city_id));
                }else{
                    $vprice['productid'] = $productid;
                    $vprice['city_id'] = $city_id;
                    $this->vdb->update('shop_price',$vprice);
                }
                
                // Tang pham;
                if($tangpham != ''){
                $this->vdb->delete('shop_gifts',array('productid'=>$productid,'city_id'=>$city_id));
                $vgifts['productid'] = $productid;
                $vgifts['city_id'] = $city_id;
                $vgifts['name'] = $tangpham;
                $this->vdb->insert('shop_gifts',$vgifts);
                }
                
            }
        }
        $data['msg'] = 'Lưu dữ liệu thành công';
        echo json_encode($data);
    }
    
    function uploader(){
        if($_FILES["uploadfile"]["size"] > 0){
            $config['upload_path'] = ROOT.'data/templ/';
            $config['allowed_types'] = 'xls';
            $config['max_size']    = '100000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);                     
                   
            if ( !$this->upload->do_upload('uploadfile')){
                $this->pre_message =  $this->upload->display_errors();
            }else{                         
                $result =  $this->upload->data();
                echo $file_name = $result['file_name'];               
            }                    
        }        
    }
}
