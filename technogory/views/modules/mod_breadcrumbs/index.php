<ul class="links">
    <li class="home"><a class="cufon" href="<?=base_url()?>">Trang chủ</a></li>
    <?if($this->link){
         for($i = 0 ; $i < count($this->link) ; $i++){
            $link = $this->link[$i];
            $links = explode(':',$link);
            if(count($links) == 2){
                $text = $links[0];
                $href= $links[1];
            }else{
                $text = $link;
                $href="";
            }
            ?>
            <li class="item cufon"><?if($href != ''){?><a href="<?=site_url($href)?>"><?=$text?></a><?}else{echo $text;}?></li>
          <?}?>
     <?}?>
</ul>