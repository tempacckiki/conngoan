<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
     <title>
	 <?php
		if($productid == 269){
			echo 'Bếp hồng ngoại Happy Call HT-J100-20D1 - alobuy.vn';
		}elseif($productid == 269){
			echo 'MÁY IN LASER MÀU OKI C301DN - alobuy.vn';
			
		}else{
			echo $title .' - '. 'alobuy.vn';
		}
	 ?>
	 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="Content-Language" content="vn" />
	<?php
		$description = 'Mua bán và phân phối sản phẩm '.$title.' với nhiều tính năng ưu Việt được nhập từ thương hiệu có uy tín, giá giảm từ 25%-50%.';
		if($productid == 269){
			$description = 'Bếp hồng ngoại Happy Call HT-J100-20D1 giá chỉ: 445.000 VND tiết kiệm gần 30% chi phí với nhiều tính năng ưu Việt được nhập từ Hàn quốc.';
		}
		
		if($productid == 1724){
			$description = 'Giảm 1.640.000đ MÁY IN LASER MÀU OKI C301DN đa chức năng, in màu 2 mặt, hình ảnh in ấn cực kì rực rỡ, nổi bật dù chỉ in trên giấy thường.In thử miễn phí trước khi quyết định mua hàng.';
		}
	?>
    <meta name="description" content="<?php echo $description;?>">
    <meta name="keywords" content="<?=$title;?>">
	<!--<meta name="keywords" content="<?if(isset($keyword)){echo $des;}else{echo  $this->config->item('site_keyword');}?>">-->

    <?=$this->load->view('templates/default/meta/meta_detail')?>
	
</head>
<body id="bd">
	<?=$this->load->view('templates/default/html/box_header');?> 
	
	<div class="popcart" style="display: none;">
	    <a class="close" id="popcart_close"></a>
	    <div class="popcart-content" id="cartcontent">
	    </div>
	</div>
	
	<div id="show_msg"></div>

 <div id="main-container"> <!-- #wapper -->

    <header> <!-- header -->
        <?=$this->load->view('templates/default/html/header')?>
    </header> <!-- End box banner --> 
    <div class="box-content-wapper">
    	<div class="bg-title-main">    
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=base_url()?>" itemprop="url" class="no-bg"><span itemprop="title">Trang chủ</span></a></div>
		    <?=$top_link?> 
		    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=$top_link_seo;?>" itemprop="url"><span itemprop="title"><strong><?=vnit_cut_string($rs->productname, 60);?></strong></span></a></div>
		</div>
	    <?if(isset($message) && $message !=''){ echo '<div class="show_notice" id="msg">'.$message.'</div>';}?>
	    <?if($this->session->flashdata('message')){
	        echo '<div class="show_success" id="msg">'.$this->session->flashdata('message').'</div>';
	    }if($this->session->flashdata('error')){
	        echo '<div class="show_error" id="msg">'.$this->session->flashdata('error').'</div>';
	    }if($this->session->flashdata('notes')){
	        echo '<div class="show_notice" id="msg">'.$this->session->flashdata('notes').'</div>';
	    }
	    ?> 
	    <?=$this->load->view($page)?>    
	</div>
    <?=$this->load->view('templates/default/html/footer')?>     
</div> <!-- End #wapper -->
</body>
</html>
