<?php
   set_include_path ('/home/jbarton/public_html/');
   include('includes/common.inc.php');
   $page = new Page();
   $linkedIn = $page->getLinkedIn();
   
   switch($_REQUEST['action']){
	   case 'notify':
	       //should Notify by email
	       $data = json_decode($_REQUEST['data']);
	       $linkedIn->updateNotifyOption($data);
	   break;
   } 
    
?>