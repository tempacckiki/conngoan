<?php
$imgdir = ROOT.get_params("url_folder",$attr);
$w_s = ROOT.get_params("w_s",$attr);
$h_s = ROOT.get_params("h_s",$attr);
$img_dir = base_url().get_params("url_folder",$attr);
$allowed_types = array("png","jpg","jpeg","gif"); // list of filetypes you want to show
?>
<style>
.theme-default{
    width: <?=$w_s?>;
    height: <?=$h_s?>;
    display: block;
    overflow: hidden;

    position: relative;  
}
</style>
<?
$dimg = opendir($imgdir);
while($imgfile = readdir($dimg))
{
 if(in_array(strtolower(substr($imgfile,-3)),$allowed_types))
 {
  $a_img[] = $imgfile;
  sort($a_img);
  reset ($a_img);
 } 
}

$totimg = count($a_img); // total image number
 
for($x=0; $x < $totimg; $x++)
{
 $size = getimagesize($imgdir."/".$a_img[$x]);

 $halfwidth = ceil($size[0]/2);
 $halfheight = ceil($size[1]/2);
}

?>
<script type="text/javascript" src="<?=base_url()?>site/views/modules/mod_slideshow/esset/jquery.nivo.slider.js"></script>
<link rel="stylesheet" href="<?=base_url()?>site/views/modules/mod_slideshow/esset/nivo-slider.css" type="text/css" media="screen" />

    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    </script>
    <div class="theme-default">
    <div class="ribbon"></div>
        <div id="slider" class="nivoSlider">
        <?php
        for($x=0; $x < $totimg; $x++)
        {                
        ?>
            <a href="<?=$img_dir.$a_img[$x]?>" title="" ><img src="<?=$img_dir.$a_img[$x]?>" alt="" /></a>
        <?php }?>
        </div>
    </div>
