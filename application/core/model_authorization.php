<?php
class Authorization extends Model {
    private $current_user = null;
    static function delete_cookie() {
        if(isset($_COOKIE['hash'])) {
            setcookie("user_id", "", time() - TIME*12);
            setcookie("hash", "", time() - TIME*12);
            setcookie("login", "", time() - TIME*12);
        }
    }
    public function delete_session() {
        $user_id = (int) $_COOKIE['user_id'];
        $this->prepare("DELETE FROM sessions WHERE user_id=:id");
        $this->query->bindParam(':id',$user_id,PDO::PARAM_INT);
        $this->execute_simple();
        Authorization::delete_cookie();
    }
    public function approve_session($login = null) { // TODO ?
        if (isset($_COOKIE['user_id']) and isset($_COOKIE['hash']))
        {
            $user_id = (int) $_COOKIE['user_id'];
            $this->prepare("SELECT sessions.*,users.* FROM sessions,users
WHERE user_id = :id AND s_hash=:hash  AND users.id = sessions.user_id LIMIT 1");
            $this->query->bindParam(':id',$user_id,PDO::PARAM_INT);
            $this->query->bindParam(':hash',$_COOKIE['hash'],PDO::PARAM_STR);
            $u_data = $this->execute_row();
            if(($u_data['s_hash'] !== $_COOKIE['hash']) or ($u_data['user_id'] !== $_COOKIE['user_id'])
                or ($u_data['s_time'] < time()) or ($login !== null && $login !== $u_data["login"]))
            {   #в этом случае сносим существующие куки
                $this->delete_session();
                return false;
            }
            else
            {
                $this->current_user = new user($u_data["id"],$u_data["login"],$u_data["user_info"],$u_data["group_id"],$u_data["contacts"],$u_data["rights"],$u_data["if_stuff"]);
                return true;
            }
        }
        else {
            return false;
        }
    }
    public function get_user() {
        if($this->current_user === null)
            $this->approve_session();
        return $this->current_user;
    }
    public function get_login() {
        if($this->get_user())
            return $this->get_user()->getLogin();
        return false;
    }
    public function get_rights() {
        if($this->get_user())
            return $this->get_user()->getRights();
        return false;
    }
}