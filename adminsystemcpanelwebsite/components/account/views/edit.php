<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<input type="hidden" name="user_id" value="<?php echo $rs->user_id?>">
<table class="form">   
    <tr>
        <td class="label">Nhóm thành viên</td>
        <td>
            <select name="user[group_id]">
            <?php foreach($this->group as $g):?>
                <option value="<?php echo $g->group_id?>" <?php echo ($rs->group_id == $g->group_id)?'selected="selected"':''?>><?php echo $g->group_name?></option>
            <?php endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Tên thành viên</td>
        <td><input type="text" class="w200" name="user[fullname]" value="<?php echo $rs->fullname?>"></td>
    </tr>
    <tr>
        <td class="label">Email đăng nhập</td>
        <td><input type="text" class="w200" name="user[email]" value="<?php echo $rs->email?>"></td>
    </tr>  
    <tr>
        <td class="label">Mật khẩu</td>
        <td><input type="password" class="w200" name="password" value=""></td>
    </tr>  
    <tr>
        <td class="label">Mật khẩu nhắc lại</td>
        <td><input type="password" class="w200" name="re_password" value=""></td>
    </tr>
    <tr>
        <td class="label">Điện thoại</td>
        <td><input type="text" class="w200" name="user[phone]" value="<?=$rs->phone?>"></td>
    </tr> 
    <tr>
        <td class="label">Địa chỉ</td>
        <td><input type="text" class="w200" name="user[address]" value="<?=$rs->address?>"></td>
    </tr>
    <tr>
        <td class="label">Tỉnh/ Thành phố</td>
        <td>
            <select name="user[city_id]" id="city_id" style="width: 205px;">
                <option value="">Chọn Tỉnh/ Thành phố</option>
                <?foreach($listcity as $val){?>
                <option value="<?=$val->city_id?>" <?=($rs->city_id == $val->city_id)?'selected="selected"':''?>><?=$val->city_name?></option>
                <?}?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Quận, Huyện</td>
        <td>
            <select name="user[district_id]" id="get_district" style="width: 205px;">
                <option value="">Chọn Quận, Huyện</option> 
                <?
                $listdistrict = $this->vdb->find_by_list('city',array('parentid'=>$rs->city_id));
                foreach($listdistrict as $val){?>
                <option value="<?=$val->city_id?>" <?=($rs->district_id == $val->city_id)?'selected="selected"':''?>><?=$val->city_name?></option>
                <?}?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Kích hoạt</td>
        <td><input type="radio" name="user[published]" value="0" <?php echo ($rs->published == 0)?'checked="checked"':'';?>> Không 
        <input type="radio" name="user[published]" value="1" <?php echo ($rs->published == 1)?'checked="checked"':'checked="checked"';?>>Có</td>
    </tr>

</table>
<?php echo form_close();?>
