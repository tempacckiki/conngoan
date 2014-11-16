<div class="box-content-wapper">
    <div>
        <div class="cat-left">
            <span>Danh mục</span>
        </div>
		<div class="bg-title-main">    
				<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=base_url()?>" itemprop="url" class="no-bg"><span itemprop="title">Trang chủ</span></a></div>
			   
			    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=$top_link_seo;?>" itemprop="url"><span itemprop="title"><strong><?=$title;?></strong></span></a></div>
		</div>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>technogory/templates/default/css/contact.css?v=alobuy.vn" media="screen">
    </div>

    <div>
    	<div>
            <?php $this->load->view('templates/default/html/menuhuongdan');?>
    	</div>
    	<div>
			<div class="box-map">
				
				<?php echo $headerjs; ?>
				<?php echo $headermap; ?>
				<?php echo $onload; ?>
				<?php echo $map; ?>
						
			</div>

			<div>
				<div>Showroom conngoan.com.vn</div>
				<div>Địa chỉ: <?=$aData->address?></div>
				<div>Hotline: <?=$aData->phone?></div>
			</div>

			<div class="box-form">
				
				<?=form_open(uri_string())?>
				<div class="contact_items padding5">
				    <div class="label">Gửi liên hệ</div>
				</div>
				<div class="contact_items padding5">
				    <input placeholder="<?php echo lang('contact.fullname');?> " type="text" name="contact[fullname]" class="w300" value="<?=set_value('contact[fullname]')?>">
				</div>
				<div class="contact_items padding5">
				    <input placeholder="<?php echo lang('contact.phone')?>" type="text" name="contact[phone]" class="w300" value="<?=set_value('contact[phone]')?>">
				</div>
				<div class="contact_items padding5">
				    <input placeholder="Địa chỉ" type="text" name="contact[address]" class="w300" value="<?=set_value('contact[fullname]')?>">
				</div>
				<div class="contact_items padding5">
				   <input placeholder="<?php echo lang('contact.email')?>" type="text" name="contact[email]" class="w300" value="<?=set_value('contact[email]')?>">
				</div>
				<div class="contact_items padding5">
				    <textarea placeholder="<?php echo lang('contact.content')?>" cols="" rows="" style="width: 410px;height: 100px;" name="contact[content]"><?=set_value('contact[content]')?></textarea>
				</div>
				<div class="contact_items padding5">
					<div class="label">&nbsp;</div>
				    <input type="submit"  class="submit" name="bt_contact" value="Đồng ý gửi">
				</div>
				<?=form_close()?>
			</div>
    	</div>
    </div>


	
</div>
