function change_city(city_id){
    $.post(base_url+"baohanh/get_quan_huyen",{'city_id':city_id},function(data){
        $("#city_parentid").html(data.list);
    }, "json");
}

function get_map(){
    var city_id = $("#city_id").val();
    var parentid = $("#city_parentid").val();
    var address = $("#address").val();
    $.post(base_url+"baohanh/load_map",{'city_id':city_id,'parentid':parentid,'address':address},function(data){
        var geocoder = new google.maps.Geocoder();
        var address = data.address;
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

    },'json');
}