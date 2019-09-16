<?php

namespace Developez\LaraFileAuth;

class UserFile
{
    protected $id;
    protected $identifier;
    protected $uuid;
    protected $name;
    protected $email;
    protected $password;
    protected $rol;
    protected $status;

    public static function parseFromJson(object $userData)
    {
        $user = new self;

        foreach(get_object_vars($this) as $key)
        {
            $user->$key = $userData->$key;
        }

        return $user;
    }

    public static function parseFromArray(array $userData)
    {
        $user = new self;

        foreach(get_object_vars($this) as $key)
        {
            $user->$key = $userData[$key];
        }

        return $user;
    }
}