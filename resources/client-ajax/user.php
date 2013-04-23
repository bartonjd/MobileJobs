<?php
   set_include_path ('/home/jbarton/public_html/');
   include('resources/common.inc.php');
   $page = new Page();
   $linkedIn = $page->getLinkedIn();
   
   switch($_REQUEST['action']){
	   case 'notify':
	       //should Notify by email
	       $data = json_decode($_REQUEST['data']);
	       $linkedIn->updateNotifyOption($data);
	   break;
   } 
   
/****[lType Handling]*****
 * [initiate or revoke]
 * @param initiate for login to linkedIn
 * @param revoke for logout from linkedIn
 */
   
   //Ensure that the app URL is not polluted with GET parameters
   if(($linkedIn->isLoggedIn() || $REQUEST['lType']=='revoke') || isset($_GET['oauth_problem']) || isset($_GET['lResponse'])){
       $serverName = "http://${_SERVER['SERVER_NAME']}";
       header("Location: ${serverName}/index.php");
   }
?>