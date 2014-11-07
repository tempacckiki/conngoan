function change_city(city_id){
    $.post(base_url+"baohanh/get_quan_huyen",{'city_id':city_id},function(data){
        $("#city_parentid").html(data.list);
    }, "json");
}

function get_map(){
    var address = $("#address").val();
    var geocoder = new google.maps.Geocoder();
    if (geocoder) {
      geocoder.geocode({ 'address': address }, function (results, status) {
         if (status == google.maps.GeocoderStatus.OK) {
            searchLocationsNear(results[0].geometry.location);
            la = results[0].geometry.location.lat();
            lo = results[0].geometry.location.lng();
            addlocal(la,lo,'','','show_map');
         }
         else {
            console.log("Geocoding failed: " + status);
         }
      });
    } 
}