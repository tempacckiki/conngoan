<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
   <title><?=$title;?> - Alobuy.vn</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="<?=$title;?> ">
	<meta name="keywords" content="<?=$title;?>">    
    <?=$this->load->view('templates/default/meta/meta_deal')?>
</head>
<body id="bd">	
	<?php echo $this->load->view('templates/default/html/box_header');?> 
<div id="show_msg"></div>
 <div id="main-container"> 
    <header> 
       <?php echo $this->load->view('templates/default/html/header')?>
           
    </header> 
    <div class="box-content-wapper">
    	<div class="bg-title-main">    
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=base_url()?>" itemprop="url" class="no-bg"><span itemprop="title">Trang chủ</span></a></div>
		     <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=site_url('gia-re-moi-ngay')?>" itemprop="url"><span itemprop="title">Đang giảm giá</span></a></div>
		    <?php 
		    if(!empty($catinfo)){
		    ?>
		    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="no-bg"><a href="<?=site_url('gia-re-moi-ngay/'.$catinfo->caturl.'-'.$catinfo->catid);?>" itemprop="url"><span itemprop="title"><?=$catinfo->catname?></span></a></div>
		    <?php }?>
		    
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
    	<?php echo $this->load->view($page);?>    
	</div>
    <?php echo $this->load->view('templates/default/html/footer');?>     
</div> 
</body>
</html>
