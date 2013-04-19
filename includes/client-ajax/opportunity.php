<?php
   set_include_path ('/home/jbarton/public_html/');
   include('includes/common.inc.php');
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
	   case 'search_jobs':
	   		$data = getData($_REQUEST['data']);
	   	   	$db = connect2DB();
		    $sql = 'SELECT * FROM opportunities WHERE city = $1 OR state = $2 OR organization = $3';
		    $sql .= ' OR schedule_type = $4 OR pay_type = $5 OR internship = $6';
		    
		    $params =  createParams($data->city,$data->state,$data->organization,$data->schedule_type,$data->pay_type,$data->internship);

	        $query = pg_query_params($db, $sql,$params);
	        $result = pg_num_rows($query);
	        
	        if($result >0) {
		        $optionsObj = new stdClass;
		        $optionsObj->limit = 10; 
		        $optionsObj->page = 1;
		        $optionsObj->pages = ceil($result/$optionsObj->limit);
		        $optionsObj->start = 0;
	
		        $returnObj = array('options'=>$optionsObj,'search'=>$params,'success'=>true);
		    } else {
			    $returnObj = array('payload'=>array(),'errors'=>'No Results Found','success'=>false);
		    }
		    die(json_encode($returnObj));
	   break;

   } 
   function createParams($city='',$state='',$organization='', $schedule_type='',$pay_type='',$intern){
       $params = array($city,$state,$organization, $schedule_type,$pay_type,$intern);
       return $params;   
   }
?>