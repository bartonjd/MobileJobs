<?php
set_include_path ('/home/jbarton/public_html/');
include('includes/client-ajax/autocomplete.php');

?>

            <div data-theme="c" data-role="header" class="header">
                 <?php $page->commonHeader(); ?>
				<h2>Search Job & Internship Opportunities</h2>
            </div>
            <form name="search-form" id="search-form">
            <div data-role="content">
                <div data-role="fieldcontain">
                    <fieldset role="controlgroup">
                        <label for="tags">
                            Tags
                        </label>
                        <input type="text" name="tags" id="tags" value="" placeholder="Tags">
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset role="controlgroup">
                        <label for="city">
                            Organization
                        </label>
                        <input type="text" name="organization" id="organization" value="" placeholder="Organization">
                    </fieldset>
                </div>       
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

               <div data-role="fieldcontain">
                  <label for="internship">Internship</label>
                  <select name="internship" id="internship" data-role="slider" data-theme="d">
                  	 <option value=""></option>
                     <option value="f">No</option>
                     <option value="t" >Yes</option>
                  </select>
               </div>
                <input type="button" data-icon="check" data-iconpos="left" value="Search" />
            </div>
            
            </form>
        
           <?php $page->commonFooter(); ?>