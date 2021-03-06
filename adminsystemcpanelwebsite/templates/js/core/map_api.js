function set_geoEncode() {
    var geocoder = new google.maps.Geocoder();
    var address = $("#address").val();

   if (geocoder) {
      geocoder.geocode({ 'address': address }, function (results, status) {
         if (status == google.maps.GeocoderStatus.OK) {
            searchLocationsNear(results[0].geometry.location);
         }
         else {
            console.log("Geocoding failed: " + status);
         }
      });
   } 
}
function get_geoEncode() {
    var geocoder = new google.maps.Geocoder();
    var address = $("#address").val();

   if (geocoder) {
      geocoder.geocode({ 'address': address }, function (results, status) {
         if (status == google.maps.GeocoderStatus.OK) {
            searchLocationsNear(results[0].geometry.location);
         }
         else {
            console.log("Geocoding failed: " + status);
         }
      });
   } 
}

function searchLocationsNear(center) {
     $("#lat").val(center.lat());
     $("#lng").val(center.lng() );
}

function get_address(branch_id){
       $.post(site_url+"api/get_branch", { "branch_id": branch_id },function(data){
            $("#company_name").html(data.name);
            $("#company_address").html(data.address);
            $("#company_phone").html(data.phone);
            $("#company_fax").html(data.fax);
            $("#company_email").html(data.email);
            $("#company_hotline").html(data.hotline);
            addlocal(data.lat, data.lng, data.name, data.address, 'box_map');
       }, "json");
}

function addlocal(la,lo,title,content,map_div){
    var latlng = new google.maps.LatLng(la,lo);
    var options = {  
        zoom: 15, 
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };  
    
    var map = new google.maps.Map(document.getElementById(map_div), options);  
    var image = new google.maps.MarkerImage(base_url+'templates/images/fyi_map.png',
        new google.maps.Size(40, 42),
        new google.maps.Point(0,0),
        new google.maps.Point(18, 42)
    );
    
    // Add Marker
    var marker1 = new google.maps.Marker({
        position: new google.maps.LatLng(la,lo), 
        map: map,        
        icon: image 
    });    
    /*
    google.maps.event.addListener(marker1, 'click', function() {  
        infowindow1.open(map, marker1);  
    });
        
    var infowindow1 = new google.maps.InfoWindow({  
        content:  createInfo(title,content)
    }); 
    
    function createInfo(title, content) {
        return '<div class="infowindow"><strong>'+ title +'</strong><br />'+content+'</div>';
    } */
}

