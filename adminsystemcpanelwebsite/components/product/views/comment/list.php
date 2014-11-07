<?echo form_open('product/shop/delscomment',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">

<?$uri3 = (int)$this->uri->segment(3)?>
<?$uri4 = (int)$this->uri->segment(4)?>
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="6">
                Hiện có <?=$num?> bình luận <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('product/shop/listcomment/0/commentid/asc','ID')?></th>
            <th><?=vnit_order('product/shop/listcomment/0/name/asc','Họ tên')?></th>
            <th>Nội dung</th>
            <th style="width: 100px;"><?=vnit_order('product/shop/listcomment/0/add_date/asc','Ngày')?></th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->commentid?>"></td>
        <td><?=$rs->commentid?></td>
        <td><?=$rs->fullname?></td>
        <td><?=vnit_cut_string($rs->content,100)?></td>
        <td><?=date('d/m/Y',$rs->add_date)?></td>
        <td align="center">
            <?=icon_edit('product/shop/editcomment/'.$rs->commentid.'/'.$this->uri->segment(4))?>
            <span id="publish<?=$rs->commentid?>"><?=icon_active("'shop_comment'","'commentid'",$rs->commentid,$rs->published,'product/shop/published')?></span>
            <?=icon_del('product/shop/delcomment/'.$rs->commentid.'/'.$this->uri->segment(4))?>        
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="6">
            Hiện có <?=$num?> bình luận <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
