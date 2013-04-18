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
            <?php $page->commonIncludes(); ?>

        <!-- User-generated css -->
        <style>
        .i-txt{display:none}
        </style>
        <!-- User-generated js -->
        <script>

        //    $.ready = function(args){$(document).live('pageload',args);};
       	
	        	$(document).on('pagecreate',function(){
	        		$('form').validate();
	        		$('form').on('submit',function(e){
		        		var valid = $('form').validate();
		        		if (valid.errorList.length >0){
		        			e.stopImmediatePropagation();
		        			e.preventDefault();
			        		return false;
		        		}
		        		var data =$.serializeForm($('form'));
			        	//set to data get variable, url encode json string
			        	var dataString = 'data='+ encodeURIComponent($.encodeJSON(data));
			        	
			        	//Need to attach tags to opportunity record
		        		$.ajax({
					        type: "POST",
					        url: 'includes/client-ajax/opportunity.php?action=add_opportunity',
					        data: dataString,
					        dataType: "json",
					        success: function(data) {
						        
					        }
					     });
		        		
	        		});
		        	$('#state').autocomplete({
		        		autoSelectFirst:true,
			        	serviceUrl: 'includes/client-ajax/autocomplete.php',
			        	params:{action:'state_list',state:''},
			        	paramName:'query'
		        	});
		        	$('#city').autocomplete({
		        		autoSelectFirst:true,
			        	serviceUrl: 'includes/client-ajax/autocomplete.php',
			        	params:{action:'city_list',state:''},
			        	onSearchStart:function(params){
				        	params.state = $('#state').attr('value');
			        	},
			        	paramName:'query'
		        	});
		        	$('#tags').autocomplete({
		        		autoSelectFirst:true,
			        	serviceUrl: 'includes/client-ajax/autocomplete.php',
			        	params:{action:'tag_list',state:''},
			        	paramName:'query',
			        	onSelect:function(suggestion){
				        	$('#tag-area').addTag($('input[name=tags]').attr('value'));
				   //     	$('input[name=tags]').attr('value','');
			        	},
			        	onNoResult:function(){
			        		var data ={tag_name: $('input[name=tags]').attr('value')};
			        		//set to data get variable, url encode json string
			        		var dataString = 'data='+ encodeURIComponent($.encodeJSON(data));
			        		$('#tag-area').addTag($('input[name=tags]').attr('value'));
			        		
			        		$.ajax({
						        type: "POST",
						        url: 'includes/client-ajax/opportunity.php?action=add_tag',
						        data: dataString,
						        dataType: "json",
						        success: function(data) {
							        
						        }
						     });

				        //	$('input[name=tags]').attr('value','');
				        	// mark ahidden input or something saying save to db
				        }
		        	});


				    $('#tag-area').tagsInput({
				    	interactive:false,
				    	height:60,
				    	width:700,
					    onAddTag:function(){
						    $('input[name=tags]').attr('value','');
					    }
				    });
				    
				    /*		
				    $('#state').mobiscroll().select({
				        theme: 'ios',
				        display: 'top',
				        preset:'select',
				        mode: 'scroller',
				        inputClass: 'i-txt',
				        width: 200
				    });	    
					$('#show').click(function () {
					        $('#state').mobiscroll('show'); 
					        return false;
					    });
					
					    $('#clearSelect').click(function () {
					        $('#state').val(1).change();
					        $('#state').val('');
					        return false;
					    });
			       */
		           $('input[type=submit]').click(function(){
			        	
			        	//serialize form and send by ajax 
		           });

				});
        </script>
    </head>
    <body>
    
        <!-- Home -->
        <div data-role="page" id="page">
        <h2>Administrate</h2>
        <form>
            <div data-role="content">

                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="opportunity_name">
                            Opportunity Name
                        </label>
                        <input name="opportunity_name" id="opportunity_name" placeholder="Name of Opportunity" value="" type="text" class="required"/>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="opportunity_description">
                            Opportunity Description
                        </label>
                        <textarea name="opportunity_description" id="opportunity_description" placeholder="Opportunity Description" class="required"></textarea>
                    </fieldset>
                </div>
                
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="tags">
                            Tags
                        </label>
                       
                        <input name="tags" id="tags" placeholder="Add some tags to make this job easier to find" value="" type="text" />
                        <div name="tag-area" id="tag-area"></div>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="state">
                            State
                        </label>
                        <input name="state" id="state" placeholder="State" value=""  class="required" type="text" />
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="city">
                            City
                        </label>
                        <input name="city" id="city" placeholder="City (Search by city name or zip code)" value="" type="text" class="required" />
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="organization">
                            Organization
                        </label>
                        <input name="organization" id="organization" placeholder="Organization" value="" class="required" type="text" />
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <legend for="pay_type">
                        Pay Type
                    </legend>
                    <select name="pay_type" >
                        <option value="paid">
                            Paid
                        </option>
                        <option value="unpaid">
                            Unpaid
                        </option>
                    </select>
                </div>
                <div data-role="fieldcontain">
                    <legend for="schedule_type">
                        Schedule Type
                    </legend>
                    <select name="schedule_type" id="schedule_type">
                        <option value="ft">
                            Full-Time
                        </option>
                        <option value="pt">
                            Part-Time
                        </option>
                        <option value="ct">
                            Contract
                        </option>
                    </select>
                </div>
                <div id="checkboxes1" data-role="fieldcontain">
                    <fieldset data-role="controlgroup" >
                        <legend >
                            Internship
                        </legend>
                        </fieldset>
                    <fieldset data-role="controlgroup" >
                        <input id="internship" name="internship" type="checkbox" />
                         <label for="internship">
                            Yes
                        </label> 
                    </fieldset>
                  
                </div>
                <input type="submit" data-theme="b" data-icon="check" data-iconpos="left" value="Submit" />
            </div>
        </div>
        </form>
    </body>
</html>
