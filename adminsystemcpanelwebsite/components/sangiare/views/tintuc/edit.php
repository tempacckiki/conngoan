<?php echo form_open(uri_string(), array('id'=>'admindata'));?>
<input type="hidden" name="id" value="<?=$rs->id?>">
<div class="gray">
    <table class="table_">
        <tr>
            <td valign="top">
                <table class="form">
                    <tr>
                        <td class="label">Tiêu đề - vi</td>
                        <td><input type="text" name="con[title]" value="<?php echo $rs->title?>" style="width: 99%;"></td>
                        <td rowspan="4" style="width: 100px;">
                            <div id="image" class="img_news" onclick="openKCFinder(this)">
                            <?if($rs->images != ''){?>
                                <img src="<?=base_url_site().$rs->images?>" alt="">
                            <?php }else{?>
                                <img src="<?=base_url()?>templates/images/no-img.png" alt="">
                            <?php }?>
                            </div>
                            <input type="hidden" name="images" id="news_img" value="<?php echo $rs->images?>">
                        </td>
                    </tr>
                        <td class="label">Tiêu đề - en</td>
                        <td><input type="text" name="con_en[title]" value="<?php echo $rs_en->title?>" style="width: 99%;"></td>
                    <tr>
                        <td class="label">Chủ đề</td>
                        <td>
                            <select name="con[catid]" style="padding: 4px;font-size: 11px;" class="w300">
                                <?foreach($list as $val):?>
                                <option value="<?php echo $val->cat_id?>" <?=($val->cat_id == $rs->catid)?'selected="selected"':''?>><?=$val->cat_title?></option>
                                <?=$this->tintuc->ar_option_cat($val->cat_id,$rs->catid)?>
                                <?endforeach;?>
                                </optgroup>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Hiển thị</td>
                        <td>
                            <input type="radio" name="con[published]" value="0" <?php echo ($rs->published == 0)?'checked="checked"':'';?>> Không 
                            <input type="radio" name="con[published]" value="1" <?php echo ($rs->published == 1)?'checked="checked"':'checked="checked"';?>>Có                        
                        </td>
                    </tr> 
                    <!--                   
                    <tr>
                        <td class="label">Tùy chọn</td>
                        <td></td>
                    </tr>-->
                    <tr>
                        <td colspan="4">Nội dung ngắn - vi</td>
                    </tr>
                    <tr>
                        <td colspan="4"><textarea style="width:99%; height: 100px;" name="con[introtext]"><?php echo $rs->introtext?></textarea></td>
                    </tr>     
                    <tr>
                        <td colspan="4">Nội dung ngắn - en</td>
                    </tr>
                    <tr>
                        <td colspan="4"><textarea style="width:99%; height: 100px;" name="con_en[introtext]"><?php echo $rs_en->introtext?></textarea></td>
                    </tr> 
                    <tr>
                        <td colspan="4">Nội dung - vi</td>
                    </tr>
                    <tr>
                        <td colspan="4"><?=vnit_editor($rs->fulltext,'content','full')?></td>                    
                    </tr>
                    <tr>
                        <td colspan="4">Nội dung - en</td>
                    </tr>
                    <tr>
                        <td colspan="4"><?=vnit_editor($rs_en->fulltext,'content_en','en_full')?></td>                    
                    </tr>
                </table>
            </td>
            <td style="width: 300px;" valign="top">
                <div class="content-right">
                    <table>
                        <tr>
                            <td class="label">Trạng thái</td>
                            <td><?=($rs->published==1)?'Đã được bật':'Đã tắt'?></td>
                        </tr>
                        <tr>
                            <td>Lần xem</td>
                            <td><?php echo $rs->hits?></td>
                        </tr>
                        <tr>
                            <td>Đã tạo</td>
                            <td><?php echo date('H:i:s d-m-Y',$rs->created)?></td>
                        </tr>
                        <tr>
                            <td>Đã được sửa</td>
                            <td><?php if($rs->modified!=0){echo date('H:i:s d-m-Y',$rs->modified);}else{echo 'Chưa cập nhật';}?></td>
                        </tr>
                    </table>
                </div>
                <div class="panel">
                <?
                function get_params($name,$params){
                    parse_str($params, $output);
                    return $output[$name];
                }
                $show_intro = get_params('show_intro',$rs->attr);
                $show_author = get_params('show_author',$rs->attr);
                $show_date = get_params('show_date',$rs->attr);
                $show_editdate = get_params('show_editdate',$rs->attr);
                $show_print = get_params('show_print',$rs->attr);
                $show_email = get_params('show_email',$rs->attr);
                $show_comment = get_params('show_comment',$rs->attr);
                $show_other = get_params('show_other',$rs->attr);
                ?>
                    <h3 id="info" class="title vpanel_arrow_down"><span>Các thông số - bài viết</span></h3>
                    <div class="panel_content" id="info_content" style="display: block;">
                        <table>
                            <tr>
                                <td class="_key">Phần mở đầu</td>
                                <td class="_value">
                                    <select name="attr[show_intro]">
                                        <option value="1" <?=($show_intro==1)?'selected="selected"':''?>>Hiện</option>
                                        <option value="0" <?=($show_intro==0)?'selected="selected"':''?>>Ẩn</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="_key">Hiển thị tin liên quan</td>
                                <td class="_value">
                                    <select name="attr[show_other]">
                                        <option value="1" <?=($show_other==1)?'selected="selected"':''?>>Hiện</option>
                                        <option value="0" <?=($show_other==0)?'selected="selected"':''?>>Ẩn</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="_key">Tên tác giả</td>
                                <td class="_value">
                                    <select name="attr[show_author]">
                                        <option value="1" <?=($show_author==1)?'selected="selected"':''?>>Hiện</option>
                                        <option value="0" <?=($show_author==0)?'selected="selected"':''?>>Ẩn</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="_key">Ngày và giờ tạo</td>
                                <td class="_value">
                                    <select name="attr[show_date]">
                                        <option value="1" <?=($show_date==1)?'selected="selected"':''?>>Hiện</option>
                                        <option value="0" <?=($show_date==0)?'selected="selected"':''?>>Ẩn</option>
                                    </select>
                                </td>
                            </tr>   
                            <tr>
                                <td class="_key">Ngày và giờ sửa</td>
                                <td class="_value">
                                    <select name="attr[show_editdate]">
                                        <option value="1" <?=($show_editdate==1)?'selected="selected"':''?>>Hiện</option>
                                        <option value="0" <?=($show_editdate==0)?'selected="selected"':''?>>Ẩn</option>
                                    </select>
                                </td>
                            </tr> 
                            <tr>
                                <td class="_key">Biểu tượng In</td>
                                <td class="_value">
                                    <select name="attr[show_print]">
                                        <option value="1" <?=($show_print==1)?'selected="selected"':''?>>Hiện</option>
                                        <option value="0" <?=($show_print==0)?'selected="selected"':''?>>Ẩn</option>
                                    </select>
                                </td>
                            </tr> 
                            <tr>
                                <td class="_key">Biểu tượng email</td>
                                <td class="_value">
                                    <select name="attr[show_email]">
                                        <option value="1" <?=($show_email==1)?'selected="selected"':''?>>Hiện</option>
                                        <option value="0" <?=($show_email==0)?'selected="selected"':''?>>Ẩn</option>
                                    </select>
                                </td>
                            </tr>                                                                                                                                 <tr>
                                <td class="_key">Bình luận</td>
                                <td class="_value">
                                    <select name="attr[show_comment]">
                                        <option value="1" <?=($show_comment==1)?'selected="selected"':''?>>Hiện</option>
                                        <option value="0" <?=($show_comment==0)?'selected="selected"':''?>>Ẩn</option>
                                    </select>
                                </td>
                            </tr>                                      
                        </table>
                    </div>
                </div>
                <div class="panel">
                    <h3 id="meta" class="title vpanel_arrow" ><span>Thông tin Metadata</span></h3>
                    <div class="panel_content" id="meta_content">
                        <table>
                            <tr>
                                <td class="_key">Miêu tả</td>
                                <td class="_value">
                                    <textarea rows="5" cols="30" name="con[metadesc]"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="_key">Từ khóa</td>
                                <td class="_value">
                                    <textarea rows="5" cols="30" name="con[metakey]"></textarea>
                                </td>
                            </tr>
                                      
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
<?php echo form_close();?>

