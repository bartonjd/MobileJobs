<?php
set_include_path ('/home/jbarton/public_html/');
include_once('resources/common.inc.php');
$page = new Page();
$linkedIn = $page->getLinkedIn();
$data = fetchData("resources/client-ajax/opportunity.php?action=job_details&opp_id=${_REQUEST['opp_id']}");
$data = $data[0];
?>
		<?php $page->commonHeader(); ?>
            <div data-theme="c" data-role="header" class="header">
                 
				<h2>
                    Job Details
                </h2>
 
            </div>
            <div data-role="content">
                  <div data-role="fieldcontain" class="detail-header ui-title">
                    <fieldset data-role="controlgroup">
                        <h3>
							<?php echo $data->opportunity_name;?>
						</h3>
						<div class="job-small-label"><?php echo "$data->city, $data->state &mdash; $data->date_added";?></div>
                     </fieldset>
                    </div>
                <ul data-role="listview" data-inset="true" data-divider-theme="d">
	                <li data-corners="false"  class="ui-shadow details-fields">
	                        <label for="organization-result-lbl">
	                            Organization:
	                        </label>
	                        <div name="organization-result-lbl">
	                            <?php echo $data->organization;?>
							</div>
	                </li>
	                <li data-corners="false"  class="ui-shadow details-fields">
	                        <label for="paytype-result-lbl">
	                            Pay Type:
	                        </label>
	                        <div name="paytype-result-lbl">
	                            <?php echo $data->pay_type;?>
							</div>
	                </li>
	                <li data-corners="false"  class="ui-shadow details-fields">
	                        <label for="scheduletype-result-lbl">
	                            Hours:
	                        </label>
	                        <div name="scheduletype-result-lbl">
	                            <?php echo $data->schedule_type;?>
							</div>                
					</li>
					<?php 
						if ($data->internship != ""){
					?>
	                <li data-corners="false"  class="ui-shadow details-fields">
	                        <label for="internship-result-lbl">
	                            Internship:
	                        </label>
	                        <div name="internship-result-lbl">
	                            <?php echo $data->internship;?>
							</div>
					</li>
					<?php
						}
					?>
	                <li data-corners="false" data-role="list-divider" class="ui-shadow details-fields">
	                            Description
	                </li>
	                <li data-corners="false"  class="ui-shadow details-fields">
	                        <div name="opportunitydescription-result-lbl"  >
	                            <?php echo $data->opportunity_description;?>
							</div>
	                </li>

			</ul>
            </div>

	        </div>
        
           <?php $page->commonFooter(); ?>