<?php
class city extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->helper('file');
        $this->load->config('config_popcity');
    }
    
    function index(){
        $data['title'] = 'Cấu hình hiển thị Popup khu vực';
        $data['apply'] = true;
        $this->form_validation->set_rules('cachecity','','');
        $data['published'] = $this->config->item('published');
        if($this->form_validation->run()){
            $check = (int)$this->input->post('published');
            $str = "";
            if($check == 1){
               $listcity = $this->vdb->find_by_list('city',array('site'=>1),array('ordering'=>'asc'));
               if(count($listcity) > 0){
               	   //image
               		$imgPath   = base_url_static().'technogory/templates/default/images/popup_logo.png';
               	
                   $str .="<div class=\"bg_pop_city\" id=\"bg_pop_city\"></div>\n";
                   $str .="<div class=\"pop_city\" id=\"pop_city\">\n
                            <div class=\"p_city_title\">\n 
                               <img src=\"".$imgPath."\"> </div>\n 
                   			<p class=\"info\">ALOBUY Việt Nam - Mua hàng trực tuyến, Giao hàng tận nơi. </p>
                   			<p class=\"label\">Vui lòng chọn thành phố</p> \n
                                <select name=\"pop_city_id\" id=\"pop_city_id\">\n";
                            	foreach($listcity as $rs):
                                	$str .="<option value=\"".$rs->city_id."\">".$rs->city_name."</option>\n";
                           		endforeach;
                       			$str .="</select>\n";
                       $str .="<input type=\"button\" onclick=\"close_pop_city();\" class=\"submit\" value=\"Thực hiện\">\n";
                  
                   $str .="</div>\n";
                   $str .="
                        <script type=\"text/javascript\">
                   			$(document).ready(function(){
	                            if($.cookie('fyi_pop_city') == null || $.cookie('fyi_pop_city') == 1){
	                                $(\"#bg_pop_city\").show();
	                                $(\"#pop_city\").show();
	                               // $.cookie('fyi_pop_city',2);
	                            }
                   			});
                        </script>
                   ";
               }
                            
            }
            write_file(ROOT.'technogory/config/home/popcity.db', $str);
            $strcache = "<?php";
            $strcache .= "\n\$config['published'] = $check;";
            write_file(ROOT_ADMIN.'config/config_popcity.php', $strcache);
            
            write_log(91,297,'Cấu hình hiển thị Popup khu vực');
            $this->session->set_flashdata('message','Lưu thành công');
            redirect('quangcao/city/index');
            
        }
        $this->_templates['page'] ='city/index';
        $this->templates->load($this->_templates['page'],$data);
    }

}
