<div class="box-bids">
	<?php
        $ar_id = '';
        foreach($list as $jbid):            
            $ar_id .= $jbid->id.',';            
        endforeach;
        $ar_id = trim($ar_id,',');
        ?> 
        <script type="text/javascript">
        var param = '<?=$ar_id?>';
        </script>
        
	<ul class="items-bid">
		<?php foreach($list as $rs):
               $listimg =  $this->daugia->get_list_img_by_product($rs->productid);
         ?>
		<li>
			<p class="name"><?php echo $rs->product_name?></p> 	
			<div class="view-img">                                      
                        <script type="text/javascript">
                            $(function() {
                                $('#slider<?=$rs->id?>').nivoSlider({
                                     manualAdvance:true
                                });
                            });
                        </script>
                    <div class="item-default">
                        <div id="slider<?=$rs->id?>" class="nivoSlider"> 
                            <?foreach($listimg as $val):?>                                            
                            <a href="javascript:;" title="" ><img src="<?=base_url_img()?>alobuy0862779988/daugia/200/<?=$val->imagepath?>" width="220" height="190" alt="" /></a>
                            <?endforeach;?>
                        </div>
                    </div>
            </div>
			<p class="price-old">Giá thị trường: <?=number_format($rs->price_old)?> ₫</p>
			<p class="price">Tiết kiệm được: <span id="Per_<?=$rs->id?>"><?=$rs->per_saving?></span>%</p>
			<p id="TotalSecond_<?=$rs->id?>" style="display:none"><?=$rs->time_end - (time() + $this->time_server)?></p>
			<p class="date" id="TimeRemain_<?=$rs->id?>"><?=vtime($rs->time_end - (time() + $this->time_server));?></p>
			<p class="price-off" id="PriceNow_<?=$rs->id?>"><?=number_format($rs->price_last,0,'.','.')?> ₫</p>
			<p style="display: none;" id="PriceOld_<?=$rs->id?>"><?=$rs->price_last?></p>
			
			<p class="people-label">Nguoi tra gia cao nhat</p>
			<p class="people" id="Bidder_<?=$rs->id?>"><?=(!empty($rs->buyer_name))?$rs->buyer_name :'Chờ bid';?></p>
			<p id="bt_<?=$rs->id?>">
                        <?if($this->session->userdata('user_id') == $rs->buyer_id){?>
                            <a href="javascript:;" class="booking_dis">Đặt giá</a>
                        <?}else{?>
                            <a href="javascript:;" id="click_bid" bid_id="<?=$rs->id?>" class="booking">Đặt giá</a>
                        <?}?>
             </p>
		</li>
		
		 <?php endforeach;?>
		
	</ul>
	
	 <script type="text/javascript">
            $(document).ready(function() {
               ServerTime(); 
            });
    </script>
            
	<div class="partners-bid"  id="list_member">
		<div class="title">Danh sách thành viên tham gia phiên đấu giá</div>
		<div class="row bold bg">
			<div class="number">STT</div>
			<div class="timer">Thời gian</div>
			<div class="member">Thành viên</div>
			<div class="product">Sản phẩm</div>
			<div class="price">Giá mua được</div>
			<div class="sales-off">Đã tiết kiệm được</div>							
		</div>
		<?php  
		$i = 1;
		foreach($list_old as $val):?>
		<div class="row">
			<div class="number"><?=$i?></div>
			<div class="timer"><?=date('d/m/Y',$val->time_last)?></div>
			<div class="member"><?=$val->buyer_name?></div>
			<div class="product"><?=$val->product_name?></div>
			<div class="price"><?=number_format($val->price_last,0,'.',',')?></div>
			<div class="sales-off"><?=$val->per_saving?>%</div>							
		</div>
		 <?php
            $i++;
            endforeach;
         ?>
		
		
		
	</div>
</div>


<script type="text/javascript">
        $(window).load(function() {
            $('#slider').nivoSlider();
        });
    </script>
 
 <script type="text/javascript">
        function oldpage(page_no){  
            $.post(site_url+"daugia/oldpage",{'page_no':page_no},function(data){
                $("#list_member").html(data);                                            
            });
        }
        </script>
