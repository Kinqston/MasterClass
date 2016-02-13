<?php
class Controller_Calendar extends Controller
{
    function __construct() {
        $this->view = new View;
        $this->model = new Model_Calendar();
    }
    function action_index()
    {
        $data["rights"] = $this->model->get_rights();
        $data["login"] = $this->model->get_login();
        $data["rights"] = $this->model->get_rights();
        $this->view->generate('calendar_view.php', 'template_view.php',$data);

    }
    function action_date() {
        header('Content-Type: application/json ');
        echo $this->model->get_events();
    }
}
