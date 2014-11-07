<?
$uri1 = $this->uri->segment(1);
$uri2 = $this->uri->segment(2);
$uri3 = $this->uri->segment(3);
if($uri1 == 'tin-tuc'){
    $listdocnhieu = $this->news->get_tindocnhieu();
}else{
    if($uri3 != ''){// detail
        $catid = $catinfo->catid;
        $newsid = $rs->newsid;
        $listdocnhieu = $this->news->get_tindocnhieu($catid, $newsid);
    }else{// cat
        $catid = $catinfo->catid;
        $listdocnhieu = $this->news->get_tindocnhieu($catid);   
    }  
}

?>

<div class="box_modules">
	
	<div class="title">
			<p class="text">Thông tin tiêu điểm</p>
			<span class="text">&nbsp;</span>
	</div>
    <ul class="docnhieu">
    <?
    $read  = 1;
    foreach($listdocnhieu as $rs):
    	if($read == 1){
    ?>
    	<li class="item0">
    		<p class="img0">
    		 <a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>" title="<?=$rs->title?>">
                    <img src="<?=base_url().$rs->images_thumb?>" width="286" alt="<?=$rs->title?>">
              </a>
    		</p>
    		<p class="name"> <a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>" title="<?=$rs->title?>"><?=$rs->title?></a></p>
    	</li>
    <?php 
    	}else{
    ?>
        <li class="float-left">
        	<p class="img-thumb">
        		<a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>" title="<?=$rs->title?>"><img src="<?=base_url().$rs->images_thumb?>" alt="<?=$rs->title?>" width="123"></a>
        	</p>
            <p class="name-relative">
                <a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>" title="<?=$rs->title?>">
                <?=$rs->title?>
                </a>
           </p>
        </li>
    <?
    	}
    $read ++;	
    endforeach;
    
    ?>
    </ul>
</div>
