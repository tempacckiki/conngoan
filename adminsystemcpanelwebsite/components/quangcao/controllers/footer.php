<?php
class footer extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        //$this->load->model('footer_model','footer');
    }
    
    function index(){
        $data['title'] = 'Quảng cáo Footer Left';
        $data['apply'] = true;
        $data['f1'] = $this->vdb->find_by_id('ads',array('id'=>3,'position'=>'footer_left'));
        $data['f2'] = $this->vdb->find_by_id('ads',array('id'=>4,'position'=>'footer_left'));
        $data['f3'] = $this->vdb->find_by_id('ads',array('id'=>5,'position'=>'footer_left'));
        $this->form_validation->set_rules('name1','Quảng cáo 1','required');
        $this->form_validation->set_rules('link1','Link 1','required');
        $this->form_validation->set_rules('name2','Quảng cáo 2','required');
        $this->form_validation->set_rules('link2','Link 2','required');
        $this->form_validation->set_rules('name3','Quảng cáo 3','required');
        $this->form_validation->set_rules('link3','Link 3','required');   
        if($this->form_validation->run() === FALSE){
           $this->pre_message = validation_errors() ;
        }else{
            $name1 = $this->input->post('name1');
            $link1 = $this->input->post('link1');
            $intro1 = $this->input->post('intro1');
            $linkmain1 = $this->input->post('linkmain1');
            $name2 = $this->input->post('name2');
            $link2 = $this->input->post('link2');
            $intro2 = $this->input->post('intro2');
            $linkmain2 = $this->input->post('linkmain2');
            $name3 = $this->input->post('name3');
            $link3 = $this->input->post('link3');
            $intro3 = $this->input->post('intro3');
            $linkmain3 = $this->input->post('linkmain3');
            $published = $this->input->post('published');
            // Quang cao 1
            if($_FILES["userfile1"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/adv/footer/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload('userfile1')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $images1 = $result['file_name'];               
                }                    
            }else{
                $images1 = $this->input->post('images1');
            }
            // Quang cao 2
            if($_FILES["userfile2"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/adv/footer/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload('userfile2')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $images2 = $result['file_name'];               
                }                    
            }else{
                $images2 = $this->input->post('images2');
            }
            // Quang cao 3
            if($_FILES["userfile3"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/adv/footer/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload('userfile3')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $images3 = $result['file_name'];               
                }                    
            }else{
                $images3 = $this->input->post('images3');
            }
            
            $vdata1['name'] = $name1;
            $vdata1['link'] = $link1;
            $vdata1['images'] = $images1;
            $vdata1['intro'] = $intro1;
            $vdata1['link_main'] = $linkmain1;
            $vdata1['published'] = $published;
            $this->vdb->update('ads',$vdata1,array('id'=>3));
            
            $vdata2['name'] = $name2;
            $vdata2['link'] = $link2;
            $vdata2['images'] = $images2;
            $vdata2['intro'] = $intro2;
            $vdata2['link_main'] = $linkmain2;
            $vdata2['published'] = $published;
            $this->vdb->update('ads',$vdata2,array('id'=>4));
            
            $vdata3['name'] = $name3;
            $vdata3['link'] = $link3;
            $vdata3['images'] = $images3;
            $vdata3['intro'] = $intro3;
            $vdata3['link_main'] = $linkmain3;
            $vdata3['published'] = $published;
            $this->vdb->update('ads',$vdata3,array('id'=>5));
            
            if($published == 1){
                $this->write_km(1);
            }else{
               $this->write_km(0);
            }
            write_log(93,302,'Cập nhật quảng cáo banner footer trái');
            $this->session->set_flashdata('message','Lưu thành công');
            redirect('quangcao/footer/index');
        }
        $this->_templates['page'] = 'footer/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function write_km($pub){
        $this->load->helper('file');
        if($pub == 1){
            $km1 = $this->vdb->find_by_id('ads',array('id'=>3));
            $km2 = $this->vdb->find_by_id('ads',array('id'=>4));
            $km3 = $this->vdb->find_by_id('ads',array('id'=>5));
            $str = '<div class="ads_footer">';
                $str .= '<div class="close_show">';
                    $str .= '<ul>';
                    $str .= '<li><a class="close" href="javascript:delete_p_f()"></a></li>';
                    $str .= '<li><a class="min" href="javascript:close_f()"></a></li>';
                    $str .= '<li><a class="max" href="javascript:open_f()"></a></li>';
                    
                    $str .= '</ul>';
                $str .= '</div>';
                $str .= '<div class="box_ads_footer">';
                    $str .= '<div class="col1">';
                    $str .= '<a href="'.$km1->link.'">';
                    $str .= '<img src="'.base_url_site().'data/adv/footer/'.$km1->images.'" alt="'.$km1->name.'">';
                    $str .= '<div class="title">'.$km1->name.'</div>';
                    $str .= '<div class="link">'.$km1->link_main.'</div>';
                    $str .= '<div class="intro">'.$km1->intro.'</div>';
                    $str .= '</a>';
                    $str .= '</div>';
                    $str .= '<div class="col2">';
                    $str .= '<a href="'.$km2->link.'">'; 
                    $str .= '<img src="'.base_url_site().'data/adv/footer/'.$km2->images.'" alt="'.$km2->name.'">';
                    $str .= '<div class="title">'.$km2->name.'</div>';
                    $str .= '<div class="link">'.$km2->link_main.'</div>';
                    $str .= '<div class="intro">'.$km2->intro.'</div>';
                    $str .= '</a>';
                    $str .= '</div>';
                    $str .= '<div class="col3">';
                    $str .= '<a href="'.$km3->link.'">';
                    $str .= '<img src="'.base_url_site().'data/adv/footer/'.$km3->images.'" alt="'.$km3->name.'">';
                    $str .= '<div class="title">'.$km3->name.'</div>';
                    $str .= '<div class="link">'.$km3->link_main.'</div>';
                    $str .= '<div class="intro">'.$km3->intro.'</div>';
                    $str .= '</a>';
                    $str .= '</div>';
                $str .= '</div>';
            $str .= '</div>';
            $str .= '<script type="text/javascript">';
            $str .= '
                    $(document).ready(function(){
                        auto_open_close();  
                    });
                    // Auto dong mo quang cao by Cookie
                    function close_f(){
                        $(".box_ads_footer").slideUp();
                        $("a.min").hide();
                        $("a.max").show();
                        $.cookie("fyi_pop_fl","dong",{ path: "'.base_url_site().'" });
                    }

                    function open_f(){
                        $(".box_ads_footer").slideDown();
                        $("a.min").show();
                        $("a.max").hide();
                        $.cookie("fyi_pop_fl","mo",{ path: "'.base_url_site().'" });
                    }
                    function delete_p_f(){
                        $(".ads_footer").hide();
                        $.cookie("fyi_pop_fl","delete",{ path: "'.base_url_site().'" });
                    }
                    function auto_open_close(){
                         if($.cookie("fyi_pop_fl") == "dong"){   
                            $(".box_ads_footer").hide();
                            $("a.min").hide();
                            $("a.max").show();
                        }else if($.cookie("fyi_pop_fl") == "mo"){
                            $(".box_ads_footer").show();
                            $("a.min").show();
                            $("a.max").hide();
                        }else if($.cookie("fyi_pop_fl") == "delete"){
                            $(".ads_footer").hide();
                        }else if($.cookie("fyi_pop_fl") == ""){
                            $(".ads_footer").show();
                            $("a.min").show();
                            $("a.max").hide();
                        }
                    }
            ';
            $str .= '</script>';
            
        }else{
            $str = "";
        }
        write_file(ROOT.'site/config/home/adv_footer_left.db', $str); 
    }
}
