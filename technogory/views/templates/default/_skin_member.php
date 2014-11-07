<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
    <title><?if(isset($title)){echo $title.' | ALOBUY Việt Nam - Mua hàng trực tuyến, Giao hàng tận nhà ';}else{echo 'ALOBUY Việt Nam - Mua hàng trực tuyến, Giao hàng tận nhà';}?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="<?if(isset($des)){echo $des;}else{echo  $this->config->item('site_des');}?>">
    <meta name="keywords" content="<?if(isset($keyword)){echo $des;}else{echo  $this->config->item('site_keyword');}?>">
    <?=$this->load->view('templates/default/meta/meta_member')?>
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

    <header> <!-- header -->
        <?=$this->load->view('templates/default/html/header')?>
    </header> <!-- End box banner --> 
    <div class="box-content-wapper">
    	<div class="bg-title-main">    
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=base_url()?>" itemprop="url" class="no-bg"><span itemprop="title">Trang chủ</span></a></div>
		    <?=$top_link?> 		    
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
</div> 
</body>
</html>
