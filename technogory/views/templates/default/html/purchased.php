<?
$uri1 = $this->uri->segment(1);
$uri2 = $this->uri->segment(2);
$catid = end(explode('-',$uri2));
$this->city_id = $this->session->userdata('city_site');
if($uri1 = 'category'){
$ar_catid = $this->category->get_ar_cat($catid);
$this->db->where_in('catid',$ar_catid);
}
$this->db->select('shop_product.productid, shop_product.productimg, shop_product.tinhnang, shop_product.productname, shop_product.producturl, shop_product.manufactureid, shop_price.*');
$this->db->join('shop_price','shop_price.productid = shop_product.productid');
$this->db->where('shop_price.city_id',$this->city_id);
if($uri1 = 'category'){
$this->db->where_in('shop_product.catid',$ar_catid);
}
$this->db->where('shop_product.published',1);
$this->db->where('shop_price.giathitruong >',0);
$this->db->where('shop_price.giaban >',0);

$this->db->order_by('shop_product.buyer','desc');
$this->db->limit(5);
$list = $this->db->get('shop_product')->result();
?>
<h3 class="title">Mua nhiều nhất</h3>
<div class="box_modules">
    <div class="box-m">
        <ul class="purchased">
        <?
        $i = 1;
        foreach($list as $rs):
        $giaban = $rs->giaban;
        ?>
            <li style="<?=($i == 5)?'border-bottom: 0px;':''?>"  class="vnit_tip" id="tip_<?=$rs->productid?>">
                <div class="img">
                    <a href="<?=site_url('product/'.$rs->producturl.'/'.$rs->productid)?>">
                        <img src="<?=base_url_img()?>data/img_product/80/<?=$rs->productimg?>" alt="<?=$rs->productname?>">
                    </a>
                </div>
                <div class="title"><a href="<?=site_url('product/'.$rs->producturl.'/'.$rs->productid)?>"><?=vnit_cut_string($rs->productname,35)?></a></div>
                <div class="price"><?=number_format($giaban,0,'.','.')?> VND</div>
                <div id="vtip">
                    <div class="v-title">
                        <p><?=$rs->productname?></p>
                        <p class="giaban">Giá bán: <span><?=number_format($giaban,0,'.','.')?></span> VND</p>
                    </div>
                    <div class="vcontent">
     
                    <div class="tinhnang">Tính năng nổi bật</div>
                        <ul class="tinhnangnoibat">
                            <?=addli($rs->tinhnang)?>
                        </ul>
                    </div>
                </div>
            </li>
        <?
        $i++;
        endforeach;?>
        </ul>
    </div>
</div>
