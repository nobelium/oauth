<?php
/**
 * This file contains class definition for user class
 * 
 * Classname : user
 * Filename  : class.user.inc.php
 * 
 */
 
@require_once (dirname(__FILE__).'/class.db.inc.php');
 
class user {
	
	//columns in user table
	protected $id;
	protected $username;
	protected $password;
	protected $pdo;
	
	function __construct($id=0) {
		$this->pdo = db::instance();
		if($id!=0){
			$this->id = $id;
			$this->load();
		}
	}
	
	private function load(){
		$query = "SELECT * FROM `user` WHERE `id`={$this->id}";
		$result = $this->pdo->query($query);
		if($result->rowCount()==1){
			$result->fetch();
			$this->username = $result['user_name'];
			$this->password = $result['password'];
		}
	}
	
	public static function findbyusername($username){
		$pdo = db::instance();
		$query = "SELECT `id` FROM `user` WHERE `user_name`='{$username}'";
		$result = $pdo->query($query);
		if($result->rowCount()==1){
			$result = $result->fetch();
			return new user($result[`id`]);
		}
		return FALSE;
	}
	
	public function getid(){
		return $this->id;
	}
	
	public function getusername(){
		return $this->username;
	}
	
	public function getpassword(){
		return $this->password;
	}
}

?>
