<?php
class skin extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_messsge = "";
    }
    
    function edit(){
        $this->load->helper('file');
        $data['title'] = 'Tùy chỉnh giao diện';
        $data['file_skin'] = ROOT.'site/views/templates/vfa/skin.php';
        // Form validation
        $this->form_validation->set_rules('content','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_messsge = validation_errors();
        }else{
            $content = $this->input->post('content');
            if(write_file(ROOT.'site/views/templates/vfa/skin.php', $content)){
                $this->pre_messsge = "Lưu thành công";
            }
        }
        $data['message'] = $this->pre_messsge;
        $this->_templates['page'] = 'edit';
        $this->templates->load($this->_templates['page'],$data);
    }
}
