<?php
  $max = get_params('max',$attr);  
  $this->db->order_by('hits','desc');
  $this->db->limit($max);
  $list = $this->db->get('content')->result();
?>
<ul class="most_read">
    <?foreach($list as $rs):?>
    <li>
        <?if($rs->images_thumb !=''){?>
        <div class="img">
            <img src="<?=base_url().$rs->images_thumb?>" alt="">
        </div>
        <?}?>
        <?=anchor('content/article/'.$rs->title_alias.'-'.$rs->id,$rs->title)?>
    </li>
    <?endforeach;?>
</ul>
