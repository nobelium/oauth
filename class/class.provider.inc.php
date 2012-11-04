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

class provider{
	
	//data members
	protected $oauth;	//php pecl oauth extension object
	/*other objects of $oauth
	 * $oauth->token						//
	 * $oauth->callback						//
	 * $oauth->tokenhandler					//sets the method to be called to check the token 
	 * $oauth->timestampnoncehandler		//sets the method to check nonce
	 * $oauth->consumerhandler				//sets the method to check consumer
	 * $oauth->isRequestTokenEndpoint		//indicates if the request is for a request token
	 * $oauth->addRequiredParameters		//adds the parameters given
	*/
	protected $consumer;
	protected $user;
	protected $auth_url = OAUTH_URL;
	protected $oauth_error;
	
	public static function createconsumer(){
		$key = md5(OAuthProvider::generateToken(20, FALSE));
		$secret = md5(OAuthProvider::generateToken(20, FALSE));
		return consumer::create($key, $secret);
	}
	
	public static function generateverifier(){
		return md5(OAuthProvider::generateToken(20, FALSE));
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
		$this->oauth->isRequestTokenEndpoint(TRUE);
		//set call back url - name of the parameter in get request
		$this->oauth->addRequiredParameter("oauth_callback");
	}
	
	public function generaterequesttoken(){
		if($this->oauth_error){
			return FALSE;
		}
		$request_token = md5(OAuthProvider::generateToken(20, FALSE));
		$request_token_secret = md5(OAuthProvider::generateToken(20, FALSE));
		
		$callback = $this->oauth->callback;
		$consumer = $this->consumer;
		
		token::createrequesttoken($consumer, $request_token, $request_token_secret, $callback);
		
		return "auth_url=".$this->auth_url."&request_token=".$request_token."&request_token_secret=".$request_token_secret;
	}
	
	public function generateaccesstoken(){
		if($this->oauth_error){
			return FALSE;
		}
		$access_token = md5(OAuthProvider::generateToken(20, FALSE));
		$access_token_secret = md5(OAuthProvider::generateToken(20, FALSE));
		
		$token = token::findbytoken($this->oauth->token);
		
		if($token){
			$token->changetoaccesstoken($access_token, $access_token_secret);
			return "access_token=".$token->gettoken()."&access_token_secret=".$token->gettokensecret();
		}
		$this->oauth_error = TRUE;
		return FALSE;
	}
	
	//handlerfunctions
	public function checkconsumer($provider){
		$consumer = consumer::findbykey($provider->consumer_key);
		
		if(is_object($consumer)){
			if(!$consumer->isactive()){
				//refuse consumer key
				return  OAUTH_CONSUMER_KEY_REFUSED;
			} else {
				//set $this->consumer
				$this->consumer = $consumer;
				$provider->consumer_secret = $this->consumer->getsecret();
				/*echo "key=>";
				print_r($provider->consumer_key);
				echo "secret=>";
				print_r($provider->consumer_secret);*/
				return OAUTH_OK;
			}
		}
		return OAUTH_CONSUMER_KEY_UNKNOWN;
	}
	
	public function checktoken($provider){
		//return OAUTH_OK;
		$token = token::findbytoken($provider->token);
		if(is_null($token)){
			return OAUTH_TOKEN_REJECTED;
		} else if($token->gettype() == 1 && $token->getverifier() != $provider->verifier){
			return OAUTH_VERIFIER_INVALID;
		} else {
			if($token->gettype() == 2){
				$this->user = $token->getuser();
			}
			$provider->token_secret = $token->gettokensecret();
			return OAUTH_OK;
		}
	}
	
	public function checknonce($provider){
		//add a complex nonce checker
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