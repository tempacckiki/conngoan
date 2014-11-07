<?php
class export extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('export_model','export');
        $this->pre_message = "";
        $js_array = array(
            array(base_url().'components/export/views/esset/export.js')
        );
        $this->esset->js($js_array);
    }
    function index(){
        $data['title'] = 'Xuất sản phẩm';
        $data['listcat'] = $this->export->get_main_cat();
        $data['listcity'] = $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));
        $this->form_validation->set_rules('nhomhang','','');
        if($this->form_validation->run()){
            $nhomhang = $this->input->post('nhomhang');
            $city_id = $this->input->post('city_id');
            $tungay = $this->input->post('tungay');
            $denngay = $this->input->post('denngay');
            $sapxep = explode('|',$this->input->post('sapxep'));
            $khuvuc =  $this->vdb->find_by_id('city',array('city_id'=>$city_id))->city_name;
            $nhomhangs = $this->vdb->find_by_id('shop_cat',array('catid'=>$nhomhang))->catname;
            $tungays = strtotime($tungay);
            $denngays = strtotime($denngay);
            $field = $sapxep[0];
            $order = $sapxep[1];
            $list_p = $this->export->get_all_product($nhomhang, $city_id, $tungay, $denngay, $field, $order);
            $list_np = $this->export->get_all_product_noprice($nhomhang);
          
            if(count($list_p) > 0){
               $list = $list_p; 
            }else{
               $list = $list_np; 
            }
            
            
           ini_set('memory_limit', '100M');
           memory_get_peak_usage(true);
           require_once APPEXCEL.'excel/PHPExcel.php';
           $this->phpexcel = new PHPExcel(); 
           $this->phpexcel->getProperties()->setCreator("DEV")
                                          ->setLastModifiedBy("DEV")
                                          ->setTitle("File mau")
                                          ->setSubject("File mau")
                                          ->setDescription("File mau")
                                          ->setKeywords("office 2007 openxml php")
                                          ->setCategory("FYI VN");
            // SET HEADER FILE EXCEL
            
            // Tieu de
            $this->phpexcel->getActiveSheet()->mergeCells('A1:K1');
            $this->phpexcel->getActiveSheet()->getStyle('A1:K1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('A1:K1')->getFill()->getStartColor()->setARGB('FFFFFFFF');             
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'Danh sách sản phẩm nhóm hàng: '.$nhomhangs); 
            $style_tbm = array(
                'font'    => array(
                    'bold'      => true
                ), 
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            );                                              
            $this->phpexcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($style_tbm); 
            // Tieu de 1
            $this->phpexcel->getActiveSheet()->mergeCells('A2:K2');
            $this->phpexcel->getActiveSheet()->getStyle('A2:K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('A2:K2')->getFill()->getStartColor()->setARGB('FFFFFFFF');             
            $khuvuc_text = "Tỉnh, Thành phố: $khuvuc";
            if($tungay != 0 && $denngay != 0){
              $khuvuc_text .=" Từ ngày: ".date('d/m/Y',$tungays)." đến ngày: ".date('d/m/Y',$denngays);
            }
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('A2', $khuvuc_text); 
            $style_tbm = array(
                'font'    => array(
                    'bold'      => true
                ), 
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            );                                              
            $this->phpexcel->getActiveSheet()->getStyle('A2:K2')->applyFromArray($style_tbm);
            // Tieu de 1
            $this->phpexcel->getActiveSheet()->mergeCells('A3:K3');
            $this->phpexcel->getActiveSheet()->getStyle('A3:K3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('A3:K3')->getFill()->getStartColor()->setARGB('FFFFFFFF');             
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('A3', ''); 
            $style_tbm = array(
                'font'    => array(
                    'bold'      => true
                ), 
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            );                                              
            $this->phpexcel->getActiveSheet()->getStyle('A3:K3')->applyFromArray($style_tbm);
            $style = array(
                'font'    => array(
                    'bold'      => true
                ), 
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),                           
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'FF4cccf6'),
                    ),
                ),
            ); 
            //STT
            $this->phpexcel->getActiveSheet()->getStyle('A4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('A4')->getFill()->getStartColor()->setARGB('FF9ca2a1');            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('A4', 'STT');                                              
            $this->phpexcel->getActiveSheet()->getStyle('A4')->applyFromArray($style);            
            //MA HS
            $this->phpexcel->getActiveSheet()->getStyle('B4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('B4')->getFill()->getStartColor()->setARGB('FF9ca2a1');            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('B4', 'ID SP');                                
            $this->phpexcel->getActiveSheet()->getStyle('B4')->applyFromArray($style);    
            //Mã sản phẩm
            $this->phpexcel->getActiveSheet()->getStyle('C4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('C4')->getFill()->getStartColor()->setARGB('FF9ca2a1');            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('C4', 'Mã sản phẩm');                                             
            $this->phpexcel->getActiveSheet()->getStyle('C4')->applyFromArray($style);
            //Tên sản phẩm
            $this->phpexcel->getActiveSheet()->getStyle('D4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('D4')->getFill()->getStartColor()->setARGB('FF9ca2a1');            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('D4', 'Tên sản phẩm');             
            $this->phpexcel->getActiveSheet()->getStyle('D4')->applyFromArray($style);
            //Nhan hang
            $this->phpexcel->getActiveSheet()->getStyle('E4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('E4')->getFill()->getStartColor()->setARGB('FF9ca2a1');            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('E4', 'Nhãn hàng');             
            $this->phpexcel->getActiveSheet()->getStyle('E4')->applyFromArray($style);
            
            //Bao hanh
            $this->phpexcel->getActiveSheet()->getStyle('F4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('F4')->getFill()->getStartColor()->setARGB('FF9ca2a1');            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('F4', 'Bảo hành');             
            $this->phpexcel->getActiveSheet()->getStyle('F4')->applyFromArray($style);
            
            //Tinh nang noi bat
           /* $this->phpexcel->getActiveSheet()->getStyle('G4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('G4')->getFill()->getStartColor()->setARGB('FF9ca2a1');            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('G4', 'Phu kiện');             
            $this->phpexcel->getActiveSheet()->getStyle('G4')->applyFromArray($style);*/
            
            //Gia thi truong
            $this->phpexcel->getActiveSheet()->getStyle('H4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('H4')->getFill()->getStartColor()->setARGB('FF9ca2a1');            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('H4', 'Giá thị trường');             
            $this->phpexcel->getActiveSheet()->getStyle('H4')->applyFromArray($style);
            //Giảm giá
            $this->phpexcel->getActiveSheet()->getStyle('I4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('I4')->getFill()->getStartColor()->setARGB('FF9ca2a1');            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('I4', 'Giảm giá');             
            $this->phpexcel->getActiveSheet()->getStyle('I4')->applyFromArray($style);
            //Gia ban
            $this->phpexcel->getActiveSheet()->getStyle('J4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('J4')->getFill()->getStartColor()->setARGB('FF9ca2a1');            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('J4', 'Giá bán');             
            $this->phpexcel->getActiveSheet()->getStyle('J4')->applyFromArray($style);                              
            //Ma tinh
            $this->phpexcel->getActiveSheet()->getStyle('K4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('K4')->getFill()->getStartColor()->setARGB('FF9ca2a1');            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('K4', 'Mã tỉnh');             
            $this->phpexcel->getActiveSheet()->getStyle('K4')->applyFromArray($style);      

            // Lay danh sach hoc vien theo lop
            $style1 = array( 
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),             
                    'borders' => array(
                        'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF4cccf6'),
                        ),
                    ),
            );  
            
            $style_border_left = array( 
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),             
                    'borders' => array(
                        'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF4cccf6'),
                        ),
                    ),
            );
            $style_border_center = array( 
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),             
                    'borders' => array(
                        'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF4cccf6'),
                        ),
                        'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF4cccf6'),
                        ),
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF4cccf6'),
                        )
                    ),
            );  
            
            $style_gia = array( 
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),             
                    'borders' => array(
                        'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF4cccf6'),
                        ),
                        'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF4cccf6'),
                        ),
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF4cccf6'),
                        )
                    ),
            );                                 
            $i=5;
            $k=1;           
            foreach($list as $rs):    
           
            $nsx = $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$rs->manufactureid));
           // $tp  = $this->export->get_tangpham($rs->productid,$city_id);
          //  $tangpham = ($tp)?$tp->name:'';
                // STT 
                $this->phpexcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setName('Tahoma');
                $this->phpexcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setName('Tahoma');
                $this->phpexcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setName('Tahoma');
                $this->phpexcel->getActiveSheet()->getStyle('D'.$i)->getFont()->setName('Tahoma');
                $this->phpexcel->getActiveSheet()->getStyle('E'.$i)->getFont()->setName('Tahoma');
                $this->phpexcel->getActiveSheet()->getStyle('F'.$i)->getFont()->setName('Tahoma');
                $this->phpexcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('Tahoma');
                $this->phpexcel->getActiveSheet()->getStyle('H'.$i)->getFont()->setName('Tahoma');
                $this->phpexcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setName('Tahoma');
                $this->phpexcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setName('Tahoma');
                
                $this->phpexcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);
                $this->phpexcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(10);
                $this->phpexcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(10);
                $this->phpexcel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(10);
                $this->phpexcel->getActiveSheet()->getStyle('E'.$i)->getFont()->setSize(10);
                $this->phpexcel->getActiveSheet()->getStyle('F'.$i)->getFont()->setSize(10);
                $this->phpexcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(10);
                $this->phpexcel->getActiveSheet()->getStyle('H'.$i)->getFont()->setSize(10);
                $this->phpexcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setSize(10);
                $this->phpexcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setSize(10);
                

				
                $this->phpexcel->getActiveSheet()->getStyle('A'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $this->phpexcel->getActiveSheet()->getStyle('A'.$i)->getFill()->getStartColor()->setARGB('FFf9fbbf');                                         
                $this->phpexcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($style1);
                            
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $k);
                // ID SP                                          
                $this->phpexcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($style1);            
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('B'.$i, $rs->productid);             
                // MA SAN PHAM
                $this->phpexcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($style_border_left);
                 $this->phpexcel->setActiveSheetIndex(0)->setCellValue('C'.$i, $rs->barcode);
                 //Ten san pham
                 $this->phpexcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($style_border_center); 
                 $this->phpexcel->setActiveSheetIndex(0)->setCellValue('D'.$i, $rs->productname);
                 // Nhan hang
                 $this->phpexcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($style_border_center); 
                 $this->phpexcel->setActiveSheetIndex(0)->setCellValue('E'.$i, ($nsx)?$nsx->name:'');
                 
                 // Bao hanh
                 $this->phpexcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($style_border_center); 
                 $this->phpexcel->setActiveSheetIndex(0)->setCellValue('F'.$i, $rs->baohanh);  
                 // Tinh nang noi bat
                 /*$this->phpexcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($style_border_center); 
                 $this->phpexcel->setActiveSheetIndex(0)->setCellValue('G'.$i, $rs->phukien); */
                 // Gia thi truong
                 $this->phpexcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($style_gia); 
                 $this->phpexcel->getActiveSheet()->getStyle('H'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                 $this->phpexcel->getActiveSheet()->getStyle('H'.$i)->getFill()->getStartColor()->setARGB('FFf3f3f0'); 
                 $this->phpexcel->setActiveSheetIndex(0)->setCellValue('H'.$i, (count($list_p) > 0)?$rs->giathitruong:0); 
                 $this->phpexcel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('#,##0');
                 // Giam gia
                 $this->phpexcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($style_gia); 
                 $this->phpexcel->getActiveSheet()->getStyle('I'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                 $this->phpexcel->getActiveSheet()->getStyle('I'.$i)->getFill()->getStartColor()->setARGB('FFf9e595'); 
                 $this->phpexcel->setActiveSheetIndex(0)->setCellValue('I'.$i, (count($list_p) > 0)?$rs->giamgia:0);
                 $this->phpexcel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('#,##0'); 
                 
                 // Gia ban
                 $this->phpexcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($style_gia); 
                 $this->phpexcel->getActiveSheet()->getStyle('J'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                 $this->phpexcel->getActiveSheet()->getStyle('J'.$i)->getFill()->getStartColor()->setARGB('FFf3c2fe');  
                 $this->phpexcel->setActiveSheetIndex(0)->setCellValue('J'.$i, '=(H'.$i.'-I'.$i.')');
                 $this->phpexcel->getActiveSheet()->getStyle('J'.$i)->getNumberFormat()->setFormatCode('#,##0'); 
                 // Ma Tinh
                 $this->phpexcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($style_border_center); 
                 $this->phpexcel->setActiveSheetIndex(0)->setCellValue('K'.$i, $city_id);                               
                 
                 $this->phpexcel->getActiveSheet()->getRowDimension($i)->setRowHeight(18);
                // Bo mau

			
            $i++;
            $k++;           
            endforeach;   
            $style_bot = array(             
                    'borders' => array(
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF4cccf6'),
                        ),
                    ),
            );
            $j = 5+count($list);
            
            $this->phpexcel->getActiveSheet()->getStyle('A'.$j.':K'.$j)->applyFromArray($style_bot); 
                                
            $this->phpexcel->getActiveSheet()->mergeCells('A'.($j).':K'.($j)); 
            $this->phpexcel->getActiveSheet()->getStyle('A'.($j).':K'.($j))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('A'.($j).':K'.($j))->getFill()->getStartColor()->setARGB('FFFFFFFF');             
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('A'.($j), '');
            
            //set Font
            $this->phpexcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->phpexcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);

            // Witdh
            $this->phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
            $this->phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(9);
            $this->phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(17); 
            $this->phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);  
            $this->phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);  
            $this->phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);  
            $this->phpexcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);  
            $this->phpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(14);  
            $this->phpexcel->getActiveSheet()->getColumnDimension('I')->setWidth(14);  
            $this->phpexcel->getActiveSheet()->getColumnDimension('J')->setWidth(14);  

            $this->phpexcel->getActiveSheet()->getStyle('A4:K4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $this->phpexcel->getActiveSheet()->getStyle('A4:K4')->getFill()->getStartColor()->setARGB('FF4cccf6');
  
            $this->phpexcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
            $this->phpexcel->getActiveSheet()->getRowDimension(4)->setRowHeight(22);
 
            

            $this->phpexcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Tahoma');
            $this->phpexcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14); 
            $this->phpexcel->getActiveSheet()->getStyle('A2')->getFont()->setName('Tahoma');
            $this->phpexcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(10);
            

            // Rename sheet
             $this->phpexcel->getActiveSheet()->setTitle('Thongke');

             
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
             $this->phpexcel->setActiveSheetIndex(0);

            $date = date('h_i_s_d_m_Y',time());
            // Redirect output to a client’s web browser (Excel5)
            $filename = vnit_change_title('danh sach san pham nhom hang: '.$nhomhangs);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter( $this->phpexcel, 'Excel5');
            $objWriter->save('php://output');
            exit;            
            
            /*$this->_templates['page'] = 'export';
            $this->load->view($this->_templates['page'],$data);*/
        }
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
}
