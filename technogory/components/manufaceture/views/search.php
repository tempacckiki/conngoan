<div id="vnit_page_cat">
   
    
    <div class="head-order-cat">
    	<h2 class="cat-head">Tìm thấy <?=$num?> sản phẩm <?=$title;?></h2>
        <ul class="ordering">  
        	         
            <li class="fr">
            	Giá: 
                <select onchange="change_order(this.value)" id="vnit_order">
                    <option value="price_desc">Giá giảm dần</option>
                    <option value="price_asc" selected="selected">Giá tăng dần</option>
                    <option value="name_asc">Từ A-Z</option>
                    <option value="name_desc">Từ Z-A</option>
                </select>
            </li>            
            <li class="fr">
            	Sắp xếp:
                <select onchange="change_hot(this.value)" id="vnit_hot" style="width: 120px;">
                    <option value="all">Tất cả</option>
                    <option value="hot">Sản phẩm hot</option>
                    <option value="new">Sản phẩm mới</option>
                    <option value="promotion">Sản phẩm khuyến mãi</option>
                </select>
            </li>
        </ul>
    </div>
    
   
    <ul class="cat-p-items">
    <?
    $i = 1;
    foreach($list as $rs){
        $nxs 			= $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$rs->manufactureid));
       
        $giathitruong 	= $rs->giathitruong;
        $giaban 		= $rs->giaban;
        $giamgia 		= $rs->giamgia;
        $phantram 		= $rs->phantram;
        $tinhtrang 		= $rs->tinhtrang;
        $tinhtrang_text = $rs->tinhtrang_text;
        $phuKien		= addli($rs->phukien);
        ?>
         <li>    
         	<div class="info-prod-cat">    
	            <figure class="img">
	                <a href="<?=site_url('san-pham/'.$rs->producturl.'-'.$rs->productid)?>">
	                <img  src="<?=base_url_img()?>alobuy0862779988/0862779988product//190/<?=$rs->productimg?>" alt="<?=$rs->productname?>" width="188">
	                </a>
	
	            </figure>
	            <?php 
	            if($i>5){
					$i = 1;
	            ?>
	            <h<?=$i;?> class="name"><a href="<?=site_url('san-pham/'.$rs->producturl.'-'.$rs->productid)?>"><?=$rs->productname?></a></h<?=$i;?>>
	            <?php }else{?>
	            <h<?=$i;?> class="name"><a href="<?=site_url('san-pham/'.$rs->producturl.'-'.$rs->productid)?>"><?=$rs->productname?></a></h<?=$i;?>>            
	            <?php }?>
	            <ul class="phu-kien">
	            	<?=$phuKien;?>
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
    <?
    $i++;
    }?>
    </ul>
    
   
    <div class="div_page pages" style="padding: 0px;"><?=$pagination?></div>
    
	<script type="text/javascript">
		var catid = <?=$catid?>; 
		var input_get = '<?=$url_page?>';
	</script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$(".info-prod-cat").hover(function(){
				$(this).find(".buttom-buy-prod").css({
					'display':'block'
				});
			},function(){
				$(this).find(".buttom-buy-prod").css({
					'display':'none'
				});
			});
		});
	</script>
	
</div>