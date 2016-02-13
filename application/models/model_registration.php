<?php
class Model_Authorization extends Authorization
{
    public $errors = array();
    private function check_login($login) {
/*        if(!preg_match("/^[a-zA-Z0-9]+$/",$login))
        {
            return false;
        }
        if(strlen($login) < 3 or strlen($login) > 30)
        {
            return false;
        }*/
        return true;
    }

    public function get_options() {
        $this->prepare("SELECT group_name FROM groups");
        return $this->execute_all();
    }
    private function get_group_id($group_name) {
        if($group_name) {
            $this->prepare("SELECT id FROM groups WHERE group_name=:group_name");
            $this->query->bindParam(":group_name", $group_name, PDO::PARAM_STR);
            return (int) $this->execute_row()[0];
        }
        return NULL;
    }
    private function unique_login($login) {
        $this->prepare("SELECT COUNT(id) FROM users WHERE login=:login");
        $this->query->bindParam(':login',$login);
        $data =  $this->execute_row();
        if($data[0] > 0)
        {
            return false;
        }
        return true;
    }
    private function check_pass($password,$confirm_password) {
        if($password != $confirm_password) {
            return false;
        }
/*        if(strlen($password) < 4 || strlen($password) > 30) {
            return false;
        }*/
        return true;
    }
    public function add_user($user) {
        if($this->unique_login($user->login) && $this->check_login($user->login) && ($this->check_pass($user->password,$user->confirm_password))) {
            $user_rights = U_USER;
            $group = $this->get_group_id($user->user_group);
            $user->password = md5(md5(trim($user->password)));
            $this->prepare("INSERT INTO users(id,login,user_password,user_info,group_id,contacts,rights,if_stuff)
VALUES (NULL,:login,:user_password,:user_info,:group_id,:contacts,:rights,:if_stuff)");
            $this->query->bindParam(':login',$user->login,PDO::PARAM_STR);
            $this->query->bindParam(':user_password',$user->password,PDO::PARAM_STR);
            $this->query->bindParam(':user_info',$user->user_info,PDO::PARAM_STR);
            $this->query->bindParam(':group_id',$group,PDO::PARAM_INT);
            $this->query->bindParam(':contacts',$user->contacts,PDO::PARAM_STR);
            $this->query->bindParam(':if_stuff',$user->if_stuff,PDO::PARAM_BOOL);
            $this->query->bindParam(':rights',$user_rights,PDO::PARAM_INT);
            $this->execute_simple();
            return true;
        }
        else {
            return false;
        }
    }
}