$(document).ready(function() { 
   $(".giathitruong").change(function(){
        id = $(this).attr("id").replace("giathitruong_", ""); 
        giathitruong_miennam = ToNumber($(this).val());
        giaban_miennam = ToNumber($("#giaban_"+id).val());
        giamgia = giathitruong_miennam - giaban_miennam;
        $("#giamgia_"+id).val(formatCurrency(giamgia));
   });

   $(".giaban").change(function(){
        id = $(this).attr("id").replace("giaban_", ""); 
        giaban = ToNumber($(this).val());
        giathitruong = ToNumber($("#giathitruong_"+id).val());
        giamgia = giathitruong - giaban;
        $("#giamgia_"+id).val(formatCurrency(giamgia));
   });
});