<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<input type="hidden" name="kh_id" value="<?php echo $rs->weblink_id?>">
<table class="form">   
    <tr>
        <td class="label">Tên khách hàng</td>
        <td><input type="text" class="w200" name="name" value="<?php echo $rs->name?>"></td>
    </tr>
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <div id="image" class="img_news" onclick="openKCFinder(this)">
			<?if($rs->weblink_img !=''){?>
				<img src="<?=base_url_site().$rs->weblink_img?>" alt="">
			<?}else{?>
                <img src="<?=base_url()?>templates/images/no-img.png" alt="">
			<?}?>
            </div>
            <input type="hidden" name="images" id="news_img" value="<?=$rs->weblink_img?>">        
        </td>
    </tr>  
    <tr>
        <td class="label">Website</td>
        <td><input type="text" class="w200" name="link" value="<?php echo $rs->link?>"></td>
    </tr>
 
</table>
<?php echo form_close();?>
