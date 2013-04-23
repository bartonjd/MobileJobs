       	$(document).delegate('#home-page', 'pagecreate', function () {
       	`	alert(3)
       	    $(document).delegate('#account__login','click', function () {
       	        var action = $('#account__login').attr('action');
       	        if (action == 'signedin') {
       	            $.post('resources/client-ajax/user.php?lType=revoke', function (data) {
       	                window.location.replace(window.location.href);
       	            });

       	        } else {
       	            document.location.replace('resources/client-ajax/user.php?lType=initiate');
       	        }

       	    });
       	});