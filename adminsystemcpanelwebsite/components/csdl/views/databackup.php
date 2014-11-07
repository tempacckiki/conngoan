<table class="admindata">
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên file</th>
            <th>Dung lượng</th>
            <th>Thời gian backup</th>


        </tr>        
    </thead>
    <?
    $log_dir = ROOT. "data/backup/";
    $k=1;
    $i=1;
    $files = scandir( $log_dir );
    foreach($files as $file):
    unset( $mc );
    if ( preg_match( "/^([a-zA-Z0-9]+)\_([a-zA-Z0-9\-\_]+)\.(sql|sql\.gz)+$/", $file, $mc ) ){
    ?>
    <tr class="row<?=$k?>">
        <td><?=$i?></td>
        <td><?=$file?></td>
        <td><?=fileSizeInfo(filesize( $log_dir . '/' . $file ));?></td>
        <td><?=date('d/m/Y H:i:s',intval( filemtime( $log_dir . '/' . $file )));?></td>


    </tr>    
    <?
    $k= 1-$k;
    $i++;
    }
    endforeach;?>
   
</table>