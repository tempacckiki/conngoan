<?php
class compare extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('compare_model','compare');
        $this->regions = $this->session->userdata('fyi_regions');
        $this->city_id = $this->session->userdata('city_site');
    }
    
    function add(){
        $data['error'] = 0;
        $productid = $this->input->post('productid');
        $rs = $this->vdb->find_by_id('shop_product',array('productid'=>$productid));
        $check = $this->vdb->find_by_id('shop_compare',array('session_id'=>cookie_mycart(),'productid'=>$productid));
        if(!$check){
            $data['error'] = 1;
            $vdata['session_id'] = cookie_mycart();
            $vdata['productid'] = $productid;
            $vdata['productimg'] = $rs->productimg;
            $id = $this->vdb->update('shop_compare',$vdata);
            $data['id'] = $id;
            $data['productimg'] = $rs->productimg;
            $data['msg'] = 'Thêm sản phẩm: <b>'.$rs->productname.'</b> vào khay so sánh thành công';
        }else{
            $data['msg'] = 'Thêm sản phẩm: <b>'.$rs->productname.'</b> đã tồn tại trong khay so sánh';
        }
        
        echo json_encode($data);
    }
    
    function dels(){
        $compareid = $this->input->post('compareid');
        $this->vdb->delete('shop_compare',array('compareid'=>$compareid));
        $data['msg'] = 'Xóa sản phẩm khỏi khay so sánh thành công';
        echo json_encode($data);
    }
    
    function action(){
        $data['title'] = 'So sánh sản phẩm';
        $listid = $this->input->get('list');
        $catid = $this->input->get('categoryid');
        $ar = explode(';',$listid);
        if(count($ar)== 4){
            $ar_id = array($ar[1],$ar[2]);
        }else if(count($ar) == 5){
            $ar_id = array($ar[1],$ar[2],$ar[3]);
        }else{
            $this->session->set_flashdata('message','Bạn phải chọn ít nhất 2 sản phẩm để so sánh');
            redirect($this->input->get('teturnurl'));
        }
        
        $data['ar_id'] = $ar_id;
        $data['list'] = $this->compare->get_ar_product($ar_id);
        $data['list_type'] = $this->compare->get_features_list($catid);
        $this->link['0'] = 'So sánh sản phẩm';
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data,'detail');
    }
}