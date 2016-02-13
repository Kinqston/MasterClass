<?php
class Controller_Admin extends Controller
{
    function __construct()
    {
        $this->view = new View();
        $this->model = new Model_Admin();
    }
    function create_event($data) {
        if(!isset($_POST["group"]))
            $_POST["group"] = $data["event"]["group_name"];
        if(!isset($_POST["professor"]))
            $_POST["professor"] = $data["event"]["user_info"];
        return (object) [
            "ev_text" => $_POST["event_text"],
            "group_id" => $this->model->get_id($data["groups"],$_POST["group"],"group_name"),
            "professor_id" => $this->model->get_id($data["professors"],$_POST["professor"],"user_info"),
            "ev_date" => $_POST["date"] // TODO date check
        ];
    }
    function action_index()
    {
        $data["login"] = $this->model->get_login();

        if($this->model->get_rights() & U_EDIT)
            $this->view->generate('admin_view.php', 'template_view.php',$data);
        else
            Route::ErrorPage404();
    }
    function action_create_event($date) {
        $data["login"] = $this->model->get_login();
        $data["date"] = $this->model->get_date($date);
        $data["professors"] = $this->model->get_professors();
        $data["groups"] = $this->model->get_groups();

        if(isset($_POST['submit'])) {
            $this->model->create_event($this->create_event($data));
        }

        if($this->model->get_rights() & U_EDIT)
            $this->view->generate('create_event_view.php', 'template_view.php',$data);
        else
            Route::ErrorPage404();
    }
    function action_delete_event($id) {
        if(!empty($id))
            if($this->model->get_rights() & U_EDIT)
                $this->model->delete_event((int) $id[0]);
            else
                Route::ErrorPage404();
    }
    function action_update_event($id) {
        if($this->model->get_rights() & U_EDIT) {
            $int_id = (int)$id[0];
            $data["login"] = $this->model->get_login();
            $data["event"] = $this->model->get_event($int_id);
            $data["professors"] = $this->model->get_professors();
            $data["groups"] = $this->model->get_groups();
            if (isset($_POST['submit'])) {
                if ($this->model->update_event($this->create_event($data), $int_id)) {
                    header("Location: /calendar");
                }
            }
            $this->view->generate('update_event_view.php', 'template_view.php', $data);
        }
    else
            Route::ErrorPage404();
    }
    function action_get_rights() {
        echo $this->model->get_rights();
    }
    function action_upgrade_rights($id) {
        if($this->model->get_rights() & U_EDIT)
            if($this->model->upgrade_rights((int) $id[0]))
                header("Location: {$_SERVER["HTTP_REFERER"]}");
        else
            Route::ErrorPage404();
    }
    function action_delete_group() {
        if($this->model->get_rights() & U_EDIT) {
            if(isset($_POST["submit"])) {
                $data["success"] = $this->model->delete_group($_POST["group"]);
            }
            $data["groups"] = $this->model->get_groups();
            $data["login"] = $this->model->get_login();
            $this->view->generate('delete_group_view.php', 'template_view.php', $data);
        }
        else
            Route::ErrorPage404();
    }
    function action_create_group() {
        if($this->model->get_rights() & U_EDIT) {
            if (isset($_POST["submit"]))
                $data["success"] = $this->model->add_group($_POST["group"]);
            $data["login"] = $this->model->get_login();
            $this->view->generate('create_group_view.php', 'template_view.php', $data);
        }
        else
            Route::ErrorPage404();
    }
    function action_list_professors() {
        if($this->model->get_rights() & U_EDIT) {
            $data["login"] = $this->model->get_login();
            $data["list"] = $this->model->get_professors_list();
            $this->view->generate('professors_list_view.php', 'template_view.php', $data);
        }
        else
            Route::ErrorPage404();
    }
}
