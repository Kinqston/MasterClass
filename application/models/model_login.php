<?php
class Model_Login extends Authorization
{
    private $thisUser;
    private $hash;
    public  $errors = array();
    private function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }
    public function checkPass($pass,$login) {
        $this->prepare('SELECT id, user_password ,login FROM users WHERE login=:login LIMIT 1'); // Warning!!!
        $this->query->bindParam(':login',$login);
        $this->thisUser = $this->execute_row();
        if($this->thisUser["user_password"] === md5(md5($pass))) {
            return true;
        }
        return false;
    }
    private function createCookie() {
        setcookie("user_id", $this->thisUser['id'], time()+TIME);
        setcookie("hash", $this->hash, time()+TIME);
        setcookie("login", $this->thisUser['login'], time()+TIME); // TODO переделать кукисы под  object!
    }
    function approveUser($login,$pass) {
        if($this->checkPass($pass,$login)) { #ПРОВЕРЯЕМ ПРАВИЛЬНОСТЬ ПАРОЛЯ
            $time = time() + TIME;
            var_dump($time);
            $this->hash = md5($this->generateCode(10));
            $this->prepare("INSERT INTO sessions SET user_id=:id, s_hash=:hash,s_time=:time");
            $this->query->bindParam(':hash',$this->hash);
            $this->query->bindParam(':id',$this->thisUser['id']);
            $this->query->bindParam(':time',$time); // Два часа!
            $this->execute_simple();
            $this->createCookie(); // Создаем куки
            return true;
        }
        else {
            Authorization::delete_cookie();
            return false;
        }
    }
}