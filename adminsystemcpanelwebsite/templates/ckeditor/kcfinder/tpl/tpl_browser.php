<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>KCFinder: /<?php echo $this->session['dir'] ?></title>
<?php INCLUDE "tpl/tpl__css.php" ?>
<?php INCLUDE "tpl/tpl__javascript.php" ?>
</head>
<body>
<script type="text/javascript">
$('body').noContext();
</script>
<div id="resizer"></div>
<div id="shadow"></div>
<div id="dialog"></div>
<div id="clipboard"></div>
<div id="all">
<div id="left">
    <div id="folders"></div>
</div>
<div id="right">
    <div id="toolbar">
        <div>
        <a href="kcact:upload"><?php echo $this->label("Tải File") ?></a>
        <a href="kcact:refresh"><?php echo $this->label("Làm mới trang") ?></a>
        <a href="kcact:settings"><?php echo $this->label("Cài đặt") ?></a>
        <!--<a href="kcact:about"><?php echo $this->label("About") ?></a>-->
        <div id="loading"></div>
        </div>
    </div>
    <div id="settings">

    <div>
    <fieldset>
    <legend><?php echo $this->label("Kiểu xem:") ?></legend>
        <table summary="view" id="view"><tr>
        <th><input id="viewThumbs" type="radio" name="view" value="thumbs" /></th>
        <td><label for="viewThumbs">&nbsp;<?php echo $this->label("Biểu tượng") ?></label> &nbsp;</td>
        <th><input id="viewList" type="radio" name="view" value="list" /></th>
        <td><label for="viewList">&nbsp;<?php echo $this->label("Danh sách") ?></label></td>
        </tr></table>
    </fieldset>
    </div>

    <div>
    <fieldset>
    <legend><?php echo $this->label("Hiển thị theo:") ?></legend>
        <table summary="show" id="show"><tr>
        <th><input id="showName" type="checkbox" name="name" /></th>
        <td><label for="showName">&nbsp;<?php echo $this->label("Tên") ?></label> &nbsp;</td>
        <th><input id="showSize" type="checkbox" name="size" /></th>
        <td><label for="showSize">&nbsp;<?php echo $this->label("Duong lượng") ?></label> &nbsp;</td>
        <th><input id="showTime" type="checkbox" name="time" /></th>
        <td><label for="showTime">&nbsp;<?php echo $this->label("Ngày") ?></label></td>
        </tr></table>
    </fieldset>
    </div>

    <div>
    <fieldset>
    <legend><?php echo $this->label("Sắp xếp theo:") ?></legend>
        <table summary="order" id="order"><tr>
        <th><input id="sortName" type="radio" name="sort" value="name" /></th>
        <td><label for="sortName">&nbsp;<?php echo $this->label("Tên") ?></label> &nbsp;</td>
        <th><input id="sortType" type="radio" name="sort" value="type" /></th>
        <td><label for="sortType">&nbsp;<?php echo $this->label("Kiểu") ?></label> &nbsp;</td>
        <th><input id="sortSize" type="radio" name="sort" value="size" /></th>
        <td><label for="sortSize">&nbsp;<?php echo $this->label("Dung lượng") ?></label> &nbsp;</td>
        <th><input id="sortTime" type="radio" name="sort" value="date" /></th>
        <td><label for="sortTime">&nbsp;<?php echo $this->label("Ngày") ?></label> &nbsp;</td>
        <th><input id="sortOrder" type="checkbox" name="desc" /></th>
        <td><label for="sortOrder">&nbsp;<?php echo $this->label("Giảm dần") ?></label></td>
        </tr></table>
    </fieldset>
    </div>

    </div>
    <div id="files">
        <div id="content"></div>
    </div>
</div>
<div id="status"><span id="fileinfo">&nbsp;</span></div>
</div>
</body>
</html>