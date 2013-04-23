<?php
	require_once('linkedin/linkedInUsers.php');
    class Page {
    	public $URL;
    	public $docURL;
    	private $linkedIn;
    	
    	public function __construct (){
			session_start();
			$this->docURL = $_SERVER['PHP_SELF'];
			$this->URL = "docURL = '$this->docURL';\n";
			$this->linkedIn = new LinkedInAuthMgr(APP_KEY,APP_SECRET);
			//$this->redirectUnauth();
    	}
    	public function getLinkedIn(){
    		return $this->linkedIn;
    	}
    	public function commonresources(){
        	echo <<<EOT
	        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	        <link rel="apple-touch-icon" href="apple-touch-icon.png"/>
	        <link rel="apple-touch-icon" sizes="114x114" href="images/iPhoneIcon_Big.png" />
			<link rel="apple-touch-icon" sizes="72x72" href="images/iPhoneIcon_Medium.png" />
			<link rel="apple-touch-icon" href="images/iPhoneIcon_Small.png" />
			<meta name="apple-mobile-web-app-status-bar-style" content="black" />
			<meta name="apple-mobile-web-app-capable" content="yes">
	        <title></title>
	        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
	        <link rel="stylesheet" href="css/mobiscroll.2.5.0.min.css" />
	        <link rel="stylesheet" href="css/jquery.tagsinput.css" />
	        <link rel="stylesheet" href="css/my.css" />
	        <link rel="stylesheet" href="css/jquery.mobile.pagination.css" />
	        
	        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	        <script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
	        <script src="js/plugins/autocomplete.js"></script>
	        <script src="js/my.js"></script>
	        <script src="js/plugins/mobiscroll.2.5.0.min.js"></script>
	        <script src="js/plugins/jquery.tagsinput.js"></script> 
	        <script src="js/plugins/validate.js"></script>
	        <script src="js/plugins/store_json2.min.js"></script>
	        
	        
EOT;
		}
		public function commonHeader ($title=null) {
			if (!isset($title)){
				$title = ' USU MIS JOB Board';
			}
			echo <<<EOT
				<div data-theme="b" data-role="header" class="header">
            		<a href="/" data-role="button" data-icon="home" data-inline="true" data-mini="true" class="ui-btn-right" data-theme="b">Home</a>
                	<h1>
                    	<div>$title</div>
                    </h1>
                </div>
EOT;
		}
		public function commonFooter () {
			echo <<<EOT
			   <div data-theme="c" data-role="footer" class="footer">
               		<h3 >
                    	<div>powered by <img src="images/logo-lores.png" /></div>
                    </h3>
               </div>

EOT;
		}
		public function redirectUnauth (){
			if (!$this->linkedIn->isLoggedIn()){
				header('Location: index.php');
			}
		}
	}    
	function formatData ($data){
		return urlencode(json_encode($data));
	}
	function getData($str) {
		return json_decode(urldecode($str));
	}
	function fetchData($url) {
		$serverName = $_SERVER['SERVER_NAME'];
		return json_decode(file_get_contents("http://${serverName}/$url"));
	}
	function getWhereParams($data){
		$whereClause = "";
   	   	$i=1;
   	   	$paramList = array();
		foreach($data as $key=>$par){
			if ($par != '') {
				$varNum = '$'.$i;
				$and = "";
				if ($i != 1){
					$and = " AND";
				}
				$whereClause .= "$and ${key} = $varNum";
				array_push($paramList,  $data->$key);
				$i++;
			}
			
		}
		if ($i > 1){	
			//If there was at least one parameter passed in
			$whereClause = "WHERE $whereClause";
		}
		return array($whereClause,$paramList);
	}
?>