<?
$info_db = $this->db->query( 'SELECT @@session.time_zone AS `db_time_zone`, @@session.character_set_database AS `db_charset`, @@session.collation_database AS `db_collation`')->row();
?>
<table class="form">
    <tr>
        <td class="label">Máy chủ MySql</td>
        <td><?echo mysql_get_host_info();?></td>
    </tr>
    <tr>
        <td class="label">Phiên bản máy chủ MySql</td>
        <td><?echo $this->db->query("select version() as ve")->row()->ve?></td>
    </tr>    
    <tr>
        <td class="label">Phiên bản giao thức MySql</td>
        <td><?echo mysql_get_proto_info();?></td>
    </tr>     
    <tr>
        <td class="label">Tên máy chủ MySql</td>
        <td><?echo $this->db->hostname;?></td>
    </tr> 
    <tr>
        <td class="label">Tên CSDL</td>
        <td><?echo $this->db->database;?></td>
    </tr>     
    <tr>
        <td class="label">Tài khoản truy cập CSDL</td>
        <td><?echo $this->db->username;?></td>
    </tr>  
    <tr>
        <td class="label">Bảng mã CSDL</td>
        <td><?echo $info_db->db_charset;?></td>
    </tr>    
    <tr>
        <td class="label">Mã so sánh CSDL</td>
        <td><?echo $info_db->db_collation;?></td>
    </tr>           
</table>
<div class="h-title">Các Table thuộc CSDL “<?=$this->db->database?>”</div>
<?
// Query hien thi danh sach Table trong Database;
$list = $this->db->query("SHOW TABLE STATUS")->result();
?>
<?echo form_open('admin/dels',  array('id' => 'admindata'));?> 
<table class="admindata">
    <thead>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th>Tên Table</th>
            <th>Dung lượng</th>
            <th>Số bản ghi</th>
            <th>Mã</th>
            <th>Loại</th>
            <th>Số tự động</th>
            <th>Khởi tạo</th>
            <th>Cập nhật</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->Name?>"></td>
        <td><?=$rs->Name?></td>
        <td><?=fileSizeInfo($rs->Data_length)?></td>

        <td><?=intval( $rs->Rows)?></td>
        <td><?=( ! empty( $rs->Collation ) && preg_match( "/^([a-z0-9]+)_/i", $rs->Collation, $m ) ) ? $m[1] : ""?></td>
        <td><?=$rs->Engine?></td>
        <td><?=$rs->Auto_increment?></td>
        <td><?=strftime( "%H:%M %d/%m/%Y", strtotime( $rs->Create_time ) )?></td>
        <td><?=strftime( "%H:%M %d/%m/%Y", strtotime( $rs->Update_time ) )?></td>
    </tr>    
    <?
    $k=1-$k;
    endforeach;?>
   
</table>
<?=form_close()?>