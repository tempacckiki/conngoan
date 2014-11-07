<?=form_open(uri_string(),  array('id' => 'admindata'))?>
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<table class="form">
    <tr>
        <td class="label">Tên nhóm hàng</td>
        <td>
            <input type="text" class="w500" name="catname" value="<?=set_value('catname')?>">
        </td>
    </tr>

    <tr>
        <td class="label">Sắp xếp</td>
        <td><input type="text" name="cat[ordering]" value="<?=$this->vdb->find_by_order('shop_cat','ordering',array('parentid'=>0))?>" class="w200"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị trang chủ</td>
        <td><input type="checkbox" name="cat[ishome]" value="1"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị Tab ngang con</td>
        <td><input type="checkbox" name="cat[istab]" value="1"></td>
    </tr>
    <!--
    <tr>
        <td class="label">Hiển thị menu trái</td>
        <td><input type="checkbox" name="cat[ismenuleft]" value="1"></td>
    </tr>
    <tr>
        <td class="label">Không link</td>
        <td><input type="checkbox" name="cat[nolink]" value="1"></td>
    </tr>
    -->
    <tr>
        <td class="label">Từ khóa</td>
        <td><input type="text" name="cat[catkeyword]" class="w500" value="<?=set_value('cat[catkeyword]')?>"></td>
    </tr>
    <tr>
        <td class="label">Miêu tả</td>
        <td>
            <textarea style="width: 500px;height: 100px;" name="cat[catdes]"><?=set_value('cat[catdes]')?></textarea>
        </td>
    </tr>
    <!--
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <div id="image" class="img_news" onclick="openKCFinder(this,'img_main')">
                <?if(set_value('img_main')!=''){?>
                   <img src="<?=base_url_site().set_value('img_main')?>" alt="">     
                <?}else{?>
                    <img src="<?=base_url()?>templates/images/no_img.jpg" alt="">   
                <?}?>
            </div>
            <input type="hidden" name="img_main" id="img_main" value="<?=set_value('img_main')?>" class="w350">     
        </td>
    </tr>    
    -->
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="checkbox" name="cat[published]" value="1" checked="checked" <?=(set_value('cat[published]')==1)?'checked="checked"':'';?>></td>
    </tr>
</table>
<?=form_close();?>
