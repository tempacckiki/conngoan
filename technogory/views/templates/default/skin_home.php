<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
    <title>ALOBUY Việt Nam - Phân Phối Sỉ & Lẻ Điện Máy, Thiết Bị Nhà Bếp Cao Cấp. </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="Content-Language" content="vn" />
    <meta name="description" content="ALOBUY Việt Nam cung cấp hàng ngàn mặt hàng sản phẩm Điện tử, điện lạnh, gia dụng, Thiết bị KTS, Máy tính và thiết bị văn phòng.">
   
    <meta name="msvalidate.01" content="657B8924E2C066356A8F36096D131302" />
    <meta name="robots" content="INDEX,FOLLOW">
	<?=$this->load->view('templates/default/meta/meta_home')?>
	
</head>
<body id="bd">
	
	<?=$this->load->view('templates/default/html/box_header');?>  
    <div id="main-container"> <!-- #wapper -->
        <header> <!-- header -->
            <?=$this->load->view('templates/default/html/header')?>
            <!-- nav left-->
            <?if($this->uri->segment(1) == ''){?>
            <div class="sl_menu">
                <?=$this->load->view('templates/default/html/navleft')?>
                <div class="wrapper_slider"> <!-- box banner -->
                    <?=$this->load->view('templates/default/html/slider')?>
               </div> 
               
               <?=$this->load->view("templates/default/html/box_top");?>
           </div>
           <?}?>
           <?=$this->load->view("templates/default/html/box-support");?>
           
        </header>
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
        <?=$this->load->view('templates/default/html/footer')?>     
    </div> <!-- End #wapper -->
</body>
</html>
