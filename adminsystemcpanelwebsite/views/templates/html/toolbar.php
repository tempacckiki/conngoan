<div id="toolbar" class="toolbar-list">
<ul>
    <?php if(isset($save)){?>
    <li id="toolbar-apply" class="button">
        <a class="toolbar" onclick="return action_apply();" href="javascript:;">
            <span class="icon-32-apply"></span>Áp dụng
        </a>
    </li>
    <?php }?>
    
    <?php if(isset($apply)){?>
    <li id="toolbar-save" class="button">
        <a class="toolbar" onclick="return action_save();" href="javascript:;">
        <span class="icon-32-save">
        </span>
        Lưu
        </a>
    </li>
    <?php }?>
    
    <?php if(isset($cancel)){?>
    <li id="toolbar-cancel" class="button">
        <a class="toolbar" href="<?php echo site_url($cancel)?>">
        <span class="icon-32-cancel">
        </span>
        Hủy
        </a>
    </li>
    <?php }?>
    
    <?php if(isset($delete)){
    if($delete == 1 || $this->session->userdata('group_id') == 18){
    ?>
    <li id="toolbar-cancel" class="button">
        <a class="toolbar" onclick="return action_del();" href="javascript:;">
        <span class="icon-32-trash">
        </span>
        Xóa
        </a>
    </li>
    <?php }}?>    
    
    <?php if(isset($add)){
    $add = explode('|',$add);
    $add_link = $add[0];
    if( (isset($add[1]) && $add[1] == 1) || $this->session->userdata('group_id') == 18){
    ?>                  
    <li id="toolbar-new" class="button">
        <a class="toolbar" href="<?=site_url($add_link)?>">
        <span class="icon-32-new">
        </span>
        Thêm mới
        </a>
    </li>
    <?php }}?>
</ul>
</div>