<?php
/*
 * This file contains class definition to abstract database interation that uses a pdo instance
 * 
 * Classname : db
 * Filename  : class.db.inc.php
 * 
 * */
 
class db {
	
	protected $pdo;
	
	function __construct($argument) {
		
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
}

 
 
 
 
?>