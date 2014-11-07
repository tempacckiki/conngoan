<?php echo form_open(uri_string(), array('id'=>'admindata'))?>
<div class="show_notice_small">
    Click chọn 1 Module mà bạn muốn thêm mới
</div>
<table class="admindata">
<?php
  $k = 1;
  $i = 1;
  while(false !== ($file = readdir($handle))){
        if ($file != "." && $file != ".." && $file != 'index.php') {
        $xml = simplexml_load_file(ROOT.'site/views/modules/'.$file.'/'.$file.'.xml')    
            ?>
<tr class="row<?php echo $k?>">
    <td style="width: 30px;" align="center"><?php echo $i?></td>
    <td style="width: 30px;"><input type="radio" name="modules_name" value="<?php echo $file?>"></td>
    <td style="width: 150px;"><?php echo $file?></td>
    <td style="width: 250px;"><?=$xml->name[0]?></td>  
    <td><?=$xml->author[0]?></td>  
    <td><?=$xml->version[0]?></td>  
</tr>
<?php    
        $i ++ ;
        }      
  
  $k = 1 - $k;
  }
?>
</table>
<?php echo form_close()?>
