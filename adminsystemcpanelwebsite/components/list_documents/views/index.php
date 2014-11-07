<?php echo form_open('dichvu/dels',  array('id' => 'admindata'));?> 
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="8">
                Hiện có <?php echo count($list)?> bảng giá
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th width="100">File</th>
            <th width="100">Hình ảnh</th>
            <th>Tên bảng giá</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    	$img 			= (!empty($rs->image))?base_url_site().'data/documents/full_images/'.$rs->image:base_url_site()."site/templates/fyi/images/noimage.png";
    	$extDocument   = substr($rs->file, -3, 3);
    	switch( $extDocument )
				{
					case 'pdf':
					{
						$imgDocument		=  base_url_site()."site/templates/fyi/images/pdf.png"; 
						break; 
					}
					case 'pdfx':
					{
						$imgDocument		=  base_url_site()."site/templates/fyi/images/pdf.png"; 
						break; 
					}
					case 'xls':
					{
						$imgDocument 		=  base_url_site()."site/templates/fyi/images/excel.png"; 
						break; 
					}
					case 'xlsx':
					{
						$imgDocument 		=   base_url_site()."site/templates/fyi/images/excel.png"; 
						break; 
					}
					case 'docx':
					{
						$imgDocument 		=   base_url_site()."site/templates/fyi/images/word.png"; 
						break; 
					}
					default:
					{
						$imgDocument 		=   base_url_site()."site/templates/fyi/images/word.png"; 
						break; 
					}
				}
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->id?>"></td>
        <td><?=$rs->id?></td>
        <td><img src="<?=$imgDocument;?>" width="90"></td>
        <td><img src="<?=$img;?>" width="90"></td>
        <td><?=$rs->name?></td>
        <td align="center">
            <?php echo icon_edit('list_documents/edit/'.$rs->id)?>
            <span id="publish<?php echo $rs->id?>"><?php echo icon_active("'documents'","'id'",$rs->id,$rs->published,'list_documents/published')?></span>
            <?php echo icon_del('list_documents/del/'.$rs->id)?>        
        </td>
    </tr>       
    <?php
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="8">
            Hiện có <?php echo count($list)?> Dịch vụ
        </td>
    </tfoot>    
</table>
<?php echo form_close()?>
