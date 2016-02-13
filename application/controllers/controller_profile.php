<?php
class Controller_Profile extends Controller
{
    function __construct() {
        $this->view = new View;
        $this->model = new Model_Profile();
    }
    function action_index($login)
    {
        if($login) {
            $data["login"] = $this->model->get_login();
            $data["user"] = $this->model->get_current_user($login[0]);
            $data["rights"] = $this->model->get_rights();
            $data["owner"] = $data["user"]["login"] == $data["login"];
            $this->view->generate('profile_view.php', 'template_view.php', $data); //TODO js == true AND bool in MYSQL
        }
    }
    function action_change_pass($login) {
        if($this->model->get_user() && isset($_POST["password"]))
            echo $this->model->change_pass($_POST["password"]);
    }
}