<?php
/**
 * This file contains class definition for tokens
 * 
 * Author	 : vignesh
 * Classname : token
 * Filename  : class.token.inc.php
 * 
 */
 
@require_once (dirname(__FILE__).'/class.db.inc.php');
 
class token {
	
	//columns in token table
	protected $id;
	protected $type;
	protected $consumer; //consumer object from class.consumer.inc.php
	protected $user;	//user object from class.user.inc.php
	protected $token;
	protected $token_secret;
	protected $callback_url;
	protected $verifier;
	
	//pdo instance
	protected $pdo;
	
	function __construct($id) {
		$this->pdo = db::instance();
		if($id != 0){
			$this->id = $id;
			$this->load();
		}
	}
	
	private function load(){
		$query = "SELECT * FROM `token` WHERE `id`='{$this->id}'";
		$result = $this->pdo->query($query);
		if($result->rowCount()==1){
			$result = $result->fetch();
			$this->type = $result['type'];
			$this->token = $result['token'];
			$this->token_secret = $result['token_secret'];
			$this->callback_url = $result['callback_url'];
			$this->verifier = $result['verifier'];
			$this->consumer = new consumer($result['consumer_id']);
			//add user object after defining the class...
			if($result['user_id']){
				$this->user = new user($result['user_id']);
			} else {
				$this->user = 0;
			}
		}
	}
	
	
	//functions to do CRUD operations
	
	public static function createrequesttoken($consumer, $token, $token_secret, $callback){
		$pdo = db::instance();
		$query = "INSERT INTO `token` (`type`, `consumer_id`, `token`, `token_secret`, `callback_url`) VALUES ('1', '{$consumer->getid()}', '{$token}', '{$token_secret}', '{$callback}')";
		$pdo->exec($query);
		//return new token($pdo->lastinsertid());
	}
	
	public static function findbytoken($token){
		$pdo = db::instance();
		$query = "SELECT `id` FROM `token` WHERE `token`='{$token}'";
		$result = $pdo->query($query);
		if($result->rowCount()==1){
			$result = $result->fetch();
			return new token($result['id']);
		}
		return FALSE;
	}
	
	//setter functions
	
	public function changetoaccesstoken($token, $secret){
		if($this->isrequest()){
			$query = "UPDATE `token` SET `type`=2 , `token`='{$token}', `token_secret`='{$secret}', `callback_url`='', `verifier`='' WHERE `id`='{$this->id}'";
			$this->pdo->exec($query);
			$this->token = $token;
			$this->token_secret = $secret;
			$this->type = 2;
			$this->verifier = "";
			$this->callback_url = "";
			return TRUE;
		} else {
			return FALSE;
		}
		
	}
	
	public function setverifier($verifier){
		$this->verifier = $verifier;
		$query = "UPDATE `token` SET `verifier`='{$verifier}' WHERE `id`='{$this->id}'";
		$this->pdo->exec($query);
	}
	
	public function setuser($user){
		$this->user = $user;
		$query = "UPDATE `token` SET `user_id`='{$user->getid()}' WHERE `id`='{$this->id}'";
		$this->pdo->exec($query);
	}
	
	//getter functions
	//set type = 1 for request token
	//type = 2 for access token
	public function isrequest(){
		return $this->type == 1;
	}
	
	public function isaccess(){
		return !$this->isrequest();
	}
	
	public function getid(){
		return $this->id;
	}
	
	public function gettype(){
		return $this->type;
	}
	
	public function getconsumer(){
		return $this->consumer;
	}
	
	public function getuser(){
		return $this->user;
	}
	
	public function gettoken(){
		return $this->token;
	}
	
	public function gettokensecret(){
		return $this->token_secret;
	}
	
	public function getcallbackurl(){
		return $this->callback_url;
	}
	
	public function getverifier(){
		return $this->verifier;
	}
}

?>
