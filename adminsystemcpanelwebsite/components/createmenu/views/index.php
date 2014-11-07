<div>
    Chọn Danh mục chính
    <select onchange="window.open(this.value,'_self');">
        <option value="<?=site_url('createmenu/ds')?>">Chọn danh mục</option>
        <?foreach($list as $rs):?>
        <option value="<?=site_url('createmenu/edit/'.$rs->catid)?>"><?=$rs->catname?></option>
        <?endforeach;?>
    </select>
</div>
