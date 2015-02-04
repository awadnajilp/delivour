
jQuery(document).ready( function() {
		
		//jQuery("#restaurant_city").load(document.location.href+'cities.txt');

   jQuery("#restaurant_city").change( function() {
      city = jQuery(this).val();
      nonce = jQuery(this).attr("data-nonce");

      jQuery.ajax({
         type : "post",
         dataType : "html",
         url : myAjax.ajaxurl,
         data : {action: "get_city_area", city:city, nonce: nonce},
         success: function(response) {
         	
           jQuery("#delivery_area").html(response);
         },
         error:function(){
         	alert('Erro at ajax city and area finder');
         }
      });

		
   });


   /*jQuery("#customer_city").change( function() {
      city = jQuery(this).val();
      nonce = jQuery(this).attr("data-nonce");

      jQuery.ajax({
         type : "post",
         dataType : "html",
         url : myAjax.ajaxurl,
         data : {action: "get_city_area_front", city:city, nonce: nonce},
         success: function(response) {
         	
           jQuery("#customer_area").html(response);
           jQuery('.chosen-select').trigger("chosen:updated");
         },
         error:function(){
         	alert('Erro at ajax city and area finder');
         }
      });

		
   });*/
  

 

});