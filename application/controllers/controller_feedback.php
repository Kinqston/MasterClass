<?php
class Controller_Feedback extends Controller
{
    function __construct() {
        $this->view = new View();
        $this->model = new Model_Feedback();
    }
    function action_index()
    {
        $data["login"] = $this->model->get_login();
        $this->view->generate('feedback_view.php', 'template_view.php',$data);
    }
}
