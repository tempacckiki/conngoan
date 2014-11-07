<?echo form_open('giamgia/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="9">
                Hiện có <?=count($list)?> mã mầu 
            </th>
        </tr>
        <tr>
            <th class="id">ID</th>
            <th style="width: 30px;">Mã mầu</th>
            <th>Tên</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">

        <td><?=$rs->icolor?></td>
        <td><img src="<?=base_url_site()?>data/iconcolor/<?=$rs->images?>" alt=""></td>
        <td><?=$rs->color?></td>
        <td align="center">
            <?=icon_edit('icolor/edit/'.$rs->icolor)?>
            <?=icon_del('icolor/del/'.$rs->icolor)?>
        </td>
    </tr>        
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="9">
            Hiện có <?=count($list)?> mã mầu
        </td>
    </tfoot>    
</table>
<?=form_close()?>
