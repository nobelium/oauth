<?php
/**
 * This file contains class definition for tokens
 * 
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
			
		}
	}
	
	//screwed up... fix this immediately
	private function load(){
		$query = "SELECT * FROM `token` WHERE `id`='{$this->id}'";
		$result = $this->pdo->query($query);
		if($result->rowCount()==1){
			$result = $result->fetch();
			$this->type = $result['type'];
		}
	}
	
	
	//functions to do CRUD operations
	
	//getter functions
	
	public function isaccess(){
		return $this->type == 1;
	}
	
	public function isrequest(){
		return !$this->isaccess();
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
