<?php
class user
{
    private $id,$login,$info,$g_id,$contacts,$rights,$stuff;
    private $model;
    function __construct($id,$login,$info,$g_id,$contacts,$rights,$stuff)
    {
        $this->id = $id;
        $this->login = $login;
        $this->info = $info;
        $this->g_id = $g_id;
        $this->contacts = $contacts;
        $this->rights = $rights;
        $this->stuff = $stuff;

        $this->model = new Model();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function getGId()
    {
        return $this->g_id;
    }

    public function getContacts()
    {
        return $this->contacts;
    }

    public function getRights()
    {
        return $this->rights;
    }

    public function getStuff()
    {
        return $this->stuff;
    }

    public function setLogin($login)
    {
        $this->model->prepare("UPDATE `users` SET `login`=:login WHERE `id`=:id");
        $this->model->query->bindValue(':login',$login,PDO::PARAM_STR);
        $this->model->query->bindValue(':id',$this->getId(),PDO::PARAM_INT);
        return $this->model->execute_simple();
    }

    public function setInfo($info)
    {
        $this->model->prepare("UPDATE `users` SET `user_info`=:info WHERE `id`=:id");
        $this->model->query->bindValue(':info',$info,PDO::PARAM_STR);
        $this->model->query->bindValue(':id',$this->getId(),PDO::PARAM_INT);
        return $this->model->execute_simple();
    }

    public function setPass($password) {
        $this->model->prepare("UPDATE `users` SET `user_password`=:pass WHERE `id`=:id");
        $this->model->query->bindValue(':pass',$password,PDO::PARAM_STR);
        $this->model->query->bindValue(':id',$this->getId(),PDO::PARAM_INT);
        return $this->model->execute_simple();
    }
}