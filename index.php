<?php
set_include_path ('/home/jbarton/public_html/');
include('includes/common.inc.php');
$page = new Page();

 $linkedIn = $page->getLinkedIn();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <?php $page->commonIncludes(); ?>
        <script>
        /*$.mobile.ignoreContentEnabled=true;*/
           	<?php echo $page->URL;?>
        	<?php echo $linkedIn->getLoginConfig(); ?>        	
        	$(document).ready(function(){

        		switch (loginConfig.state){
	        		case 'signedin':
	        			//User is signed in
	        			loginConfig.action = 'revoke';

	        		break;
	        		case 'signedout':
	        			//User is not currently signed in
	        			loginConfig.action = 'initiate';
	        		break;
        		}
	        	$('#account__login').live('click',function(){
	        		switch (loginConfig.action){
		        		case 'revoke':
		        			$.ajax({
						        type: "POST",
						        url: 'includes/client-ajax/user.php?lType=revoke',
						        dataType: "json",
						        success: function(data) {
							        loginConfig.state = 'signedout';
							        loginConfig.action = 'initiate';
							        window.location = docURL;
						        }
						     });

		        		break;
		        		case 'initiate':
		        			window.location = docURL+'?lType=initiate';
		        		break;
	        		}
		        	
		        });
	        });
        </script>
        <script>
            try {

    $(function() {

    });

  } catch (error) {
    console.error("Your javascript has an error: " + error);
  }
        </script>
    </head>
    <body>
        <div  data-role="page" data-theme="c">
	        <?php $page->commonHeader(); ?>
			<div>
            	<img style="width: 288px; height: 100px" src="http://huntsman.usu.edu/mis/images/uploads/site/topbars/MIS1.jpg" />
            </div>
                
            <div data-role="fieldcontain" class="body">
	        	<h2>
	            	Opportunities
	            </h2>
                <p>
                    The MIS program enables students to lead intelligent change in organizations. The Huntsman MIS program provides a solid foundation for bridging the 
					strategies of business and information technologies through advanced SQL database development, data analysis, and intelligent decision making. MIS students 
					frequently find careers as database administrators, business intelligence experts, web developers, consultants, or project managers. The Huntsman MIS program 
					is also a great minor for other business majors because it allows focused activity in functional areas using analytical techniques.
				</p>
            </div>

            <div data-role="content">
                <ul id="navigation" data-role="listview" data-divider-theme="c" data-inset="true">
                    <li data-role="list-divider" role="heading">
                        Account Settings
                    </li>
                    <li action="user" data-theme="c">
                    
                       <a href="#" id="account__login" data-transition="slide">
                            <?php echo $linkedIn->getButtonLabel();?>
                        </a>
                    </li>
                    <?php 
                    if ($linkedIn->isLoggedIn()){
                    ?>
                    <li action="notify" data-theme="c">
                        <a href="notify.php" data-transition="slide">
                            Notifications
                        </a>
                    </li>
                    <?php
                    }
                    ?>
                    <li action="opportunities" data-role="list-divider" role="heading">
                        Opportunities
                    </li>
                    <li action="search" data-theme="c">
                        <a href="search.php" data-transition="slide">
                            Search
                        </a>
                    </li>
                    <li action="view" data-theme="c">
                        <a href="#page1" data-transition="slide">
                            View Saved
                        </a>
                    </li>
                </ul>
            </div>
            <?php $page->commonFooter(); ?>
            </div>
    </body>
    </body>
</html>
<?php
echo $loginConfig; 
ob_end_flush();
?>