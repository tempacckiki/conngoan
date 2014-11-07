<div class="box-content-wapper">
	<div class="bg-title-main">    
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=base_url()?>" itemprop="url" class="no-bg"><span itemprop="title">Trang chủ</span></a></div>
		   
		    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=$top_link_seo;?>" itemprop="url"><span itemprop="title"><strong><?=$title;?></strong></span></a></div>
		</div>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>technogory/templates/default/css/contact.css?v=alobuy.vn" media="screen">
	<div class="box-form">
		
		<?=form_open(uri_string())?>
		<div class="contact_items padding5">
		    <div class="label"><?php echo lang('contact.fullname');?> (*):</div>
		    <input type="text" name="contact[fullname]" class="w300" value="<?=set_value('contact[fullname]')?>">
		</div>
		<div class="contact_items padding5">
		    <div class="label"><?php echo lang('contact.phone')?> (*) :</div>
		    <input type="text" name="contact[phone]" class="w300" value="<?=set_value('contact[phone]')?>">
		</div>
		<div class="contact_items padding5">
		    <div class="label"><?php echo lang('contact.email')?> (*):</div>
		   <input type="text" name="contact[email]" class="w300" value="<?=set_value('contact[email]')?>">
		</div>
		<div class="contact_items padding5">
		    <div class="label"><?php echo lang('contact.content')?> (*): </div>
		    <textarea cols="" rows="" style="width: 410px;height: 100px;" name="contact[content]"><?=set_value('contact[content]')?></textarea>
		</div>
		<div class="contact_items padding5">
			<div class="label">&nbsp;</div>
		    Ghi chú: Những trường hợp có (*) xin vui lòng điền đầy đủ thông tin. Cảm ơn!
		</div>
		<div class="contact_items padding5">
			<div class="label">&nbsp;</div>
		    <input type="submit"  class="submit" name="bt_contact" value="<?php echo lang('contact.send')?>">
		</div>
		<?=form_close()?>
	</div>
	
	<div class="box-contacts">
		<p class="img"><img src="<?=base_url();?>technogory/templates/default/images/hinh_contact_us.jpg" width="350"></p>
		<p class="title"><?=$this->config->item('contact_name');?></p>
              
                <ul class="items-contact">
							 
					<li><strong>Địa chỉ:</strong> <?=$this->config->item('contact_address');?> </li>
	                <li><strong>Điện thoại:</strong> <?=$this->config->item('contact_phone');?></li>
	                <li><strong>Fax:</strong> <?=$this->config->item('contact_fax');?></li>
					<li><strong>Email:</strong> <?=$this->config->item('contact_email');?> </li>
					
					<li><strong>Website:</strong> <a href="http://alobuy.vn">www.alobuy.vn</a></li>
					
				</ul>
	</div>
	
	
	<div class="box-map">
		
		<?php echo $headerjs; ?>
		<?php echo $headermap; ?>
		<?php echo $onload; ?>
		<?php echo $map; ?>
				
	</div>
</div>
