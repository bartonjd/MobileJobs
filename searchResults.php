<?php
set_include_path ('/home/jbarton/public_html/');
include('includes/common.inc.php');
$page = new Page();
$linkedIn = $page->getLinkedIn();
$options = getData($_REQUEST['options']);
$nextOptions = getData($_REQUEST['options']);
if (isset($_REQUEST['search'])){
	$searchTerms = json_decode($_REQUEST['search']);
} else {
	$searchTerms = getData($_REQUEST['searchTerms']);
}
$options->start = ($options->page+1) * $options->limit;

if($options->page == 1) {
	$noPrev = true;
	$noNext = false;
}

if($options->page == $options->pages) {
	//This is the last page
	$noNext = true;
	if($options->page == 1){
		$noPrev = true;
	} else{
		$noPrev = false;
	}
}
$nextOptions->page = $nextOptions->page+1;
$nextOptions->start = ($options->page) * $options->limit;
$prevOptions->page = $prevOptions->page-1;
$prevOptions->start = ($prevOptions->page) * $prevOptions->limit;

$nextOptions = formatData($options);
$prevOptions = formatData($options);
$url_prev = $page->docURL .'?options='.($prevOptions).'&searchTerms='.formatData($searchTerms);
$url_next = $page->docURL .'?options='.($nextOptions).'&searchTerms='.formatData($searchTerms);

	function listJobs($params){
	   	  	$db = connect2DB();
		    $sql = "SELECT opportunity_id, opportunity_name, city,state,pay_type,schedule_type,CASE WHEN internship = 't' THEN 'Yes' ELSE 'No' END as internship FROM opportunities WHERE city = $1 ";
		    $sql .= " OR state = $2 OR organization = $3 OR schedule_type = $4 OR pay_type = $5 OR internship = $6";
	        $query = pg_query_params($db, $sql, $params);
	        $result = pg_num_rows($query);
	
	        if ($result > 0) {
		       $search_results = pg_fetch_all($query);
		       	   $html = "<table data-role=\"table\" data-mode=\"reflow\" id=\"my-table\">
		       	   	   <thead>\n
		       	   	   		<tr>\n
		       	   	   			<th>Name</th>\n
		       	   	   			<th>City</th>\n
		       	   	   			<th>State</th>\n
		       	   	   			<th>Pay Type</th>\n
		       	   	   			<th>Schedule Type</th>
		       	   	   			<th>Internship</th>
		       	   	   		</tr>
		       	   	   	</thead><tbody>";	       	   	   			
		    	foreach($search_results as $row){
		    		$oppId = $row['opportunity_id'];
			        $html .= "<tr id=\"$oppId\" class=\"sres ui-btn  ui-shadow ui-btn-up-c ui-corner-all ui-body-c\">\n";

	       		    foreach($row as $key=>$value){
	       		    	if ($key != 'opportunity_id') {
		       		    	$html .= "<td>$value</td>\n";
		       		    }
		       	    }
		         	$html .="</tr>\n";
		       }
		       $html .= '</tbody></table>';
		       return $html;
	        }
   }

$resultHtml =  listJobs($searchTerms);
?>
        	<ul data-role="pagination">
	        	<?php
			        		if (!$noPrev){
				        		echo <<<EOT
				        		<li class="ui-pagination-prev"><a href="$url_prev">Prev</a></li>
EOT;
							}
							if (!$noNext){
				        		echo <<<EOT
				        		<li class="ui-pagination-next"><a href="$url_next">Next</a></li>
EOT;
							}
						?>
			</ul>    
			<div data-theme="c" data-role="header" class="header">
         		<?php $page->commonHeader(); ?>
	         	<h2>Search Results</h2>
	      	 </div>
        <form>
        <div data-role="content">

			<div data-role="fieldcontain" style="margin:5px 25px 30px 25px;">
				<?php echo $resultHtml; ?>
			</div>
		</div>
        </form>
        <?php $page->commonFooter(); ?>
