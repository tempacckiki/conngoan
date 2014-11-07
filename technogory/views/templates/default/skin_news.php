<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
   <title><?=$title;?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="<?=$title;?> ">
	<!-- <meta name="keywords" content="<?=$title;?>"> -->
    <!--<meta name="keywords" content="<?if(isset($keyword)){echo $des;}else{echo  $this->config->item('site_keyword');}?>">-->
	<meta name="msvalidate.01" content="657B8924E2C066356A8F36096D131302" />
    <?=$this->load->view('templates/default/meta/meta_news')?>
</head>
<body id="bd">
	<?=$this->load->view('templates/default/html/box_header');?> 
	
	<div id="show_msg"></div>
 <div id="main-container"> <!-- #wapper -->

    <header> <!-- header -->
        <?=$this->load->view('templates/default/html/header')?>
    </header> <!-- End box banner --> 
    <div class="box-content-wapper">
    <div class="bg-title-main">    
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=base_url()?>" itemprop="url" class="no-bg"><span itemprop="title">Trang chủ</span></a></div>
		     <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=site_url('tin-tuc')?>" itemprop="url"><span itemprop="title">Tin tức</span></a></div>
		    <?php 
		    if(!empty($catinfo)){
		    ?>
		    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="no-bg"><a href="<?=site_url('news/'.$catinfo->caturl.'-'.$catinfo->catid);?>" itemprop="url" class="homepage"><span itemprop="title"><?=$catinfo->catname?></span></a></div>
		    <?php }?>
		    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=$top_link_seo;?>" itemprop="url"><span itemprop="title"><strong><?=vnit_cut_string($rs->title, 60);?></strong></span></a></div>
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
