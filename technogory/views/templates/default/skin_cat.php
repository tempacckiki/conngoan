<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
    <title>
    	<?php 
    	$uri1  = $this->uri->segment("1");
    	if($uri1 == 'Hang-san-xuat' || $uri1 == 'Tinh-nang'){
    		echo $title.' giá rẻ bất ngờ '.'- Hotline (08) 62 77 99 88';
    	}else{
    		echo ($catkeyword)?$catkeyword:'Chuyên bán '.$title.' giá rẻ bất ngờ - Hotline (08) 62 77 99 88 "';
    	}
    	?>
    	
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="Content-Language" content="vn" />
    <meta name="description" content="<?=($catdes)?$catdes:'Mua bán và phân phối '.$title.' chính hãng của thương hiệu uy tín '.$listMabnuFac.' với giá thành rẻ nhất, chất lượng dịch vụ tốt nhất';?>">
   <!--  <meta name="keywords" content="<?=$title;?>, mua bán <?=$title;?>, <?=$title;?> giá rẻ"> -->
    <?=$this->load->view('templates/default/meta/meta_cat')?>
</head>
<body id="bd">
<?=$this->load->view('templates/default/html/box_header');?> 

<div class="popcart" style="display: none;">
    <a class="close" id="popcart_close"></a>
    <div class="popcart-content" id="cartcontent">
    </div>
</div>

<div id="show_msg"></div>
<div id="main-container"> 
    <header>
        <?=$this->load->view('templates/default/html/header')?>
    </header>
    
    <div class="box-content-wapper">
        <div>
            <div class="cat-left">
                <?if($this->uri->segment(1) == 'chuyen-muc' || $this->uri->segment(1) == 'hang-san-xuat'){?>
                <?php $this->load->view('templates/default/html/product_associated');?>
                <?php $this->load->view('templates/default/html/features');?>
                <?php $this->load->view('templates/default/html/banner_left');?>
                <?}?>
            </div>
            <div class="bg-title-main">    
                <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=base_url()?>" itemprop="url" class="no-bg"><span itemprop="title">Trang chủ</span></a></div>
                <?=$top_link?>          
            </div>
        </div>
        <div>
            <div class="cat-content">
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
            <div>
                <div>
                   <?=$this->load->view("templates/default/html/box_top");?>
                </div>
                <div>
                   <?=$this->load->view("templates/default/html/randomproduct");?>
                </div>
            </div>
        </div>
    </div>
    <?=$this->load->view('templates/default/html/footer')?>     
</div> <!-- End #wapper -->
</body>
</html>
