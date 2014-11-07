$(document).ready(function() {
            $(".admindata tbody td.copy").each(function() {
                //Create a new clipboard client
                var clip = new ZeroClipboard.Client();
                
                //Cache the last td and the parent row    
                var lastTd = $(this);
                var parentRow = lastTd.parent("tr");

                //Glue the clipboard client to the last td in each row
                clip.glue(lastTd[0]);

                //Grab the text from the parent row of the icon
                var txt = $("#link_"+$(this).attr('id')).val();
                clip.setText(txt);

                //Add a complete event to let the user know the text was copied
                clip.addEventListener('complete', function(client, text) {
                    alert("Link đã được Copy:\n" + text);
                });
            });
});