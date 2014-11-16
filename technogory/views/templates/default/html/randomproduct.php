<aside id="col-right-i">
    <?php
        $aRandomProducts = $this->helper->getRandomProduct();
        if(count($aRandomProducts) > 0){
            $imgPath   = base_url_static().'technogory/templates/default/images/';
            $base_url_static = $this->config->item('base_url_static');
            $base_url_site = $this->config->item('base_url_site');
    ?>
        <div class="box-quan-tam">
            <ul class="list-items">
                <?php
                    foreach ($aRandomProducts as $key => $aProduct) {
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
                            <div>
                                <a title="<?=$productname?>" href="<?=$base_url_site.'san-pham/'.$producturl.'-'.$productid?>.html">
                                    <img height="190" src="<?=$productimg?>" data-original="<?=$productimg?>"  alt="<?=$productname?>">
                                </a>                    
                            </div>
                            <div><?=$productname?></div>
                            <div><?=$aProduct->barcode?></div>
                            <div>
                                <div><?=$giaban?></div>
                                <?php
                                    if((double)$aProduct->phantram > 0){
                                ?>
                                    <div><?=$giathitruong?></div>
                                <?php
                                    }
                                ?>                                      
                            </div>
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
