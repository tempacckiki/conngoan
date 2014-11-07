<?php
class phivanchuyen extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->mainmenu = 'sangiare';
        $js_array = array(
            array(base_url().'components/phuongthuc/views/esset/vanchuyen.js')
        );
        $this->esset->js($js_array);
        $this->load->model('phivanchuyen_model','phivanchuyen');
    }
    
    function syn_shipping(){
        $this->db = $this->load->database('default',true);
        $vdata['rate'] = 0;
        $this->db->update('city',$vdata);
    }
    
    function index(){
        $data['title'] = 'Phí vận chuyển';
        $cityid = (int)$this->uri->segment(4); 
        $listcity = $this->phivanchuyen->get_all_city();
        $data['listcity'] = $listcity;
        $cityid = ($cityid != 0)?$cityid:$listcity[0]->city_id; 
        $city_name = $this->vdb->find_by_id('city',array('city_id'=>$cityid))->city_name;
        write_log(89,291,'Xem danh sách phí vận chuyển theo Tỉnh, Thành phố: '.$city_name);
        $data['list'] = $this->phivanchuyen->get_all_city($cityid);
        $data['city_id'] = $cityid;
        $this->_templates['page'] = 'phivanchuyen/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $cityid = $this->uri->segment(4);
        $city_id = $this->uri->segment(5);
        $data['title'] = 'Cập nhật phí vận chuyển';
        $data['apply'] = true;
        $data['save'] = true;
        $data['cancel'] = 'phuongthuc/phivanchuyen/index/'.$cityid;

        $data['rs'] = $this->vdb->find_by_id('city',array('city_id'=>$cityid));
        $data['val'] = $this->vdb->find_by_id('city',array('city_id'=>$city_id));
        $this->form_validation->set_rules('cityid','','');
        if($this->form_validation->run()){
            $cityid = $this->input->post('cityid');
            $city_id = $this->input->post('city_id');
            $vdata['rate'] = str_replace('.','',$this->input->post('rate'));
            if($this->vdb->update('city',$vdata,array('city_id'=>$city_id))){
                $quan = $this->vdb->find_by_id('city',array('city_id'=>$city_id));
                $thanhpho = $this->vdb->find_by_id('city',array('city_id'=>$cityid));
                write_log(89,292,'Cập nhật phí vận chuyển Quân: '.$quan->city_name.', Thành phố: '.$thanhpho->city_name);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'phuongthuc/phivanchuyen/index/'.$cityid;
                }else{
                    $url = uri_string();
                }
                redirect($url);     
            }
        }
        $this->_templates['page'] = 'phivanchuyen/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
}
