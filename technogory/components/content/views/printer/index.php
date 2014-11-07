<div class="title"><?=$rs->title?></div>
<div><?=date('d/m/Y',$rs->created)?> <a href="javascript:window.print()"><div style="float: right;margin-right: 10px;" class="printer"></div></a></div>
<div style="margin-bottom: 10px;"><b><?php echo $rs->introtext?></b></div>
<div><?php echo $rs->fulltext?></div>