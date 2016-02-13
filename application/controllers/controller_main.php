<?php
class Controller_Main extends Controller
{
    function __construct() {
        $this->view = new View();
        $this->model = new Model_Main();
    }
    function action_index()
    {
        $data["news"] = $this->model->get_news();
        $data["login"] = $this->model->get_login();
        $this->view->generate('main_view.php', 'template_view.php',$data);
    }
    function action_logout() {
        $this->model->delete_session();
        header("Location: /main");
    }
}