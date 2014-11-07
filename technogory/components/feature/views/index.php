<style>
ul.home_list_sp li{
    height: 235px;
}
</style>
<div class="pathway">    
	<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=base_url()?>" itemprop="url" class="homepage"><span itemprop="title">Trang chủ</span></a></div>
    <?=$top_link?> 
    
</div>
<?
// Buoc nay dem hoi cu chuoi
$dem = 0;
$dem_sub = 0;
foreach($listcat as $row):
    $listsubcat = $this->category->get_subcat($row->catid);   
    if(count($listsubcat) > 0){
        $dem_sub = $dem_sub + count($listsubcat);
    }

$dem = $dem + 1;
endforeach;
?>


<?if($dem_sub > 0){?>
<?
$c1 = 0;
foreach($listcat as $row):
$listsubcat = $this->category->get_subcat($row->catid);
?>
<div class="tabcat">
    <span><a  href="<?=site_url('category/'.$row->caturl.'/'.$row->catid)?>"><?=$row->catname?></a></span>
</div>
<ul class="listsubcat">
    <? 
    $i = 1;
    foreach($listsubcat as $val):
    $dem_sub = $dem_sub + 1;
    ?>
    <li class="<?=($i % 4)?'spcat':'spcat1'?>">
        <div align="center">
        <a href="<?=site_url('category/'.$val->caturl.'/'.$val->catid)?>">
        <?if($val->img_main != ''){?>
            <img src="<?=base_url()?>data/img_cat/<?=$val->img_main?>" alt="<?=$val->catname?>">
        <?}else{?>
            <img src="<?=base_url()?>data/no_image.jpg" alt="<?=$val->catname?>">
        <?}?>
        </a>
        </div>
        <div class="title"><a href="<?=site_url('category/'.$val->caturl.'/'.$val->catid)?>"><?=$val->catname?></a></div>
    </li>
    <?
    $i++;
    endforeach;?>
</ul>
<? endforeach;?>

<?}else{?>
<ul class="listsubcat">
    <? 
    $i = 1;
    foreach($listcat as $val):?>
    <li class="<?=($i % 4)?'spcat':'spcat1'?>">
        <div align="center">
        <a href="<?=site_url('category/'.$val->caturl.'/'.$val->catid)?>">
        <?if($val->img_main != ''){?>
            <img src="<?=base_url()?>data/img_cat/<?=$val->img_main?>" alt="<?=$val->catname?>">
        <?}else{?>
            <img src="<?=base_url()?>data/no_image.jpg" alt="<?=$val->catname?>">
        <?}?>
        </a>
        </div>
        <div class="title"><a href="<?=site_url('category/'.$val->caturl.'/'.$val->catid)?>"><?=$val->catname?></a></div>
    </li>
    <?
    $i++;
    endforeach;?>
</ul>
<?}?>

<?if(count($list) > 0){?>
<div id="vnit_page_cat">
    <div class="headcat">
    	
        <ul class="ordering"> 
            <li class="fl"><h2 class="cathead">Tìm thấy <?=$num?> sản phẩm <?=$catinfo->catname;?></h2></li>
            <li class="fr">
                <div class="type-view">
                    <span class="title-option">Xem theo:</span>
                    <a class="deal_view view-grid <?=($this->session->userdata('vnit_view')=='view_list')?'active':''?>" onclick="change_view('view_list')" title="Dạng khối" id="grid" href="javascript:;"></a>
                    <a class="deal_view view-col <?=($this->session->userdata('vnit_view')=='view_grid')?'active':''?>" onclick="change_view('view_grid')" title="Dạng danh sách" id="list" href="javascript:;"></a>
                    <input type="hidden" value="<?=$this->session->userdata('vnit_view')?>" id="vnit_view">
                </div>
            </li>            
            <li class="fr">
                <select onchange="change_order(this.value)" id="vnit_order">
                    <option value="price_desc">Giá giảm dần</option>
                    <option value="price_asc" selected="selected">Giá tăng dần</option>
                    <option value="name_asc">Từ A-Z</option>
                    <option value="name_desc">Từ Z-A</option>
                </select>
            </li>            
            <li class="fr">
                <select onchange="change_hot(this.value)" id="vnit_hot" style="width: 120px;">
                    <option value="all">Tất cả</option>
                    <option value="hot">Hàng hot</option>
                    <option value="new">Hàng mới</option>
                    <option value="promotion">Hàng khuyến mãi</option>
                </select>
            </li>
        </ul>
    </div>
    <div class="div_comparison"> <!-- Begin So sanh-->
        <form id="form_compare" accept-charset="utf-8" method="post" action="#">
            <div class="list-compare">
                <span class="compareItemContain" id="compareItemContain_1"></span>
                <span class="compareItemContain" id="compareItemContain_2"></span>
                <span class="compareItemContain" id="compareItemContain_3"></span>
            </div>
            <input type="hidden" value="" id="productItemContain_1">
            <input type="hidden" value="" id="productItemContain_2">
            <input type="hidden" value="" id="productItemContain_3">
            <input type="hidden" value=";" id="productCompareList">
            <input type="button" value="So sánh" class="submit" onclick="goComparePage(<?=$catinfo->catid?>)"> 
            <div class="div_page pages" style="padding: 0px;"><?=$pagination?></div>
        </form>

    </div> <!-- End So sanh-->
    <?if($this->session->userdata('vnit_view')=='view_list'){?>
   
    <ul id="thumb" class="cat-p-i">
    <?
    $i = 1;
    foreach($list as $rs){
       // $listgift = $this->category->get_list_gifts($rs->productid);
        //$tangpham = $this->category->gettangpham($rs->productid);
        $tangpham = $rs->phukien;
        $giathitruong = $rs->giathitruong;
        $giaban = $rs->giaban;
        $giamgia = $rs->giamgia;
        $phantram = $rs->phantram;
        $tinhtrang = $rs->tinhtrang;
        $tinhtrang_text = $rs->tinhtrang_text;
        
        $nxs = $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$rs->manufactureid));
        ?>
        <li id="tip_<?=$rs->productid?>" class="vnit_tip">
            <!--<div class="hot"><img src="<?=base_url()?>site/templates/fyi/images/new.gif"></div>-->
            <figure class="img">
                <!--<div class="nsx"><img src="<?=base_url()?>data/img_manufacture/<?=$nxs->images_small?>" width="60px"></div>-->
                <a href="<?=site_url('product/'.$rs->producturl.'/'.$rs->productid)?>" title="<?=$rs->productname?>">
                <img id="zoom" src="<?=base_url_img()?>data/img_product/200/<?=$rs->productimg?>" alt="<?=$rs->productname?>" class="product">
                </a>

            </figure>
            <p class="name"><a href="<?=site_url('product/'.$rs->producturl.'/'.$rs->productid)?>" title="<?=$rs->productname?>"><?=$rs->productname?></a></p>
            <div class="sales-off">
                <p class="price-old"><?=number_format($giathitruong,0,'.','.')?> VND</p>
                <p class="discount">Tiết kiệm: <?=number_format($giamgia,0,'.','.')?> VND</p>
            </div>
            <p class="price">
                <span><?=number_format($giaban,0,'.','.')?> VND</span>
            </p>
            <div style="text-align: center;">
                <input type="checkbox" name="compare_id" id="compareItem_<?=$rs->productid?>" onclick="addCompareList(<?=$rs->productid?>)"> Chọn so sánh
                <input type="hidden" id="productHiddenImage_<?=$rs->productid?>" value="<?=base_url_img()?>data/img_product/40/<?=$rs->productimg?>"> 
            </div>
            <div id="vtip">
                <div class="v-title">
                    <p><?=$rs->productname?></p>
                    <p class="giaban">Giá bán: <span><?=number_format($giaban,0,'.','.')?></span> VND</p>
                </div>
                <div class="vcontent">
                <?if($tangpham){?>
                    <div class="v-discount">
                        <div class="tangpham">Khuyến mãi</div>
                        <div class="tangpham_title"><?=$tangpham;?></div>
                    </div>
                <?}?>
                <div class="tinhnang">Tính năng nổi bật</div>
                    <ul class="tinhnangnoibat">
                        <?=addli($rs->tinhnang)?>
                    </ul>
                </div>
            </div>
        </li>
    <?
    $i++;
    }?>
    </ul>
    <?}else{?>
    <ul class="listpro" id="thumbs">
    <?foreach($list as $rs):
    $nxs = $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$rs->manufactureid));
    //$listgift = $this->category->get_list_gifts($rs->productid);
     $listgift = $rs->phukien;
        $giathitruong = $rs->giathitruong;
        $giaban = $rs->giaban;
        $giamgia = $rs->giamgia;
        $phantram = $rs->phantram;
        $tinhtrang = $rs->tinhtrang;
        $tinhtrang_text = $rs->tinhtrang_text;
    ?>
        <li>
            <div class="show_img">
                <div class="img">
                    <div class="new"></div>
                    <?if($nxs){?>
                    <div class="nsx"><img src="<?=base_url_img()?>data/img_manufacture/<?=$nxs->images_small?>" height="25px"></div>
                    <?}?>
                    <a href="<?=site_url('product/'.$rs->producturl.'/'.$rs->productid)?>" title="<?=$rs->productname?>">
                    <img id="zoom" class="pro hover" src="<?=base_url_img()?>data/img_product/200/<?=$rs->productimg?>" alt="<?=$rs->productname?>">
                    </a>
                </div>
                <div align="center">
                    <input type="checkbox" name="compare_id" id="compareItem_<?=$rs->productid?>" onclick="addCompareList(<?=$rs->productid?>)"> Chọn so sánh
                    <input type="hidden" id="productHiddenImage_<?=$rs->productid?>" value="<?=base_url_img()?>data/img_product/40/<?=$rs->productimg?>">
                </div>
            </div>
            <div class="show_info">
                <div class="col_l">
                    <div class="productname"><a href="<?=site_url('product/'.$rs->producturl.'/'.$rs->productid)?>" title="<?=$rs->productname?>"><?=$rs->productname?></a></div>
                    <div class="show_attr">
                        <ul class="tinhnangnoibat">
                        <?echo addli($rs->tinhnang);?>
                        </ul>
                        <div class="readmore"><a href="<?=site_url('product/'.$rs->producturl.'/'.$rs->productid)?>" title="<?=$rs->productname?>">Xem chi tiết</a></div>
                        <!--
                        <div class="cm-d-rating">
                            <?$rating = $this->category->loadRating($rs->productid); ?>
                            <div style="width: 100px;float: left;">
                                <ul class="star-rating">
                                    <li  style="width: <?=$rating?>%;" class="current-rating" id="current-rating_<?=$rs->productid?>"></li>
                                    <?if($this->category->check_session_rating($rs->productid)==0){?>
                                    <span id="ratelinks">
                                        <li><a class="one-star" rel="<?=$rs->productid?>" title="1 star out of 5" href="javascript:void(0)">1</a></li>
                                        <li><a class="two-stars" rel="<?=$rs->productid?>" title="2 stars out of 5" href="javascript:void(0)">2</a></li>
                                        <li><a class="three-stars" rel="<?=$rs->productid?>" title="3 stars out of 5" href="javascript:void(0)">3</a></li>
                                        <li><a class="four-stars" rel="<?=$rs->productid?>" title="4 stars out of 5" href="javascript:void(0)">4</a></li>
                                        <li><a class="five-stars" rel="<?=$rs->productid?>" title="5 stars out of 5" href="javascript:void(0)">5</a></li>
                                    </span>
                                    <?}?>
                                </ul>
                                <input type="hidden" value="<?=$rs->productid?>" id="ratingid_<?=$rs->productid?>">
                            </div>
                            <div style="float: right;">Xem nhận xét</div>
                        </div>
                        -->
                    </div>
                    
                </div>
                <div class="col_r">
                    <div class="show_price">
                        <div class="top">
                            <p class="price"><span><?=number_format($giaban,0,'.','.')?> VND</span></p>
                            <p class="price-old">Giá thị trường: <?=number_format($giathitruong,0,'.','.')?> VND</p>
                            <?if($giamgia > 0){?>
                            <p class="discount">Tiết kiệm: <?=number_format($giamgia,0,'.','.')?> VND = <?=$phantram?>%</p> 
                            <?}?>
                            <div class="box_buy">
                            <input type="text" value="1" name="qty" id="qty_<?=$rs->productid?>" class="qty">
                            <a href="javascript:;" id="product_<?=$rs->productid?>" class="addtocart chonmua"></a>
                            </div>
                        </div>
                        <div class="under">
                        <!--<?if(count($listgift)>0){?>
                            <?foreach($listgift as $km){?>
                            <div class="gifts"><?=$km->name?></div>
                            <?}?>
                        <?}?>-->
                         <div class="gifts"><?=$listgift;?></div>
                        </div>
                        
                    </div>
                </div>
                <div class="clear"></div>
                
            </div>

        </li>
    <?endforeach;?>
    </ul>
    <?}?>
    <div class="clear"></div>
    <div class="div_comparison" style="margin-top: 10px;border: 1px solid #E2E2E2;border-bottom: 0px;"> <!-- Begin So sanh-->
        <form id="form_compare" accept-charset="utf-8" method="post" action="#">
            <div class="list-compare">
                <span class="compareItemContain" id="compareItemContain2_1"></span>
                <span class="compareItemContain" id="compareItemContain2_2"></span>
                <span class="compareItemContain" id="compareItemContain2_3"></span>
            </div>
            <input type="hidden" value="" id="productItemContain2_1">
            <input type="hidden" value="" id="productItemContain2_2">
            <input type="hidden" value="" id="productItemContain2_3">
            <input type="hidden" value=";" id="productCompareList">
            <input type="button" value="So sánh" class="submit" onclick="goComparePage(<?=$catinfo->catid?>)"> 
            <div class="div_page pages" style="padding: 0px;"><?=$pagination?></div>
        </form>

    </div> <!-- End So sanh-->
    <div class="footcat">
        <ul class="ordering"> 
            <li class="fl">Tìm thấy <span id="num"><b><?=$num?> </b></span>sản phẩm<h2 class="cathead"><?=$catinfo->catname;?></h2></li>
            <li class="fr">
                <div class="type-view">
                    <span class="title-option">Xem theo:</span>
                    <a class="deal_view view-grid <?=($this->session->userdata('vnit_view')=='view_list')?'active':''?>" onclick="change_view('view_list')" title="Dạng khối" id="grid" href="javascript:;"></a>
                    <a class="deal_view view-col <?=($this->session->userdata('vnit_view')=='view_grid')?'active':''?>" onclick="change_view('view_grid')" title="Dạng danh sách" id="list" href="javascript:;"></a>
                    <input type="hidden" value="<?=$this->session->userdata('vnit_view')?>" id="vnit_view">
                </div>
            </li>            
            <li class="fr">
                <select onchange="change_order(this.value)" id="vnit_order">
                    <option value="price_desc">Giá giảm dần</option>
                    <option value="price_asc">Giá tăng dần</option>
                    <option value="name_asc">Từ A-Z</option>
                    <option value="name_desc">Từ Z-A</option>
                </select>
            </li>            
            <li class="fr">
                <select onchange="change_hot(this.value)" id="vnit_hot" style="width: 120px;">
                    <option value="all">Tất cả</option>
                    <option value="hot">Hàng hot</option>
                    <option value="new">Hàng mới</option>
                    <option value="promotion">Hàng khuyến mãi</option>
                </select>
            </li>
        </ul>
    </div>
</div>
<?
    $url = get_url();
    $temp = explode('?',$url);
    if(isset($temp[1])){
        $url_page = '?'.$temp[1];
    }else{
        $url_page = '';
    }
?>
<script type="text/javascript">
var catid = <?=$catinfo->catid?>; 
var input_get = '<?=$url_page?>';

</script>
<?}?>
