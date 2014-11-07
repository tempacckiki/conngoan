$(document).ready(function(){
    // second example
    $("#browser").treeview({
        animated:"normal",
        persist: "cookie"
    });

    $("#samplebutton").click(function(){
        var branches = $("<li><span class='folder'>New Sublist</span><ul>" + 
            "<li><span class='file'>Item1</span></li>" + 
            "<li><span class='file'>Item2</span></li></ul></li>").appendTo("#browser");
        $("#browser").treeview({
            add: branches
        });
    });
    

});

function get_dir(path){
    $("#block_upload").html('');
    $("#block_upload").html('<input id="file_upload" name="file_upload" type="file" />');
    $.post(base_url+"vfile/get_dir",{'path':path},function(data){
        $("#root_dir").val('data/'+path);
        path_thumb = 'data/thumbs_/'+path;
        $("#root_dir_thumb").val(path_thumb);
        $("#gallery_picture").html(data);                                            
    });
}

function refresh_page(){
    path = $("#dir_vfile").val();
    $("#block_upload").html('');
    $("#block_upload").html('<input id="file_upload" name="file_upload" type="file" />');
    $.post(base_url+"vfile/get_dir",{'path':path},function(data){
        $("#root_dir").val('data/'+path);
        path_thumb = 'data/thumbs_/'+path;
        $("#root_dir_thumb").val(path_thumb);
        $("#gallery_picture").html(data);                                            
    });
}

function get_hostname() {
    url = document.domain;
    var m = ((url||'')+'').match(/^http:\/\/[^/]+/);
    return m ? m[0] : null;
}


function add_to_editor(file) {
    var fileURL =file;
    window.opener.CKEDITOR.tools.callFunction(CKEditor.funcNum,fileURL);
    window.close();
};

function save_edit(){
    id = $("#vfile_id").val();
    name = $("#foler_name").val();
    $.post(base_url+"vfile/save_edit_folder",{'id':id,'name':name},function(data){
        load_tree();
        close_pop();                                      
    },'json');
}
function save_add(){
    parentid = $("#parentid").val();
    name = $("#foler_name").val();
    $.post(base_url+"vfile/save_add_folder",{'parentid':parentid,'name':name},function(data){
        load_tree();          
        close_pop();                            
    },'json');
}

function load_tree(){
    $.post(base_url+"vfile/tree",function(data){
         $("#tree_view").html(data);
    });
}

function str_replace (search, replace, subject, count) {
        j = 0,
        temp = '',
        repl = '',
        sl = 0,        fl = 0,
        f = [].concat(search),
        r = [].concat(replace),
        s = subject,
        ra = Object.prototype.toString.call(r) === '[object Array]',        sa = Object.prototype.toString.call(s) === '[object Array]';
    s = [].concat(s);
    if (count) {
        this.window[count] = 0;
    } 
    for (i = 0, sl = s.length; i < sl; i++) {
        if (s[i] === '') {
            continue;
        }        for (j = 0, fl = f.length; j < fl; j++) {
            temp = s[i] + '';
            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
            s[i] = (temp).split(f[j]).join(repl);
            if (count && s[i] !== temp) {                this.window[count] += (temp.length - s[i].length) / f[j].length;
            }
        }
    }
    return sa ? s : s[0];
}