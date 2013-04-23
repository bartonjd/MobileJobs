         
         $(document).on('pagecreate',function() {
         	$("form#notify-user-form").change(function(e){
	         	e.preventDefault();
 
	        var dataString = "data=" + $.encodeJSON($.serializeForm($("form#notify-user-form")));

	        $.ajax({
		        type: "POST",
		        url: 'resources/client-ajax/user.php?action=notify',
		        data: dataString,
		        dataType: "json",
		        success: function(data) {
			        
		        }
		     });
		   });
	    });