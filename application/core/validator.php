<?php

/**
 * Created by PhpStorm.
 * User: Falscroom
 * Date: 11.12.2015
 * Time: 23:43
 */
class validator
{
    public $result = true;
    function is_date($date) {
        $current = preg_match("/^[0-9]{2}(\.|,)[0-9]{2}(\.|,)[0-9]{4}$/",$date);
        $this->result = $current ? true : false;
        return $current;
    }
    function is_correct_login($login) {
        $current = preg_match("/^[a-zA-Z0-9]{4,}$/",$login);
        $this->result = $current ? true : false;
        return $current;
    }
    function is_correct_pass($pass) {
        $current = preg_match("/^.{4,}$/",$pass);
        $this->result = $current ? true : false;
        return $current;
    }
    function is_correct_info($info) {
        $current = preg_match("/^[a-zA-Z0-9а-яА-Я ёЁ]{4,32}$/u",$info);
        $this->result = $current ? true : false;
        return $current;
    }

    function is_correct_contacts($contacts) {
        $current = preg_match("/^[a-zA-Z0-9а-яА-Я ёЁ]{4,32}$/u",$contacts);
        $this->result = $current ? true : false;
        return $current;
    }
}