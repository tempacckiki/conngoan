<script type="text/javascript" src="<?=base_url()?>components/createmenu/views/esset/interface-1.2.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/createmenu/views/esset/inestedsortable.js"></script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>components/createmenu/views/esset/menu.css?v=2.0" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
/*
$('#createmenu').NestedSortable(
    {
    accept: 'page-item2',
    opacity: .8,
    helperclass: 'helper',
    rightToLeft: true,
    nestingPxSpace: '60', 
    currentNestingClass: 'current-nesting'
    }
);  
*/    
$(".checkbox").click(function(){
    id = $(this).attr('id');
    thuoctinh = $(this).attr('thuoctinh');
    checkbox = $(this).attr('checked');
    
    if(checkbox == 'checked'){
        $(".col_"+id).hide();
        $("#"+thuoctinh).show();
    }else{
        $(".col_"+id).show();    
    }
})
});
</script>
<div>
    Chọn Danh mục chính
    <select onchange="window.open(this.value,'_self');">
        <option value="<?=site_url('createmenu/ds')?>">Chọn danh mục</option>
        <?foreach($listcat as $rs):?>
        <option value="<?=site_url('createmenu/edit/'.$rs->catid)?>" <?=($rs->catid == $catid)?'selected="selected"':''?>><?=$rs->catname?></option>
        <?endforeach;?>
    </select>
</div>
<?=form_open(uri_string(),array('id'=>'admindata'))?>
<input type="hidden" name="catid" value="<?=$catid?>">
<ul class="menu" id="createmenu">
    <li>
        <div>Col 1<input type="hidden" name="ar_id[]" value="1"></div>
        <ul>
            <?foreach($list as $val):
            $check = $this->mmenu->check($catid, 1, $val->catid);
            $checkcat = $this->mmenu->checkcatid($val->catid,$catid);

            ?>
            <li class="col_<?=$val->catid?>" id="col1_<?=$val->catid?>" style="<?=($checkcat)?($check)?'display:block;':'display:none;':''?>">
                <input type="checkbox" <?=($check)?'checked="checked"':''?> name="ar_id_1[]" value="<?=$val->catid?>" thuoctinh="col1_<?=$val->catid?>" id="<?=$val->catid?>" class="checkbox"><?=$val->catname?>
            </li>
            <?endforeach;?>
        </ul>
    </li>
    <li>
        <div>Col 2<input type="hidden" name="ar_id[]" value="2"></div>
        <ul class="page-list">
            <?foreach($list as $val):
            $check = $this->mmenu->check($catid, 2, $val->catid);
            $checkcat = $this->mmenu->checkcatid($val->catid,$catid);  
            ?>
            <li class="col_<?=$val->catid?>" id="col2_<?=$val->catid?>" style="<?=($checkcat)?($check)?'display:block;':'display:none;':''?>">

                <input type="checkbox" <?=($check)?'checked="checked"':''?> name="ar_id_2[]" value="<?=$val->catid?>" thuoctinh="col2_<?=$val->catid?>" id="<?=$val->catid?>" class="checkbox"><?=$val->catname?>
            </li>
            <?endforeach;?>
        </ul>
    </li>
    <li>
        <div>Col 3<input type="hidden" name="ar_id[]" value="3"></div>
        <ul>
            <?foreach($list as $val):
            $check = $this->mmenu->check($catid, 3, $val->catid); 
            $checkcat = $this->mmenu->checkcatid($val->catid,$catid); 
            ?>
            <li class="col_<?=$val->catid?>" id="col3_<?=$val->catid?>" style="<?=($checkcat)?($check)?'display:block;':'display:none;':''?>">
                <input type="checkbox" <?=($check)?'checked="checked"':''?> name="ar_id_3[]" value="<?=$val->catid?>" thuoctinh="col3_<?=$val->catid?>" id="<?=$val->catid?>" class="checkbox"><?=$val->catname?>
            </li>
            <?endforeach;?>
        </ul>
    </li>
    <li>
        <div>Col 4<input type="hidden" name="ar_id[]" value="4"></div>
        <ul>
            <?foreach($list as $val):
            $check = $this->mmenu->check($catid, 4, $val->catid);
            $checkcat = $this->mmenu->checkcatid($val->catid,$catid);  
            ?>
            
            <li class="col_<?=$val->catid?>" id="col4_<?=$val->catid?>" style="<?=($checkcat)?($check)?'display:block;':'display:none;':''?>">
                <input type="checkbox" <?=($check)?'checked="checked"':''?>  name="ar_id_4[]" value="<?=$val->catid?>" thuoctinh="col4_<?=$val->catid?>" id="<?=$val->catid?>" class="checkbox"><?=$val->catname?>
            </li>
            <?endforeach;?>
        </ul>
    </li>
</ul>
<?=form_close()?>