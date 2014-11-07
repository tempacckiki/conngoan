<?php 
header("Pragma: public");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
header("Content-type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=danh-sach-san-pham-nhom-hang-".vnit_change_title($nhomhang).".xls"); 
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
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
}
.xl67 {
    border-color: -moz-use-text-color black black;
    border-style: none solid solid;
    border-width: medium 0.5pt 0.5pt;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    text-align: center;
    vertical-align: middle;
}
.xl68 {
    border-color: -moz-use-text-color black black -moz-use-text-color;
    border-style: none solid solid none;
    border-width: medium 0.5pt 0.5pt medium;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    text-align: left;
    vertical-align: middle;
}
.xl69 {
    border-color: -moz-use-text-color black black -moz-use-text-color;
    border-style: none solid solid none;
    border-width: medium 0.5pt 0.5pt medium;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    text-align: left;
    vertical-align: middle;
    white-space: normal;
}
.xl70 {
    background: none repeat scroll 0 0 #00B0F0;
    border-color: black black -moz-use-text-color;
    border-style: solid solid none;
    border-width: 0.5pt 0.5pt medium;
    color: white;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
}
.xl71 {
    background: none repeat scroll 0 0 #00B0F0;
    border-color: -moz-use-text-color black black;
    border-style: none solid solid;
    border-width: medium 0.5pt 0.5pt;
    color: white;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
}
.xl72 {
    background: none repeat scroll 0 0 #00B0F0;
    border-color: black -moz-use-text-color -moz-use-text-color black;
    border-style: solid none none solid;
    border-width: 0.5pt medium medium 0.5pt;
    color: white;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
}
.xl73 {
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 14pt;
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
}
.xl74 {
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    font-weight: 700;
    text-align: center;
}
.xl75 {
    background: none repeat scroll 0 0 #00B0F0;
    border-color: -moz-use-text-color -moz-use-text-color black black;
    border-style: none none solid solid;
    border-width: medium medium 0.5pt 0.5pt;
    color: white;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    font-weight: 700;
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
    text-align: left;
    vertical-align: middle;
    white-space: normal;
}
.xl77 {
    background: none repeat scroll 0 0 #00B0F0;
    border: 0.5pt solid windowtext;
    color: white;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
}
.xl78 {
    border: 0.5pt solid windowtext;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    text-align: left;
    vertical-align: middle;
    white-space: normal;
}
.xl79 {
    border: 0.5pt solid windowtext;
    color: black;
    font-family: Tahoma,sans-serif;
    font-size: 10pt;
    text-align: right;
    vertical-align: middle;
}
.xl80 {
    border: 0.5pt solid windowtext;
}
.xl81 {
    background: none repeat scroll 0 0 #00B0F0;
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
<body>


<table style="border-collapse: collapse;table-layout:fixed;width:1014pt" border="0" cellpadding="0" cellspacing="0" width="1349">
 <colgroup><col class="xl65" style="mso-width-source:userset;mso-width-alt:694; width:14pt" width="19">
 <col class="xl65" style="mso-width-source:userset;mso-width-alt:1389; width:29pt" width="38">
 <col class="xl65" style="mso-width-source:userset;mso-width-alt:2340; width:48pt" width="64">
 <col class="xl65" style="mso-width-source:userset;mso-width-alt:4681; width:96pt" width="128">
 <col class="xl65" style="mso-width-source:userset;mso-width-alt:9691; width:199pt" width="265">
 <col class="xl65" style="mso-width-source:userset;mso-width-alt:2998; width:62pt" width="82">
 <col class="xl65" style="mso-width-source:userset;mso-width-alt:2523; width:52pt" width="69">
 <col class="xl65" style="mso-width-source:userset;mso-width-alt:12982; width:266pt" width="355">
 <col class="xl65" style="mso-width-source:userset;mso-width-alt:3547; width:73pt" width="97">
 <col class="xl65" style="mso-width-source:userset;mso-width-alt:2998; width:62pt" width="82">
 <col class="xl65" style="mso-width-source:userset;mso-width-alt:3437; width:71pt" width="94">
 <col style="mso-width-source:userset;mso-width-alt:2048;width:42pt" width="56">
 </colgroup><tbody><tr style="mso-height-source:userset;height:26.25pt" height="35">
  <td class="xl66" style="height:26.25pt;width:14pt" height="35" width="19"></td>
  <td colspan="10" class="xl73" style="width:958pt" width="1274">Danh sách sản phẩm  nhóm hàng: <?=$nhomhang?></td>
  <td style="width:42pt" width="56"></td>
 </tr>
 <tr style="mso-height-source:userset;height:14.25pt" height="19">
  <td class="xl66" style="height:14.25pt" height="19"></td>
  <td colspan="10" class="xl74">Tỉnh, Thành phố: <?=$khuvuc?>
  <?if($tungay != 0 && $denngay != 0){?>
  <span style="mso-spacerun:yes">&nbsp; </span>- Từ ngày: <?=date('d/m/Y',$tungay)?> đến ngày: <?=date('d/m/Y',$denngay)?>
  <?}?>
  </td>
  <td></td>
 </tr>
 <tr style="mso-height-source:userset;height:12.75pt" height="17">
  <td class="xl66" style="height:12.75pt" height="17"></td>
  <td class="xl66"></td>
  <td class="xl66"></td>
  <td class="xl66"></td>
  <td class="xl66"></td>
  <td class="xl66"></td>
  <td class="xl66"></td>
  <td class="xl66"></td>
  <td class="xl66"></td>
  <td class="xl66"></td>
  <td class="xl66"></td>
  <td></td>
 </tr>
 <tr style="mso-height-source:userset;height:20.1pt" height="26">
  <td class="xl66" style="height:20.1pt" height="26"></td>
  <td rowspan="2" class="xl70" style="border-bottom:.5pt solid black">STT</td>
  <td rowspan="2" class="xl70" style="border-bottom:.5pt solid black">ID SP</td>
  <td rowspan="2" class="xl70" style="border-bottom:.5pt solid black">Mã sản phẩm</td>
  <td rowspan="2" class="xl72" style="border-bottom:.5pt solid black">Tên sản phẩm</td>
  <td rowspan="2" class="xl77">Nhãn hàng</td>
  <td rowspan="2" class="xl77">Bảo hành</td>
  <td rowspan="2" class="xl77">Tính năng nổi bật</td>
  <td colspan="3" class="xl77" style="border-left:none">Giá sản phẩm</td>
  <td rowspan="2" class="xl81">Mã tỉnh</td>
 </tr>
 <tr style="mso-height-source:userset;height:20.1pt" height="26">
  <td class="xl66" style="height:20.1pt" height="26"></td>
  <td class="xl77" style="border-top:none;border-left:none">Giá thị trường</td>
  <td class="xl77" style="border-top:none;border-left:none">Giảm giá</td>
  <td class="xl77" style="border-top:none;border-left:none">Giá bán</td>
 </tr>
 <?
 $i = 1;
 foreach($list as $rs):
 $nsx = $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$rs->manufactureid));
 $tinhnang_old = nl2br($rs->tinhnang);
 $tinhnang = str_replace('<br />','|',$tinhnang_old);
 ?>
 <tr style="mso-height-source:userset;height:20.1pt" height="26">
  <td class="xl66" style="height:20.1pt" height="26"></td>
  <td class="xl67"><?=$i?></td>
  <td class="xl68"><?=$rs->productid?></td>
  <td class="xl69" style="width:96pt" width="128"><?=$rs->barcode?></td>
  <td class="xl76" style="width:199pt" width="265"><?=$rs->productname?></td>
  <td class="xl78" style="border-top:none;width:62pt" width="82"><?=($nsx)?$nsx->name:'';?></td>
  <td class="xl78" style="border-top:none;border-left:none;width:52pt" width="69"><?=$rs->baohanh?></td>
  <td class="xl78" style="border-top:none;border-left:none;width:266pt" width="355"><?=$tinhnang?></td>
  <td class="xl79" style="border-top:none;border-left:none"><?=number_format($rs->giathitruong,0,',',',')?></td>
  <td class="xl79" style="border-top:none;border-left:none"><?=number_format($rs->giamgia,0,',',',')?></td>
  <td class="xl79" style="border-top:none;border-left:none"><?=number_format($rs->giaban,0,',',',')?></td>
  <td class="xl80" style="border-top:none;border-left:none"><?=$rs->city_id?></td>
 </tr>
 <?
 $i++;
 endforeach;?>
 <!--[if supportMisalignedColumns]-->
 <tr style="display:none" height="0">
  <td style="width:14pt" width="19"></td>
  <td style="width:29pt" width="38"></td>
  <td style="width:48pt" width="64"></td>
  <td style="width:96pt" width="128"></td>
  <td style="width:199pt" width="265"></td>
  <td style="width:62pt" width="82"></td>
  <td style="width:52pt" width="69"></td>
  <td style="width:266pt" width="355"></td>
  <td style="width:73pt" width="97"></td>
  <td style="width:62pt" width="82"></td>
  <td style="width:71pt" width="94"></td>
  <td style="width:42pt" width="56"></td>
 </tr>
 <!--[endif]-->
</tbody></table>
</body>
</html>
