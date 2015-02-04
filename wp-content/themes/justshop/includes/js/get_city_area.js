jQuery(document).ready( function() {

   jQuery("#delivery_area").change( function() {
      post_id = jQuery(this).attr("data-post_id")
      nonce = jQuery(this).attr("data-nonce")

      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "get_city_area", post_id : post_id, nonce: nonce},
         success: function(response) {
            if(response.type == "success") {
               alert('success');
            }
            else {
               alert("Your vote could not be added")
            }
         }
      })   

   })

})