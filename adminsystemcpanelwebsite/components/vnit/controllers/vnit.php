<?php
  class vnit extends CI_Controller{
      function __construct(){
         parent::__construct();
         $this->load->model('vnit/vnit_model','page');
      }
      function index(){
          $data['title'] = 'Index';
          $data['rs'] = $this->page->get_content();
          $this->load->view('index',$data);
      }
      
      function abc(){
          $data['title'] = 'abc';
          $data['uri2'] = $this->uri->segment(2);
          $data['uri3'] = $this->uri->segment(3);
          $data['uri4'] = $this->uri->segment(4);
          $this->load->view('abc',$data);
      }
  }
?>
