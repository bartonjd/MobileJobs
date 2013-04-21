<?php
   set_include_path ('/home/jbarton/public_html/');
   include_once('includes/common.inc.php');
   $page = new Page();
   $linkedIn = $page->getLinkedIn();
   
   switch($_REQUEST['action']){
	   case 'add_opportunity':
	       $db = connect2DB();
	       $data = $_REQUEST['data'];

	       $jtb = new JSONTableBridge('opportunities', null, array('tag'=>'{false}','tags'=>'{false}'), $db);
	       $jtb->CREATE($data);

	   break;
	   case 'add_tag':
	       //should Notify by email
	       $data = ($_REQUEST['data']);
		   $db = connect2DB();

	       $jtb = new JSONTableBridge('tags', null, array(), $db);
	       $jtb->CREATE($data);
	   break;
	   case 'job_details':
	   		$db = connect2DB();
	   		$sql = "SELECT opportunity_description,opportunity_name, city,state,pay_type,organization,schedule_type,CASE WHEN internship = 't' THEN 'Yes' ELSE 'No' END as internship FROM opportunities WHERE opportunity_id = $1";
	   		$params = array((integer)$_REQUEST['opp_id']);
	   		
	        $query = pg_query_params($db, $sql,$params);
	        $result = pg_num_rows($query);
	        if($result == 1) {
		        $returnData = pg_fetch_all($query);
		        die(json_encode($returnData));
	        }
	   break;
	   case 'search_jobs':
	   		$data = getData($_REQUEST['data']);
	   	   	$db = connect2DB();
	   	   	$whereArray = getWhereParams($data);
	   	   	
			//$params =  createParams($paramList);

		    $sql = 'SELECT * FROM opportunities WHERE '.$whereArray[0];
die($sql);
	        $query = pg_query_params($db, $sql,$whereArray[1]);
	        $result = pg_num_rows($query);
	        
	        if($result >0) {
		        $optionsObj = new stdClass;
		        $optionsObj->limit = 10; 
		        $optionsObj->results = $result;
		        $optionsObj->page = 1;
		        $optionsObj->pages = ceil($result/$optionsObj->limit);
		        $optionsObj->start = 0;
	
		        $returnObj = array('options'=>$optionsObj,'search'=>$data,'success'=>true);
		    } else {
			    $returnObj = array('payload'=>array(),'errors'=>'No Results Found','success'=>false);
		    }
		    die(json_encode($returnObj));
	   break;

   } 
   function createParams($city='',$state='',$organization='', $schedule_type='',$pay_type='',$intern=''){
       $params = array($city,$state,$organization, $schedule_type,$pay_type,$intern);
       return $params;   
   }
?>