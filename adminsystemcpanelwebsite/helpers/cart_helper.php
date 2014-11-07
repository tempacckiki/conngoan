<?php
  function get_status($status){
      if($status == 1){
          return 'Chưa xác nhận';
      }else if($status == 2){
          return 'Đã xác nhận';
      }else if($status==3){
          return 'Đang xử lý';
      }else if($status == 4){
          return 'Hoàn thành';
      }else if($status == 5){
          return 'Đã Hủy';
      }
  }
?>
