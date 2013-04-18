<?php
set_include_path ('/home/jbarton/public_html/');
include('includes/common.inc.php');
include('includes/client-ajax/autocomplete.php');
$page = new Page();
$linkedIn = $page->getLinkedIn();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <?php $page->commonIncludes(); ?>
        <script>
               var docURL = window.location;	
            $(document).on('pageinit',function(){
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
					window.ranOnce = 1;
				}
            });   
               
        	$(document).on('pageinit',function(){

				var valid = $('form').validate();
				$('form input[type=button]').on('click',function(e){

					 var valid = $('form').validate();
		        		if (valid.errorList.length >0){

			        		return false;
		        		}
		        		var data =$.serializeForm($('form'));
			        	//set to data get variable, url encode json string
			        	var dataString = 'data='+ encodeURIComponent($.encodeJSON(data));
			        
		        		$.ajax({
					        type: "POST",
					        url: 'includes/client-ajax/opportunity.php?action=search_jobs',
					        data: dataString,
					        dataType: "json",
					        success: function(data) {
						        
					        }
					     });
				});
				
            });
        </script>
    </head>
    <body>
        <!-- Home -->
        <div data-role="page" id="page">
            <div data-theme="c" data-role="header" class="header">
                 <?php $page->commonHeader(); ?>
				<h2>Search Job & Internship Opportunities</h2>
            </div>
            <form>
            <div data-role="content">
           
                <div data-role="fieldcontain">
                    <fieldset role="controlgroup">
                        <label for="city">
                            City
                        </label>
                        <input type="text" name="city" id="city" value="" placeholder="City">
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="state">State</label>
                        <?php echo getStates('state');?>
                    </fieldset>
                </div>
                
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="pay_type">Pay Type</label>
                        <select name="pay_type" id="pay_type" data-role="none">
                            <option value=""></option>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                        </select>
                     </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                    <label for="schedule_type">Schedule Type</label>
                    <select name="schedule_type" id="schedule_type" data-role="none">
                    	<option value=""></option>
                        <option value="ft">Full-Time</option>
                        <option value="pt">Part-Time </option>
                        <option value="ct">Contract</option>
                    </select>
                    </fieldset>
                </div>
                <div id="checkboxes1" data-role="fieldcontain">
                    <fieldset data-role="controlgroup" data-type="vertical">
                        <legend>
                            Internship
                        </legend>
                    </fieldset>
                    <fieldset data-role="controlgroup" data-type="vertical">
                        <label for="internship">
                        <input id="checkbox1" name="internship" type="checkbox" />Yes</label>
                    </fieldset>
                </div>
                <input type="button" data-icon="check" data-iconpos="left" value="Submit" />
            </div>
            </form>
        
           <?php $page->commonFooter(); ?>
        </div>
    </body>
</html>