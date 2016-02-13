<?php
class Model_Profile extends Authorization
{
    function get_current_user($login) {
        $this->prepare("SELECT * FROM users WHERE login=:login");
        $this->query->bindParam(":login",$login,PDO::PARAM_STR);
        return $this->execute_row();
    }
    function change_pass($new_pass) {
        $new_pass = md5(md5($new_pass));
        return $this->get_user()->setPass($new_pass);
    }
}