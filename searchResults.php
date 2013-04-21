<?php
set_include_path ('/home/jbarton/public_html/');
include('includes/common.inc.php');
$page = new Page();
$linkedIn = $page->getLinkedIn();
$options = getData($_REQUEST['options']);
if (isset($_REQUEST['search'])){
	$searchTerms = json_decode($_REQUEST['search']);
}
$options->start = ($options->page-1) * $options->limit;

$nextPage = $options->page+1;
$prevPage = $options->page-1;

if($prevPage == -1) {
	$noPrev = true;
	$noNext = false;
}

if($nextPage >= $options->pages) {
	//This is the last page
	$noNext = true;
}
if($options->page == 1){
		$noPrev = true;
} else{
		$noPrev = false;
}

function listJobs($params,$options){
   	  	$db = connect2DB();
   	   	$whereArray = getWhereParams($params);
   	   	$limit = $options->limit;
   	   	$offset = $options->start;
	    $sql  = "SELECT opportunity_id, opportunity_name, city,state,pay_type,schedule_type,CASE WHEN internship = 't' THEN 'Yes' ELSE 'No' END as internship FROM opportunities WHERE ";	
	    $sql .= $whereArray[0]." LIMIT $limit OFFSET $offset";
	  //  die($sql);
        $query = pg_query_params($db, $sql, $whereArray[1]);
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

$resultHtml =  listJobs($searchTerms,$options);
?>

        	<ul data-role="pagination" style="cursor:pointer;>
	        	<?php
			        		if (!$noPrev){
				        		echo <<<EOT
				        		<li class="paging-sres ui-pagination-prev" style="cursor:pointer;" url="$url_prev"><a href="#">Prev</a></li>
EOT;
							}
							if (!$noNext){
				        		echo <<<EOT
				        		<li class="paging-sres  ui-pagination-next" style="cursor:pointer;" url="$url_next"><a href="#NEXT">Next</a></li>
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
				<div>Found <?php echo $options->results;?> results</div>
				<?php echo $resultHtml; ?>
			</div>
		</div>
        </form>
        <?php $page->commonFooter(); ?>