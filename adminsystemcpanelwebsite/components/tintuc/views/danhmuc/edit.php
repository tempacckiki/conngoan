<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<input type="hidden" name="catid" value="<?=$rs->catid?>">
<table class="form">
    <tr>
        <td class="label">Tiêu đề</td>
        <td><input type="text" name="cat[catname]" value="<?php echo $rs->catname?>" style="width: 300px;"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="radio" name="cat[published]" value="0" <?php echo ($rs->published == 0)?'checked="checked"':'';?>> Không 
        <input type="radio" name="cat[published]" value="1" <?php echo ($rs->published == 1)?'checked="checked"':'';?>>Có</td>
    </tr>
    <tr>
        <td class="label">Danh mục</td>
        <td>
            <select name="cat[parentid]" style="width: 305px;" onchange="change_productcat(this.value)">
                <option value="0">== Là danh mục chính ==</option>
                <?foreach($listcat as $val):?>
                <option value="<?php echo $val->catid?>" <?php echo ($val->catid == $rs->parentid)?'selected="selected"':'';?>><?php echo $val->catname?></option>
                <?endforeach;?>
            </select>
            <div id="show_productcat" style="display: <?=($rs->parentid == 0)?'block':'none'?>;">
                <div style="padding: 5px 0px;">ID danh mục sản phẩm</div>
                <input type="text" name="productcat" value="<?=$rs->productcat?>" style="width: 300px;">
                <div class="show_notice_small" style="width: 300px;">Danh mục sản phẩm được ngăn cách bởi dấu phẩy (,)<br />Ví dụ: 123, 4564, 8, 5</div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td><input type="text" name="cat[ordering]" value="<?=$rs->ordering?>" style="width: 300px;"></td>
    </tr>
    <tr>
        <td class="label">Miêu tả</td>
        <td>
            <textarea style="width: 300px;height: 50px;" name="cat[desc]"><?=$rs->desc?></textarea>
        </td>
    </tr>
    <tr>
        <td class="label">Từ khóa</td>
        <td>
            <textarea style="width: 300px;height: 50px;" name="cat[keyword]"><?=$rs->keyword?></textarea>
        </td>
    </tr>
</table>
<?php echo form_close();?>
<script type="text/javascript">
function change_productcat(catid){
    if(catid == 0){
        $("#show_productcat").show();
    }else{
        $("#show_productcat").hide();    
    }
}
</script>