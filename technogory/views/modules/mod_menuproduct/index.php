<link type="text/css" rel="stylesheet" href="<?=base_url()?>site/views/modules/mod_menuproduct/esset/category.css?v=2.0" media="screen" />
<link type="text/css" rel="stylesheet" href="<?=base_url()?>vnit/templates/css/menu_left.css?v=2.0" media="screen" />
<script type="text/javascript">
var item_select = "item<?=(isset($menuid))?$menuid:''?>";
<!--//--><![CDATA[//><!--
    $(document).ready(function() {
        $("#nv_ac").each(function() {
            $("#nv_ac ul").css("display", "none");
            $(this).find('ul#'+item_select).css('display','block');
            $(this).find('ul#'+item_select+' a.arrow').html('<img src="'+base_url+'site/templates/songdong/images/menu-collapsed.gif">');
        });
        $("#nv_ac li a.arrow").click(function() { 
            var nv_id = "#" + $(this).attr("rel");
                        
            $("#nv_ac ul").slideUp();
            $("#nv_ac li a.arrow").each(function() {
                var src = $(this).find('img')
                if(src.attr("src")){
                    $(this).html('<img src="'+base_url+'site/templates/songdong/images/menu-collapsed.gif">');               
                }
            });

            
            if ($(nv_id).css("display") == "none") { 
                $(nv_id).slideDown();
                
                $(this).html('<img src="'+base_url+'site/templates/songdong/images/menu-expanded.gif">');
            }else {
                $(nv_id).slideUp();
                $(this).html('<img src="'+base_url+'site/templates/songdong/images/menu-collapsed.gif">');
            }
        });
    });
//--><!]]>
</script>
<?
    $uri=$this->uri->segment(1);
    $uri2=$this->uri->segment(2);
    $list = $this->vdb->find_by_list('shop_cat',array('published'=>1,'parentid'=>0),array('ordering'=>'asc'));
?>
 <ul class="nv-ac" id="nv_ac">
 <?
 $i=1;
 foreach($list as $rs):
 $listsub = $this->vdb->find_by_list('shop_cat',array('published'=>1,'parentid'=>$rs->catid));
 ?>
    <li><a href="javascript:;" rel="item<?=$rs->catid?>" class="arrow">
    <?if(count($listsub) > 0){?><img src="<?=base_url()?>site/templates/songdong/images/menu-collapsed.gif"><?}?>
        <a href="<?=site_url('product/view_cat/'.$rs->caturl.'-'.$rs->catid)?>"><?=$rs->catname?></a>
        <?if(count($listsub) > 0){?>
        <ul id="item<?=$rs->catid?>">
            <?foreach($listsub as $val):?>
            <li><a href="<?=site_url('product/view_cat/'.$val->caturl.'-'.$val->catid)?>"><?=$val->catname?></a></li>
            <?endforeach;?>
        </ul>
        <?}?>
    </li>
 <?
 $i++;
 endforeach;?>                                        
 </ul>



