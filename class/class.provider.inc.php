<?php
/**
 * This file contains class defintion for oauth provider
 * 
 * Author	 : vignesh
 * Classname : provider
 * Filename  : class.provider.inc.php
 * 
 */
 
@require_once (dirname(__FILE__).'/config.inc.php');

class ClassName{
	
	//data members
	protected $oauth;
	protected $consumer;
	protected $user;
	protected $auth_url = OAUTH_URL;
	protected $oauth_error;
	
	public static function createconsumer(){
		$key = md5(OAuthProvider::generateToken(20, TRUE));
		$secret = md5(OAuthProvider::generateToken(20, TRUE));
		return consumer::create($key, $secret);
	}

	function __construct() {
		$this->oauth = new OAuthProvider();
		
		$this->oauth->consumerHandler(array($this, 'checkconsumer'));
		$this->oauth->tokenHandler(array($this, 'checktoken'));
		$this->oauth->timestampNonceHandler(array($this, 'checknonce'));
	}
	
	public function checkrequest(){
		try{
			//runs noncehandler and expects OAUTH_OK and runs consumer handler and expects it to set consumer_secret from db
			//calls token handler if OAuthProvider::isRequestTokenEndpoint(false)
			$this->oauth->checkOauthRequest();
		}catch (OAuthException $e){
			echo OAuthProvider::reportProblem($e);
			$this->oauth_error = TRUE;
		}
	}
	
	public function setrequesttokenquery(){
		OAuthProvider::isRequestTokenEndpoint(TRUE);
	}
	
	public function generaterequesttoken(){
		if($this->oauth_error){
			return FALSE;
		}
		$require_token = md5(OAuthProvider::generateToken(20, TRUE));
		$require_token_secret = md5(OAuthProvider::generateToken(20, TRUE));
		
		$callback = $this->oauth->callback;
		$consumer = $this->consumer;
		
		token::createrequesttoken($consumer, $require_token, $require_token_secret, $callback);
		
		return "auth_url=".$this->auth_url."&request_token=".$require_token."&request_token_secret=".$require_token_secret;
	}
	
	public function generateaccesstoken(){
		if($this->oauth_error){
			return FALSE;
		}
		$access_token = md5(OAuthProvider::generateToken(20, TRUE));
		$access_token_secret = md5(OAuthProvider::generateToken(20, TRUE));
		
		$token = token::findbytoken($this->oauth->token);
		
		if($token){
			$token->changetoaccesstoken($access_token, $access_token_secret);
			return "access_token=".$token->gettoken()."&access_token_secret=".$token->gettokensecret();
		}
		$this->oauth_error = TRUE;
		return FALSE;
	}
	
	public function generateverifier(){
		return md5(OAuthProvider::generateToken(20, TRUE));
	}
	
	//handlerfunctions
	public function checkconsumer(){
		
	}
	
	public function checktoken(){
		
	}
	
	public function chechnonce(){
		return OAUTH_OK;
	}
	
	//getter functions
	
	public function getuser(){
		if(is_object($this->user)){
			return $this->user;
		} else {
			
		}
	}
}

?>