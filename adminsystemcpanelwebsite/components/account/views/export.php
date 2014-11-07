<?php 
header("Content-type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=thong-ke-thanh-vien-tu-".$tungay."-den-ngay-".$denngay.".xls"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml"xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REChtml40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
@page{
    margin:0.5in .5in .5in .5in;
}
td {
    padding-top: 1px;
}
tr {
}
col {
}
br {
}
.style0 {
    border: medium none;
    color: black;
    font-family: Calibri,sans-serif;
    font-size: 11pt;
    font-style: normal;
    font-weight: 400;
    text-decoration: none;
    vertical-align: bottom;
    white-space: nowrap;
}
td {
    border: medium none;
    color: black;
    font-family: Calibri,sans-serif;
    font-size: 11pt;
    font-style: normal;
    font-weight: 400;
    padding-left: 1px;
    padding-right: 1px;
    padding-top: 1px;
    text-decoration: none;
    vertical-align: bottom;
    white-space: nowrap;
}
.xl65 {
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
}
.xl66 {
    background: none repeat scroll 0 0 white;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 9pt;
    vertical-align: middle;
    white-space: normal;
}
.xl67 {
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
}
.xl68 {
    border-color: -moz-use-text-color windowtext windowtext;
    border-style: none solid solid;
    border-width: medium 0.5pt 0.5pt;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    text-align: center;
    vertical-align: middle;
}
.xl69 {
    border-color: -moz-use-text-color windowtext windowtext -moz-use-text-color;
    border-style: none solid solid none;
    border-width: medium 0.5pt 0.5pt medium;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    vertical-align: middle;
}
.xl70 {
    border-color: -moz-use-text-color windowtext windowtext -moz-use-text-color;
    border-style: none solid solid none;
    border-width: medium 0.5pt 0.5pt medium;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    vertical-align: middle;
}
.xl71 {
    background: none repeat scroll 0 0 white;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    vertical-align: middle;
}
.xl72 {
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    vertical-align: middle;
}
.xl73 {
    background: none repeat scroll 0 0 white;
    border-color: -moz-use-text-color -moz-use-text-color windowtext;
    border-style: none none solid;
    border-width: medium medium 0.5pt;
    color: black;
    font-family: Tahoma,sans-serif;
    text-align: center;
    vertical-align: middle;
    white-space: normal;
}
.xl74 {
    background: none repeat scroll 0 0 white;
    color: black;
    font-family: Tahoma,sans-serif;
    text-align: center;
    vertical-align: middle;
    white-space: normal;
}
.xl75 {
    border-color: -moz-use-text-color windowtext windowtext -moz-use-text-color;
    border-style: none solid solid none;
    border-width: medium 0.5pt 0.5pt medium;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    text-align: center;
    vertical-align: middle;
}
.xl76 {
    border-color: -moz-use-text-color -moz-use-text-color windowtext;
    border-style: none none solid;
    border-width: medium medium 0.5pt;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    vertical-align: middle;
}
.xl77 {
    border: 0.5pt solid windowtext;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    vertical-align: middle;
}
.xl78 {
    border: 0.5pt solid windowtext;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
}
.xl79 {
    background: none repeat scroll 0 0 #538ED5;
    border: 0.5pt solid windowtext;
    color: white;
    font-family: Tahoma,sans-serif;
    font-size: 9pt;
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
    white-space: normal;
}
.xl80 {
    background: none repeat scroll 0 0 #538ED5;
    border-color: windowtext windowtext windowtext -moz-use-text-color;
    border-style: solid solid solid none;
    border-width: 0.5pt 0.5pt 0.5pt medium;
    color: white;
    font-family: Tahoma,sans-serif;
    font-size: 9pt;
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
    white-space: normal;
}
.xl81 {
    background: none repeat scroll 0 0 #538ED5;
    border-color: windowtext windowtext windowtext -moz-use-text-color;
    border-style: solid solid solid none;
    border-width: 0.5pt 0.5pt 0.5pt medium;
    color: white;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
    white-space: normal;
}
.xl82 {
    background: none repeat scroll 0 0 #538ED5;
    border-color: windowtext -moz-use-text-color;
    border-style: solid none;
    border-width: 0.5pt medium;
    color: white;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
}
.xl83 {
    background: none repeat scroll 0 0 #538ED5;
    border: 0.5pt solid windowtext;
    color: white;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
}
</style>
</head>
<body vlink="purple" link="blue" class="xl65">
<table cellspacing="0" cellpadding="0" border="0" width="1270" style="border-collapse: collapse;table-layout:fixed;width:953pt">
 <colgroup><col width="11" style="mso-width-source:userset;mso-width-alt:402; width:8pt" class="xl65">
 <col width="32" style="mso-width-source:userset;mso-width-alt:1170; width:24pt" class="xl65">
 <col width="96" style="mso-width-source:userset;mso-width-alt:3510; width:72pt" class="xl65">
 <col width="207" style="mso-width-source:userset;mso-width-alt:7570; width:155pt" class="xl65">
 <col width="185" style="mso-width-source:userset;mso-width-alt:6765; width:139pt" class="xl65">
 <col width="142" style="mso-width-source:userset;mso-width-alt:5193; width:107pt" class="xl65">
 <col width="339" style="mso-width-source:userset;mso-width-alt:12397; width:254pt" class="xl65">
 <col width="161" style="mso-width-source:userset;mso-width-alt:5888; width:121pt" class="xl65">
 <col width="97" style="mso-width-source:userset;mso-width-alt:3547; width:73pt" class="xl65">
 <col width="100" style="mso-width-source:userset;mso-width-alt:3657; width:75pt" class="xl65">
 <col width="91" style="mso-width-source:userset;mso-width-alt:3328; width:68pt" class="xl65">
 </colgroup><tbody><tr height="42" style="mso-height-source:userset;height:31.5pt">
  <td height="42" width="11" style="height:31.5pt;width:8pt" class="xl65"></td>
  <td width="1259" style="width:945pt" class="xl74" colspan="8">THỐNG KÊ THÀNH VIÊN TỪ NGÀY <?=$tungay?> ĐẾN NGÀY <?=$denngay?></td>
 </tr>
 <tr height="24" style="mso-height-source:userset;height:18.0pt">
  <td height="24" style="height:18.0pt" class="xl66">&nbsp;</td>
  <td width="1259" style="width:945pt" class="xl73" colspan="8">
    Khu vực: 
    <?if($city_id !=0){
        $this->db = $this->load->database('default', TRUE);
        echo $this->vdb->find_by_id('city',array('city_id'=>$city_id))->city_name;
    }else{
        echo "Tất cả";
    }?>
  </td>
 </tr>
 <tr height="27" style="mso-height-source:userset;height:20.25pt">
  <td height="27" style="height:20.25pt" class="xl66">&nbsp;</td>
  <td width="32" style="border-top:none;width:24pt" class="xl79">STT</td>
  <td width="96" style="border-top:none;width:72pt" class="xl80">ID</td>
  <td width="207" style="border-top:none;width:155pt" class="xl80">Tên thành viên</td>
  <td width="185" style="border-top:none;width:139pt" class="xl80">Email</td>
  <td width="142" style="border-top:none;width:107pt" class="xl81">Điện thoại</td>
  <td style="border-top:none" class="xl82">Địa chỉ</td>
  <td style="border-top:none" class="xl83">Thành phố</td>
  <td style="border-top:none;border-left:none" class="xl83">Điểm thưởng</td>
 </tr>
 <?
 $i =1;
 foreach($list as $rs):?>
 <tr height="27" style="mso-height-source:userset;height:20.25pt">
  <td height="27" style="height:20.25pt" class="xl66">&nbsp;</td>
  <td class="xl68"><?=$i?></td>
  <td class="xl75"><?=$rs->user_code?></td>
  <td class="xl69"><?=$rs->fullname?></td>
  <td class="xl69"><?=$rs->email?></td>
  <td class="xl70"><?=$rs->phone?></td>
  <td class="xl76"><?=$rs->address?></td>
  <td style="border-top:none" class="xl77">
  <?
  $this->db = $this->load->database('default', TRUE);
  $city = $this->vdb->find_by_id('city',array('city_id'=>$rs->city_id));
  if($city){
      echo $city->city_name;
  }?>
  </td>
  <td style="border-top:none;border-left:none" class="xl78">&nbsp;</td>
 </tr>
 <?
 $i++;
 endforeach;?>
 <!--[if supportMisalignedColumns]-->
 <tr height="0" style="display:none">
  <td width="11" style="width:8pt"></td>
  <td width="32" style="width:24pt"></td>
  <td width="96" style="width:72pt"></td>
  <td width="207" style="width:155pt"></td>
  <td width="185" style="width:139pt"></td>
  <td width="142" style="width:107pt"></td>
  <td width="339" style="width:254pt"></td>
  <td width="161" style="width:121pt"></td>
  <td width="97" style="width:73pt"></td>
 </tr>
 <!--[endif]-->
</tbody></table>
</body>
</html>
