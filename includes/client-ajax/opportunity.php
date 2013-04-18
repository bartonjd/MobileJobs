<?php
   set_include_path ('/home/jbarton/public_html/');
   include('includes/common.inc.php');
   $page = new Page();
   $linkedIn = $page->getLinkedIn();
   
   switch($_REQUEST['action']){
	   case 'add_opportunity':
	       $data = $_REQUEST['data'];
		   $db = connect2DB();

	       $jtb = new JSONTableBridge('opportunities', null, array('tags'=>'{false}'), $db);
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
	   
	   break;
   } 
   class Opportunity {
	   
	   
   }
?>