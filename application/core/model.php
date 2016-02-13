<?php
class Model
{
	public $query = null; // Содержит не выполненный запрос, чтобы заполнять плэйсхолдеры
	private  $link; // содержит ссылку на обьект PDO
	public $errorCode = 0; // Содержит код ошибки если что-то пошло не так
	public function __construct () {
		try {
			$this->link = new PDO("mysql:host=".HOST.";dbname=".BASENAME."", LOGIN, PASS);
			$this->link->exec("set names utf8");
			$this->link->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch(PDOException $e) {
			$this->errorCode = $e->getCode();
		}
	}
	function prepare($query) { // Подгатавливает запрос
		$this->query = $this->link->prepare($query);
	}
	function execute_simple() {
		try {
			$this->query->execute();
			return true;
		}
		catch(PDOException $e) {
			$this->errorCode = $e->getCode();
		}
		return false;
	}
	function execute_row() {
		try {
			$this->execute_simple();
			$arr =  $this->query->fetch();
			return $arr;
		}
		catch(PDOException $e) {
			$this->errorCode = $e->getCode();
		}
		return false;
	}
	function execute_all() {
		try{
			$this->execute_simple();
			$arr =  $this->query->fetchAll();
			return $arr;
		}
		catch(PDOException $e) {
			$this->errorCode = $e->getCode();
		}
		return false;
	}
}