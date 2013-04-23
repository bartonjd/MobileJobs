<?php
set_include_path ('/home/jbarton/public_html/');
include_once('resources/common.inc.php');
$page = new Page();

$linkedIn = $page->getLinkedIn();
?>
    <div data-theme="c" data-role="header" class="header">
		        <?php $page->commonHeader(); ?>
				<div>
	            	<img style="width: 288px; height: 100px" src="http://huntsman.usu.edu/mis/images/uploads/site/topbars/MIS1.jpg" />
	            </div>
            </div>   
            <div data-role="fieldcontain" class="body-content">
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
                    
                       <a href="#" id="account__login" action="<?php echo $linkedIn->getLoginState();?>" data-transition="slide">
                            <?php echo $linkedIn->getButtonLabel();?>
                        </a>
                    </li>
                    <?php 
                    if ($linkedIn->isLoggedIn()){
                    ?>
                    <li action="notify" data-theme="c">
                        <a href="#notify-page" data-transition="slide">
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
                        <a href="#search-page" data-transition="slide">
                            Search
                        </a>
                    </li>
                    <li action="view" data-theme="c">
                        <a href="#saved-jobs-page" data-transition="slide">
                            View Saved
                        </a>
                    </li>
                </ul>
            </div>
            <?php $page->commonFooter(); ?>