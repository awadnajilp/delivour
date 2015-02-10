jQuery(document).ready( function() {
   	//Select2 config & initialization
   	jQuery(".select2").select2();
   	jQuery(".awd-chosen-select").select2();
   	jQuery("#delivery_area").select2();
   	jQuery("#select-all-area").click(function(){
   		if( jQuery("#select-all-area").is(':checked') ){
   			jQuery("#delivery_area > option").prop("selected","selected");
   			jQuery("#delivery_area").trigger("change");
   			
   		}else{
   			jQuery("#delivery_area > option").removeAttr("selected");
   			jQuery("#delivery_area").trigger("change");
   		}

   	});
      //time picker in admin rest setting page
   	jQuery(".awd-time").timepicker();
   	
   	// Product Category Desktop/Mobile switch
   	if ( jQuery(window).width() > 739 ) {
   		jQuery("#m-product-cat-container").hide();
   	}else{
   		jQuery(".awd-single-product").hide();
   		var selected = jQuery("#m-product-cat").val();
   		jQuery("#div-"+selected).show();
   		jQuery("#m-product-cat").change(function(){
   				var cat_slug = jQuery(this).val();
   				jQuery(".awd-single-product").hide();
   				jQuery("#div-"+cat_slug).show();
   		});
   		
   	};
      
      jQuery(".cboxOverlay").hide();

      // document load end
   });
   // Set user location in session and submit homepage form
    function set_session_location_home(val){
         city = jQuery("#customer_city_home").val();
         area = jQuery("#customer_area_home").val();
         //nonce = jQuery("#customer_city_home").attr("data-nonce");
         jQuery.ajax({
            type:"POST",
            dataType:'text',
            url:templateUrl+'/awad/awd-ajax-handler.php',
            data:{action:"set_session_location",city:city,area:area},
            success:function(){
               jQuery("#city_choose_form_home").submit();            
            },
            error:function(){
               alert("Error Occured! Please try again");
            }
         });
      }
   // Set user location in session and submit sitewide form
       function set_session_location(val){
         city = jQuery("#customer_city").val();
         area = jQuery("#customer_area").val();
         //nonce = jQuery("#customer_city").attr("data-nonce");
         jQuery.ajax({
            type:"POST",
            dataType:'text',
            url:templateUrl+'/awad/awd-ajax-handler.php',
            data:{action:"set_session_location",city:city,area:area},
            success:function(){
               jQuery("#city_choose_form_hl").submit();               
            },
            error:function(){
               alert("Error Occured! Please try again");
            }
         });
      }

      //loading Indicator
   jQuery(document).ajaxStart(function(){
      jQuery(".cboxOverlay").show();
     //$("#searchLoading").html('<img src="img/ajax-loaders/ajax-loader-1.gif" title="img/ajax-loaders/ajax-loader-5.gif" >');
   }); 
   jQuery(document).ajaxComplete(function(){
     jQuery("#searchLoading").html(''); 
     jQuery(".cboxOverlay").hide();
   }); 