
<?php 
	$imgPath   		= base_url_static().'technogory/templates/default/images/';
?>
<div id="left-faq">
    <div class="headcat">
        <ul class="ordering"> 
            <li class="fl">Tìm thấy <span id="num"><b><?=$total?></b></span> sản phẩm với từ khóa : <b><?=$productkey?></b></li>            
          
        </ul>
    </div>
    
		<div class="clear">
		    <ul class="cat-p-items">
		    <?php
		    $i = 1;
		    foreach($list as $rs):
		    	$nxs = $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$rs->manufactureid));
		    
		    
			    $giathitruong 	= $rs->giathitruong;
			    $giaban 		= $rs->giaban;
			    $giamgia 		= $rs->giamgia;
			    $phantram 		= $rs->phantram;
			    $tinhtrang 		= $rs->tinhtrang;
			    $tinhtrang_text = $rs->tinhtrang_text;
			    
			    $phuKien		= $rs->phukien;
		
		    ?>
		        <li>    
		         	<div class="info-prod-cat">    
			            <figure class="img">
			                <a href="<?=site_url('san-pham/'.$rs->producturl.'-'.$rs->productid)?>">
			                <img  src="<?=base_url_img()?>alobuy0862779988/0862779988product/190/<?=$rs->productimg?>" alt="<?=$rs->productname?>" width="222">
			                </a>
			
			            </figure>
			            <?php 
			            if($i>6){
							$i = 1;
			            ?>
			            <h<?=$i;?> class="name"><a href="<?=site_url('san-pham/'.$rs->producturl.'-'.$rs->productid)?>"><?=$rs->productname?></a></h<?=$i;?>>
			            <?php }else{?>
			            <h<?=$i;?> class="name"><a href="<?=site_url('san-pham/'.$rs->producturl.'-'.$rs->productid)?>"><?=$rs->productname?></a></h<?=$i;?>>            
			            <?php }?>
			            <ul class="phu-kien">
			            	<?=addli($phuKien);?>
			            </ul>
						<p class="price-old"><?=number_format($giathitruong,0,'.','.')?> ₫</p>	
			            <p class="price">
			                <span><?=number_format($giaban,0,'.','.')?> ₫</span>
			            </p>
		            	
		            	<div class="discount">
							<p class="lable">Tiết kiệm</p>
		                    <p class="price-discount"><?=$phantram;?> %</p>
		                </div>
		                            
		            	<div class="buttom-buy-prod" style="display: none;">
					    	<p class="text"><a href="#">Mua ngay</a></p>
					    </div>
					                
		            </div>   
		        </li>
		    <?endforeach;?>
		    </ul>
	    </div>
   
    <div class="clear-paginator">
     	<div class="pages" style="padding: 0px;"><?=$pagination?></div>
     </div>
</div>
<div id="right-faq">
	<div class="box-cam-ket-faq">
		<p class="title">Chúng tôi cam kết</p>
		<div>
			<ul>
				<li class="payment">Trả tiền khi nhận hàng</li>
				<li class="shipping">Giao hàng toàn quốc</li>
				<li class="modifier">Đảm bảo hàng hóa Đổi trả, hoàn </li>
			</ul>
		</div>
	</div>
	<div>
		<a href="<?=site_url('huong-dan/huong-dan-mua-hang-online-23.html');?>"><img src="<?=$imgPath;?>support-detail.jpg"></a>
	</div>
	
	<div class="box-quan-tam-de">
		<?if($this->config->item('advDeal_total') > 0){?>
	   		<div class="title"><p class="text">Có thể bạn quan tâm</p></div>
	        	<ul class="list-items">
	        		 <?php
	        		 $k = 0;
	        		 for($i = 1; $i <= $this->config->item('advDeal_total'); $i++){
	        		 	$name   		= $this->config->item('advDeal_name_'.$i);
	        		 	$discription   	= $this->config->item('advDeal_decription_'.$i);
	        		 	$price   		= number_format($this->config->item('advDeal_price_'.$i), 0, '.','.');
	        		 	$priceOld  		= number_format($this->config->item('advDeal_priceOld_'.$i), 0, '.','.');
	        		 	$link   		= $this->config->item('advDeal_link_'.$i);
	        		 	$img  			= base_url_static().'alobuy0862779988/adv/dealindex/thumb/'.$this->config->item('advDeal_img_'.$i);
	        		 ?>
	        		<li class="row<?=$k;?>">
	        			<div class="sub-row">
		        			<p class="name"><a href="<?=$link;?>" title="<?=$name;?>" target="_blank"><?=$name;?></a></p>
		        			<p class="img"><a href="<?=$link;?>" title="<?=$name;?>" target="_blank"><img src="<?=$img;?>" alt="<?=$name;?>" width="90"></a></p>
		        			<div class="info-deal-de">
		        				<p class="description"><?=$discription;?></p>
		        				<p class="price-old"><?=$priceOld;?> ₫</p>
		        				<p class="price"><?=$price;?> ₫</p>
		        			</div>
	        			</div>
	        		</li>
	        		<?php 
					$k  = 1 - $k;
					}
					?>
	        		
	        	</ul>
	        
	        <?php }?>
	</div>

</div>
<script type="text/javascript">
function searchresult_page(page_no){ 
    $.post(site_url+"search/result.html?p=<?=$productkey?>",{'page_no':page_no,'ajax':1},function(data){
        $("#vnit_page_cat").html(data);                                      
    });
}
</script>
