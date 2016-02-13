<?php
Class Model_Main extends Authorization {
	public function get_news() {
		$this->prepare("SELECT * FROM news ORDER BY id DESC LIMIT 3");
		return $this->execute_all();
	}
}