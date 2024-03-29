<?php
require_once('resources/jsonTableBridge.php');
// include the LinkedIn class
require_once('linkedin_3.2.0.class.php');
/**
 * This file is used in conjunction with the 'LinkedIn' class, demonstrating 
 * the basic functionality and usage of the library.
 * 
 * COPYRIGHT:
 *   
 * Copyright (C) 2011, fiftyMission Inc.
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a 
 * copy of this software and associated documentation files (the "Software"), 
 * to deal in the Software without restriction, including without limitation 
 * the rights to use, copy, modify, merge, publish, distribute, sublicense, 
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in 
 * all copies or substantial portions of the Software.  
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING 
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS 
 * IN THE SOFTWARE.  
 *
 * SOURCE CODE LOCATION:
 * 
 *   http://code.google.com/p/simple-linkedinphp/
 *    
 * REQUIREMENTS:
 * 
 * 1. You must have cURL installed on the server and available to PHP.
 * 2. You must be running PHP 5+.  
 *  
 * QUICK START:
 * 
 * There are two files needed to enable LinkedIn API functionality from PHP; the
 * stand-alone OAuth library, and the Simple-LinkedIn library. The latest 
 * version of the stand-alone OAuth library can be found on Google Code:
 * 
 *   http://code.google.com/p/oauth/
 * 
 * The latest versions of the Simple-LinkedIn library and this demonstation 
 * script can be found here:
 * 
 *   http://code.google.com/p/simple-linkedinphp/
 *   
 * Install these two files on your server in a location that is accessible to 
 * this demo script. Make sure to change the file permissions such that your 
 * web server can read the files.
 * 
 * Next, make sure the path to the LinkedIn class below is correct.
 * 
 * Finally, read and follow the 'Quick Start' guidelines located in the comments
 * of the Simple-LinkedIn library file.   
 *
 * @version 3.2.0 - November 8, 2011
 * @author Paul Mennega <paul@fiftymission.net>
 * @copyright Copyright 2011, fiftyMission Inc. 
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License 
 */
class LinkedInAuthMgr {
	protected $loggedInState;
	protected $linkedInResponse;
	protected $buttonLabel;
	protected $errorMsg;
    public function __construct($app_key,$app_secret) {
        try {
            $this->errorMsg = array();

            // start the session
            if (!session_start()) {
                throw new LinkedInException('This script requires session support, which appears to be disabled according to session_start().');
            }

            // display constants
            $API_CONFIG = array(
                'appKey' => $app_key,
                'appSecret' => $app_secret,
                'callbackUrl' => NULL);
            define('PORT_HTTP', '80');
            define('PORT_HTTP_SSL', '443');

            // set index
            $_REQUEST[LINKEDIN::_GET_TYPE] = (isset($_REQUEST[LINKEDIN::_GET_TYPE])) ? $_REQUEST[LINKEDIN::_GET_TYPE] : '';
            switch ($_REQUEST[LINKEDIN::_GET_TYPE]) {
                case 'initiate':
                    /**
                     * Handle user initiated LinkedIn connection, create the LinkedIn object.
                     */

                    // check for the correct http protocol (i.e. is this script being served via http or https)
                    if ($_SERVER['HTTPS'] == 'on') {
                        $protocol = 'https';
                    } else {
                        $protocol = 'http';
                    }

                    // set the callback url
                    $API_CONFIG['callbackUrl'] = $protocol.
                    '://'.$_SERVER['SERVER_NAME'].((($_SERVER['SERVER_PORT'] != PORT_HTTP) || ($_SERVER['SERVER_PORT'] != PORT_HTTP_SSL)) ? ':'.$_SERVER['SERVER_PORT'] : '').$_SERVER['PHP_SELF'].
                    '?'.LINKEDIN::_GET_TYPE.
                    '=initiate&'.LINKEDIN::_GET_RESPONSE.
                    '=1';
                    $OBJ_linkedin = new LinkedIn($API_CONFIG);

                    // check for response from LinkedIn
                    $_REQUEST[LINKEDIN::_GET_RESPONSE] = (isset($_REQUEST[LINKEDIN::_GET_RESPONSE])) ? $_REQUEST[LINKEDIN::_GET_RESPONSE] : '';
                    if (!$_REQUEST[LINKEDIN::_GET_RESPONSE]) {
                        // LinkedIn hasn't sent us a response, the user is initiating the connection

                        // send a request for a LinkedIn access token
                        $response = $OBJ_linkedin -> retrieveTokenRequest();
                        if ($response['success'] === TRUE) {
                            // store the request token
                            $_SESSION['oauth']['linkedin']['request'] = $response['linkedin'];
                            $this->linkedInResponse = $response['linkedin'] ;
                           

                            // redirect the user to the LinkedIn authentication/authorisation page to initiate validation.
                            header('Location: '.LINKEDIN::_URL_AUTH.$response['linkedin']['oauth_token']);
                        } else {
                            // bad token request
                            $this->logError("Request token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>".json_decode($response).
                            "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>".json_encode($OBJ_linkedin).
                            "</pre>");
                        }
                    } else {
                        // LinkedIn has sent a response, user has granted permission, take the temp access token, the user's secret and the verifier to request the user's real secret key
                        $response = $OBJ_linkedin->retrieveTokenAccess($_SESSION['oauth']['linkedin']['request']['oauth_token'], $_SESSION['oauth']['linkedin']['request']['oauth_token_secret'], $_REQUEST['oauth_verifier']);
                        if ($response['success'] === TRUE) {
                            // the request went through without an error, gather user's 'access' tokens
                            $_SESSION['oauth']['linkedin']['access'] = $response['linkedin'];

                            // set the user as authorized for future quick reference
                            $_SESSION['oauth']['linkedin']['authorized'] = TRUE;
                            $this->linkedInResponse = $response['linkedin'] ;

                            // redirect the user back to the demo page
                            header('Location: '.$_SERVER['PHP_SELF']);
                        } else {
                            // bad token access
                            $this->logError("Access token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>".json_encode($response).
                            "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>".json_encode($OBJ_linkedin).
                            "</pre>");
                        }
                    }
                    break;

                case 'revoke':
                    /**
                     * Handle authorization revocation.
                     */

                    // check the session
                    if (!$this->oauth_session_exists()) {
                        throw new LinkedInException('This script requires session support, which doesn\'t appear to be working correctly.');
                    }

                    $OBJ_linkedin = new LinkedIn($API_CONFIG);
                    $OBJ_linkedin->setTokenAccess($_SESSION['oauth']['linkedin']['access']);
                    $response = $OBJ_linkedin -> revoke();
                    if ($response['success'] === TRUE) {
                        // revocation successful, clear session
                        session_unset();
                        $_SESSION = array();
                        if (session_destroy()) {
                        	$this->linkedInResponse = null;
                            // session destroyed
                            header('Location: '.$_SERVER['PHP_SELF']);
                        } else {
                            // session not destroyed
                            $this->logError("Error clearing user's session");
                        }
                    } else {
                        // revocation failed
                        $this->logError("Error revoking user's token:<br /><br />RESPONSE:<br /><br /><pre>".json_encode($response).
                        "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>".json_encode($OBJ_linkedin).
                        "</pre>");
                    }
                    break;
                default:
                    // nothing being passed back, display demo page

                    // check PHP version
                    if (version_compare(PHP_VERSION, '5.0.0', '<')) {
                        throw new LinkedInException('You must be running version 5.x or greater of PHP to use this library.');
                    }

                    // check for cURL
                    if (extension_loaded('curl')) {
                        $curl_version = curl_version();
                        $curl_version = $curl_version['version'];
                    } else {
                        throw new LinkedInException('You must load the cURL extension to use this library.');
                    }
                    $_SESSION['oauth']['linkedin']['authorized'] = (isset($_SESSION['oauth']['linkedin']['authorized'])) ? $_SESSION['oauth']['linkedin']['authorized'] : FALSE;
                    if ($_SESSION['oauth']['linkedin']['authorized'] === TRUE) {
                        $OBJ_linkedin = new LinkedIn($API_CONFIG);
                        $OBJ_linkedin -> setTokenAccess($_SESSION['oauth']['linkedin']['access']);
                        $OBJ_linkedin -> setResponseFormat(LINKEDIN::_RESPONSE_XML);

                    } else {

                    }

                    if ($_SESSION['oauth']['linkedin']['authorized'] === TRUE) {
                        // user is already connected
                        $server_self = $_SERVER['PHP_SELF'];


                        $type = LINKEDIN::_GET_TYPE;
                        //The label to showto change the current state
                        $this->buttonLabel = 'Sign Out';
                        //The actual state
                        $this->loggedInState = 'signedin';

                        $response = $OBJ_linkedin -> profile('~:(id,first-name,last-name,email-address,picture-url)');
                        if ($response['success'] === TRUE) {

                            $response['linkedin'] = new SimpleXMLElement($response['linkedin']);
                            $this->linkedInResponse = $response['linkedin'] ;
                            $this->checkUserExists($response['linkedin']);


                        } else {
                            // request failed
                            $this->logError("Error retrieving profile information:<br /><br />RESPONSE:<br /><br /><pre>" . json_encode($response) . "</pre>");
                        }
                    } else {
                        // user isn't connected
                        $this->buttonLabel = 'Sign In';
                        $this->loggedInState = 'signedout';


                    }

                    break;
            }
        } catch (LinkedInException $e) {
            // exception raised by library call
        }
    }
    public function getProfileData(){
    	
	    return $this->convertXML2Array($this->linkedInResponse);    
    }
    public function getUserData(){
	    $data = $this->getProfileData();
	    $db = connect2DB();
	    $sql = "SELECT * FROM users WHERE email_address = $1";
	    $params = array($data['email-address']);
        $query = pg_query_params($db, $sql, $params);
        $result = pg_num_rows($query);

        if ($result == 1) {
	       $account = pg_fetch_assoc($query,0);
	       return $account;
        } else {
        	$this->logError('Problem getting user account info');
	        return array();
        }
    }
    public function isLoggedIn(){
		if ($this->loggedInState == 'signedin'){
			return true;
		}
		return false;
	}
    private function checkUserExists($data) {

        $db = connect2DB();
        $data = $this->convertXML2Array($data);
        $sql = "SELECT * FROM users WHERE email_address = $1";

        $params = array($data['email-address']);
        $query = pg_query_params($db, $sql, $params);
        $result = pg_num_rows($query);

        if ($result == 0) {
            $jtb = new JSONTableBridge('users', null, array('last_modified'=>'{datetime}','email-address' => 'email_address', 'first-name' => 'first_name', 'last-name' => 'last_name', 'picture-url' => '{false}', 'id' => '{false}'), $db);
            $jsonData = json_encode($data);
            $jtb -> CREATE($jsonData, NULL, true);
        }
    }
    private function convertXML2Array($xml) {
    	if ($xml != "") {
	        $obj = array();
	        foreach($xml as $prop => $val) {
	            $obj[$prop] = $val;
	        }
	        return $obj;
        } else {
	        return array();
        }
    }
    public function getButtonLabel(){
	    return $this->buttonLabel;
    }
    public function getLoginState(){
	    return $this->loggedInState;
    }
    private function oauth_session_exists() {
        /**
         * Session existence check.
         * 
         * Helper function that checks to see that we have a 'set' $_SESSION that we can
         * use for the demo.   
         */
        if ((is_array($_SESSION)) && (array_key_exists('oauth', $_SESSION))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    private function logError($msg){
    	error_log($msg);
	    array_push($this->errorMsg,$msg);
	    
    }
    public function updateNotifyOption($input){
	    $db = connect2DB();
	    $data = $this->getProfileData();
        $jtb = new JSONTableBridge('users', 'email_address', array('last_modified'=>'{datetime}','email_address'=>"[".$data['email-address']."]"), $db);
        $jtb->UPDATE(json_encode($input));
 
    }
}
?>