<?                   
	$uri2 		= $this->uri->segment(2);
	$catid 		= end(explode('-', $uri2));  
	$cat 		= $this->vdb->find_by_id('shop_cat',array('catid'=>$catid)); 
	$this->db->where('parentid',$cat->parentid);
	$this->db->order_by('ordering','asc');
	
	//get list category ****
	$list 		= $this->db->get('shop_cat')->result();
	
?>

<div class="box-left-content">
<p class="title"><span>&nbsp;</span>Chuyên mục sản phẩm</p>
<div class="box-m">
	<ul class="sub-left-items">
	<?foreach($list as $rs):
		$listSubCat  = $this->vdb->find_by_list("shop_cat", array('parentid'=>$rs->catid), array('ordering'=>'DESC'));
		
	?>
		<li <?=($catid ==$rs->catid)?'class="select"':'';?>><a href="<?=site_url('chuyen-muc/'.$rs->caturl.'-'.$rs->catid)?>" title="<?=$rs->catname;?>"><?=$rs->catname?></a>
			<ul <?=($catid ==$rs->catid)?'class="block"':'class="none"';?>>
				<?php 
				foreach ($listSubCat as $valSub):
				?>
				<li><a href="<?=site_url('chuyen-muc/'.$valSub->caturl.'-'.$valSub->catid)?>"><?=$valSub->catname;?></a></li>
				<?php 
				endforeach;
				?>
			</ul>
		
		</li>
	<?endforeach;?>
	</ul>
</div>
</div>
