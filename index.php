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
            $(document).on("mobileinit", function() {
              $.support.touchOverflow = true;
              $.mobile.touchOverflowEnabled = true;
            });


        /*$.mobile.ignoreContentEnabled=true;*/
           	var docURL = window.location;	
        	$(document).on('pagecreate',function(){
	        	$('#account__login').on('click',function(){
	        		var action = $('#account__login').attr('action');
	        		if (action == 'signedin'){
		        			$.ajax({
						        type: "POST",
						        url: 'includes/client-ajax/user.php?lType=revoke',
						        dataType: "json",
						        success: function(data) {	
							        window.location = docURL;
						        }
						     });

		        	} else {
		        			window.location = docURL+'?lType=initiate';
	        		}
		        	
		        });
	        });

                  
         $(document).delegate('#search-page','pageshow',function() {
	     	var docURL = window.location; 
	     		if(window.ranOnce != 1){
    	           $('#state').mobiscroll().select({
	    			        theme: 'ios',
					        display: 'top',
					        preset:'select',
					        mode: 'scroller',
					        width: 200
					});
					$('#schedule_type').mobiscroll().select({
	    			        theme: 'ios',
					        display: 'top',
					        preset:'select',
					        mode: 'scroller',
					        width: 200
					});
					$('#pay_type').mobiscroll().select({
	    			        theme: 'ios',
					        display: 'top',
					        preset:'select',
					        mode: 'scroller',
					        width: 200
					});
					$('#tags').tagsInput({
						
					});
					window.ranOnce = 1;
				}

				var valid = $('form#search-form').validate();
				$('form input[type=button]').on('click',function(e){

					 var valid = $('form#search-form').validate();
		        		if (valid.errorList.length >0){

			        		return false;
		        		}
		        		var data =$.serializeForm($('form#search-form'));
			        	//set to data get variable, url encode json string
			        	var dataString = 'data='+ encodeURIComponent($.encodeJSON(data));
			        	$.ajax({
					        type: "POST",
					        url: 'includes/client-ajax/opportunity.php?action=search_jobs',
					        data: dataString,
					        dataType: "json",
					        success: function(data,status) {
					        	if (data.success == true){
						       // 	$.mobile.loadPage('searchResults.php?options=' + encodeURIComponent($.encodeJSON(data.options))+'&search='+encodeURIComponent($.encodeJSON(data.search)),{pageContainer:$('#search-results-page'),changeHash:true});
						       		//clear any previous search settings
						       		store.clear();
						       		//store the search options
						       		store.set('searchParams',{options:data.options,search:data.search});
						       		
						        	$('#search-results-page').load('searchResults.php',{options:$.encodeJSON(data.options),search:$.encodeJSON(data.search)}, function () {
									    $(this).trigger('create');
									    $.mobile.changePage('#search-results-page');
									});
						        } else {
							        if (data.errors != '' && data.errors != undefined) {
								        $('body').append(
								            '<div id="error_msg" data-close-btn="right" data-overlay-theme="a"  data-corners="true" data-role="dialog">'+
							                	'<div data-role="header" ><div style="font-size:22px;padding:5px;color:#DDD;">Notice</div></div>'+
							                	'<div data-role="content" class="err_cnt">'+data.errors+'</div>'+
							                	'<div data-role="footer" >&nbsp;</div>'+
							                '</div>');
								        $('#err_msg').append($('.err_cnt'));
								        
								        $.mobile.changePage('#error_msg', { transition: "pop", role: "dialog" } );
							        }
						        }
					        }
					     });

		        						
		        }).keydown(function(event){
					    if(event.keyCode == 13) {
					      event.preventDefault();
					      return false;
					    }
				});

            });
            $(document).delegate('#search-results-page','pagecreate',function(){
	           var docURL = window.location;	
	        	$('tr.sres').bind('tap click',function(){
		        	var id = $(this).attr('id');
		        	//consider saving options to url or adding a back button
		        	$('#job-detail-page').load('result.php?opp_id='+id,function(){
						
						$(this).trigger('create');
						$.mobile.changePage('#job-detail-page');
		        	});

	        	});
	        	$('.paging-sres').bind('tap click',function(){
	        	
		        	$('#searchs-result-page').load($(this).attr('url'),function(){
			        		
						$(this).trigger('create');
						$.mobile.changePage('#search-results-page');
					});
				});
            });
        </script>
    </head>
    <body>
        <div  data-role="page" data-theme="c" id="home-page">
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
            </div>
            
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
            
            <!-- Saved Jobs Page -->
            <div data-role="page" id="saved-jobs-page" data-add-back-btn="true" data-theme="c">
                <?php 
                    if ($linkedIn->isLoggedIn()){
                    	//include('savedresult.php');
                    }
                ?>
            </div>           
            <!-- End Saved Jobs Page -->
    </body>
</html>
<?php
echo $loginConfig; 
ob_end_flush();
?>