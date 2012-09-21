<?php
/**
 * This file contains class defintion for consumer
 * 
 * Classname : consumer
 * Filename  : class.consumer.inc.php
 * 
 */
 
@require_once (dirname(__FILE__).'/class.db.inc.php');

class consumer {
	
	//All columns in consumer table
	private $id;
	private $key;
	private $secret;
	private $active;
	
	//pdo object
	private $pdo;
	
	function __construct($id=0) {
		$this->pdo = db::instance();
		if($id != 0){
			$this->id = $id;
			$this->load();
		}
	}
	
	private function load(){
		$query = "SELECT * FROM `consumer` WHERE `id`='{$this->id}'";
		$result = $this->pdo->query($query);
		if($result->rowCount()==1){
			$result = $result->fetch();
			$this->setkey($result['consumer_key']);
			$this->setsecret($result['consumer_secret']);
			$this->setactive($result['active']);
		} else {
			$this->id = NULL;
		}
	}
		
	//Function to do CRUD operations
	
	public static function create($key, $secret){
		$pdo = db::instance();
		$query = "INSERT INTO `consumer` (`id`, `consumer_key`, `consumer_secret`, `active`) VALUES (NULL, '{$key}', '{$secret}', '1')";
		$pdo->exec($query);
		return new consumer($pdo->lastinsertid());
	}
	
	public static function findbykey($key){
		$pdo = db::instance();
		$query = "SELECT `id` FROM `consumer` WHERE `consumer_key`='{$key}'";
		$result = $pdo->query($query);
		if($result->rowCount() == 1){
			$result = $result->fetch();
			return new consumer($result['id']);
		}
		return FALSE;
	}
	
	//getter functions
	public function getid(){
		return $this->id;
	}
	
	public function getkey(){
		return $this->key;
	}
	
	public function getsecret(){
		return $this->secret;
	}
	
	public function isactive(){
		return $this->active;
	}
	
	//setter functions
	public function setid($val){
		$this->id = $id;
	}
	
	public function setkey($val){
		$this->key = $val;
	}
	
	public function setsecret($val){
		$this->secret = $val;
	}
	
	public function setactive($val){
		$this->active = $val;
	}
}

?>