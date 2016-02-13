<?php
class Controller_Registration extends Controller
{
    function __construct() {
        $this->view = new View;
        $this->model = new Model_Authorization();
    }
    function create_user() {
        $if_stuff = $_POST["if_stuff"] == "Да";
        $group = $_POST["group"];
        if($if_stuff)
            $group = null;
        return (object) [
            "login" => $_POST["login"],
            "password" => $_POST["password"],
            "confirm_password" => $_POST["confirm_password"],
            "contacts" => $_POST["contacts"],
            "user_info" => $_POST["user_info"],
            "if_stuff" => $if_stuff,
            "user_group" => $group
        ];
    }
    function action_index()
    {

        $validator = new validator();
        $data["login"] = $this->model->get_login();
        $data["options"] = $this->model->get_options();

        if(isset($_POST['submit'])) {
            $user = $this->create_user();

            $data["errors"]["login"] = $validator->is_correct_login($user->login) ? "" : "has-error";
            $data["errors"]["pass"] = $validator->is_correct_pass($user->password) ? "" : "has-error";
            $data["errors"]["contacts"] = $validator->is_correct_contacts($user->contacts) ? "" : "has-error";
            $data["errors"]["info"] = $validator->is_correct_info($user->user_info) ? "" : "has-error";

            if($validator->result)
                if ($this->model->add_user($user))
                    header("Location: /login");
        }
        $this->view->generate('registration_view.php', 'template_view.php',$data);
    }
}