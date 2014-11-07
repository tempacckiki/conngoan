<?php echo form_open_multipart(uri_string(), array('id'=>'admindata'));
?>
<input type="hidden" name="newsid" value="<?=$rs->newsid?>">
<div class="gray">
    <table class="table_">
        <tr>
            <td valign="top">
                <table class="form">
                    <tr>
                        <td class="label">Tiêu đề</td>
                        <td><input type="text" name="con[title]" value="<?php echo $rs->title?>" class="w500"></td>
                        <td rowspan="4" style="width: 100px;">
                            <div id="image" class="img_news">
                            <?if($rs->images_thumb != ''){?>
                                <img src="<?=base_url_site().'data/events/'.$rs->images_thumb?>" alt="">
                            <?php }else{?>
                                <img src="<?=base_url()?>templates/images/no-img.png" alt="">
                            <?php }?>
                            </div>
                            <input type="hidden" name="images" id="news_img" value="<?php echo $rs->images?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Hình ảnh</td>
                        <td>
                            <input type="file" name="userfile">
                            <input type="hidden" name="images" value="<?=$rs->images_thumb?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Hiển thị</td>
                        <td>
                            <input type="radio" name="con[published]" value="0" <?php echo ($rs->published == 0)?'checked="checked"':'';?>> Không 
                            <input type="radio" name="con[published]" value="1" <?php echo ($rs->published == 1)?'checked="checked"':'';?>>Có                        
                        </td>
                    </tr>                    
                    <tr>
                        <td class="2"></td>
                    </tr>
                    <tr>
                        <td colspan="4">Nội dung ngắn</td>
                    </tr>
                    <tr>
                        <td colspan="4"><textarea cols="" rows="" style="width:99%; height: 100px;" name="con[introtext]"><?php echo $rs->introtext?></textarea></td>
                    </tr>     
                    
                    <tr>
                        <td colspan="4">Nội dung</td>
                    </tr>
                    <tr>
                        <td colspan="4"><?=vnit_editor($rs->fulltext,'content','full',false)?></td>                    
                    </tr>
                </table>
            </td>
            <td style="width: 300px;" valign="top">
                <div class="content-right">
                    <table>
                        <tr>
                            <td class="label">Trạng thái</td>
                            <td>
                                <?if($rs->published == 1){echo 'Đã được bật';}else{ echo 'Đang tắt';}?>
                            </td>
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
                    <h3 id="info" class="title vpanel_arrow_down"><span>Các thông số - bài viết</span></h3>
                    <div class="panel_content" id="info_content" style="display: block;">
                        <table>
                            <tr>
                                <td class="_key">Phần mở đầu</td>
                                <td class="_value">
                                    <select name="attr[show_intro]">
                                        <option value="1">Hiện</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="_key">Tên tác giả</td>
                                <td class="_value">
                                    <select name="attr[show_author]">
                                        <option value="1">Hiện</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="_key">Ngày và giờ tạo</td>
                                <td class="_value">
                                    <select name="attr[show_date]">
                                        <option value="1">Hiện</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </td>
                            </tr>   
                            <tr>
                                <td class="_key">Ngày và giờ sửa</td>
                                <td class="_value">
                                    <select name="attr[show_editdate]">
                                        <option value="1">Hiện</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </td>
                            </tr> 
                            <tr>
                                <td class="_key">Biểu tượng In</td>
                                <td class="_value">
                                    <select name="attr[show_print]">
                                        <option value="1">Hiện</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </td>
                            </tr> 
                            <tr>
                                <td class="_key">Biểu tượng email</td>
                                <td class="_value">
                                    <select name="attr[show_email]">
                                        <option value="1">Hiện</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </td>
                            </tr>                                                                                                                                 <tr>
                                <td class="_key">Bình luận</td>
                                <td class="_value">
                                    <select name="attr[show_comment]">
                                        <option value="1">Hiện</option>
                                        <option value="0">Ẩn</option>
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
                                    <textarea rows="5" cols="30" name="con[metadesc]"><?=$rs->metadesc?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="_key">Từ khóa</td>
                                <td class="_value">
                                    <textarea rows="5" cols="30" name="con[metakey]"><?=$rs->metakey?></textarea>
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

