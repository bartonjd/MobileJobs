<?php
			require_once('linkedin/linkedInUsers.php');
	
    class Page {
    	public $loginConfig;
    	public $URL;
    	private $docURL;
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
	        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.css" />
	        <link rel="stylesheet" href="css/my.css" />
	        <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	        <script src="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.js"></script>
	        <script src="js/my.js"></script>
EOT;
		}
		public function commonHeader ($title=null) {
			if (!isset($title)){
				$title = 'Utah State University';
			}
			echo <<<EOT
				<div data-theme="b" data-role="header" class="header">
            		<a href="#" data-role="button" data-icon="home" data-theme="d">Home</a>
                	<h1>
                    	$title
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
	if ($_REQUEST['lType'] == 'revoke'){
		// clear the url of any GET parameters such as 'lType'
		header('location:index.php');
	}
?>