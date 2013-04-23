<?php
set_include_path ('/home/jbarton/public_html/');
include('resources/common.inc.php');
$page = new Page();
$linkedIn = $page->getLinkedIn();
$options = getData($_REQUEST['options']);
if (isset($_REQUEST['search'])){
	$searchTerms = json_decode($_REQUEST['search']);
}
$options->start = ($options->page-1) * $options->limit;



function listJobs($params,$options){
   	  	$db = connect2DB();
   	   	$whereArray = getWhereParams($params);
   	   	$limit = $options->limit;
   	   	$offset = $options->start;
	    $sql  = <<<EOT
	    	SELECT opportunity_id, opportunity_name, to_char(date_added::date, 'Month dd, YYYY') as date_added,city,state,
	    		CASE WHEN pay_type = 'paid'    THEN 'Paid'
	    			 WHEN pay_type = 'unpaid'   THEN 'Un-Paid'
	    			 WHEN pay_type = 'contract' THEN 'Contract'
	    			
	    		END as pay_type,
	    		CASE WHEN schedule_type = 'ft'
	    			THEN 'Full-Time'
	    			ELSE 'Part-Time'
	    		END as schedule_type,
	    		CASE WHEN internship = 't'
	    			THEN 'Internship' 
	    			ELSE '' 
	    		END as internship 
	    	FROM opportunities ${whereArray[0]} LIMIT $limit OFFSET $offset
EOT;

        $query = pg_query_params($db, $sql, $whereArray[1]);
        $result = pg_num_rows($query);

        if ($result > 0) {
	       $search_results = pg_fetch_all($query);
	       	$html = '<ul data-role="listview" data-inset="true">';
	       	$i = 1;
	       	$markup = "";  	   	   			
	    	foreach($search_results as $row){
	    		$oppId = $row['opportunity_id'];
		        $markup = <<<EOT
		        		${markup}\n 
		           	    <li data-role="list-divider"><span class="icon-star star-color">&#x73;</span>${row['opportunity_name']}<span class="ui-li-count">$i</span></li>
					    <li class="sres" opp_id="${row['opportunity_id']}"><a href="#">
					        <h2></h2>
					        <p class="job-small-label">${row['internship']}</p>
					        <p class="job-small-label"><strong>Hours: ${row['schedule_type']}</strong></p>
					        <p class="job-small-label"><strong>Pay:   ${row['pay_type']}</strong></p>
					        <p class="job-small-label">${row['city']}, ${row['state']}</p>
					        <p class="ui-li-aside">${row['date_added']}</p>
					    </a></li>
EOT;
	       	 	$i++;
	       }
	       $html .="$markup </ul>\n";
	       return $html;
        }
}

	$resultHtml =  listJobs($searchTerms,$options);
?>
			<?php $page->commonHeader(); ?>
			<div data-theme="c" data-role="none" class="header ui-header ui-bar-c" role="banner">
	         	<h2 class="ui-title" role="heading">Search Results</h2>
	      	</div>
        <form>
	        <div data-role="content">
				<div data-role="fieldcontain">
					<?php echo $resultHtml; ?>
				</div>
			</div>
        </form>
        <?php $page->commonFooter(); ?>
