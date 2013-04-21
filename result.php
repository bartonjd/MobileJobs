<?php
set_include_path ('/home/jbarton/public_html/');
include_once('includes/common.inc.php');
$page = new Page();
$linkedIn = $page->getLinkedIn();
$data = fetchData('includes/client-ajax/opportunity.php?action=job_details&opp_id='.$_REQUEST['opp_id']);
$data = $data[0];
?>
		<?php $page->commonHeader(); ?>
            <div data-theme="c" data-role="header" class="header">
                 
				<h2>
                    Job Details
                </h2>
 
            </div>
            <div data-role="content">
                  <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">

                        <label>
							<?php echo $data->opportunity_name;;?>
						</label>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label>
                            Opportunity Description:
                        </label>
                        <label>
                            <?php echo $data->opportunity_description;?>
						</label>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label>
                            City:
                        </label>
                        <label>
                            <?php echo $data->city;?>
						</label>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <label>
                            State:
                        </label>
                        <label>
                            <?php echo $data->state;?>
						</label>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label>
                            Organization/Company:
                        </label>
                        <label>
                            <?php echo $data->organization;?>
						</label>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <label>
                            Pay Type:
                        </label>
                        <label>
                            <?php echo $data->pay_type;?>
						</label>
                </div>
                <div data-role="fieldcontain">
                    <label>
                            Schedule Type:
                        </label>
                        <label>
                            <?php echo $data->schedule_type;?>
						</label>
                </div>
                <div id="checkboxes1" data-role="fieldcontain">
                    <fieldset data-role="controlgroup" data-type="vertical">
                        <label>
                            Internship
                        </label>

                        <label for="checkbox1">
	                        <?php echo $data->internship;?>    
                        </label>
                    </fieldset>
            </div>
	        </div>
        
           <?php $page->commonFooter(); ?>