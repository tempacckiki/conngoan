/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
   config.language ='vi';
   config.skin ='v2';
   config.height = 300;
   
    config.filebrowserBrowseUrl = base_url+'vfile/vfile_dir';
   config.filebrowserImageBrowseUrl = base_url+'vfile/vfile_dir';
   config.filebrowserFlashBrowseUrl = base_url+'vfile/vfile_dir';
   config.filebrowserUploadUrl = base_url+'templates/ckeditor/kcfinder/upload.php?type=files';
   config.filebrowserImageUploadUrl = base_url+'templates/ckeditor/kcfinder/upload.php?type=images';
   config.filebrowserFlashUploadUrl = base_url+'templates/ckeditor/kcfinder/upload.php?type=flash';
   
   config.toolbar = 'full';
   config.toolbar = 'basic';

 
    config.toolbar_full =
    [
        { name: 'document', items : [ 'Source','-','Preview' ] },
        { name: 'clipboard', items : [ 'Cut','Copy','PasteFromWord','-','Undo','Redo' ] },
        { name: 'editing', items : [ 'Find','Replace','SpellChecker', 'Scayt' ] },

        '/',
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
        { name: 'links', items : [ 'Link','Unlink'] },
        { name: 'insert', items : [ 'Image','Flash','jwplayer','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
        '/',
        { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
        { name: 'colors', items : [ 'TextColor','BGColor' ] },
        { name: 'tools', items : [ 'Maximize', 'ShowBlocks' ] }
    ]; 
 


 
    config.toolbar_basic =
    [
        { name: 'document', items : [ 'Source','-','Preview' ] },
        { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
        { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] },
        { name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
        '/',
        { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] }, 
        { name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
        { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ] },
        { name: 'links', items : [ 'Link','Unlink' ] },
        { name: 'tools', items : [ 'Maximize'] }
    ];   
};
