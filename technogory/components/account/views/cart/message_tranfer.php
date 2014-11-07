<div class="uleft">
    <?=$this->load->view('html/uleft')?>
</div>
<div class="ucontent">
    <div class="pathway" style="margin-bottom: 10px;">
        <ul>
            <li><a href="<?=base_url()?>" class="homepage">Trang chủ</a></li>
            <li><a href="<?=site_url('giao-dich/don-hang')?>">Đơn hàng</a></li> 
            <li><a href="#" class="active">Thông báo chuyển khoản</a></li> 
        </ul>
    </div>
    <?=form_open(uri_string(),array('id'=>'message_tranfer'))?>
    <?if(count($list) > 0){?>
    <div class="show_notice">
        <b>Ghi chú:</b> Quý khách chỉ có thể thông báo chuyển khoản những đơn hàng đã được xác nhận
    </div>
    <table class="info">
        <tr>
            <td class="label">Đơn hàng</td>
            <td>
                <select name="order_id" style="width: 200px;">
                    <?foreach($list as $rs):?>
                    <option value="<?=$rs->order_id?>"><?=$rs->barcode?> - <?=date('H:i d/m/Y',$rs->date_buy)?></option>
                    <?endforeach;?>
                </select>
            </td>                            
        </tr>
        <tr>
            <td class="label">Nội dung:</td>
            <td>
                <textarea style="width: 400px; height: 100px;" name="message"></textarea>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" class="submit" value="Gửi thông báo"></td>
        </tr>
    </table>
    <?}else{?>
    <div class="show_notice">
        Quý khách chưa có đơn hàng nào để thông báo chuyển khoản
    </div>
    <?}?>
    <?=form_close();?>
    
</div>
