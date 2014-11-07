<div class="uleft">
    <?=$this->load->view('html/uleft')?>
</div>
<div class="ucontent">
    <div class="pathway" style="margin-bottom: 10px;">
        <ul>
            <li><a href="<?=base_url()?>" class="homepage">Trang chủ</a></li>
            <li><a href="<?=site_url('u/thong-tin-tai-khoan')?>">Tài khoản</li> 
            <li><a href="#" class="active">Thông tin tài khoản</a></li> 
        </ul>
    </div>
    <?$ns = explode('-',$rs->brithday);?> 
    <?=form_open(uri_string(),array('id'=>'reg_fyi'))?>

    <div class="v_reg">
        <div class="label" style="width: 130px;"><?=lang('hovaten')?>: (<span class="required">*</span>)</div>
        <div class="text"><input type="text" style="width: 250px;" value="<?=$rs->fullname?>" name="fullname"></div>
    </div>
    <div class="v_reg">
        <div class="label" style="width: 130px;"><?=lang('gioitinh')?>: (<span class="required">*</span>)</div>
        <div class="text">
            <select name="male" class="select">
                <option value="1" <?=($rs->male == 1)?'selected="selected"':''?>><?=lang('nam')?></option>
                <option value="0" <?=($rs->male == 0)?'selected="selected"':''?>><?=lang('nu')?></option>
            </select>
        </div>
    </div>
    
    <div class="v_reg">
        <div class="label" style="width: 130px;"><?=lang('ngaysinh')?>: (<span class="required">*</span>)</div>
        <div class="text">
            <select name="date_d" class="select" style="width: 50px;float: left;">
                <?for($i=1;$i<=31;$i++){?>
                <option class="<?=$i?>" <?=(isset($ns[2]))?($ns[2] == $i)?'selected="selected"':'':'';?> ><?=$i?></option>
                <?}?>
            </select>
            <select name="date_m" class="select" style="width: 50px;float: left;">
                <?for($i=1;$i<=12;$i++){?>
                <option class="<?=$i?>" <?=(isset($ns[2]))?($ns[1] == $i)?'selected="selected"':'':'';?> ><?=$i?></option>
                <?}?>
            </select>
            <select name="date_y" class="select" style="width: 87px;float: left;">
                <?for($i = (date('Y',time())-10);$i > 1940 ; $i--){?>
                <option class="<?=$i?>" <?=(isset($ns[2]))?($ns[0] == $i)?'selected="selected"':'':'';?> ><?=$i?></option>
                <?}?>
            </select>
        </div>
    </div>
    <div class="v_reg">
        <div class="label" style="width: 130px;"><?=lang('dienthoai')?>: (<span class="required">*</span>)</div>
        <div class="text"><input type="text" style="width: 250px;" name="phone" value="<?=$rs->phone?>"></div>
    </div>
    <div class="v_reg">
        <div class="label" style="width: 130px;"><?=lang('diachi')?>: (<span class="required">*</span>)</div>
        <div class="text"><input type="text" style="width: 250px;" name="address" value="<?=$rs->address?>"></div>
    </div>
    <div class="v_reg">
        <div class="label" style="width: 130px;"><?=lang('tinh')?>: (<span class="required">*</span>)</div>
        <div class="text">
            <select name="city_id" id="city_id" class="select">
                <option value=""><?=lang('chonthanhpho')?></option>
                <?foreach($listcity as $val):?>
                <option value="<?=$val->city_id?>" <?=($rs->city_id == $val->city_id)?'selected="selected"':''?>><?=$val->city_name?></option>
                <?endforeach;?>
            </select>
        </div>
    </div>
    <div class="v_reg">
        <div class="label" style="width: 130px;"><?=lang('quanhuyen')?>:</div>
        <div class="text">
            <select name="district_id" id="get_district" class="select">
                <option value=""><?=lang('chonquanhuyen')?></option>
                <?
                if($rs->city_id != 0){
                $quanhuyen = $this->vdb->find_by_list('city',array('parentid'=>$rs->city_id));
                foreach($quanhuyen as $val):?>
                <option value="<?=$val->city_id?>" <?=($val->city_id == $rs->district_id)?'selected="selected"':''?>><?=$val->city_name?></option>
                <?endforeach;
                }
                ?>
            </select>
        </div>
    </div>
    <div class="v_reg">
        <div class="label" style="width: 130px;"></div>
        <div><input type="submit" class="submit" value="<?=lang('capnhat')?>" style="padding: 5px 10px;"></div>
    </div>
    <?=form_close();?>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#reg_fyi").validate({
            rules: {
                fullname:   "required",
                phone:      "required",
                address:    "required",
                city_id:    "required",
                district_id:    "required"
            },
            messages:{
                fullname:   "Vui lòng nhập Họ tên",
                phone:      "Vui lòng nhập số điện thoại",
                address:    "Vui lòng nhập địa chỉ",
                city_id:    "Vui lòng chọn Tỉnh, Thành phố",
                district_id:    "Vui lòng chọn Quận, Huyện"
            }
        });    
    });
    </script>
</div>
