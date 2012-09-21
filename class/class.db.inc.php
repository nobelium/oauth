<?php
/*
 * This file contains class definition to abstract database interation that uses a pdo instance
 * 
 * Classname : db
 * Filename  : class.db.inc.php
 * 
 * */
 
class db {
	
	private $pdo;
	
	private static $instance;
	
	function __construct($argument) {
		try{
			$this->pdo = new PDO(DB_HOST.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASSWD);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->exec("set names 'utf8'");
		}catch(PDOException $e){
			die("Error <br/>Message: ".$e->getMessage());
		}
	}
	
	public static function instance(){
		if(!isset(self::$instance)){
			$classname = __CLASS__;
			self::$instance = new $classname;
		}
		return self::$instance;
	}
	
	public function exec($query){
		try{
			return $this->pdo->exec($query);
		}catch(PDOException $e){
			die("Error in ".$query." <br/>Message: ".$e->getMessage()." <br/>Trace: ".$e->getTrace());
		}
	}
	
	public function query($query){
		try{
			return $this->pdo->query($query);
		}catch(PDOException $e){
			die("Error in ".$query." <br/>Message: ".$e->getMessage()." <br/>Trace: ".$e->getTrace());
		}
	}
	
	public function lastinsertid(){
		return $this->pdo->lastInsertId();
	}
	
	public function quote($query){
		return $this->pdo->quote($query);
	}
}

 
 
 
 
?>