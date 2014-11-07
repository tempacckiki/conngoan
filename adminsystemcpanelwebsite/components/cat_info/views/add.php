<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<table class="form">
    <tr>
        <td class="label">Danh mục sản phẩm</td>
        <td>
            <select name="cat_id" id="cat_id" class="w250">
                        <?php foreach($listcat as $cat):
                        $listsub = $this->danhmuc->get_sub_cat($cat->catid);?>
                        <option value="<?=$cat->catid?>" <?=($cat->catid == set_value('catid'))?'selected="selected"':'';?>><?=$cat->catname?></option>
                            <?php foreach($listsub as $sub):
                            $listsub1 = $this->danhmuc->get_sub_cat($sub->catid);
                            ?>
                            <option value="<?=$sub->catid?>" <?=($sub->catid == set_value('catid'))?'selected="selected"':'';?>>|___<?=$sub->catname?></option>
                            
                                <?php foreach($listsub1 as $val):
                                $listsub2 = $this->danhmuc->get_sub_cat($val->catid);  
                                ?>
                                <option value="<?=$val->catid?>">|___|___<?=$val->catname?></option>
                                    <?foreach($listsub2 as $val1):?>
                                    <option value="<?=$val1->catid?>">|___|___|___<?=$val1->catname?></option>
                                    <?endforeach;?>
                                <?endforeach;?>
                            <?endforeach;?>
                        
                        <?endforeach;?>
                    </select>
        </td>
    </tr>
    <tr>
        <td class="label">Tên thông tin</td>
        <td>
            <input type="text" class="w300" name="name" value="">
        </td>
    </tr>
    
    <tr>
        <td class="label">Tóm tắt:</td>
        <td>
        	<?=vnit_editor(set_value('content'),'content','full', false)?>          
        </td>
    </tr>
   
   
    <tr>
        <td class="label">Sắp xếp</td>
        <td>
            <input type="text" name="ordering" value="1">
        </td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td>
            <input type="checkbox" name="published" value="1" checked="checked">
        </td>
    </tr>
</table>
<?=form_close();?>
