<?php
set_include_path ('/home/jbarton/public_html/');
include('includes/common.inc.php');
$page = new Page();
$linkedIn = $page->getLinkedIn();
?>
            <div data-theme="c" data-role="header" class="header">
                 <?php $page->commonHeader(); ?>
				<h2>
                    Job Details
                </h2>
 
            </div>
            <div data-role="content">
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label>
                            Opportunity Name:
                        </label>
                        <label>
							placeholder for name
						</label>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label>
                            Opportunity Description:
                        </label>
                        <label>
							placeholder for description
						</label>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label>
                            City:
                        </label>
                        <label>
							placeholder for city
						</label>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <label>
                            State:
                        </label>
                        <label>
							placeholder for state
						</label>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label>
                            Organization/Company:
                        </label>
                        <label>
							placeholder for organization/company
						</label>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <label>
                            Pay Type:
                        </label>
                        <label>
							placeholder for pay type
						</label>
                </div>
                <div data-role="fieldcontain">
                    <label>
                            Schedule Type:
                        </label>
                        <label>
							placeholder for schedule type
						</label>
                </div>
                <div id="checkboxes1" data-role="fieldcontain">
                    <fieldset data-role="controlgroup" data-type="vertical">
                        <legend>
                            Internship
                        </legend>
                        <input id="checkbox1" name="Yes" type="checkbox" />
                        <label for="checkbox1">
                            Yes
                        </label>
                    </fieldset>
            </div>
        
           <?php $page->commonFooter(); ?>