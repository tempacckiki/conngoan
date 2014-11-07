<?echo form_open(uri_string(),  array('id' => 'admindata'));?> 
<input type="hidden" name="catid" value="<?=$this->uri->segment(3)?>">
<table class="admindata" align="left" style="width: 400px;">
    <thead>
        <tr>
            <th>Tên Hãng sản xuất</th>
            <th style="width: 50px;">Sắp xếp</th>
        </tr>
    </thead>
    <?
    $i = 1;
    $k = 1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td>
            <?=$rs->name?>
            <input type="hidden" name="ar_id[]" value="<?=$rs->manufactureid?>">
        </td>
        <td><input type="text" name="id_<?=$rs->manufactureid?>" value="<?=$rs->ordering?>" style="width: 50px;text-align: center;"></td>
    </tr>
    <?
    $i++;
    $k = 1 - $k;
    endforeach;?>
</table>
<?=form_close();?>