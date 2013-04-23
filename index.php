<?php
set_include_path ('/home/jbarton/public_html/');
include_once('resources/common.inc.php');
$page = new Page();

 $linkedIn = $page->getLinkedIn();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <?php $page->commonresources(); ?>
        <script data-main="js/main" src="js/plugins/require.js"></script>
        <script>
            $(document).delegate('#home-page', 'pageinit', function () {

       	    $('#account__login').on('click', function () {
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
        </script>
    </head>
    <body>
    	<!-- Home Page -->
        <div  data-role="page" data-theme="c" id="home-page">
	        <?php include('home.php');?>
        </div>
        <!-- End Home Page -->
                    
        <!-- Search Page -->
        <div data-role="page" id="search-page" data-add-back-btn="true" data-theme="c">
            <?php include('search.php');?>
        </div>
        <!-- End Search Page -->
        
        <!-- Search Results Page -->
        <div data-role="page" id="search-results-page" data-add-back-btn="true" data-theme="c">

        </div>           
        <!-- End Search Results Page -->
        
        <!-- Job Detail  Page -->
        <div data-role="page" id="job-detail-page" data-add-back-btn="true" data-theme="c">

        </div>           
        <!-- End Job Detail Page -->
        
        <!-- Notification Settings Page -->
        <div data-role="page" id="notify-page" data-add-back-btn="true" data-theme="c">
            <?php
                if ($linkedIn->isLoggedIn()){
                	include('notify.php');
                }
            ?>
        </div>           
        <!-- End Notification Settings Page -->
        <?php 
            if ($linkedIn->isLoggedIn()){
        ?>     
        <!-- Saved Results Page -->
        <div data-role="page" id="saved-results-page" data-add-back-btn="true" data-theme="c">

        </div>           
        <!-- End Saved Results Page -->
        <?php
             }
        ?>
    </body>
</html>
<?php
echo $loginConfig; 
ob_end_flush();
?>