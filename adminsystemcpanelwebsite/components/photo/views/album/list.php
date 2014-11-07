<?echo form_open('photo/dels',  array('id' => 'admindata'));?> 
<?$catid = (int)$this->uri->segment(3)?>
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="4">
                Xem Album theo chuyên mục
                <select name="catid" onchange="window.open(this.value,'_self');">
                    <option value="<?=base_url().'photo/listalbum/0'?>">Tất cả chuyên mục</option>
                    <?foreach($listcat as $val):?>
                    <option value="<?=base_url().'photo/listalbum/'.$val->catid?>" <?=($val->catid == $this->uri->segment(3))?'selected="selected"':''?>><?=$val->catname?></option>
                    <?endforeach;?>
                </select>
            
            </th>
        </tr>
        <tr>
            <th class="head" colspan="4">
                Hiện có <?=$num?> Album <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('photo/listalbum/'.$catid.'/0/albumid/asc','ID')?></th>
            <th><?=vnit_order('photo/listalbum/'.$catid.'/0/album_name/asc','Tên Album')?></th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->albumid?>"></td>
        <td><?=$rs->albumid?></td>
        <td><?=$rs->album_name?></td>
        <td align="center">
            <?=icon_edit('photo/edit/'.$rs->albumid)?>
            <span id="publish<?=$rs->albumid?>"><?=icon_active("'album'","'albumid'",$rs->albumid,$rs->IsActive)?></span>
            <?=icon_del('photo/del/'.$rs->albumid.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>        
    <?
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="4">
                    Hiện có <?=$num?> Album <span class="pages"><?=$pagination?></span>
                </td>
            </tfoot>    
</table>
<?=form_close()?>
