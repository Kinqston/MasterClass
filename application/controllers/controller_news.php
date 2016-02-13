<?php
class Controller_News extends Controller
{
    function __construct() {
        $this->view = new View();
        $this->model = new Model_News();
    }
	function addnews($id) {
		return (object) [
				"caption" => $_POST["newsCaption"],
				"ntext" => $_POST["newsText"],
				"id" => $id,
				"image" => $_FILES['uploadfile']['name']
		];
	}
    function action_index() {
        $data["news"] = $this->model->get_news();
        $data["rights"] = $this->model->get_rights();
        $data["login"] = $this->model->get_login();
        $this->view->generate('news_view.php', 'template_view.php',$data);
    }
    function action_addnews() {
		if($this->model->get_rights() & U_EDIT) {
    	$data["login"] = $this->model->get_login();
			if (isset($_POST['submit'])) {
				if (is_uploaded_file($_FILES['uploadfile']['tmp_name'])) {
					move_uploaded_file($_FILES['uploadfile']['tmp_name'], 'images/' . $_FILES['uploadfile']['name']);
				};
				$this->model->addnews($this->addnews());
				header("Location: /news");
			}

			$this->view->generate('create_news_view.php', 'template_view.php', $data);
		}
		else {
			Route::ErrorPage404();
		}
    }
    function action_viewnews($id) {
    	$data["news"] = $this->model->viewnews($id['0']);
    	$data["rights"] = $this->model->get_rights();
    	$data["login"] = $this->model->get_login();
    	$this->view->generate('viewnews_view.php', 'template_view.php', $data);
    }
    function action_deletenews($id) {
		if($this->model->get_rights() & U_EDIT) {
			if ($this->model->deletenews($id['0'])) {
				header("Location: /news");
			};
		}
		else {
			Route::ErrorPage404();
		}
    }
    function action_editnews($id)
	{
		if ($this->model->get_rights() & U_EDIT) {
			$data["news"] = $this->model->viewnews($id['0']);
			$data["login"] = $this->model->get_login();
			if (isset($_POST['submit'])) {
				if (is_uploaded_file($_FILES['uploadfile']['tmp_name'])) {
					move_uploaded_file($_FILES['uploadfile']['tmp_name'], 'images/' . $_FILES['uploadfile']['name']);
				};
				$this->model->editnews($this->addnews($id['0']));
				header("Location: /news");
			}
			$this->view->generate('edit_news_view.php', 'template_view.php', $data);
		}
		else {
			Route::ErrorPage404();
		}
	}
}
