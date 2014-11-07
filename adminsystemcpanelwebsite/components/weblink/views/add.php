<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<input type="hidden" name="user_id" value="0">
<table class="form">   

    <tr>
        <td class="label">Tên liên kết</td>
        <td><input type="text" class="w200" name="name" value="<?php echo set_value('name')?>"></td>
    </tr>
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <div id="image" class="img_news" onclick="openKCFinder(this)">
                <img src="<?=base_url()?>templates/images/no-img.png" alt="">
            </div>
            <input type="hidden" name="images" id="news_img" value="<?=set_value('images')?>">        
        </td>
    </tr>  
    <tr>
        <td class="label">Links</td>
        <td><input type="text" class="w200" name="link" value="<?php echo set_value('link')?>"></td>
    </tr>
 </table>
<?php echo form_close();?>
