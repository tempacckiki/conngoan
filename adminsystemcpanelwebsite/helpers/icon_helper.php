<?php

  // Toolbar Edit
    function icon_edit($link){
        $CI = get_instance();
        if($CI->permit->get_permit_icon($link)){
            return '<a href="'.site_url($link).'" title="Cập nhật"><img src="'.base_url().'templates/icon/edit.gif"></a>';
        }else{
            return false;
        }
    }
  
    // Toolbar Add
    function icon_add($link){
         $CI = get_instance();
         if($CI->permit->get_permit_icon($link)){ 
             return 1;
         }else{
             return 0;
         }
        //return '<a href="'.site_url($link).'" title="Thêm mới"><img src="'.base_url().'templates/icon/add_small.png"></a>';
    }
    function icon_add_small($link){
         $CI = get_instance();
         if($CI->permit->get_permit_icon($link)){ 
             return '<a href="'.site_url($link).'" title="Thêm mới"><img src="'.base_url().'templates/icon/add_small.png"></a>';
         }
    }
    function icon_add1($link){
         $CI = get_instance();
         if($CI->permit->get_permit_icon($link)){ 
             return '<a href="'.site_url($link).'" title="Thêm mới"><img src="'.base_url().'templates/icon/add_small.png"></a>';
         }
    }
    
    function icon_nsx($link){
        return '<a href="'.site_url($link).'" title="Sắp xếp nhà sản xuất"><img src="'.base_url().'templates/icon/order.png"></a>';
    }
    
    // Action Del
    function icon_dels($link){
        $CI = get_instance();
        if($CI->permit->get_permit_icon($link)){
            return 1;
        }else{
            return 0;
        }
    }
    // Action Active
    function icon_active($table,$field,$id,$status,$link = ''){
        $CI = get_instance();
        if($link == ''){
            if($status==1){
                      $rep ='un_';
            }else{
                      $rep ='';
            }
            return  '<a href="javascript:;" onclick="publish('.$table.','.$field.','.$id.','.$status.',\''.$link.'\');" title="Bật | Tắt"><img src="'.base_url().'templates/icon/'.$rep.'lock.png"></a>';
        }else if($CI->permit->get_permit_icon($link)){
            if($status==1){
                      $rep ='un_';
            }else{
                      $rep ='';
            }
            return  '<a href="javascript:;" onclick="publish('.$table.','.$field.','.$id.','.$status.',\''.$link.'\');" title="Bật | Tắt"><img src="'.base_url().'templates/icon/'.$rep.'lock.png"></a>';
        }
    }

    // Action View
    function icon_view($link){
        return '<a  href="'.site_url($link).'" title="Xem"><img src="'.base_url().'templates/icon/view.png"></a>';
    }  
    // Action Sangiare
    function icon_sangiare($link){
        return '<a href="'.site_url($link).'" title="Phiên mua rẻ"><img src="'.base_url().'templates/icon/sangiare.png"></a>'; 
    }
    // Action Del
    function icon_del($link){
        $CI = get_instance();
        if($CI->permit->get_permit_icon($link)){
            return '<a class="delete_record" href="'.site_url($link).'" title="Xóa"><img src="'.base_url().'templates/icon/dels_status.png"></a>';
        }
    }

    // Action Delete status
    function icon_del_status($link){
        return '<a class="delete_record" href="'.site_url($link).'" title="Xóa"><img src="'.base_url().'templates/icon/dels_status.png"></a>';
    }

    // Action Order
    function action_order(){
        return '<a  style="overflow: hidden;padding-top: 5px;position: relative;top: 4px;" onclick="save_order();" href="javascript:;"><span><img align="mid" src="'.base_url().'templates/icon/ordering.png"></span></a>';     
    }

    // Toolbar Del
    function action_del(){
        $CI =& get_instance(); 
        return '<a class="del" onclick="return action_del();"><span>Xóa</span></a>';
    }

    // Toolbar Save
    function action_save(){
        return '<a class="save" onclick="return action_save();"><span>'.$value.'</span></a>'; 
    }

    // Toolbar Apply
    function action_apply(){
      
    } 

?>
