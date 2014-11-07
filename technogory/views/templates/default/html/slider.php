<?if($this->config->item('advtop_total') > 0){?>
<div id="slider" class="nivoSlider">
    <?for($i = 1; $i <= $this->config->item('advtop_total'); $i++){?>
    
    <a href="<?=$this->config->item('advtop_link_'.$i)?>" title="<?=$this->config->item('advtop_name_'.$i)?>">
        <img src="<?=base_url_static();?>alobuy0862779988/adv/bannertop/<?=$this->config->item('advtop_img_'.$i)?>" width="562" height="328"  alt="<?=$this->config->item('advtop_name_'.$i)?>">
         <div class="title-slider">
    		<?=$this->config->item('advtop_name_'.$i)?>
 	  	</div> 
    </a> 
                     
    <?}?>
</div>

<script type="text/javascript">
$(window).load(function() {
    $('#slider').nivoSlider();
});
</script>
<?}?>