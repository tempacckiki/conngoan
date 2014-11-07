<?foreach($listcomment as $val):?>
<li class="commentlast" id="<?=$val->commentid?>">
    <div class="commentuser"><div class="img"><img width="75" alt="" src="http://localhost/2012/fyi/data/no_avatar.png"></div></div>
    <div class="infocomment">
        <div class="arrow"></div>
        <div class="boxcomment">
            <div class="info_user_comment"><span><?=$val->fullname?></span> <span><?=date('H:i:s d/m/Y',$val->add_date)?></span></div>
            <p><?=$val->content?></p>
        </div>
    </div>
</li>
<?endforeach;?>
