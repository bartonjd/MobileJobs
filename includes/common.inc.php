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
    	public function commonIncludes(){
        	echo <<<EOT
	        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	        <meta name="apple-mobile-web-app-capable" content="yes" />
	        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
	        <title></title>
	        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
	        <link rel="stylesheet" href="css/mobiscroll.2.5.0.min.css" />
	        <link rel="stylesheet" href="css/jquery.tagsinput.css" />
	        <link rel="stylesheet" href="css/my.css" />
	        <link rel="stylesheet" href="css/jquery.mobile.pagination.css" />
	        
	        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	        <script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
	        <script src="js/autocomplete.js"></script>
	        <script src="js/my.js"></script>
	        <script src="js/mobiscroll.2.5.0.min.js"></script>
	        <script src="js/jquery.tagsinput.js"></script>
	        <script src="js/jquery.mobile.pagination.js"></script>    
	        <script src="js/validate.js"></script>
	        
EOT;
		}
		public function commonHeader ($title=null) {
			if (!isset($title)){
				$title = ' USU MIS JOB Board';
			}
			echo <<<EOT
				<div data-theme="b" data-role="header" class="header">
            		<a href="/" data-role="button" data-icon="home" data-theme="d">Home</a>
                	<h1>
                    	<div>$title</div>
                    </h1>
                </div>
EOT;
		}
		public function commonFooter () {
			echo <<<EOT
			   <div data-theme="c" data-role="footer" data-position="fixed" class="footer">
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
?>