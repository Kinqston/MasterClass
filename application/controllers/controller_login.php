<?php
class Controller_Login extends Controller
{
    function __construct()
    {
        $this->view = new View();
        $this->model = new Model_Login();
    }
    function action_index()
    {
        if(isset($_POST['submit'])) {
            $validator = new validator();

            $data["errors"]["login"] = $validator->is_correct_login($_POST['login']) ? "" : "has-error";
            $data["errors"]["pass"] = $validator->is_correct_pass($_POST['password']) ? "" : "has-error";

            if($this->model->approveUser($_POST['login'],$_POST['password']) && $validator->result) {
                header("Location: /main");
            }
            else {
                $data["errors"]["login"] = "has-error";
                $data["errors"]["pass"] =  "has-error";
            }
        }
        $data["login"] = $this->model->get_login();
        $this->view->generate('login_view.php', 'template_view.php',$data);
    }
}
