<?php
echo form_open(uri_string(),array('id'=>'admindata'));
$file = fopen($file_skin, "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
$file_content = '';
while(!feof($file)){
 $file_content .=fgets($file);  
}?>
<textarea name="content" cols="" rows="" style="width: 99%;height: 500px;"><?php echo $file_content ?></textarea>  
<? 
fclose($file);  
?>
<div><?=action_save("Lưu Skin")?></div>
<?=form_close()?>
