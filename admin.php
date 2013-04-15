<?php
include('../includes/client-ajax/autocomplete.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <?php readfile('../includes/common.inc');?>

        <!-- User-generated css -->
        <style>
        .i-txt{display:none}
        </style>
        <!-- User-generated js -->
        <script>

        //    $.ready = function(args){$(document).live('pageload',args);};
       	
	        	$(document).ready(function(){
	        
	         	    $('#state').mobiscroll().select({
				        theme: 'ios',
				        display: 'top',
				        preset:'select',
				        mode: 'scroller',
				        inputClass: 'i-txt',
				        width: 200
				    })
$('#show').click(function () {
        $('#state').mobiscroll('show'); 
        return false;
    });

    $('#clearSelect').click(function () {
        $('#state').val(1).change();
        $('#state').val('');
        return false;
    });
    
		        	$('input[type=submit]').click(function(){
			        	
			        	//serialize form and send by ajax 
		        	});

				});
        </script>
    </head>
    <body>
    
        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-role="content">

                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="textinput1">
                            Opportunity Name
                        </label>
                        <input name="Opportunity Name" id="textinput1" placeholder="name" value="name" type="text" />
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="textarea1">
                            Opportunity Description
                        </label>
                        <textarea name="Opportunity Description" id="textarea1" placeholder="description">
                            description
                        </textarea>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="textinput2">
                            City
                        </label>
                        <input name="City" id="textinput2" placeholder="city" value="city" type="text" />
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <label for="state">
                        State
                    </label>
                    <?php
    echo getStates("state");
    ?>

                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="textinput4">
                            Organization
                        </label>
                        <input name="Organization" id="textinput4" placeholder="org" value="org" type="text" />
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <label for="selectmenu2">
                        Pay Type
                    </label>
                    <select name="paytype" data-role="none">
                        <option value="Paid">
                            Paid
                        </option>
                        <option value="Unpaid">
                            Unpaid
                        </option>
                    </select>
                </div>
                <div data-role="fieldcontain">
                    <label for="selectmenu3">
                        Schedule Type
                    </label>
                    <select name="scheduletype" data-role="none">
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
                    <fieldset data-role="controlgroup" data-type="vertical">
                        <legend>
                            Internship
                        </legend>
                        <input id="isinternship" name="yes" type="checkbox" />
                        <label for="isinternship">
                            Yes
                        </label>
                    </fieldset>
                </div>
                <input type="submit" data-icon="check" data-iconpos="left" value="Submit" />
            </div>
        </div>
    </body>
</html>
