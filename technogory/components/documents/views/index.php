<div class="box-content-wapper">
<div class="pathway">
    <ul>
        <li><a href="<?=base_url()?>" class="homepage">&nbsp;</a></li>
        
        <li><a href="#" class="active"><?=$title;?></a></li> 
    </ul>
</div>
<div class="list-documents">
	<ul class="items">
		<?php 
		if(count($list)>0){
			foreach ($list as $val):
				$name 			= $val->name;
				$fileDocument   = base_url().'data/documents/full_images/'.$val->file;
				
			
				$imgDocument =  (!empty($val->image))?base_url().'data/documents/full_images/'.$val->image:base_url()."site/templates/fyi/images/noimage.png"; 
		?>
		<li>
			<p class="img"><a href="<?=$fileDocument;?>"><img src="<?=$imgDocument;?>" width="164"></a></p>
			<p class="name"><a href="<?=$fileDocument;?>"><?=$name;?></a></p>
		</li>
		<?php 
		endforeach;
		}
		?>
		
	</ul>
</div>

</div>