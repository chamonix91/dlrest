<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 29/12/2017
 * Time: 14:57
 */

namespace DL\UserBundle\Entity;


class Credentials

{
    protected $login;

    protected $password;

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }


}