<?php
class phanquyen_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_all_user(){
        $this->member = $this->load->database('member', TRUE); 
        $this->member->where('group_id',17);
        return $this->member->get('user')->result(); 
        
    }
    function save_phanquyen(){
        $ar_id = $this->input->post('ar_id');
        $user_id = $this->input->post('user_id');

        $this->vdb->delete('phanquyen_user',array('user_id'=>$user_id));
        for($i = 0; $i < sizeof($ar_id);$i++){
            if($ar_id[$i]){
                
                $function =  $this->vdb->find_by_id('phanquyen_chucnang',array('function_id'=>$ar_id[$i]));
                $root = $this->vdb->find_by_id('phanquyen',array('id'=>$function->phanquyen_id));
                $vdata['menu'] = $this->vdb->find_by_id('phanquyen',array('id'=>$root->parentid))->component;
                if($root->module != '0'){
                    $vdata['uri1'] = $root->module;
                    $vdata['uri2'] = $root->component;
                    $vdata['uri3'] = $function->function_name;
                }else{
                    $vdata['uri1'] = $root->component;
                    $vdata['uri2'] = $function->function_name;
                    $vdata['uri3'] = '';
                }
                
                $vdata['user_id'] = $user_id;
                $vdata['phanquyen_id'] = $root->id;
                $vdata['component'] = $root->component;
                $vdata['module'] = $root->module;
                $vdata['function_id'] = $ar_id[$i];
                $vdata['function_name'] = $function->function_name;
                $this->vdb->update('phanquyen_user',$vdata);
                
                 //***********write ************************************************
               
                 $str = "";
                 $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File config_bannertop language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";		       		      
				   $str .= "\n\$config['user_id'] = '$user_id';";
  		           $addPrice  = $this->input->post('addPrice');
		           $editPrice = $this->input->post('editPrice'); 
		            
		            $str .= "\n\$config['addPrice'] = '$addPrice';";
		            $str .= "\n\$config['editPrice'] = '$editPrice';";		           
		       
		        $str .= "\n\n/* End of file config_bannertop*/";        
		        write_file(ROOT_ADMIN.'config/config_price_'.$user_id.'.php', $str);
                
                //***********************************************************
                
		        
            }
        }
    }
    
    
    
    
    function get_all_danhmuc($parentid = 0){
        $this->db->where('parentid',$parentid);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result();
    }
    
    function check_dm($user_id, $catid){
        $this->db->where('user_id',$user_id);
        $this->db->where('catid',$catid);
        return $this->db->get('phanquyen_danhmuc')->row();
    }
}
