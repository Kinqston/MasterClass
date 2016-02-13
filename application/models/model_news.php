<?php
Class Model_News extends Authorization {
	public function get_news() {
		$this->prepare("SELECT * FROM news ORDER BY id DESC");
		return $this->execute_all();
	}
	public function addnews($news) {
		$this->prepare("INSERT INTO news(id, caption, ntext, image) VALUES (NULL, :caption, :ntext, :image)");
		$this->query->bindParam(":caption",$news->caption,PDO::PARAM_STR);
		$this->query->bindParam(":ntext",$news->ntext,PDO::PARAM_STR);
		$this->query->bindParam(":image",$news->image,PDO::PARAM_STR);
		return $this->execute_simple();
	}
	public function viewnews($newsid) {
		$this->prepare("SELECT * FROM news WHERE id=:id");
		$this->query->bindParam(":id",$newsid,PDO::PARAM_INT);
		return $this->execute_all();
	}
	public function deletenews($newsid) {
		$this->prepare("DELETE FROM news WHERE id=:id");
		$this->query->bindParam(":id",$newsid,PDO::PARAM_INT);
		return $this->execute_simple();
	}
	public function editnews($news) {
		$this->prepare("UPDATE news SET caption=:caption, ntext=:ntext, image=:image WHERE id=:id");
		$this->query->bindParam(":caption",$news->caption,PDO::PARAM_STR);
		$this->query->bindParam(":ntext",$news->ntext,PDO::PARAM_STR);
		$this->query->bindParam(":image",$news->image,PDO::PARAM_STR);
		$this->query->bindParam(":id",$news->id,PDO::PARAM_INT);
		return $this->execute_simple();
	}
}