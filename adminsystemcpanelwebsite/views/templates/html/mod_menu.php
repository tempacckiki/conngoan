<?//$list = $this->db->get('menu_type')->result();?>

<div id="slidemenu" class="ddsmoothmenu">
    <ul>
        <li>
            <a href="<?=site_url('admincp')?>" style="padding-right: 23px;" class=""><span>Bảng điều khiển</span></a>
            <ul>
                <li><a href="<?=site_url('vcache')?>">Lưu Cache</a></li>
                <li><a href="<?=site_url('siteconfig/info')?>">Cấu hình website</a></li>
                <li><a href="<?=site_url('accountinfo')?>">Thông tin tài khoản</a></li>
                <li><a href="<?=site_url('login/logout')?>">Thoát</a></li>
            </ul>
        </li>
        <?if($this->permit->get_permit_mainmenu('thanhvien')){?> 
        <li>
            <a href=""><span>Thành viên</span></a>
            <ul>
                <?if($this->permit->get_permit_icon('account/listaccount')){?>
                <li><a href="<?=site_url('account/listaccount')?>"><span>Danh sách thành viên</span></a></li>
                <li><a href="<?=site_url('account/listaccountAddmin')?>"><span>Danh sách quản trị website</span></a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('account/add')){?>
                <li><a href="<?=site_url('account/add')?>"><span>Thêm mới thành viên</span></a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('account/history')){?>
                <li><a href="<?=site_url('account/history')?>"><span>Lịch sử truy cập</span></a></li>
                <?}?>
                <?if($this->session->userdata('group_id') == 18){?>
                <li><a href="<?=site_url('phanquyen/ds')?>"><span>Phân quyền</span></a></li>
                <li><a href="<?=site_url('phanquyen/danhmuc')?>"><span>Phân quyền danh mục</span></a></li>
                <?}?>

            </ul>
        </li>
        <?}?>
        <?if($this->permit->get_permit_mainmenu('sanpham')){?>
        <li>
            <a href="#" style="padding-right: 23px;" class=""><span>Gian hàng</span></a>
            <ul>
                <?if($this->permit->get_permit_icon('product/shop/listproduct')){?>
                <li>
                    <a href="<?=site_url('product/shop/listproduct/0/25')?>">Quản lý sản phẩm</a>
                    <ul>
                        <li><a href="<?=site_url('product/producthome/ds')?>">Sản phẩm trang chủ home</a></li>
                        <li><a href="<?=site_url('product/producthome/hot')?>">Khuyến mãi bán chạy home </a></li>
                        <li><a href="<?=site_url('product/producthome/muanhieu')?>">Sản phẩm khuyến mãi home</a></li>
                        <li><a href="<?=site_url('product/producthome/cat')?>">Sản phẩm hot chuyên mục</a></li>
                    </ul>
                </li>
                <?}?>
                <?if($this->permit->get_permit_icon('product/order/listorder')){?>
                <li>
                    <a href="<?=site_url('product/order/listorder/moinhat')?>">Đơn hàng</a>
                    <ul>
                        <li><a href="<?=site_url('thongke')?>">Thống kê đơn hàng</a></li>
                    </ul>
                </li>
                <?}?>
                <?if($this->permit->get_permit_icon('nhomhang/dsnhomhang')){?>
                <li><a href="<?=site_url('nhomhang/dsnhomhang')?>">Nhóm hàng</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('danhmuc/ds')){?>
                <li><a href="<?=site_url('danhmuc/ds')?>">Danh mục</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('product/manufacture/listmanufacture')){?>
                <li><a href="<?=site_url('product/manufacture/listmanufacture')?>">Hãng sản xuất</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('baohanh/ds')){?>
                <li><a href="<?=site_url('baohanh/ds')?>">Điểm bảo hành</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('icolor/ds')){?>
                <li><a href="<?=site_url('icolor/ds')?>">Bảng mầu sản phẩm</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('features/manage/listmanage')){?>
                <li><a href="<?=site_url('features/manage/listmanage')?>">Thuộc tính sản phẩm</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('features/manage/feature_cat')){?>
                <li><a href="<?=site_url('features/manage/feature_cat')?>">Thuộc tính - Nhóm sản phẩm</a></li>
                <?}?>

                <?if($this->permit->get_permit_icon('phuongthuc/phivanchuyen/index')){?>
                <li><a href="<?=site_url('phuongthuc/phivanchuyen/index')?>">Phí vận chuyển</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('phuongthuc/thanhtoan/ds')){?>
                <li><a href="<?=site_url('phuongthuc/thanhtoan/ds')?>">Phương thức thanh toán</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('phuongthuc/vanchuyen/ds')){?>
                <li><a href="<?=site_url('phuongthuc/vanchuyen/ds')?>">Phương thức vận chuyển</a></li>
                <?}?>
                
                 <li><a href="<?=site_url('cat_info/detailnews/ds')?>">Thông tin chuyên mục</a></li>
				<!-- 
                <?if($this->permit->get_permit_icon('callme/ds')){?>
                <li><a href="<?=site_url('callme/ds')?>">Liên hệ tư vấn</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('product/shop/listcomment')){?>
                <li><a href="<?=site_url('product/shop/listcomment')?>">Bình luận</a></li>
                <?}?>
                 -->
            </ul>
        </li> 
        <?}?>
        
        <li><a href="#" style="padding-right: 23px;" class=""><span>Sàn giá rẻ</span></a>
        	<ul>
        		<li>  <a href="<?=site_url('deal/productdeal/ds');?>" style="padding-right: 23px;" class=""><span>Sản phẩm sản giá rẻ</span></a></li>
        		<!-- <li>  <a href="<?=site_url('adsdeal/bannertop/ds');?>" style="padding-right: 23px;" class=""><span>Banner Quảng cáo head</span></a></li> -->
        	</ul>
        </li>
        
        <!--  
        <?if($this->permit->get_permit_mainmenu('tragop')){?> 
        <li>
            <a href="#">Trả góp</a>
            <ul>
                <?if($this->permit->get_permit_icon('tragop/cauhinh/index')){?> 
                <li><a href="<?=site_url('tragop/cauhinh/index')?>">Cấu hình</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('tragop/order/listorder')){?> 
                <li><a href="<?=site_url('tragop/order/listorder/moinhat')?>">Đơn hàng</a></li>
                <?}?>
            </ul>
        </li>
        <?}?>
        -->
        <?if($this->permit->get_permit_mainmenu('tintuc')){?>
        <li>
            <a href="#" style="padding-right: 23px;" class=""><span>Tin tức</span></a>
            <ul>
                <?if($this->permit->get_permit_icon('tintuc/danhmuc')){?> 
                <li><a href="<?=site_url('tintuc/danhmuc')?>">Danh mục</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('tintuc/baiviet')){?> 
                <li><a href="<?=site_url('tintuc/baiviet')?>">Danh sách bài viết</a></li>
                <?}?>
                 <li><a href="<?=site_url('tintuc/newsproduct/getNewsProduct')?>">Quản lý chi tiết sản phẩm</a></li>
                 <li><a href="<?=site_url('tintuc/readMany')?>">Quản lý thông tin tiêu điểm</a></li>
                 <li><a href="<?=site_url('tintuc/readThumb')?>">Quản lý bài viết thumb</a></li>
                 <li><a href="<?=site_url('tintuc/photonews/readPhoto')?>">Quản lý bài viết ảnh đẹp</a></li>
                 <li><a href="<?=site_url('ads/editHorizontal')?>">Quảng cáo banner ngang</a></li>                 
                 <li><a href="<?=site_url('ads/editlogo')?>">Quảng cáo banner right top</a></li>                 
                 <li><a href="<?=site_url('quangcao/detailnews/ds')?>">Quảng cáo banner chi tiết</a></li>                 
                 <li><a href="<?=site_url('videoclip')?>">Quản lý Video clip</a></li>
                <?if($this->permit->get_permit_icon('tintuc/listcomment')){?> 
                <li><a href="<?=site_url('tintuc/listcomment')?>">Bình luận</a></li>
                <?}?>
            </ul>
        </li>
        <?}?>
        
       
        
        <?if($this->permit->get_permit_mainmenu('quangcao')){?>
        <li>
            <a href="#" style="padding-right: 23px;" class=""><span>Quảng cáo</span></a>
            <ul>
            	 <?if($this->permit->get_permit_icon('quangcao/chitiet/ds')){?>
                <li><a href="<?=site_url('quangcao/chitiet/ds')?>">Quảng cáo từng chuyên mục top</a></li>
                <?}?>
				 <?if($this->permit->get_permit_icon('quangcao/left/ds')){?>
                <li><a href="<?=site_url('quangcao/left/ds')?>">Quảng cáo từng chuyên mục left</a></li>
                <?}?>
            	<li><a href="<?=site_url('quangcao/dealindextop/ds')?>">Quảng cáo deal Top index</a></li>
            	<li><a href="<?=site_url('quangcao/dealindexfooter/ds')?>">Quảng cáo deal footer index</a></li>
                <li><a href="<?=site_url('quangcao/dealindex/ds')?>">Quảng cáo deal left index</a></li>
               
                <?if($this->permit->get_permit_icon('quangcao/city/index')){?>
                <li><a href="<?=site_url('quangcao/city/index')?>">Popup khu vực</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('quangcao/bannertruot')){?>
                <li><a href="<?=site_url('quangcao/bannertruot')?>">Banner trượt</a></li>
                <?}?>
                <!-- 
                 <?if($this->permit->get_permit_icon('quangcao/danhmuc/ds')){?>
                <li><a href="<?=site_url('quangcao/danhmuc/ds')?>">QC Danh mục trang chủ</a></li>
                <?}?>
                 -->
                <?if($this->permit->get_permit_icon('quangcao/bannertop/ds')){?>
                <li><a href="<?=site_url('quangcao/bannertop/ds')?>">Quảng cáo top trang chủ</a></li>
                <?}?>
                <li><a href="<?=site_url('quangcao/banner_newspage/listads')?>">Quảng cáo tin tức</a></li>
                <li><a href="<?=site_url('quangcao/banner_news')?>">Quảng cáo footer</a></li>
                
                 <!--  
                <?if($this->permit->get_permit_icon('quangcao/khuyenmai/index')){?>
                <li><a href="<?=site_url('quangcao/khuyenmai/index')?>">Quảng cáo khuyến mãi</a></li>
                <?}?>
               
               -->
               
                <!-- 
                <?if($this->permit->get_permit_icon('quangcao/popup/content')){?>
                <li><a href="<?=site_url('quangcao/popup/content')?>">QC Popup Content</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('quangcao/popup/footer')){?>
                <li><a href="<?=site_url('quangcao/popup/footer')?>">QC Popup Footer Right</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('quangcao/footer/index')){?>
                <li><a href="<?=site_url('quangcao/footer/index')?>">QC Footer Left</a></li>
                <?}?>
                 -->
            </ul>
        </li>
        <?}?>
        <!-- 
        <?if($this->permit->get_permit_mainmenu('sukien')){?>
        <li>
            <a href="<?=site_url('sukien/ds')?>" style="padding-right: 23px;" class=""><span>Sự kiện</span></a>
        </li> 
        <?}?>
         -->
        <?if($this->permit->get_permit_mainmenu('morong')){?> 
        <li>
            <a href="#" style="padding-right: 23px;" class=""><span>Mở rộng</span></a>
            <ul>
                <?if($this->permit->get_permit_icon('suppermarket/listsupper')){?>
                <li><a href="<?=site_url('suppermarket/listsupper')?>">Hệ thống siêu thị</a></li>
                <?}?>
                <li><a href="<?=site_url('dichvu')?>">Dịch vụ</a></li>
                <li><a href="<?=site_url('subscriptions/index')?>">Đăng ký nhận khuyến mãi</a></li>
                <?if($this->permit->get_permit_icon('support/ds')){?>
                <li><a href="<?=site_url('support/ds')?>">Hỗ trợ trực tuyến</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('createmenu/ds')){?>
                <li><a href="<?=site_url('createmenu/ds')?>">Xây dụng Main Menu</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('giamgia/ds')){?>
                <li><a href="<?=site_url('giamgia/ds')?>">Mã giảm giá</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('thanhpho/listthanhpho')){?>
                <li><a href="<?=site_url('thanhpho/listthanhpho')?>">Tỉnh, Thành phố</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('faq/listfaq')){?>
                <li><a href="<?=site_url('faq/listfaq')?>">Hướng dẫn</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('eskin/ds')){?>
                <li><a href="<?=site_url('eskin/ds')?>">Email Templates</a></li> 
                <?}?>
                <?if($this->permit->get_permit_icon('csdl/index')){?>
                <li><a href="<?php echo site_url('csdl/index')?>">Cơ sở dữ liệu</a></li>
                <?}?>
            </ul>
        </li>
        <?}?>
        <?if($this->permit->get_permit_mainmenu('ex/im')){?>    
        <li>
            <a href="#"><span>Export/Import</span></a>
            <ul>
                <?if($this->permit->get_permit_icon('export/index')){?>
                <li><a href="<?=site_url('export')?>">Export sản phẩm</a></li>
                <?}?>
                <?if($this->permit->get_permit_icon('import/action')){?>
                <li><a href="<?=site_url('import/action')?>">Import sản phẩm</a></li>
                <?}?>
            </ul>
        </li>
        <?}?>
        
        <li>
        	<a href="">Đấu giá</a>
        	<ul>
                        <li><a href="<?=site_url('daugia/cauhinh/cauhinhsite')?>">Cấu hình</a></li>
                        <li><a href="<?=site_url('daugia/shop/listproduct')?>">Quản lý sản phẩm</a></li>
                        <li><a href="<?=site_url('daugia/phiendaugia/ds')?>">Phiên đấu giá</a></li>
                        <li><a href="<?=site_url('daugia/chienthang/ds')?>">Dành chiến thắng</a></li>
             </ul>
        </li>
        <li>
            <a href="<?=site_url('contact')?>"><span>Liên hệ</span></a>
           
        </li>
        
        <li><a href="<?=site_url('sitemap');?>">Tạo sitemap</a></li>
        
        <li><a href="#">Xóa cache</a>
        	 <ul>
        	 	 <li><a href="<?=site_url('cacheDelete/listCat');?>">Xóa cache theo chuyên mục</a></li>
        	 	 <li><a href="<?=site_url('cacheDelete/manufactureCat');?>">Xóa Cache theo hãng sản xuất</a></li>
        	 	 <li><a href="<?=site_url('cacheDelete/index');?>">Xóa tất cả cache</a></li>
        	 </ul>
        
        </li> 
       
    </ul>
<div class="clear"></div>
</div>
