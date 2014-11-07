<h3 style="font-size: 17px;margin-bottom: 10px;"><?=$this->vdb->find_by_id('shop_cat',array('catid'=>$this->uri->segment(4)))->catname?></h3>
<div>
    Chọn nhóm thuộc tính
    <select id="features_id">
        <?foreach($listfea as $val):?>
        <option value="<?=$val->feature_id?>~<?=$val->description?>"><?=$val->description?></option>
        <?endforeach;?>
    </select>
    <input type="button" value="Thêm" onclick="add_fea();"> <a href="<?=site_url('features/manage/feature_cat/'.$this->uri->segment(5))?>"><b>Quay lại</b></a>
</div>
<div style="width: 500px;margin-top: 10px;">
<?=form_open(uri_string(),array('id'=>'feature'))?>
<input type="hidden" name="catid" value="<?=$this->uri->segment(4)?>">
<table class="admindata">
    <thead>
        <tr>
            <th>Nhóm thuộc tính</th>
            <th style="width: 50px;">Sắp xếp</th>
            <th style="width: 20px;">Xóa</th>
        </tr>
    </thead>
    <tbody>
    <?foreach($list as $rs){?>
        <tr class="row1" id="<?=$rs->feature_id?>">
            <td><?=$rs->description?> <input type="hidden" name="ar_id[]" value="<?=$rs->feature_id?>"></td>
            <td><input type="text" name="order_<?=$rs->feature_id?>" style="width: 50px;" value="<?=$rs->ordering?>"></td>
            <td align="center"><a href="javascript:;" onclick="remove_fea(<?=$rs->feature_id?>)">x</a></td>
        </tr>
    <?}?>
    </tbody>
</table>
<div style="margin-top: 10px;"><input type="submit" value="Lưu"></div>
<?=form_close()?>
</div>
<script type="text/javascript">
    function add_fea(){
        var features  = $("#features_id").val();
        ar_fea = features.split("~"); 
        var msg_e = 0;
        $("table.admindata tbody tr").each(function() { 
            id_fea = $(this).attr("id");
            if(id_fea == ar_fea[0]){
                msg_e = 1;
            }
        });
        if(msg_e == 1){
            jAlert('Nhóm thuộc tính này đã tồn tại','Thông báo');
            return false;
        }
        var html = '<tr class="row1" id="'+ar_fea[0]+'">';
             html +='<td>'+ar_fea[1]+'<input type="hidden" name="ar_id[]" value="'+ar_fea[0]+'"></td>';
             html +='<td><input type="text" style="width: 50px;" name="order_'+ar_fea[0]+'" value="1"></td>';
             html +='<td align="center"><a href="javascript:;" onclick="remove_fea('+ar_fea[0]+')">x</a></td>';
             html +='</tr>';
        $("table.admindata tbody").append(html);
    }
    
    function remove_fea(id){
        $("table.admindata tbody tr#"+id).remove();
    }
</script>