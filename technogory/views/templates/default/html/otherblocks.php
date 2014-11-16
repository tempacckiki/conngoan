<!-- san pham huu dung -->
<aside class="col-mid-i">
<?php
    $aRandomProducts = $this->helper->getRandomProduct();
    if(count($aRandomProducts) > 0){
        $imgPath   = base_url_static().'technogory/templates/default/images/';
        $base_url_static = $this->config->item('base_url_static');
        $base_url_site = $this->config->item('base_url_site');
?>    
        <div class="title-content"> <!-- title-content -->
            <div class="mang">
                <a href="<?=site_url() . 'huu-dung';?>" target="_blank" title="Sản phẩm hữu dụng">
                    <img src="http://i2.wp.com/meyeucon.org/wp-content/uploads/2013/04/xego.jpg?resize=400%2C400" width="18" height="18"  align="absmiddle" /> Sản phẩm hữu dụng
                </a>

                <p class="more"><a href="<?=site_url() . 'huu-dung';?>" target="_blank">Xem thêm</a></p>
            </div>
        </div> <!-- End title-content -->

        <div>
            <ul>
            <?php
                    foreach ($aRandomProducts as $key => $aProduct) {
                        $tangpham       = addli($aProduct->phukien);
                        $productid      = $aProduct->productid;
                        $productname    = $aProduct->productname;
                        $producturl     = $aProduct->producturl;
                        $aImg = $this->helper->getProductImageByProductId($productid);
                        if(count($aImg) > 0){
                            $productimg     = $base_url_static.'alobuy0862779988/0862779988product/190/' . $aImg[0]->imagepath;
                        } else {
                            $productimg     = $imgPath . 'no_image.gif';
                        }
                        $giathitruong   = number_format($aProduct->giathitruong,0,'.','.');
                        $phantram       = $aProduct->phantram .' %';
                        $giaban         = number_format($aProduct->giaban,0,'.','.');
            ?>
                        <li>
                            <div>
                                <div class="div-info">
                                    <div>
                                        <a title="<?=$productname?>" href="<?=$base_url_site.'san-pham/'.$producturl.'-'.$productid?>.html">
                                            <img height="190" src="<?=$imgPath?>placeholder.gif" data-original="<?=$productimg?>"  alt="<?=$productname?>">
                                        </a>
                                    </div>
                                    <div><a title="<?=$productname?>" href="<?=$base_url_site.'san-pham/'.$producturl.'-'.$productid?>.html"><?=$productname?></a></div>
                                    <div><span><?=$aProduct->barcode?></div>
                                    <div><span><?=$giaban?> ₫</div>
                                <?php
                                    if((double)$aProduct->phantram > 0){
                                ?>
                                        <div><span><?=$giathitruong?> ₫</div>
                                <?php
                                    }
                                ?>
                                </div>
                                <?php
                                    if((double)$aProduct->phantram > 0){
                                ?>
                                        <div class="discount">-<?=$phantram?></div>
                                <?php
                                    } else if($aProduct->sphot) {
                                ?>
                                        <div class="discount">HOT</div>
                                <?php       
                                    }
                                ?>
                            </div>
                        </li>
            <?php
                    }
            ?>
            </ul>
        </div>
<?php
    }
?>
</aside>

<!-- san pham da xem -->
<aside class="col-mid-i">
    <?php
          $sViewedProductIds = $this->session->userdata('sViewedProductIds');
          if(false === $sViewedProductIds){
            // do nothing
            $sViewedProductIds = '';
          }
          $sViewedProductIds = trim($sViewedProductIds, ',');
          $aViewedProductIds = explode(',', $sViewedProductIds);
          // foreach ($aViewedProductIds as $key => $value) {
          //   if((int)$value <= 0){
          //       unset($aViewedProductIds[$key]);
          //   }
          // }

          $aViewedProducts = null;
          if(count($aViewedProductIds)){
            $aViewedProducts = $this->helper->getProductByProductIds($aViewedProductIds);
            if(count($aViewedProducts) <= 0){
                $aViewedProducts = null;
            }
          }

    if(null != $aViewedProducts && count($aViewedProducts) > 0){
?>    
        <div class="title-content"> <!-- title-content -->
            <div class="mang">
                <a href="<?=site_url() . 'da-xem';?>" target="_blank" title="Sản phẩm đã xem">
                    <img src="http://i2.wp.com/meyeucon.org/wp-content/uploads/2013/04/xego.jpg?resize=400%2C400" width="18" height="18"  align="absmiddle" /> Sản phẩm đã xem
                </a>

                <p class="more"><a href="<?=site_url() . 'da-xem';?>" target="_blank">Xem thêm</a></p>
            </div>
        </div> <!-- End title-content -->

        <div>
            <ul>
            <?php
                    foreach ($aViewedProducts as $key => $aProduct) {
                        $tangpham       = addli($aProduct->phukien);
                        $productid      = $aProduct->productid;
                        $productname    = $aProduct->productname;
                        $producturl     = $aProduct->producturl;
                        $aImg = $this->helper->getProductImageByProductId($productid);
                        if(count($aImg) > 0){
                            $productimg     = $base_url_static.'alobuy0862779988/0862779988product/190/' . $aImg[0]->imagepath;
                        } else {
                            $productimg     = $imgPath . 'no_image.gif';
                        }
                        $giathitruong   = number_format($aProduct->giathitruong,0,'.','.');
                        $phantram       = $aProduct->phantram .' %';
                        $giaban         = number_format($aProduct->giaban,0,'.','.');
            ?>
                        <li>
                            <div>
                                <div class="div-info">
                                    <div>
                                        <a title="<?=$productname?>" href="<?=$base_url_site.'san-pham/'.$producturl.'-'.$productid?>.html">
                                            <img height="190" src="<?=$imgPath?>placeholder.gif" data-original="<?=$productimg?>"  alt="<?=$productname?>">
                                        </a>
                                    </div>
                                    <div><a title="<?=$productname?>" href="<?=$base_url_site.'san-pham/'.$producturl.'-'.$productid?>.html"><?=$productname?></a></div>
                                    <div><span><?=$aProduct->barcode?></div>
                                    <div><span><?=$giaban?> ₫</div>
                                <?php
                                    if((double)$aProduct->phantram > 0){
                                ?>
                                        <div><span><?=$giathitruong?> ₫</div>
                                <?php
                                    }
                                ?>
                                </div>
                                <?php
                                    if((double)$aProduct->phantram > 0){
                                ?>
                                        <div class="discount">-<?=$phantram?></div>
                                <?php
                                    } else if($aProduct->sphot) {
                                ?>
                                        <div class="discount">HOT</div>
                                <?php       
                                    }
                                ?>
                            </div>
                        </li>
            <?php
                    }
            ?>
            </ul>
        </div>
<?php
    }
?>
</aside>