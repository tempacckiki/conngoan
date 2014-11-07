jQuery(function($){ 
    $("#city_id").change(function() {
        dataString = 'city_id='+$(this).val();
        $.ajax({
            type: "POST",
            url: base_url+'account/get_district',
            data: dataString,
            dataType: "json",
            success: function(data) {
                $("#get_district").html(data.list);
            }
        });
    });  
});