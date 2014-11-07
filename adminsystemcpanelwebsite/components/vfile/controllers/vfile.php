<?php
class vfile extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('vfile_model','vfile');
        $this->load->model('shop_model','shop');
        $this->load->helper('directory');
        
    }
    
    function index(){
        $data['title'] = 'Quản lý File';
        $this->session->set_userdata('root_dir','data/images');
        $this->session->set_userdata('root_dir_thumb','data/thumbs_/images');
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function get_dir(){
        $data['title'] = 'Dir';
        $path = $this->input->post('path');
        
        $data['path'] = $path;
        $this->_templates['page'] = 'get_dir';
        $this->load->view($this->_templates['page'],$data);
    }
    
    function vfile_dir(){
        $data['title'] = 'Quản lý File';
        $this->session->set_userdata('root_dir','data/images');
        $this->session->set_userdata('root_dir_thumb','data/thumbs_/images');
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data,'vfile');
    }
    
    function opener(){
        $data['title'] = 'Quản lý File';
        $this->session->set_userdata('root_dir','data/images');
        $this->session->set_userdata('root_dir_thumb','data/thumbs_/images');
        $this->_templates['page'] = 'opener';
        $this->templates->load($this->_templates['page'],$data,'vfile');
    }
    
    function vupload(){
        $dir_upload = $_SERVER['DOCUMENT_ROOT'].$this->input->post('folder');
        $dir_upload = str_replace(array('vfile/','vfile_dir/'),array('',''),$dir_upload);
        $this->load->helper('img');
        $dir = str_replace('foldersystemcpanel/','',$dir_upload).'/';
        $size=$_FILES['Filedata']['size'];
        if($size > 204857600)
        {
            echo "file_biger";
            unlink($_FILES['Filedata']['tmp_name']);
        }            
        $filename = stripslashes($_FILES['Filedata']['name']);
        $i = strrpos($filename,".");
        if (!$i) { return ""; }
        $l = strlen($filename) - $i;
        $extension = substr($filename,$i+1,$l);                 
        
        $file_name = strtolower(str_replace($extension,'',$filename));
        $file_name =vnit_change_title($file_name).'.';
        $extension = strtolower($extension); 

        $filename = $dir.$file_name.$extension;
        if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $filename)) {   
            $folder_new = str_replace(array("foldersystemcpanel/","vfile/","vfile_dir/"),array('','',''),$this->input->post('folder'));
            
            $dir_new = str_replace('data','data/thumbs_',$dir);
            // Return seg[4];
            $seg_4 = str_replace('foldersystemcpanel/','',$folder_new).'/'.$file_name.$extension;
            
            if($extension =='jpg' || $extension =='jpeg' || $extension =='png' || $extension =='gif'){
                
                $dir_new_file = $dir_new.$file_name.$extension;
                vnit_resize_image($filename,$dir_new_file,80,80,false); 

                echo str_replace(array('data','foldersystemcpanel/'),array('data/thumbs_',''),$folder_new).'/'.$file_name.$extension.'|'.$file_name.$extension.'|'.$extension.'|'.$seg_4;
            }else{
                echo '/'.$folder_new.'/'.$file_name.$extension.'|'.$file_name.$extension.'|'.$extension.'|'.$seg_4;
            }    
            
        } else {
            echo '111|'.$dir_upload.'|ssss';
        }        
        sleep(1);

    }
    
    function tree(){
        $this->_templates['page'] = 'tree';
        $this->load->view($this->_templates['page']);
    }
    function edit_folder(){
        $id = $this->input->post('id');
        $rs = $this->vdb->find_by_id('vfile',array('id'=>$id));
        echo json_encode($rs);
    }
    
    function save_edit_folder(){
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $rs = $this->vdb->find_by_id('vfile',array('id'=>$id));
        $root = explode('/',$rs->path);
        rename(ROOT.'data/'.$rs->path,ROOT.'data/'.$root[0].'/'.$name);
        rename(ROOT.'data/thumbs_/'.$rs->path,ROOT.'data/thumbs_/'.$root[0].'/'.$name);
        
        $vdata['name'] = $name;
        $vdata['path'] = $root[0].'/'.$name;
        $this->vdb->update('vfile',$vdata,array('id'=>$id));
    }

    
    function save_add_folder(){
        $parentid = $this->input->post('parentid');
        $name = $this->input->post('name');
        $rs = $this->vdb->find_by_id('vfile',array('id'=>$parentid));
        $root = explode('/',$rs->path);
        mkdir(ROOT.'data/'.$rs->path.'/'.$name,0775);
        mkdir(ROOT.'data/thumbs_/'.$rs->path.'/'.$name,0775);
        
        
        $vdata['name'] = $name;
        $vdata['parentid'] = $parentid;
        $vdata['path'] = $rs->path.'/'.$name;
        $this->vdb->update('vfile',$vdata);
    }
    
    function delete_folder(){
        $id = $this->input->post('id');
        if($id == 1 || $id == 2 || $id == 3){
            $data['error'] = 1;
            $data['msg'] = 'Không thể xóa thư mục gốc này';
        }else{
            $rs = $this->vdb->find_by_id('vfile',array('id'=>$id));
            $this->deletedirectory(ROOT.'data/'.$rs->path);
            $this->deletedirectory(ROOT.'data/thumbs_/'.$rs->path);
            $this->vdb->delete('vfile',array('id'=>$id));
            $data['error'] = 0;
            $data['msg'] = 'Xóa thành công';
        }
        echo json_encode($data);
    }
    
    function deletedirectory($dir) {
        if (!file_exists($dir)) return true;
        if (!is_dir($dir) || is_link($dir)) return unlink($dir);
            foreach (scandir($dir) as $item) {
                if ($item == '.' || $item == '..') continue;
                if (!$this->deleteDirectory($dir . "/" . $item)) {
                    chmod($dir . "/" . $item, 0777);
                    if (!$this->deleteDirectory($dir . "/" . $item)) return false;
                };
            }
            return rmdir($dir);
    }
    function delete(){
        $file = $this->input->post('file');
        $file_thumb = str_replace('data','data/thumbs_',$file);
        if(unlink($_SERVER['DOCUMENT_ROOT'].$file)){
            $data['error'] = 0;
            $type = end(explode('.',$file));
            if($type=='jpg' || $type =='png' || $type =='gif' || $type =='jpeg'){
                unlink($_SERVER['DOCUMENT_ROOT'].$file_thumb);
            }
        }else{
            $data['error'] = 1;
        }
        echo json_encode($data);
    }
    
/******
* Upload san pham
*/
    function uploader_rotare(){
        //session_start();
        $dir_rotare = ROOT.'data/img_rotare';  
        $productid = $this->input->post('productid');
        $rs = $this->vdb->find_by_id('shop_product',array('productid'=>$productid));
        $order = $this->shop->get_max_order_img_rotare($productid);
        $ordering = $order + 1;
        $product_img_name = $rs->producturl.'-'.$ordering;
        
        if(!is_dir($dir_rotare.'/'.$productid)){
            mkdir($dir_rotare.'/'.$productid);
            chmod($dir_rotare.'/'.$productid,0777);
        }
        
        $dir = ROOT.'data/img_rotare/'.$productid.'/'; 
        
        $size=$_FILES['Filedata']['size'];
        if($size>204857600)
        {
            echo "error";
            unlink($_FILES['Filedata']['tmp_name']);
        }            
        $filename = stripslashes($_FILES['Filedata']['name']);
        $extension = end(explode('.',$filename));
        $filename = $dir.$product_img_name.'.'.$extension;
        $filename_add = 'data/img_rotare/'.$productid.'/'.$product_img_name.'.'.$extension;
        $file_ext = $product_img_name.'.'.$extension;
        if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $filename)) {
            $vimg['productid'] = $productid;
            $vimg['imagepath'] = $filename_add;
            $vimg['ordering'] = $ordering;
            $idimg = $this->vdb->update('shop_img_rotare',$vimg);
                            
            echo $idimg.'|'.$filename_add.'|'.$ordering;
        } else {
            echo 'error';
        }
        sleep(1);

    }
    function uploader_rotare_tmpl(){
        session_start();
        $dir_rotare = ROOT.'data/img_rotare_tmpl';  
        $productid = $this->input->post('productid');
        //$rs = $this->vdb->find_by_id('shop_product',array('productid'=>$productid));
        $order = $this->shop->get_max_order_img_rotare_tmpl($productid);
        $ordering = $order + 1;
        $product_img_name = 'fyi_vn_'.$productid.'-'.$ordering;
        
        if(!is_dir($dir_rotare.'/'.$productid)){
            mkdir($dir_rotare.'/'.$productid);
            chmod($dir_rotare.'/'.$productid,0777);
        }
        
        $dir = ROOT.'data/img_rotare_tmpl/'.$productid.'/'; 
        
        $size=$_FILES['Filedata']['size'];
        if($size>204857600)
        {
            echo "error";
            unlink($_FILES['Filedata']['tmp_name']);
        }            
        $filename = stripslashes($_FILES['Filedata']['name']);
        $extension = end(explode('.',$filename));
        $filename = $dir.$product_img_name.'.'.$extension;
        $filename_add = 'data/img_rotare_tmpl/'.$productid.'/'.$product_img_name.'.'.$extension;
        $file_ext = $product_img_name.'.'.$extension;
        if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $filename)) {
            $vimg['productid'] = $productid;
            $vimg['imagepath'] = $filename_add;
            $vimg['ordering'] = $ordering;
            $vimg['random'] = $productid;
            $idimg = $this->vdb->update('shop_img_rotare_temp',$vimg);
                            
            echo $idimg.'|'.$filename_add.'|'.$ordering;
        } else {
            echo 'error';
        }
        sleep(1);
    }
}
