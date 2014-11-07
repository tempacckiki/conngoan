<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<input type="hidden" name="user_id" value="0">
<table class="form">   
    <tr>
        <td class="label">Nhóm thành viên</td>
        <td>
            <select name="user[group_id]">
            <?php foreach($this->group as $g):?>
                <option value="<?php echo $g->group_id?>"><?php echo $g->group_name?></option>
            <?php endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Tên thành viên</td>
        <td><input type="text" class="w200" name="user[fullname]" value="<?php echo set_value('user[fullname]')?>"></td>
    </tr>
    <tr>
        <td class="label">Email</td>
        <td><input type="text" class="w200" name="user[email]" value="<?php echo set_value('user[email]')?>"></td>
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
        <td><input type="text" class="w200" name="user[phone]" value=""></td>
    </tr> 
    <tr>
        <td class="label">Địa chỉ</td>
        <td><input type="text" class="w200" name="user[address]" value=""></td>
    </tr>
    <tr>
        <td class="label">Tỉnh/ Thành phố</td>
        <td>
            <select name="user[city_id]" id="city_id" style="width: 205px;">
                <option value="">Chọn Tỉnh/ Thành phố</option>
                <?foreach($listcity as $val){?>
                <option value="<?=$val->city_id?>"><?=$val->city_name?></option>
                <?}?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Quận, Huyện</td>
        <td>
            <select name="user[district_id]" id="get_district" style="width: 205px;">
                <option value="">Chọn Quận, Huyện</option> 
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Kích hoạt</td>
        <td><input type="radio" name="user[published]" value="0" <?php echo (set_value('user[published]') == 0)?'checked="checked"':'';?>> Không 
        <input type="radio" name="user[published]" value="1" <?php echo (set_value('user[published]') == 1)?'checked="checked"':'checked="checked"';?>>Có</td>
    </tr>

</table>
<?php echo form_close();?>
