<?php
  class csdl extends CI_Controller{
      protected $_templates;
      function __construct(){
          parent::__construct();
          $this->pre_message = "";
          $this->load->config('config_csdl');
          $this->menu = $this->config->item('menu'); 
          $this->load->helper('file');
      }
      //Thong tin ve co so du lieu
      function index(){
          $data['title'] = 'Thông tin chung';
          $this->_templates['page'] = 'index';
          $this->templates->load($this->_templates['page'],$data);
      }
      // Backup csdl
      function backup(){
          $data['title'] = 'Backup cơ sở dữ liệu';
          $this->pre_message = 'Đã thực hiện lưu một bản trên Server' ;
          //DB backup:
          $this->load->dbutil();
          $this->load->helper('download');
          $backup = &$this->dbutil->backup(); 
          $info_db = $this->db->database.'_'.date('d_m_Y_H_i_s',time());
          $db_backup_file = $info_db.'.sql.gz';
          chmod(ROOT.'data/backup',0777);
          write_file(ROOT.'data/backup/'. $db_backup_file, $backup);
          
          force_download($db_backup_file, $backup); 
          
          $data['message']   = $this->pre_message;
          $this->_templates['page']  = 'backup';
          $this->templates->load($this->_templates['page'],$data);
      }
      // Hien thi danh sach cac file Backup
      function databackup(){
          $data['title'] = 'Data backup';
          $this->load->helper('download');
          $this->_templates['page'] = 'databackup';
          $this->templates->load($this->_templates['page'],$data);
      }
      // Toi uu csdl
      
      function optimize(){
          $data['title'] = 'Tôi ưu';
          $this->_templates['page'] = 'optimize';
          $this->templates->load($this->_templates['page'],$data);
      }
      // Cau hinh backup
      function setting(){
          $data['title'] = 'Cấu hình';
          $this->_templates['page'] = 'setting';
          $this->templates->load($this->_templates['page'],$data);
      }
      // Xoa file backup
      function delbackup(){
          $file = $this->uri->segment(3);
          if(file_exists(ROOT.'data/backup/'.$file)){
              unlink(ROOT.'data/backup/'.$file);
              $this->session->set_flashdata('message','Xóa File thành công');
          }else{
              $this->session->set_flashdata('error','Xóa File thành công');
          }
          redirect('csdl/databackup');
      }
  }
?>
