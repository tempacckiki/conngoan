<?echo form_open('daugia/binhluan/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">

<?$uri3 = (int)$this->uri->segment(3)?>
<?$uri4 = (int)$this->uri->segment(4)?>
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="7">
                Hiện có <?=$num?> bình luận <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('daugia/binhluan/ds/0/commentid/asc','ID')?></th>
            <th style="width: 150px;"><?=vnit_order('daugia/binhluan/ds/0/fullname/asc','Họ tên')?></th>
            <th style="width: 100px;"><?=vnit_order('daugia/binhluan/ds/0/add_date/asc','Ngày')?></th>
            <th>Nội dung</th>
            <th style="width: 100px;"><?=vnit_order('daugia/binhluan/ds/0/published/asc','Tình trạng')?></th> 
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    $cheap = $this->vdb->find_by_id('cheap_list',array('id'=>$rs->cheap_id));
    $pro = $this->vdb->find_by_id('shop_product',array('productid'=>$cheap->productid));
    $city = $this->vdb->find_by_id('city',array('city_id'=>$cheap->city_id));
    $city_url = ($city)?$city->city_url:'toan-quoc';
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->commentid?>"></td>
        <td><?=$rs->commentid?></td>
        <td><?=$rs->fullname?></td>
        <td><?=date('d/m/Y',$rs->add_date)?></td>
        <td>
            <b><a href="<?=base_url_site().$city_url.'/deals/'.$pro->producturl.'-'.$cheap->id?>" target="_blank">Link</a></b>
            <?=vnit_cut_string($rs->content,200)?>
        </td>
        <td>
            <?=($rs->published == '1')?'Đã duyệt':'Chờ duyệt';?>
        </td>
        <td align="center">
            <?=icon_edit('daugia/binhluan/editcomment/'.$rs->commentid.'/'.$this->uri->segment(4))?>
            
            <?=icon_del('daugia/binhluan/del/'.$rs->commentid.'/'.$this->uri->segment(4))?>
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="7">
            Hiện có <?=$num?> bình luận <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
