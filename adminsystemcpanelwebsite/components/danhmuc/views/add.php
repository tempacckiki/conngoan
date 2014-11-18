<?=form_open_multipart(uri_string(),  array('id' => 'admindata'))?>
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<table class="form">
    <tr>
        <td class="label">Danh mục</td>
        <td>
            <input type="text" class="w500" name="catname" value="<?=set_value('catname')?>">
        </td>
        <td rowspan="10">
            Hãng sản xuất
            <table class="admindata">
                <thead>
                    <tr>
                        <th style="width: 20px;"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
                        <th>Hãng sản xuât</th>
                    </tr>
                </thead>
            </table>
            <div style="height: 340px;overflow: auto;">
            <table class="admindata">
                <?
                $k=1;
                foreach($listnxs as $val):?>
                <tr class="row<?=$k?>">
                    <td style="width: 20px;"><input  type="checkbox" name="ar_id[]" value="<?=$val->manufactureid?>"></td>
                    <td><?=$val->name?></td>
                </tr>
                <?
                $k=1-$k;
                endforeach;?>
            </table>
            </div>
        </td>
    </tr>
    <tr>
        <td class="label">Chuyên mục chính</td>
        <td>
            <select name="parentid" class="w200">
                <?foreach($listcat as $cat):
                    $listsub = $this->danhmuc->get_sub_cat($cat->catid); 
                ?>
                    <option value="<?=$cat->catid?>" <?=($cat->catid == $maincat)?'selected="selected"':''?> style="font-size: 16px;font-weight: bold;"><?=$cat->catname?>
                    </option>
<!--                     <?foreach($listsub as $val):
                        $listsub1 = $this->danhmuc->get_sub_cat($val->catid);
                    ?>
                        <option value="<?=$val->catid?>" <?=($val->catid == $subcat)?'selected="selected"':''?> style="font-size: 14px;font-weight: bold;">|___<?=$val->catname?>
                        </option>
                        <?foreach($listsub1 as $val1):
                        ?>
                            <option value="<?=$val1->catid?>" <?=($val1->catid == $subcat)?'selected="selected"':''?>>|___|___<?=$val1->catname?>
                            </option>
                        <?endforeach;?>
                    <?endforeach;?>
 -->                <?endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td><input type="text" name="ordering" value="<?=$this->vdb->find_by_order('shop_cat','ordering',array('parentid'=>$subcat))?>" class="w200"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị trang chủ</td>
        <td><input type="checkbox" name="ishome" value="1"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị Tab ngang con</td>
        <td><input type="checkbox" name="istab" value="1"></td>
    </tr>
    <!-- 
    <tr>
        <td class="label">Hiển thị menu trái</td>
        <td><input type="checkbox" name="ismenuleft" value="1"></td>
    </tr>
    
    <tr>
        <td class="label">Không link</td>
        <td><input type="checkbox" name="nolink" value="1"></td>
    </tr>
    -->
    <tr>
        <td class="label">Từ khóa title:</td>
        <td><input type="text" name="catkeyword" class="w500" value="<?=set_value('catkeyword')?>"></td>
    </tr>
    
    <tr>
        <td class="label">Miêu tả</td>
        <td>
            <textarea style="width: 500px;height: 100px;" name="catdes"><?=set_value('catdes')?></textarea>
        </td>
    </tr>

    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <div id="image" class="img_news">
                <?if(set_value('img_main')!=''){?>
                   <img src="<?=base_url_site().set_value('img_main')?>" alt="">     
                <?}else{?>
                    <img src="<?=base_url()?>templates/images/no_image.jpg" alt="">   
                <?}?>
            </div>
            <input type="file" name="userfile">
            <div>Kích thước: 120 x 85 pixcel</div>
        </td>
    </tr>    

    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="checkbox" name="published" value="1" checked="checked" <?=(set_value('cat[published]')==1)?'checked="checked"':'';?>></td>
    </tr>
</table>
<?=form_close();?>