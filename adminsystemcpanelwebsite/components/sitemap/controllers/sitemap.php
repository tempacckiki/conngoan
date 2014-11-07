<?php
  class sitemap extends CI_Controller{
      protected $_templates;
      function __construct(){
          parent::__construct();
          $this->load->model('danhmuc_model','danhmuc');
        //  $this->load->model('shop_model','shop');
          $this->pre_message = "";
      }
      
      function index(){         
          $data['title'] = 'Site map';
          $data['save'] = true;
         
            //form validation
          $this->form_validation->set_rules('idCat','Cat id','required');         
          if($this->form_validation->run() === FALSE){
              $this->pre_message = validation_errors();
          }else{
         	 $idCat  			= (int)$this->input->post("idCat");
         	 $priority  	= $this->input->post("priority");
         	 $changefreq  	= $this->input->post("changefreq");
          	 $this->create_config($idCat,$priority,$changefreq);
          }
          $data['messsage'] = $this->pre_message;
          //load templates ****************************
          $this->_templates['page'] = 'index';
          $this->templates->load($this->_templates['page'],$data);
      }
      
        
      function create_config($idCat, $priority, $changefreq){      
          $this->load->helper('file');
          $listCat 		= $this->danhmuc->get_main_cat($idCat);  
       			
          $str 	= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n\n";
          $str .= "<urlset
				      xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
				      xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
				      xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
				            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n\n"; 
             
           //chuyen muc dau   
           if(count($listCat)>0){  
           		 
           		foreach ($listCat as $val): 
           			
           			$linkCat 		= base_url_site().'chuyen-muc/'.$val->caturl.'-'.$val->catid.'.html';            			
           			//create subcat
           			$listsub 		= $this->danhmuc->get_sub_cat($val->catid);
           			$str .= "\n<url>\n";
           			$str .= "<loc>".$linkCat."</loc>\n";        
           			$str .= "<changefreq>".$changefreq."</changefreq>\n";        
           			$str .= "<priority>".$priority."</priority>\n"; 
           			$str .= "\n</url>\n";     
					
           		
           			//*----- get product -------*/
           			$listProduct   = $this->danhmuc->get_all_product($val->catid);
           			
           			if(count($listProduct) >0){
           				foreach ($listProduct as $valP):
           					$linkP 		= base_url_site().'san-pham/'.$valP->producturl.'-'.$valP->productid.'.html';            					           			
		           			$str .= "\n<url>\n";
		           			$str .= "<loc>".$linkP."</loc>\n";        
		           			$str .= "<changefreq>".$changefreq."</changefreq>\n";        
		           			$str .= "<priority>".$priority."</priority>\n"; 
		           			$str .= "\n</url>\n";  
		           				
           				endforeach;
           			}
           			 
           			// duyen  lan 2
           			if (count($listsub)>0){
           				
           				
	           			foreach ($listsub as $val2):
	           				//sub 3
	           				$listsub3 = $this->danhmuc->get_sub_cat($val2->catid);
	           				
	           				$linkCat2 		= base_url_site().'chuyen-muc/'.$val2->caturl.'-'.$val2->catid.'.html';
	           				$str .= "\n<url>\n";   
	           				$str .= "<loc>".$linkCat2."</loc>\n";        
		           			$str .= "<changefreq>".$changefreq."</changefreq>\n";        
		           			$str .= "<priority>".$priority."</priority>\n";
		           			$str .= "\n</url>\n"; 
	           				
		           			//*----- get product -------*/
		           			$listProduct2   = $this->danhmuc->get_all_product($val2->catid);
		           			
		           			if(count($listProduct2) >0){
		           				foreach ($listProduct2 as $valP2):
		           					$linkP2 		= base_url_site().'san-pham/'.$valP2->producturl.'-'.$valP2->productid.'.html';            					           			
				           			$str .= "\n<url>\n";
				           			$str .= "<loc>".$linkP2."</loc>\n";        
				           			$str .= "<changefreq>".$changefreq."</changefreq>\n";        
				           			$str .= "<priority>".$priority."</priority>\n"; 
				           			$str .= "\n</url>\n";  
				           				
		           				endforeach;
		           			}
           			
		           			
		           			//duyet 3
		           			if(count($listsub3)>0){
		           				
		           				 
			           			foreach ($listsub3 as $val3):
			           				$linkCat3 		= base_url_site().'chuyen-muc/'.$val3->caturl.'-'.$val3->catid.'.html'; 
			           				//sub 4
			           				$str .= "\n<url>\n"; 
			           				$str .= "<loc>".$linkCat3."</loc>\n";        
				           			$str .= "<changefreq>".$changefreq."</changefreq>\n";        
				           			$str .= "<priority>".$priority."</priority>\n";			           				 
			           				$str .= "\n</url>\n";
		           					 
			           				
			           				//*----- get product -------*/
				           			$listProduct3   = $this->danhmuc->get_all_product($val3->catid); 
				           			
				           			if(count($listProduct3) >0){
				           				foreach ($listProduct3 as $valP3):
				           					$linkP3 		= base_url_site().'san-pham/'.$valP3->producturl.'-'.$valP3->productid.'.html';            					           			
						           			$str .= "\n<url>\n";
						           			$str .= "<loc>".$linkP3."</loc>\n";        
						           			$str .= "<changefreq>".$changefreq."</changefreq>\n";        
						           			$str .= "<priority>".$priority."</priority>\n"; 
						           			$str .= "\n</url>\n";  
						           				
				           				endforeach;
				           			}
           			
		           			
			           				
			           			endforeach; //end for 3
			           			
		           			}
		           			
	           			endforeach; //end for 2
	           			
           			}
           			
           		endforeach;
           		
           }
                
           $str .= "\n</urlset>\n";        
          write_file(ROOT.'sitemap_'.$idCat.'.xml', $str);
      }
  }
